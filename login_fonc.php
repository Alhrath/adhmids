<?php

function login_fileLog($str){
  
  $str = date("Y-m-d|H:i:s").": ".$str."\n";
  $myFile = "log.txt";
  $fh = fopen($myFile, 'a') or die("can't open file");
  fwrite($fh, $str);
  fclose($fh);
  
}

function login_connexion(){
    
  if($_REQUEST['logout']){
    
    login_logout();
    return false;
    
  }elseif(isset($_REQUEST['login']) && isset($_REQUEST['pw']) && isset($_REQUEST['sdb'])){
    
    login_fileLog('LOGIN REQUEST with : '.$_REQUEST['login']."|".$_REQUEST['pw']."|".$_REQUEST['sdb']);
    
    if($_REQUEST['sdb']!="0"){
      
      $query2 = "SELECT * FROM sdb WHERE (id = '".$_REQUEST['sdb']."')";
      $result2 = mysql_query($query2);
      $sdb = mysql_fetch_object($result2);
      
      $query = "SELECT * FROM ".$sdb->name.".`user` WHERE (login='".$_REQUEST['login']."' AND pw='".$_REQUEST['pw']."')";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);
      
      if(mysql_num_rows($result)!="0"){
        login_setDbCookie($sdb->skey);
        sql_connect($sdb->skey);
      }
      
    }else{
    
      $query = "SELECT * FROM user WHERE (login='".$_REQUEST['login']."' AND pw='".$_REQUEST['pw']."')";
      //mail("jonas.boiziau@laposte.net", "[DEBUG] LOGIN QUERY", $query);
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);
      
      login_setDbCookie("");

    }
          
    if(mysql_num_rows($result)!="0"){
      
      login_fileLog('Login request success');
      
      login_setKey($user->id);
      return true;
      
    }else{
      
      login_fileLog('Login request failure');
      
      jsconn_alert("LOGIN FAILED");
      return false;
      
    }
    
  }elseif($_COOKIE['adhmidsuser']){
    
    login_fileLog('COOKIE LOGIN with : '.$_COOKIE['adhmidsuser']);
          
    $query = "SELECT * FROM user WHERE skey='".$_COOKIE['adhmidsuser']."'";
    $result = mysql_query($query);
    $user = mysql_fetch_object($result);
                
    if($user->id){
      
      login_fileLog('Cookie login success');
      
      $key = login_setKey($user->id);
      
      if($_REQUEST['debugmod'] && $user->level >= DEBUG_LEVEL){
        setcookie("adhmidsdebugmod",$key ,time()+3600);
      }
      return true;
      
    }else{
      
      login_fileLog('Cookie login failure');
      
      jsconn_alert("COOKIE LOGIN FAILED");
      return false;
      
    }
          
  }else{
          
    return false;
    
  }
  
}

function login_resetPw($email){
          
  $query = "SELECT * FROM `user`, `user_profile` WHERE `user_profile`.`email`='".$email."' and `user_profile`.`user_id` = `user`.`id`";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  if(!empty($user)){
    $user->npw = login_setPw($user->user_id);
    return $user;
  }else{
    return false;
  }
  
}

function login_setPw($login_id){

  for ($key = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 8; $x = rand(0,$z), $key .= $a{$x}, $i++);

  $md5_key = md5($key);

  $query = "UPDATE `user` SET `pw` = '$md5_key' WHERE `id` =".$login_id." ;";
  $result = mysql_query($query);

  return $key;

}

function login_setKey($login_id){
  

  for ($key = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 32; $x = rand(0,$z), $key .= $a{$x}, $i++);

  login_fileLog('NEW KEY SET for '.$login_id.' : '.$key.' in '.DATABASE);
  
  login_setCookie($key);

  $query = "UPDATE `user` SET `skey` = '$key' WHERE `id` =".$login_id." ;";
  $result = mysql_query($query);

  return $key;

}

function login_setCookie($key){
  login_fileLog('USER COOKIE SET to : '.$key);
  setcookie("adhmidsuser",$key,time()+10800);
}

