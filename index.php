<?php
ob_start();
?>
	
	
	<html>
	<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" type="text/css" href="js/jscalendar-1.0/calendar-win2k-1.css">
  <script type="text/javascript" src="js/jscolor/jscolor.js"></script>
  <script type="text/javascript" src="js/floating-1.7.js"></script>
  <script type="text/javascript" src="js/drag.js"></script>
  <script src="js/jscalendar-1.0/calendar.js" type="text/javascript"></script>
  <script src="js/jscalendar-1.0/lang/calendar-en.js" type="text/javascript"></script>
  <script src="js/jscalendar-1.0/calendar-setup.js" type="text/javascript"></script> 

	</head>
	<body>
  <div id="dialogbox">&nbsp;</div>
  <div id="loading"><center><h1>LOADING ...</h1></center></div>
  <div id="anoun">&nbsp;</div>
  <br/>
  <table align=center width=90% height=95% border=0 cellpadding=10>
    <tr>
      <td valign=top>
        <div id="panel" onmousedown="pan_startmoov(event)">
          <div id="menulogo">
            <div id="nav">
              <a title="(local cache, for server refresh use menu)" href="javascript:page_return();"><img id="return" src="img/arrow-round_f.png" width=32 height=32></a>
              <a href="javascript:pan_toggle();" class="insidesmlink"><img id="toggle" src="img/toggle_r.png" width=16 height=16></a>
              <a title="(local cache, for server refresh use menu)" href="javascript:page_forw();"><img id="forw" src="img/arrow-round_r_f.png" width=32 height=32></a>
            </div>
          </div>
          <div id="menutop">&nbsp;</div>
          <div id="menucontent">&nbsp;</div>
          <div id="menubot">&nbsp;</div>
        </div>
      </td>
      <td width=100%>
        <div id="messagecontent">&nbsp;</div>
        <br/>
        <div id="pagecontent"><h1>JAVASCRIPT LOADING ...</h1><p>You must enable javascript to access this website.</p></div>
      </td>
    </tr>
  </table>
	</body>
	</html>



<?php

	include("constant.php");
	include("sql_fonc.php");
	include("login_fonc.php");
  
  sql_connect();

	include("mail_fonc.php");
	include("jsconn_fonc.php");
  
  $login_res = login_connexion();
	
	include("js/ajax.js");
	include("js/login_form.js");
	include("js/page.js");
	include("js/md5.js");
	include("js/cook.js");
	include("js/slashes.js");
  			
  if($login_res){
    if($_REQUEST['page_id']){
      jsconn_loadPage($_REQUEST['page_id'], "1");
    }else{
      jsconn_loadPage(WELCOME_PAGE_ID, "1");
    }
  }else{
    if(!isset($_REQUEST['getnewpass'])){
      if(!isset($_REQUEST['newpassword'])){
        jsconn_loadPage(LOGIN_PAGE_ID);
      }else{
        $result = login_resetPw($_REQUEST['newpassword']);
        if($result!=false){
          
          $data['login'] = $result->login;
          $data['password'] = $result->npw;
          $data['forename'] = $result->forename;
          $data['surname'] = $result->surname;
      
          mail_sendMail($_REQUEST['newpassword'], RESETPWMAIL_PAGE_ID, $data);
          
          ?><SCRIPT LANGUAGE="JavaScript">display_error('304');</SCRIPT><?
          jsconn_loadPage(LOGIN_PAGE_ID);
          
        }else{
          ?><SCRIPT LANGUAGE="JavaScript">display_error('303');</SCRIPT><?
          jsconn_loadPage(LOGIN_PAGE_ID);
        }
      }
    }else{
      jsconn_loadPage(RESETPW_PAGE_ID);
    }
  }
  
  if($_REQUEST['nodebug']){
    setcookie("adhmidsdebugmod");
  }
  
  ob_end_flush();
		
?>
