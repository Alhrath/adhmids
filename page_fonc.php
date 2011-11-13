<?php

function page_fix($page, $user, $ar){

  switch($page->id){
    case LOGIN_PAGE_ID:
      page_login();
      return "101";
      break;
      
    case RESETPW_PAGE_ID:
      page_newpassword();
      return "101";
      break;
      
    case EDITMENU_PAGE_ID:
      page_menuedit();
      return "101";
      break;
      
    case USERGROUPS_PAGE_ID:
      page_userGroup($ar);
      return "101";
      break;
      
    case ACCESSRIGHTS_PAGE_ID:
      page_accessRights($ar);
      return "101";
      break;
      
    case PROFILE_PAGE_ID:
      page_profile($ar);
      return "101";
      break;
      
/*
    case EVENT_PAGE_ID:
      page_event($ar, $page, $user);
      return "101";
      break;
*/
      
    case USERLIST_PAGE_ID:
      page_userList($ar);
      return "101";
      break;
      
    case LOG_PAGE_ID:
      page_log($ar);
      return "101";
      break;
      
    case CALENDAR_PAGE_ID:
      page_calendar($ar);
      return "101";
      break;
      
    case DOCUMENT_PAGE_ID:
      page_document($ar, $page, $user);
      return "101";
      break;
      
    case PERINFO_PAGE_ID:
      page_perInfo($ar, $page, $user);
      return "101";
      break;
      
    case MANINFO_PAGE_ID:
      page_manEvent($ar, $page, $user);
      return "101";
      break;
      
    case EVENTTYPE_PAGE_ID:
      page_eventTYpe($ar, $page, $user);
      return "101";
      break;
      
    case EVENTDIS_PAGE_ID:
      page_eventDisabled($ar);
      return "101";
      break;
      
    case ANOUN_PAGE_ID:
      page_anoun($ar);
      return "101";
      break;
      
    case INSCRIP_PAGE_ID:
      page_inscrip($ar);
      return "101";
      break;
      
    case GETUSERLIST_PAGE_ID:
      page_getUserList($ar);
      return "101";
      break;
      
    default:
      return "104";
      break;
    
    
  }

}

function page_eventDisabled(){
  
  sp_eventListDis();  
}

function page_eventType(){
  
  echo "<table width=100%>";
  echo "<tr><td colspan=100 align=center><a href=\"javascript:custRequest('reqtype=addevtype_form')\" class=\"insidelink\">".TXT_ADDEVTYPE."</a><br/><br/></td></tr>";
  $is_evtype=false;
  
  $query = "SELECT `event_type`.*, `page`.`auth_mod` FROM `event_type`, `page` WHERE `page`.`id` = `event_type`.`page_id`";
  $result = mysql_query($query);
  if (mysql_num_rows($result)!=0){
    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td align=center><b>".TXT_COLOR."</b></td><td align=center colspan=2><b>".TXT_INSCMOD."</b></td><td align=center><b>".TXT_ISMANEV."</b></td><td align=center><b>".TXT_ISECTS."</b></td><td align=center><b>".TXT_ISTEST."</b><td align=center><b>".TXT_ISPRIO."</b></td></tr>";
    while($event_type = mysql_fetch_object($result)){
      $is_evtype=true;
      echo "<tr><td><b>".$event_type->name."</b></td>";
      echo "<td><a href=\"javascript:custRequest('reqtype=editevtype_form&evtype_id=".$event_type->id."')\" class=\"insidelink\">".TXT_EDIT."</a> | <a href=\"javascript:custRequest('reqtype=delevtype_conf&evtype_id=".$event_type->id."')\" class=\"insidelink\">".TXT_DELETE."</a></td>";
      echo "<td bgcolor=\"#".$event_type->color."\"></td><td align=center>".get_inscModText($event_type->is_insc)."</td>";
      echo "<td align=center>";
      
      if($event_type->is_insc=="1"){
        echo get_openModText($event_type->is_open);
      }else{echo "&nbsp;";}
      echo "</td>";
      echo "<td align=center>".get_yesNo($event_type->auth_mod-2)."</td><td align=center>".get_yesNo($event_type->is_ects)."</td><td align=center>".get_yesNo($event_type->is_test)."</td><td align=center>".get_yesNo($event_type->is_prio)."</td></tr>";
    }
  }else{
    echo "<tr><td colspan=100 align=center>".TXT_NOEVTYPE."</td></tr>";
  }
  
  echo "</table>";
  
}

function page_anoun($ar){
  
  sp_checkAnounExp();
  
  $is_anoun=false;
  
  echo "<center>";
  
  if($ar>="5"){
    
    echo "<a href=\"javascript:custRequest('reqtype=addanoun_form')\" class=\"insidelink\">".TXT_ADD." ".TXT_ANOUN."</a>";
    echo "<br/><br/>";
    
  }
  
  echo "<table>";
  
  $query = "SELECT * FROM `anoun` WHERE '1' ORDER BY `publish` DESC, `expire` DESC";
  $result = mysql_query($query);
  if(mysql_num_rows($result)!="0"){
    echo "<tr><td align=center><b>".TXT_PUBLIED."</b></td><td align=center style=\"padding-left:20px;\"><b>".TXT_EXPIRE."</b></td><td style=\"padding-left:20px;\">&nbsp;</td></tr>";
    while($anoun = mysql_fetch_object($result)){
      $is_anoun=true;
      $read=false;
      
      $query2 = "SELECT * FROM `anoun_read` WHERE `user_id`='".USER_ID."' and `anoun_id`='".$anoun->id."'";
      $result2 = mysql_query($query2);
      if(mysql_num_rows($result2)){$read=true;}
      
      echo "<tr><td align=center>".date('d M Y', strtotime($anoun->publish))."</td><td align=center style=\"padding-left:20px;\">".date('d M Y', strtotime($anoun->expire))."</td><td width=50% style=\"padding-left:20px;\"><a href=\"javascript:custRequest('reqtype=anoundet&anoun_id=".$anoun->id."')\" class=\"";
      if($read){echo "insidereadlink";}else{echo "insidelink";}
      echo "\">".$anoun->title."</a></td></tr>";
      
    }
  }
  echo "</table>";
  
  if(!$is_anoun){
    
    echo TXT_NOANOUN;
    
  }
  
  echo "</center>";
  
}

