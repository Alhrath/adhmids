<!DOCTYPE HTML>
<html>
    <head>
        <title>FixedHeaderTable Test</title>
        <link href="js/fixedtable/demo/css/960.css" rel="stylesheet" media="screen" />
        <link href="js/fixedtable/css/defaultTheme.css" rel="stylesheet" media="screen" />
        <link href="js/fixedtable/demo/css/myTheme.css" rel="stylesheet" media="screen" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script src="js/fixedtable/jquery.fixedheadertable.min.js"></script>
        <script src="js/fixedtable/perso.js"></script>
    </head>
    

<?php

	include("constant.php");

	include("sql_fonc.php");
	include("sp_fonc.php");
	include("login_fonc.php");
	include("jsconn_fonc.php");
  
  $_REQUEST['key'] = $_COOKIE['adhmidsuser'];
  $_REQUEST['sdb'] = $_COOKIE['adhmidssdb'];

  sql_connect();
  
  $user = login_checkKey();
    
  $query = "SELECT * FROM page WHERE id = '".INSCRIP_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  $ar = login_getAuth($user, $page);
  
  if(login_checkAuth($user, $page, "4")){
    $userlist=null;
  
    echo "\n<div id=\"tableContainer\" class=\"tableContainer\">";
    
    echo "<center>";
    
    echo "\n<table align=center class=\"regsumm\" id=\"tblTest1\">";
    
    $query = "SELECT `event`.*, `event_type`.`name`, `event_type`.`page_id` FROM `event`, `event_type` WHERE `event`.`type`=`event_type`.`id` and `event_type`.`is_insc`='1' ORDER BY `event_type`.`name`";
    $result = mysql_query($query);
    $first=true;
    $lastevtype=null;
    while($event = mysql_fetch_object($result)){
      $usercount=0;
      if($first){
        echo "\n\n<thead class=\"fixedHeader\">";
        echo "\n<tr><th>&nbsp;</td>";
        $query2 = "SELECT `user_profile`.* FROM `user`, `user_profile`, `access_right_g` WHERE `user_profile`.`user_id`=`user`.`id` and `access_right_g`.`group_id`=`user`.`group_id` and `access_right_g`.`page_id` = '".$event->page_id."' and `access_right_g`.`right`='2'  ORDER BY `user_profile`.`surname`";
        $result2 = mysql_query($query2);
        while($user = mysql_fetch_object($result2)){
          $useridlist[]=$user->user_id;
          $eventcount[$user->user_id][0]=$user->surname;
          $eventcount[$user->user_id][1]=0;
          echo "<th><b>".$user->surname."</b></td>";
        }
        echo "<th><b>".TXT_TOTAL."</b></td>";
        echo "</tr>";
        echo "</thead>";
        echo "\n\n<tbody class=\"scrollContent\">";
        $first=false;
      }
      if($event->name != $lastevtype){
        //echo "\n<tr><td colspan=1000><br/><font style=\"font-size:20px;\">- ".$event->name."</font></td></tr>";
        $lastevtype = $event->name;
      }
      
      echo "\n<tr><td><b>".$event->title."</b></td>";
    
      $query2 = "SELECT `user_profile`.* FROM `user`, `user_profile`, `access_right_g` WHERE `user_profile`.`user_id`=`user`.`id` and `access_right_g`.`group_id`=`user`.`group_id` and `access_right_g`.`page_id` = '".$event->page_id."' and `access_right_g`.`right`='2'  ORDER BY `user_profile`.`surname`";
      $result2 = mysql_query($query2);
      while($user = mysql_fetch_object($result2)){
        $query3 = "SELECT * FROM `event_insc` WHERE `user_id`='".$user->user_id."' and `event_id`='".$event->id."'";
        $result3 = mysql_query($query3);
        if($ar>="5"){
          if(mysql_num_rows($result3)!="0"){
            $usercount++;
            $eventcount[$user->user_id][1]++;
            $insc = mysql_fetch_object($result3);
            echo "<td align=center><a href=\"javascript:custRequest('reqtype=setinsc&insc_id=".$insc->id."')\" class=\"insidesmlink\">X</a></td>";
          }else{
            echo "<td align=center><a href=\"javascript:custRequest('reqtype=unsetinsc&user_id=".$user->user_id."&event_id=".$event->id."')\" class=\"insidesmlink\">-</a></td>";
          }
        }elseif($ar>="4"){
          if(mysql_num_rows($result3)!="0"){
            $usercount++;
            $eventcount[$user->user_id][1]++;
            echo "<td align=center>X</td>";
          }else{
            echo "<td align=center>-</td>";
          }
        }
      }
      echo "<td align=center><b>".$usercount."</b></td>";
      //echo "<td><b>".$event->title."</b></td>";

      echo "</tr>";

    }
      
    echo "\n<tr><td><b>".TXT_TOTAL."</b></td>";
    
    if(isset($useridlist)){
      foreach($useridlist as $key => $value){
          echo "<td align=center><b>".$eventcount[$value][1]."</b></td>";
      }
    }
    echo "</tr>";
    echo "\n<tr><td></td>";
    
    if(isset($useridlist)){
      foreach($useridlist as $key => $value){
          echo "<td align=center><b>".$eventcount[$value][0]."</b></td>";
      }
    }
    echo "</tr>";
    
    echo "</tbody>";
    echo "</table>";
    
    echo "</center>";
    
  }else{
    echo "ERROR : connexion parameter missing or false.";
    jsconn_error("102");
  }

?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/fixedtable/jquery.fixedheadertable.js"></script>

<script type="text/javascript">  
$(document).ready(function() { 
  $('.tbl').fixedHeaderTable({ footer: false, cloneHeadToFoot: false, fixedColumn: false });
  $('.tbl').fixedHeaderTable('hide');
  $('.tbl').fixedHeaderTable('show');
}); 
</SCRIPT>