function login_setDbCookie($key){
  login_fileLog('DB COOKIE SET to : '.$key);
  setcookie("adhmidsdb",$key,time()+10800);
}

function login_FGCookie($user, $group_id){
      
  $query = "UPDATE user SET fgroup_id='".$group_id."' WHERE id = '".$user->id."'";
  $result = mysql_query($query);
  
}

function login_logout(){
  
  login_setCookie("");
  login_setDbCookie("");
  
}

function login_checkAuth($user, $page, $right, $skipcook = false, $item=null){

  if($page->auth_type == "0"){
    return true;
  }elseif(($page->auth_type >= "1")&&(!isset($user))){
    return false;
  }elseif($page->auth_type == 1){
    return true;
  }elseif($page->auth_type == 2){
  
    if(($user->fgroup_id != "0") && !$skipcook){
      
      $query = "SELECT * FROM page WHERE id = '".FAKEGROUP_PAGE_ID."'";
      $result = mysql_query($query);
      $pagecook = mysql_fetch_object($result);
      
      $ar = login_getAuth($user, $pagecook, true);
      
      if($ar >= "6"){
        $user->group_id = $user->fgroup_id;
      }
    }
  
    $query = "SELECT * FROM access_right_g WHERE group_id='".$user->group_id."' and page_id='".$page->id."'";
    $result = mysql_query($query);
    $accri = mysql_fetch_object($result);
    
    if(!empty($accri)){if($accri->right == "2"){$accri->right = "4";}}
    
    if(empty($accri)){
      return false;
    }elseif($accri->right=="5"){
      
      if($right != "5"){
      
        $query = "SELECT * FROM ".get_PageToAuthTable($page->id)." WHERE user_id='".$user->id."' and ".get_PageToAuthCol($page->id)."='".$item."'";
        $result = mysql_query($query);
        $accriauth = mysql_fetch_object($result);
        
        if(!empty($accriauth)){
          
          if($right <= "6"){
            return true;
          }else{
            return false;
          }
          
        }else{
          
          if($right <= "4"){
            return true;
          }else{
            return false;
          }
        }
      }else{
        return true;
      }
      
    }elseif($accri->right=="3"){
      
      if($right != "5"){

      
        $query = "SELECT * FROM ".get_PageToAuthTable($page->id)." WHERE user_id='".$user->id."' and ".get_PageToAuthCol($page->id)."='".$item."'";
        $result = mysql_query($query);
        $accriauth = mysql_fetch_object($result);
        
        if(!empty($accriauth)){
          
          if($right <= "6"){
            return true;
          }else{
            return false;
          }
          
        }else{
          
          return false;
        }
      }else{
        return true;
      }
      
    }else{
      if($right <= $accri->right){
        return true;
      }else{
        return false;
      }
    }
    
  }
  
  return false;
  
}

function login_getAuth($user, $page, $skipcook = false, $item = null){
  
  if(($user->fgroup_id != "0") && !$skipcook){
    
    $query = "SELECT * FROM page WHERE id = '".FAKEGROUP_PAGE_ID."'";
    $result = mysql_query($query);
    $pagecook = mysql_fetch_object($result);
      
    $ar = login_getAuth($user, $pagecook, true);
    
    if($ar >= "6"){
      $user->group_id = $user->fgroup_id;
    }
  }
  
  $query = "SELECT * FROM access_right_g WHERE group_id='".$user->group_id."' and page_id='".$page->id."'";
  $result = mysql_query($query);
  $accri = mysql_fetch_object($result);
  
  if($page->auth_type==2){
    if(empty($accri)){
      return "0";
    }else{
      if($accri->right == "2"){$accri->right = "4";}
      if($accri->right=="5"){
        
        $query = "SELECT * FROM ".get_PageToAuthTable($page->id)." WHERE user_id='".$user->id."' and ".get_PageToAuthCol($page->id)."='".$item."'";
        $result = mysql_query($query);
        $accri = mysql_fetch_object($result);
        
        if(empty($accri)){
          return "4";
        }else{
          return "6";
        }
        
      }elseif($accri->right=="3"){
        
        $query = "SELECT * FROM ".get_PageToAuthTable($page->id)." WHERE user_id='".$user->id."' and ".get_PageToAuthCol($page->id)."='".$item."'";
        $result = mysql_query($query);
        $accri = mysql_fetch_object($result);
        
        if(empty($accri)){
          return "0";
        }else{
          return "6";
        }
        
      }else{
        return $accri->right;
      }
    }
  }else{
    return "6";
  }
  
}