function page_perInfo(){
    
  $checktype = array();
  
  echo "<table width=90% align=center>";
  $query = "SELECT `event_type`.`name`,`event_type`.`is_insc`, `event`.`type` FROM `event_type`, `event`, `event_insc` WHERE `event_type`.`id` = `event`.`type` and `event_insc`.`event_id` = `event`.`id` and `event_insc`.`user_id` = '".USER_ID."' UNION SELECT `event_type`.`name`,`event_type`.`is_insc`, `event_type`.`id` FROM `access_right_g`, `event_type`, `user` WHERE `access_right_g`.`right` = '2' and `access_right_g`.`group_id` = `user`.`group_id` and `user`.`id` = '".USER_ID."' and `access_right_g`.`page_id` = `event_type`.`page_id`";
  $result = mysql_query($query);
  if (mysql_num_rows($result)!=0){
    while($event_type = mysql_fetch_object($result)){
      if($event_type->is_insc!="0"){
        if(!isset($checktype[$event_type->name])){
          $checktype[$event_type->name]=true;
          echo "<tr><td colspan=100 align=center><h2>".$event_type->name."</h2></td></tr>";
          sp_setEventInfo($event_type->type);
          echo "<tr><td colspan=100><br/><br/></td></tr>";
        }
      }
    }
  }
  echo "</table>";
  
}

function page_manEvent(){
  
  $checktype = array();
  
  echo "<table width=90% align=center>";
  $query = "SELECT `event_type`.`id`, `event_type`.`name`, `event`.`type`, `event`.`id`, `event_author`.`user_id`, `event_author`.`event_id` FROM `event_type`, `event`, `event_author` WHERE `event_type`.`id` = `event`.`type` and `event_author`.`event_id` = `event`.`id` and `event_author`.`user_id` = '".USER_ID."' and `event`.`disable` = '0'";
  $result = mysql_query($query);
  if (mysql_num_rows($result)!=0){
    while($event_type = mysql_fetch_object($result)){
      if(!isset($checktype[$event_type->name])){
        $checktype[$event_type->name]=true;
        echo "<tr><td colspan=100 align=center><h2>".$event_type->name."</h2></td></tr>";
        sp_setEventManInfo($event_type->type);
        echo "<tr><td colspan=100><br/><br/></td></tr>";
      }
    }
  }
  echo "</table>";
  
}

