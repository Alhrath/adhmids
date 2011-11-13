<?php

$main_db;
$sec_db;

function sql_connect($skey = null){
  
  global $main_db, $sec_db;
  
  $main_db = mysql_connect(SQL_HOST,SQL_USER,SQL_PASSWORD) or die("ERROR : the connexion to the server failed.");
  
  if(isset($_COOKIE['adhmidsdb']) || isset($_REQUEST['sdb']) || $skey != null){
    
    
    if(isset($_REQUEST['sdb'])){
      $_COOKIE['adhmidsdb'] = $_REQUEST['sdb'];
    }
    if($skey!=null){
      $_COOKIE['adhmidsdb'] = $skey;
    }
    
    login_fileLog('COOKIE DATABASE CONNEXION with : '.$_COOKIE['adhmidsdb']);
    
    $query = "SELECT * FROM ".MAIN_DB.".sdb WHERE `skey`='".$_COOKIE['adhmidsdb']."'";
    $result = mysql_query($query);
    $sdb = mysql_fetch_object($result);
    
    if(mysql_num_rows($result)){
      mysql_select_db($sdb->name, $main_db) or die("ERROR : the connexion to the database failed.");
      define("DATABASE", $sdb->name);
    }else{
      mysql_select_db(MAIN_DB) or die("ERROR : the connexion to the database failed.");
      define("DATABASE", MAIN_DB);
    }
  }else{
    //login_fileLog('DEFAULT DATABASE CONNEXION');
    
    mysql_select_db(MAIN_DB) or die("ERROR : the connexion to the database failed.");
    define("DATABASE", MAIN_DB);
  }

  
}

function sql_getSDb(){
  
  $sdbl=null;
  
  $query = "SELECT * FROM sdb WHERE 1";
  $result = mysql_query($query);
  while($sdb = mysql_fetch_object($result)){
    
    $sdbl[] = $sdb;
    
  }
  
  return $sdbl;
  
}

function sql_makeSDb($name, $logo, $title){
  
  global $main_db, $sec_db;
  
  for ($key = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 32; $x = rand(0,$z), $key .= $a{$x}, $i++);

  $sec_db = mysql_connect(SQL_HOST,SQL_USER,SQL_PASSWORD, true) or die("ERROR : the connexion to the server failed.");
  mysql_select_db($name, $sec_db) or die("ERROR : the connexion to the database failed."); 
  
  $query = "show tables";
  $result = mysql_query($query, $main_db);
  while($table = mysql_fetch_row($result)){
    
    $query2 = "CREATE TABLE `".$table[0]."` LIKE `".MAIN_DB."`.`".$table[0]."`";
    $result2 = mysql_query($query2, $sec_db);
    
  }
    
  $query2 = "INSERT INTO `group` (name) VALUES ('".TXT_ADMIN."')";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "INSERT INTO `page` SELECT * FROM ".MAIN_DB.".`page` WHERE `type` != '8'";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "SELECT * FROM `page`";
  $result2 = mysql_query($query2, $sec_db);
  while($page = mysql_fetch_object($result2)){
    $query3 = "INSERT INTO `access_right_g` (`group_id`, `page_id`, `right`) VALUES ('1', '".$page->id."', '6')";
    $result3 = mysql_query($query3, $sec_db);
  }
  
  $query2 = "INSERT INTO `page_automail` SELECT * FROM ".MAIN_DB.".`page_automail`";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "INSERT INTO `page_content` SELECT * FROM ".MAIN_DB.".`page_content`";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "INSERT INTO `slink` SELECT * FROM ".MAIN_DB.".`slink`";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "INSERT INTO `user` SELECT * FROM ".MAIN_DB.".`user` WHERE `id` = '".USER_ID."'";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "INSERT INTO `user_profile` SELECT * FROM ".MAIN_DB.".`user_profile` WHERE `user_id` = '".USER_ID."'";
  $result2 = mysql_query($query2, $sec_db);
  
  $query2 = "UPDATE `user` SET `group_id`='1' WHERE `id`='".USER_ID."'";
  $result2 = mysql_query($query2, $sec_db);
  
}


?>