function login_checkKey(){
  
  if(isset($_REQUEST['key'])){
    if(strlen($_REQUEST['key'])=="32"){
      
      login_fileLog('CHECK KEY with '.$_REQUEST['key'].' in '.DATABASE);
          
      $query = "SELECT * FROM ".DATABASE.".user WHERE skey = '".$_REQUEST['key']."'";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);
      
      if(!empty($user)){
        login_fileLog('Check key success : '.$user->login);
        define("USER_ID", $user->id);
        login_log();
      }else{
        login_fileLog('Check key failure');
        $user = null;
      }
    }else{
      
      $user = null;
      
    }
  }else{
    
    $user = null;
    
  }
  
  return $user;
  
}

function login_log(){
	
	#$query = "DELETE FROM `log` WHERE `user_id` = ".USER_ID;
	#$result = mysql_query($query);

  if(isset($_REQUEST['reqtype'])){
    $reqtype = $_REQUEST['reqtype'];
  }elseif(isset($_REQUEST['page_id'])){
    $reqtype = "LOADPAGE";
  }else{
    $reqtype = "NOREQTYPE";
  }
  
  $details = login_getDetails();

	$query = "INSERT INTO `log` (`user_id`, `datetime`, `reqtype`, `details`) VALUES ('".USER_ID."', now(), '".$reqtype."', '".$details."')";
	$result = mysql_query($query);
		    
}

function login_getlastreq($reqtype){
  
  $query = "SELECT `datetime`, `user_id` FROM log WHERE reqtype = '".$reqtype."' ORDER BY datetime DESC";
  $result = mysql_query($query);
  $lastreq = mysql_fetch_object($result);
  
  $return = new stdClass();
  
  if(!empty($lastreq)){
    $query = "SELECT `surname` FROM user_profile WHERE user_id = '".$lastreq->user_id."'";
    $result = mysql_query($query);
    $uprof = mysql_fetch_object($result);
    
    $return->datetime = $lastreq->datetime;
    $return->surname = $uprof->surname;
  }else{
    $return->datetime = "N/A";
    $return->surname = "N/A";
  }
  
  return $return;
}

function login_stdLogOutput($reqtype){
  
  $lastreq = login_getlastreq($reqtype);

  return TXT_LASTMODIF." : ".$lastreq->surname." ".$lastreq->datetime;
  
}

function login_getDetails(){
  
  $details = "";
  
  if(isset($_REQUEST['page_id'])){
    $query = "SELECT `name` FROM page WHERE id = '".$_REQUEST['page_id']."'";
    $result = mysql_query($query);
    $page = mysql_fetch_object($result);
    
    $details .= $_REQUEST['page_id'];
    $details .= " (";
    $details .= $page->name;
    $details .= ")";
  }
  
  if(isset($_REQUEST['reqtype'])){
    switch($_REQUEST['reqtype']){
      case "adduser":
        $details .= $_REQUEST['email'];
        break;
        
      case "chugroup":
        $query = "SELECT `forename`, `surname` FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
        $result = mysql_query($query);
        $uprof = mysql_fetch_object($result);
        
        $query = "SELECT `name` FROM `group` WHERE id = '".$_REQUEST['group_id']."'";
        $result = mysql_query($query);
        $group = mysql_fetch_object($result);
        
        $details .= $uprof->forename." ".$uprof->surname." -> ".$group->name;
        break;
      
    }
  }
  
  return $details;
  
}

?>