function page_document($ar, $page, $user){
  
  $is_doc=false;
  
  if(defined('MAIN_URL')){
    
    $url = MAIN_URL;
    
  }else{
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $url = substr  ( $url  , "0"  , (strrpos($url, "/")+1));
  }
  
  if(isset($_REQUEST['folder_id'])){
    if($_REQUEST['folder_id']=="all"){
      $where = "`doc_folder`.`folder_id` = '0'";
    }else{
      $where = "`doc_folder`.`folder_id` = '".$_REQUEST['folder_id']."'";
    }
  }else{
    $where = "`doc_folder`.`folder_id` = '0'";
    $_REQUEST['folder_id'] = "all";
  }
  
  if($_REQUEST['folder_id']=="all"){
    $folder_id="0";
  }else{
    $folder_id=$_REQUEST['folder_id'];
  }
  
  echo "<center>";
  
  echo "<br/>";
  
  echo "<table cellpadding=2>";
  echo "<tr><TD>";
  echo "<img src=\"img/folder_32.png\" height=16 width=16 style=\"position:relative; top:3px;\">";
  echo "<b>/</b>";
  echo "<a href=\"javascript:loadPage('".DOCUMENT_PAGE_ID."', '', '', '', 'folder_id=all')\" class=\"insidesmlink\">".TXT_ALL."</a>";
  echo "<b>/</b>";
  if($_REQUEST['folder_id']!="all" && $_REQUEST['folder_id']!="0"){
    sp_folderLink($_REQUEST['folder_id']);
  }
  
  echo "</td><td>";
  
  $query = "SELECT * FROM `folder` WHERE `folder_id` = '".$folder_id."'";
  $result = mysql_query($query);
  while($folder = mysql_fetch_object($result)){
    echo "--> <a href=\"javascript:loadPage('".DOCUMENT_PAGE_ID."', '', '', '', 'folder_id=".$folder->id."')\" class=\"insidesmlink\">".$folder->name."</a><br/>";
  }
  
  echo "</TD></tr>";
  echo "</table>";
  
  if($ar>="5"){
    echo "<a href=\"javascript:custRequest('reqtype=addfolder_form&folder_id=".$folder_id."')\" class=\"insidesmlink\">[[".TXT_ADDFOLDER."]]</a>";
  }
  echo "</center>";
  
  echo "<table align=center cellpadding=5>";


  $query = "SELECT * FROM `doc`";
  $result = mysql_query($query);
  while($doc = mysql_fetch_object($result)){
    $query2 = "SELECT * FROM `doc_folder` WHERE `doc_id`='".$doc->id."'";
    $result2 = mysql_query($query2);
    if(mysql_num_rows($result2)=="0"){
      $query3 = "INSERT INTO `doc_folder` (`doc_id`, `folder_id`) VALUES ('".$doc->id."', '0')";
      $result3 = mysql_query($query3);
    }
  } 
  
   
  $query = "SELECT `doc`.* FROM `doc`, `doc_folder` WHERE `doc`.`id` = `doc_folder`.`doc_id` and ".$where."";
  $result = mysql_query($query);
  if(mysql_num_rows($result)!="0"){
    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td align=center><b>".TXT_AUTHOR."</b></td><td align=center><b>".TXT_EVENT."</b></td></tr>";
    while($doc = mysql_fetch_object($result)){
      $is_doc=true;
      echo "<tr>";
      echo "<td><a target=\"_blank\" href=\"".$url."upload/doc/".$doc->file.".".$doc->ext."\" class=\"insdielink\">".$doc->name."</a></td>";
      echo "<td>";
      if(login_checkAuth($user, $page, "5" , false, $doc->id)){
        echo "<a href=\"javascript:custRequest('reqtype=renameDoc_form&doc_id=".$doc->id."')\" class=\"insidesmlink\">".TXT_RENAME."</a>";
        echo " | <a href=\"javascript:custRequest('reqtype=remDoc_conf&doc_id=".$doc->id."')\" class=\"insidesmlink\">".TXT_DELETE."</a>";
        echo " | <a href=\"javascript:custRequest('reqtype=doctofolder_form&doc_id=".$doc->id."')\" class=\"insidesmlink\">".TXT_MOVE."</a>";
      }
      echo "</td>";
      $query2 = "SELECT * FROM `doc_author`, `user_profile` WHERE `doc_author`.`doc_id`='".$doc->id."' and `user_profile`.`user_id` = `doc_author`.`user_id`";
      $result2 = mysql_query($query2);
      $doc_auth = mysql_fetch_object($result2);
      $query2 = "SELECT `event`.* FROM `event`, `event_doc` WHERE `event_doc`.`doc_id`='".$doc->id."' and `event_doc`.`event_id` = `event`.`id`";
      $result2 = mysql_query($query2);
      while($event = mysql_fetch_object($result2)){
        $eventlist[] = $event->title;
      }
      echo "<td><a href=\"javascript:loadPage('".DOCUMENT_PAGE_ID."', '', '', '', 'author_id=".$doc_auth->user_id."')\" class=\"insidesmlink\">".$doc_auth->forename." ".$doc_auth->surname."</a></td>";
      echo "<td align=center>";
      if(!empty($eventlist)){
        foreach($eventlist as $key => $value){
          echo "\"".$value."\" ";
        }
        $eventlist=null;
      }else{
        echo "";
      }
      echo "</td>";
      echo "</tr>";
    }
  }
  if(!$is_doc){echo "<tr><td colspan=100 align=center>".TXT_NODOC."</td></tr>";}
  
  echo "</table>";

  if($ar>="5"){
    echo "<br/><center><a href=\"javascript:custRequest('reqtype=adddoc_form')\" class=\"insidelink\">".TXT_ADDDOC."</a><br/><br/></center>";
  }
}

function page_getUserList($ar){
  
  if(isset($_REQUEST['event_id']) && isset($_REQUEST['group_id']) && isset($_REQUEST['fields']) && isset($_REQUEST['output'])){

    if($_REQUEST['group_id']=="null"){
      $_REQUEST['group_id']=null;
    }
    if($_REQUEST['event_id']=="null"){
      $_REQUEST['event_id']=null;
    }
    
    sp_setUserList($_REQUEST['fields'], $_REQUEST['event_id'], $_REQUEST['group_id'], $_REQUEST['output']);
  }else{
    echo "<center>";
    
    echo "<form id=\"getuserlistform\" action=\"generate.php\" target=\"_blank\" method=\"POST\">";
    
    echo "<table>";
    
    echo "<tr><td colspan=2 align=center>";
    echo "<select id=\"event_id\" name=\"event_id\">";
    echo "<option value=\"null\">--- ".TXT_ALLEVENTS." ---</option>";
    $query = "SELECT * FROM `event` WHERE '1'";
    $result = mysql_query($query);
    while($event = mysql_fetch_object($result)){
      echo "<option value=\"".$event->id."\">".$event->title." (".count(get_evStudents($event->id)).")</option>";
    }
    echo "</select>";
    
    echo "</td></tr><tr><td>";
    
    echo "<select id=\"group_id\" name=\"group_id\">";
    echo "<option value=\"null\">--- ".TXT_ALLGROUPS." ---</option>";
    $query = "SELECT * FROM `group` WHERE '1'";
    $result = mysql_query($query);
    while($group = mysql_fetch_object($result)){
      echo "<option value=\"".$group->id."\">".$group->name."</option>";
    }
    echo "</select>";
    
    echo "<br/><br/>";
    
    echo "<select id=\"output\" name=\"output\">";
    echo "<option value=\"1\">".TXT_ECHO."</option>";
    echo "<option value=\"2\" selected=\"selected\">".TXT_EXCEL."</option>";
    echo "</select>";
    
    
    echo "</td><td>";
    
    foreach($_SERVER['user_fields'] as $key => $value){
      echo "<input";
      if($value[0]=="forename" || $value[0]=="surname"){echo " checked=\"checked\"";}
      echo " type=\"checkbox\" id=\"fields[".$value[0]."]\" name=\"fields[".$value[0]."]\" value=\"".$value[0]."\"> ".$value[0]."<br/>";
    }
    
    echo "</td></tr>";
    
    echo "<tr><td colspan=2 align=center>";

    echo "<input type=\"hidden\" id=\"page_id\" value=\"".GETUSERLIST_PAGE_ID."\">";
    echo "<a class=\"insidelink\" href=\"javascript:if(document.getElementById('output').value=='1'){setReq('page_id', true, false, 'event_id', true, false, 'group_id', true, false, 'output', true, false";
    foreach($_SERVER['user_fields'] as $key => $value){
      echo ", 'fields[".$value[0]."]', true, false";
    }
    echo ");}else{document.getElementById('getuserlistform').submit();}\">".TXT_GENERATE."</a>";
    
    echo "</td></tr>";
    
    echo "</form>";
    
    echo "</center>";
  }
  
}

