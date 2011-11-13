<?php

if(isset($_REQUEST['fields']) && isset($_REQUEST['output']) && isset($_REQUEST['event_id']) && isset($_REQUEST['group_id'])){

	include("constant.php");

	include("sql_fonc.php");
	include("sp_fonc.php");
	include("login_fonc.php");
	include("jsconn_fonc.php");
  
  $_REQUEST['key'] = $_COOKIE['adhmidsuser'];
  $_REQUEST['sdb'] = $_COOKIE['adhmidssdb'];

  sql_connect();
  
  $user = login_checkKey();
  
  if($_REQUEST['group_id']=="null"){
    $_REQUEST['group_id']=null;
  }
  if($_REQUEST['event_id']=="null"){
    $_REQUEST['event_id']=null;
  }
  
  //sp_setUserList(array('forename', 'surname'), '45');
  
  $query = "SELECT * FROM page WHERE id = '".GETUSERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    sp_setUserList($_REQUEST['fields'], $_REQUEST['event_id'], $_REQUEST['group_id'], $_REQUEST['output']);
  }else{
    echo "ERROR : connexion parameter missing or false.";
    jsconn_error("102");
  }
}  
?>