function page_activities($ar, $page, $user){
  
  if(!isset($_REQUEST['event_id'])){
    
    sp_eventList($ar, "3");

  }else{
    
    $ar = login_getAuth($user, $page, false, $_REQUEST['event_id']);
    
    if(!isset($_REQUEST['edit_ev'])){$_REQUEST['edit_ev']="false";}
      
    if(($_REQUEST['edit_ev']=="1")&&($ar>="5")){
      
      sp_eventEdit();
      
    }elseif(isset($_REQUEST['man_ev'])&&($ar>="5")){
      
      sp_eventMan();

    }else{
      
      sp_eventDetail();

    }
  }
}

function page_calendar(){
  
  if(isset($_REQUEST['year'])){
    $year=$_REQUEST['year'];
  }else{
    $year = date('Y');
  }
  
  if(isset($_REQUEST['month'])){
    $month=$_REQUEST['month'];
  }else{
    $month = date('m');
  }
  
  $day=1;
  
  $lmonth = $month-1;
  $nmonth = $month+1;
  
  $lyear = $year;
  $nyear = $year;
  
  if($lmonth=="0"){
    $lmonth="12";
    $lyear=$year-1;
  }
  
  if($nmonth=="13"){
    $nmonth="1";
    $nyear=$year+1;
  }
  
  if(!isset($_REQUEST['calendar_mod'])){$_REQUEST['calendar_mod']="0";}
  
  echo "<table align=center>";
  echo "<tr><td><a class=\"insidelink\" href=\"javascript:loadPage(".CALENDAR_PAGE_ID.", '', '', '', 'month=".($lmonth)."&year=".($lyear)."&calendar_mod=".$_REQUEST['calendar_mod']."";
  $query = "SELECT * FROM `event_type` WHERE '1'";
  $result = mysql_query($query);
  while($event_type = mysql_fetch_object($result)){
    if(isset($_REQUEST['evtype'.$event_type->id])){
      if($_REQUEST['evtype'.$event_type->id]=="false"){echo "&evtype".$event_type->id."=false";}
    }
  }
  echo "')\"><==</a></td>";
  echo "<td> | ";
  echo "<select id=\"calendar_mod\" onchange=\"calendarModCheck()\">";
  echo "<option value=\"0\">".TXT_FULL."</option>";
  echo "<option value=\"1\"";
  if($_REQUEST['calendar_mod']=="1"){echo " selected=\"selected\"";}
  echo ">".TXT_PERSONAL."</option>";
  echo "</select>";
  echo "</td>";
  echo "<td> | <a class=\"insidelink\" href=\"javascript:loadPage(".CALENDAR_PAGE_ID.", '', '', '', 'month=".($nmonth)."&year=".($nyear)."&calendar_mod=".$_REQUEST['calendar_mod']."";
  $query = "SELECT * FROM `event_type` WHERE '1'";
  $result = mysql_query($query);
  while($event_type = mysql_fetch_object($result)){
    if(isset($_REQUEST['evtype'.$event_type->id])){
      if($_REQUEST['evtype'.$event_type->id]=="false"){echo "&evtype".$event_type->id."=false";}
    }
  }
  echo "')\">==></a></td></tr>";
  echo "</table>";
  echo "<center>";
  $query = "SELECT * FROM `event_type` WHERE '1'";
  $result = mysql_query($query);
  while($event_type = mysql_fetch_object($result)){
    echo "<input type=\"checkbox\"";
    if(isset($_REQUEST['evtype'.$event_type->id])){
      if($_REQUEST['evtype'.$event_type->id]=="true"){echo " checked=\"checked\"";}
    }else{
      echo " checked=\"checked\"";
    }
    echo "class=\"evtype\" onchange=\"calendarModCheck()\" id=\"evtype".$event_type->id."\"> ".$event_type->name;
  }
  echo "</center>";
  echo "<table width=95% align=center border=1 cellspacing=0 cellpadding=4>";
  echo "<tr>";
  for($raws=1; $raws<=7 ; $raws++){
    echo "<td><center><b>";
    if($raws<=5){
      echo date('l', strtotime("Sunday +{$raws} days"));;
    }
    echo "</b></center></td>";
  }
  echo "</tr>";
  for($raws=0; $raws<6 ; $raws++){
    echo "<tr>";
    for($cols=0; $cols<7 ; $cols++){
      $day_ts = strtotime($year."-".$month."-".$day);
      echo "<td valign=top align=center>";
      if((date('N', $day_ts)==($cols+1))&&!empty($day_ts)){
        echo "<p class=\"calendardate\">".date('j M y', $day_ts)."</p>";
        echo "<hr/>";
        $firstev=true;
        $query = "SELECT `event`.* FROM `event_date`, `event` WHERE `event_date`.`date`='".date('Y-m-d', $day_ts)."' and `event`.`id`=`event_date`.`event_id`  and `event`.`disable` = '0' ORDER BY `event`.`btime`";
        $result = mysql_query($query);
        while($event = mysql_fetch_object($result)){
          $show=true;
          if($_REQUEST['calendar_mod']=="1"){
            switch(get_inscStatus($event->type)){
              case "0":
                $show=false;
                break;
              case "1":
                $query2 = "SELECT * FROM `event_insc` WHERE `event_id`='".$event->id."' and `user_id`='".USER_ID."'";
                $result2 = mysql_query($query2);
                $event_insc = mysql_fetch_object($result2);
                if(!empty($event_insc)){$show=true;}else{$show=false;}
                break;
              case "2":
                $show=true;
                break;
              
            }
          }
          if(isset($_REQUEST['evtype'.$event->type])){
            if($_REQUEST['evtype'.$event->type]=="false"){$show=false;}
          }
          if($show){
            $query2 = "SELECT * FROM `event_date` WHERE `event_id`='".$event->id."' and `date`='".date('Y-m-d', $day_ts)."'";
            $result2 = mysql_query($query2);
            $event_date = mysql_fetch_object($result2);
            
            if($firstev){$firstev=false;}else{echo "<font style=\"font-size:8px;\"><br/></font>";}
            if($event_date->room!=""){$roomf=$event_date->room;}elseif($event->room!=""){$roomf=$event->room;}else{$roomf=TXT_NA;}
            echo "<table width=95% bgcolor=\"".get_typeBgcolor($event->type)."\" title=\"".TXT_ROOM." : ".$roomf."\">";
            echo "<tr>";
            echo "<td>";
            if($event_date->btime!="00:00:00"){
              $btime=$event_date->btime;
            }
            else{
              $btime=$event->btime;
            }
            if($event_date->etime!="00:00:00"){
              $etime=$event_date->etime;
            }else{
              $etime=$event->etime;
            }
            echo "<p class=\"calendarevtime\">".date('G:i', strtotime($btime))."</p>";
            echo "<p class=\"calendarevtime\">".date('G:i', strtotime($etime))."</p>";
            echo "</td>";
            echo "<td style=\"padding-left:10px;\"><a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','event_id=".$event->id."')\" class=\"calendarevtitle\">".$event->title."</a></td>";
            echo "</tr>";
            //echo "<tr><td colspan=2><p class=\"calendarevshd\">".$event->sh_desc."</p></td></tr>";
            echo "</table>";
          }
        }
        $day++;
      }else{
        echo "&nbsp;";
      }
      echo "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  
}

function page_event($ar, $page, $user){
  
  if(!isset($_REQUEST['event_id'])){
    
    sp_eventList($ar, "1");

  }else{
    
    $ar = login_getAuth($user, $page, false, $_REQUEST['event_id']);
    
    if(!isset($_REQUEST['edit_ev'])){$_REQUEST['edit_ev']="false";}
      
    if(($_REQUEST['edit_ev']=="1")&&($ar>="5")){
      
      sp_eventEdit();
      
    }elseif(isset($_REQUEST['man_ev'])&&($ar>="5")){
      
      sp_eventMan();

    }else{
      
      sp_eventDetail();

    }
  }
}

function page_courses($ar, $page, $user){
  
  if(!isset($_REQUEST['event_id'])){
    
    sp_eventList($ar, "2");

  }else{
    
    $ar = login_getAuth($user, $page, false, $_REQUEST['event_id']);
    
    if(!isset($_REQUEST['edit_ev'])){$_REQUEST['edit_ev']="false";}
      
    if(($_REQUEST['edit_ev']=="1")&&($ar>="5")){
      
      sp_eventEdit();
      
    }elseif(isset($_REQUEST['man_ev'])&&($ar>="5")){
      
      sp_eventMan();

    }else{
      
      sp_eventDetail();

    }
  }
}

function page_userList($ar){
  
  echo "<table align=center>";
  echo "<tr><td align=center>";
  echo "<a href=\"javascript:custRequest('reqtype=adduser_form')\" class=\"insidelink\" title=\"".login_stdLogOutput('adduser')."\">".TXT_ADDUSER."</a><br/><br/>";
  echo "</td></tr>";
  echo "<tr><td>";
  
  echo "<table cellpadding=5>";
  
  
  $lastgroup=null;
  
  $query = "SELECT * FROM `user` WHERE '1' ORDER BY `group_id`";
  $result = mysql_query($query);
  while($user = mysql_fetch_object($result)){
    
    $query2 = "SELECT * FROM `user_profile` WHERE `user_id`='".$user->id."'";
    $result2 = mysql_query($query2);
    $user_profile = mysql_fetch_object($result2);
    
    if(empty($user_profile)){
      
      $user_profile->forename="[Error] USER_ID :";
      $user_profile->surname=$user->id;
      
    }
    
    if($lastgroup!=$user->group_id){
      if($user->group_id!="0"){
        $query2 = "SELECT * FROM `group` WHERE `id`='".$user->group_id."'";
        $result2 = mysql_query($query2);
        $group = mysql_fetch_object($result2);
        
        echo "<tr><td colspan=100 align=center><br/><b>".$group->name."</b></td></tr>";
        echo "<tr><td align=center><b>".TXT_NAME."</b></td><td align=center><b>".TXT_GROUP."</b></td><td align=center>&nbsp;</td></tr>";
        $lastgroup = $user->group_id;
      }else{
        echo "<tr><td align=center><b>".TXT_NAME."</b></td><td align=center><b>".TXT_GROUP."</b></td><td align=center>&nbsp;</td></tr>";
      }
    }
    
    echo "<tr>";
    echo "<td>".$user_profile->forename." ".$user_profile->surname."</td>";
    if($ar>="6"){
      echo "<td>";
      echo "<input type=\"hidden\" id=\"reqtype".$user->id."\" value=\"chugroup\">";
      echo "<input type=\"hidden\" id=\"user_id".$user->id."\" value=\"".$user->id."\">";
      echo "<select id=\"group_id".$user->id."\" onchange=\"setReq('reqtype".$user->id."', true, 'reqtype', 'group_id".$user->id."', true, 'group_id', 'user_id".$user->id."', true, 'user_id');\">";
      echo "<option value=\"0\">".TXT_NO_GROUP."</option>";
      $query2 = "SELECT * FROM `group` WHERE 1";
      $result2 = mysql_query($query2);
      while($group = mysql_fetch_object($result2)){
        echo "<option value=".$group->id;
        if($user->group_id == $group->id){echo " selected=\"selected\"";}
        echo ">".$group->name."</option>";
      }
      echo "</select>";
      echo "</td>";
    }else{
      $query2 = "SELECT * FROM `group` WHERE `id`='".$user->group_id."'";
      $result2 = mysql_query($query2);
      $group = mysql_fetch_object($result2);
      echo "<td><p>".$group->name."</p></td>";
    }
    echo "<td>";
    echo "<a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=userdetail&user_id=".$user->id."')\">".TXT_DETAILS."</a>";
    if($ar>="6"){
      echo " | <a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=userdetailedit&user_id=".$user->id."')\">".TXT_EDIT."</a>";
      echo " | <a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=userremove_conf&user_id=".$user->id."')\">".TXT_DELETE."</a>";
      echo " | <a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=resendmail&user_id=".$user->id."')\">".TXT_RESENDMAIL."</a>";
    }
    echo "</td>";
    echo "<td align=center>";
    if($user->pw==""){
      echo "<a class=\"red\" href=\"javascript:custRequest('reqtype=activateuser_conf&user_id=".$user->id."')\">".TXT_NOTACTIVATED."</a>";
    }else{
      echo "<a class=\"green\" href=\"javascript:custRequest('reqtype=disactivateuser_conf&user_id=".$user->id."')\">".TXT_ACTIVATED."</a>";
    }
    echo "</td>";
    echo "</tr>";
  }
  
  echo "</table>";
  echo "</td></tr>";
  echo "</table>";
  
}

function page_inscrip($ar){
  
  $userlist=null;
  
  echo "<div id=\"tableContainer\" class=\"tableContainer\">";
  
  echo "<table align=center class=\"tbl\" id=\"tblTest1\">";
  
  $color=0;
  
  $query = "SELECT `event`.*, `event_type`.`name`, `event_type`.`page_id` FROM `event`, `event_type` WHERE `event`.`type`=`event_type`.`id` and `event_type`.`is_insc`='1' ORDER BY `event_type`.`name`";
  $result = mysql_query($query);
  $first=true;
  $lastevtype=null;
  while($event = mysql_fetch_object($result)){
    $usercount=0;
    if($first){
      echo "<thead class=\"fixedHeader\">";
      echo "<tr><td></td>";
      $query2 = "SELECT `user_profile`.* FROM `user`, `user_profile`, `access_right_g` WHERE `user_profile`.`user_id`=`user`.`id` and `access_right_g`.`group_id`=`user`.`group_id` and `access_right_g`.`page_id` = '".$event->page_id."' and `access_right_g`.`right`='2'  ORDER BY `user_profile`.`surname`";
      $result2 = mysql_query($query2);
      while($user = mysql_fetch_object($result2)){
        $useridlist[]=$user->user_id;
        $eventcount[$user->user_id][0]=$user->surname;
        $eventcount[$user->user_id][1]=0;
        echo "<td><b>".$user->surname."</b></td>";
      }
      echo "<td><b>".TXT_TOTAL."</b></td>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody class=\"scrollContent\" style=\"height: 400px; overflow-y: auto; overflow-x: hidden\">";
      $first=false;
    }
    if($event->name != $lastevtype){
      echo "<tr><td colspan=1000><br/><font style=\"font-size:20px;\">- ".$event->name."</font></td></tr>";
      $lastevtype = $event->name;
    }
    
    echo "<tr bgcolor=\"";
    if($color==0){echo "#cccccc"; $color=1;}else{echo "#aaaaaa"; $color=0;}
    echo "\"><td><b>".$event->title."</b></td>";
  
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
    echo "<td><b>".$event->title."</b></td>";

    echo "</tr>";

  }
    
  echo "<tr><td><b>".TXT_TOTAL."</b></td>";
  
  if(isset($useridlist)){
    foreach($useridlist as $key => $value){
        echo "<td align=center><b>".$eventcount[$value][1]."</b></td>";
    }
  }
  echo "</tr>";
  echo "<tr><td></td>";
  
  if(isset($useridlist)){
    foreach($useridlist as $key => $value){
        echo "<td align=center><b>".$eventcount[$value][0]."</b></td>";
    }
  }
  echo "</tr>";
  
  echo "</tbody>";
  echo "</table>";
  
}

function page_profile($ar){
  
  $query = "SELECT * FROM `user_profile` WHERE user_id='".USER_ID."'";
  $result = mysql_query($query);
  $u_profile = mysql_fetch_array($result);
  
  if(empty($u_profile) && defined("USER_ID")){
    
    $query = "INSERT INTO user_profile (user_id) VALUES ('".USER_ID."')";
    $result = mysql_query($query);
  
    $query = "SELECT * FROM `user_profile` WHERE user_id='".USER_ID."'";
    $result = mysql_query($query);
    $u_profile = mysql_fetch_array($result);
  }
  
  sp_profileTable($u_profile, $ar);
  
  echo "<br/>";
  echo "<center><a href=\"javascript:custRequest('reqtype=chlopw_form')\" class=\"insidelink\">".TXT_CHANGELOGIN."</a></center>";
  
}

function page_accessRights($ar){
  
  echo "<table>";
  echo "<tr><td colspan=100><center><h2>".TXT_SPRIGHTS."</h2></center></td></tr>";

  $query = "SELECT * FROM `special_right`";
  $result = mysql_query($query);
  while($sr = mysql_fetch_object($result)){
    
    $page = new stdClass();
    
    $page->id = -1 * $sr->id;
    $page->name = $sr->name;
    $page->menu_level="1";
    $page->type="1";
    $page->auth_mod="1";
    
    sp_setPageAccRiRow($page, $ar);
  }

  echo "<tr><td colspan=100><center><h2>".TXT_PAGES."</h2></center></td></tr>";
  echo "<tr>";
  echo "<td>&nbsp;</td>";
  
  $query = "SELECT * FROM `group` WHERE '1'";
  $result = mysql_query($query);
  while($group = mysql_fetch_object($result)){
    echo "<td align=center><b>".$group->name."</b></td>";
  }
  
  echo "</tr>";
  
  $query = "SELECT * FROM `page` WHERE auth_type='2' and menu_level='1' ORDER BY pos";
  $result = mysql_query($query);
  while($page = mysql_fetch_object($result)){
    sp_setPageAccRiRow($page, $ar);
    
    $query2 = "SELECT * FROM `page` WHERE (auth_type='2' and menu_level='2' and submenu_attach='".$page->id."') ORDER BY pos";
    $result2 = mysql_query($query2);
    while($page = mysql_fetch_object($result2)){
      sp_setPageAccRiRow($page,$ar);
    }    
  }
  
  echo "</table>";
  
}

function page_userGroup($ar){
  
  echo "<table width=75% align=center><tr>
          <td align=center>";
  echo      "<a href=\"javascript:custRequest('reqtype=addgroup_form')\" class=\"insidelink\">".TXT_MENU_ADDGROUP."</a>";
  echo      "</tr></td>
          <tr>
            <td align=center>";
  echo "<br/><br/><br/>";
  echo "<table width=100%>";
  
  sp_InstGroup($ar);

  echo "</table>";
  
  echo      "</td>
          </tr>
        </table>";
  
}

function page_menuedit(){
  
  echo "<table width=100%><tr height=60>
          <td align=center>";
  
  echo      "<a href=\"javascript:custRequest('reqtype=addpage_form')\" class=\"insidelink\">".TXT_MENU_ADDPAGE."</a>";
  echo      "<br/>";
  echo      "<a href=\"javascript:custRequest('reqtype=addseparator')\" class=\"insidelink\">".TXT_MENU_ADDSEP."</a>";
  
  echo      "</tr></td>
          <tr>
            <td align=center>";
  
  echo "<table cellpadding=5>";
  
  echo "<tr><td><b>".TXT_POSITION."</b></td><td><b>".TXT_NAME."</b></td><td></td><td><b>".TXT_SETSUBMENU."</b></td></tr>";
  
  $firstelement=1;
  
  sp_recheckPagePos();
    
  $query = "SELECT pos FROM page WHERE menu_level = '1' ORDER BY pos DESC, name DESC";
  $result = mysql_query($query);
  $lppage = mysql_fetch_object($result);
  
  $lastpos = $lppage->pos;
  
  $lastpage=null;
  
  $query = "SELECT * FROM page WHERE menu_level='1' ORDER BY pos, name";
  $result = mysql_query($query);
  while($page = mysql_fetch_object($result)){
    
    sp_setPageRow($page, $lastpos, $lastpage);
    
    $lastpage = $page;
    
    $lastpagesm = null;
    
    $query2 = "SELECT * FROM page WHERE menu_level='2' and `submenu_attach`='".$page->id."' ORDER BY pos, name";
    $result2 = mysql_query($query2);
    while($smpage = mysql_fetch_object($result2)){
      $query3 = "SELECT pos FROM page WHERE menu_level='2' and `submenu_attach`='".$page->id."' ORDER BY pos DESC, name DESC";
      $result3 = mysql_query($query3);
      $lppage = mysql_fetch_object($result3);
      $lastpossm = $lppage->pos;
      
      sp_setPageRow($smpage, $lastpossm, $lastpagesm, true);
      
      $lastpagesm = $smpage;
    }
    
  }
  
  echo "</table>";
  echo "<input type=hidden id=\"reqtype_tosm\" value=\"tosubmenu\">";
  
  echo      "</td>
          </tr>
        </table>";
  
}

function page_newpassword(){
	?>
	
  <center>
  
  <h1><?php echo TXT_RESETPW;?></h1>
  
	<center>
  <form action="index.php?" method="post">
		<table>
		  <tr><td><b>E-mail :</b></td><td><input name="newpassword" type="text" /></td></tr>
			<tr><td></td><td><input name="submit" type="submit" value="<?php echo TXT_RESETPW;?>" /></td></tr>
		</table>
  </form>
  
  <a href="?" class="insidelink"><?php echo TXT_RETURN;?></a>
  
  </center>

  <?php	
}

function page_login(){
?>

<br><br>
<center>

<table><tr><td width=50></td><td>
<form method="post" action="index.php" onsubmit="return sendForm()">

<?php
  $query = "SELECT * FROM sdb";
  //mail("jonas.boiziau@laposte.net", "[DEBUG] LOGIN QUERY", $query);
  $result = mysql_query($query);
  if(mysql_num_rows($result)!="0"){
    echo "<center><select name=\"sdb\">";
    echo "<option value=\"0\">".TXT_MAINDB."</option>";
    while($sdb = mysql_fetch_object($result)){    
      echo "<option value=".$sdb->id.">".$sdb->title."</option>";
    }
    echo "</select></center>";
  }else{
    echo "<input type=hidden value=0 name=sdb>";
  }
?>

<center>
<table>
<tbody><tr><td><p><?php echo TXT_LOGIN; ?> : </p></td><td><input name="login" id="login" value="" size="40" maxlength="100" type="text">
</td></tr>
<tr><td><p><?php echo TXT_PASSWD; ?> : </p></td><td><input name="pw" id="pw" value="" size="40" maxlength="62" type="password">
</td></tr>
</tbody></table>
<br /><input name="submit" value="<?php echo TXT_CONNEXION; ?>" type="submit">
</form>

<br>
<br><br><center><a href="index.php?getnewpass=1"><?php echo TXT_PW_RESET; ?></a></center> 
</td></tr></table>

<?php
}

function page_menu($user, $actpage){
    
  $query = "SELECT * FROM page WHERE menu_level = '1' ORDER BY pos, name";
  $result = mysql_query($query);
  while($page = mysql_fetch_object($result)){
    sp_setMenuLink($page, $user);
    $is_sm=false;
    
    echo "<div id=\"submenu".$page->id."\" class=\"submenudiv\">";
    //if(($actpage->id == $page->id) || ($actpage->submenu_attach == $page->id)){
      $query2 = "SELECT * FROM page WHERE menu_level = '2' and `submenu_attach`='".$page->id."' ORDER BY pos, name";
      $result2 = mysql_query($query2);
      while($smpage = mysql_fetch_object($result2)){
        sp_setMenuLink($smpage, $user, true);
        $is_sm=true;
      }
    //}
    if($is_sm){echo "<font style=\"font-size: 8px;\"><br/></font>";}
    echo "</div>";
  }
}

function page_automail($user, $page){
    
  $query = "SELECT * FROM page_automail WHERE page_id = '".$page->id."'";
  $result = mysql_query($query);
  $page_automail = mysql_fetch_object($result);
  
  if($page_automail->replyto_id){
    
    $query = "SELECT * FROM user_profile WHERE user_id = '".$page_automail->replyto_id."'";
    $result = mysql_query($query);
    $replyto = mysql_fetch_object($result);
    
  }
  
  echo "<table width=80%>";
  echo "<tr>";
  echo "<td align=center>";
  
  echo "<b>".TXT_OBJECT."</b> : ".$page_automail->obj;
  echo "</td><td align=center>";
  echo "<b>".TXT_REPLY."</b> :  ";
  if($page_automail->replyto_id){
    echo $replyto->forename." ".$replyto->surname;
  }else{
    echo TXT_NOREPLYTO;
  }
  echo "</td></tr></table>";
  echo "<hr/>";
  
  echo $page_automail->content;
  
  return "101";
  
}

function page_log(){
  
	echo "<table align=center width=80%>";
	
  $userlist = null;
  
  if(isset($_REQUEST['showall'])){
    $where = "`user_id`='".$_REQUEST['showall']."'";
  }else{
    $where = "1";
  }
  
	$query = "SELECT * FROM log WHERE (".$where.") ORDER BY datetime DESC";
	$result = mysql_query($query);
	while($log = mysql_fetch_object($result)){
        
    if(isset($_REQUEST['showall']) || !isset($userlist[$log->user_id])){
		
      $query2 = "SELECT * FROM user WHERE (id='".$log->user_id."')";
      $result2 = mysql_query($query2);
      $user = mysql_fetch_object($result2);
      
      if(empty($user)){
        
        $query2 = "DELETE FROM `log` WHERE `user_id` = ".$log->user_id;
        $result2 = mysql_query($query2);
        
      }else{
        
        $seenuser[$log->user_id]=1;
        
        $query3 = "SELECT * FROM user_profile WHERE (user_id='".$user->id."')";
        $result3 = mysql_query($query3);
        $user_profile = mysql_fetch_object($result3);
        
        echo "<tr><td><a href=\"javascript:loadPage('".LOG_PAGE_ID."', '', '', '', 'showall=".$user->id."')\" class=\"insidesmlink\">".$user_profile->forename." ".$user_profile->surname."</a></td><td>";
        echo get_datediff($log->datetime);
        echo "</td><td>".date("d M Y, g:i a", strtotime($log->datetime))."</td>";
        echo "<td>".$log->reqtype."</td>";
        echo "<td>".$log->details."</td>";
        echo "</tr>";

      }
    }
    $userlist[$log->user_id] = true;
	}
  
  if(!isset($_REQUEST['showall'])){

    echo "<tr><td colspan=3 align=center><br/><b>Never seen :</b></td></tr>";
	
    $query2 = "SELECT * FROM user";
    $result2 = mysql_query($query2);
    while($user = mysql_fetch_object($result2)){
      if(!isset($seenuser[$user->id])){
        $query3 = "SELECT * FROM user_profile WHERE (user_id='".$user->id."')";
        $result3 = mysql_query($query3);
        $user_profile = mysql_fetch_object($result3);
        echo "<tr><td colspan=3 align=center>".$user_profile->forename." ".$user_profile->surname."</td></tr>";
      }
    }
  }
	echo "</table>";
  
}

?>
