<?php

function code2utf($num){
  if($num<128)
    return chr($num);
  if($num<1024)
    return chr(($num>>6)+192).chr(($num&63)+128);
  if($num<32768)
    return chr(($num>>12)+224).chr((($num>>6)&63)+128)
          .chr(($num&63)+128);
  if($num<2097152)
    return chr(($num>>18)+240).chr((($num>>12)&63)+128)
          .chr((($num>>6)&63)+128).chr(($num&63)+128);
  return '';
}

function unescape($strIn, $iconv_to = 'UTF-8') {
  $strOut = '';
  $iPos = 0;
  $len = strlen ($strIn);
  while ($iPos < $len) {
    $charAt = substr ($strIn, $iPos, 1);
    if ($charAt == '%') {
      $iPos++;
      $charAt = substr ($strIn, $iPos, 1);
      if ($charAt == 'u') {
        // Unicode character
        $iPos++;
        $unicodeHexVal = substr ($strIn, $iPos, 4);
        $unicode = hexdec ($unicodeHexVal);
        $strOut .= code2utf($unicode);
        $iPos += 4;
      }
      else {
        // Escaped ascii character
        $hexVal = substr ($strIn, $iPos, 2);
        if (hexdec($hexVal) > 127) {
          // Convert to Unicode
          $strOut .= code2utf(hexdec ($hexVal));
        }
        else {
          $strOut .= chr (hexdec ($hexVal));
        }
        $iPos += 2;
      }
    }
    else {
      $strOut .= $charAt;
      $iPos++;
    }
  }
  if ($iconv_to != "UTF-8") {
    $strOut = iconv("UTF-8", $iconv_to, $strOut);
  }  
  return $strOut;
}

function sp_checkAnounExp(){
  
  $query = "SELECT * FROM `anoun` WHERE `expire`<CURDATE()";
  $result = mysql_query($query);
  while($anoun = mysql_fetch_object($result)){
    $query2 = "DELETE FROM `anoun` WHERE `id`='".$anoun->id."'";
    $result2 = mysql_query($query2);
    
    $query2 = "DELETE FROM `anoun_read` WHERE `anoun_id`='".$anoun->id."'";
    $result2 = mysql_query($query2);

  }
}

function sp_checkAnoun(){
  if(defined('USER_ID')){
    $query = "SELECT * FROM `anoun` WHERE '1' ORDER BY `publish` DESC";
    $result = mysql_query($query);
    $first=true;
    while($anoun = mysql_fetch_object($result)){
      $query2 = "SELECT * FROM `anoun_read` WHERE anoun_id='".$anoun->id."' and `user_id`='".USER_ID."'";
      $result2 = mysql_query($query2);
      if(mysql_num_rows($result2)=="0"){
        if($first){$first=false; echo "<b>".TXT_UNREADAN."</b>";}else{echo " --- ";}
        echo "<a href=\"javascript:custRequest('reqtype=anoundet&anoun_id=".$anoun->id."')\" class=\"insidelink\">".$anoun->title."</a>";
      }
    }
  }
}

function sp_setEvTypeOptions($evtype_id){
  
  echo "<select>";
  echo "<option>---</option>";
  $query = "SELECT * FROM `event_type` WHERE '1' ORDER BY `name` DESC";
  $result = mysql_query($query);
  while($event_type = mysql_fetch_object($result)){
    echo "<option>".$event_type->name."</option>";
  }
  echo "</select>";
  
}


function sp_eventEdit(){
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event_type` WHERE id='".$event->type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".$event_type->page_id."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  echo "<center>";
  echo "<form action=\"#\" onsubmit=\"return false\">";
  echo "<input type=hidden id=\"reqtype\" value=\"updateevent\">";
  echo "<input type=hidden id=\"event_id\" value=\"".$event->id."\">";
  echo "<b>".TXT_TITLE."</b> : <input size=60 type=text id=\"event_title\" value=\"".$event->title."\">";
  echo "<br/><br/>";
  
  
  if(login_checkAuth($user, $page, "6", false, $event->id)){
    echo "<a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_DETAILS."</a>";
    echo " | <b>".TXT_EDIT."</a>";
    echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','man_ev=1&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_MANAGE."</a>";
    echo "<br/>";
  }
  
  echo "<br/><table width=100%>";
  echo "<tr><td height=5 align=center style=\"background-color:#".$event_type->color.";\">";
  echo "</td></tr>";
  echo "</table><br/>";
  
  echo "<table cellpadding=10>";
  echo "<tr><td><b>".TXT_TIME."</b></td><td>";
  sp_setTimeOptionsHH('btimehh', $event->btime);  sp_setTimeOptionsMM('btimemm', $event->btime);
  echo " - ";
  sp_setTimeOptionsHH('etimehh', $event->etime);  sp_setTimeOptionsMM('etimemm', $event->etime);
  echo "<br/>";
  echo "</td>";
  echo "<td>";
  echo "<b>".TXT_ROOM."</b> : <input type=text id=\"event_room\" value=\"".$event->room."\">";
  echo "</td>";
  echo "<td align=right>";
  /*
  echo "<select id=\"event_type\">";
  $query = "SELECT * FROM `event_type` WHERE '1' ORDER BY name";
  $result = mysql_query($query);
  while($event_type = mysql_fetch_object($result)){
    echo "<option value=\"".$event_type->id."\"";
    if($event->type==$event_type->id){echo " selected=\"selected\"";}  
    echo ">".$event_type->name."</option>";    
  }
  echo "</select>";
  */
  echo "<input type=hidden id=\"event_type\" value=\"".$event->type."\">";
  echo "</td></tr>";
  echo "<tr><td><b>".TXT_DATES."</b><br/><br/>";
  echo "<a href=\"javascript:custRequest('reqtype=adddate_form&event_id=".$event->id."')\" class=\"insidelink\">".TXT_ADDDATE."</a>";
  echo "</td><td colspan=2>";
  $query = "SELECT * FROM `event_date` WHERE event_id='".$event->id."' ORDER BY date";
  $result = mysql_query($query);
  $nbres = mysql_num_rows($result);
  while($event_date = mysql_fetch_object($result)){
    echo date('D d M Y', strtotime($event_date->date))."";
    echo " <a href=\"javascript:custRequest('reqtype=remevdate&date_id=".$event_date->id."')\" class=\"insidesmlink\">(".TXT_REMOVE.")</a>";
    echo " | <a href=\"javascript:custRequest('reqtype=editdate_form&date_id=".$event_date->id."')\" class=\"insidesmlink\">(".TXT_EDIT.")</a>";
    if($event_date->room!=""){
      echo " ".TXT_ROOM." : ".$event_date->room;
    }
    if($event_date->btime!="00:00:00"){
      echo ", ".TXT_TIME." : ".date('H:i', strtotime($event_date->btime))." - ".date('H:i', strtotime($event_date->etime));
    }
    echo "<br/>";
  }
  
  echo "</td>";
  echo "<td align=center>";
  echo "<table height=100% cellpadding=20>";
  if(get_inChargeStatus($event->type)){
    echo "<tr><td align=center><b>".TXT_INCHARGE."</b> (<a href=\"javascript:custRequest('reqtype=addauthor_form&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_ADD."</a>)<br/><br/>";
    $query = "SELECT `event_author`.* , `user_profile`.`forename`, `surname` FROM `event_author`, `user_profile` WHERE `event_author`.`event_id`='".$event->id."' and `user_profile`.`user_id`=`event_author`.`user_id`";
    $result = mysql_query($query);
    while($event_author = mysql_fetch_object($result)){
      echo $event_author->forename." ".$event_author->surname." <a href=\"javascript:custRequest('reqtype=remevauthor&author_id=".$event_author->id."')\" class=\"insidesmlink\">(".TXT_REMOVE.")</a><br/>";
    }
    echo "</td></tr>";
  }
  if(get_ectsStatus($event->type)){
    echo "<tr><td align=center><b>".TXT_ECTS."</b><br/>";
    echo "<input type=\"text\" size=\"3\" id=\"ects\" value=\"".$event->ects."\">";
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</td>";
  echo "</tr>";
  echo "<tr><td><b>".TXT_SHDESC."</b><br/>".TXT_400CHAR."</td><td colspan=3><textarea id=\"sh_desc\" cols=100 rows=4>".br2nl($event->sh_desc)."</textarea></td></tr>";
  echo "<tr><td><b>".TXT_DESC."</b></td><td colspan=3><textarea id=\"desc\" cols=100 rows=15>".br2nl($event->desc)."</textarea></td></tr>";
  echo "</table>";    
  echo "<a href=\"javascript:setReq('event_room', false, false, 'reqtype', true, false, 'btimehh', true, false, 'etimehh', true, false, 'btimemm', true, false, 'etimemm', true, false, 'event_id', true, false, 'event_title', true, false, 'sh_desc', false, false, 'desc', false, false";
  if(get_ectsStatus($event->type)){echo ", 'ects', false, false";}
  echo ")\" class=\"insidelink\">".TXT_UPDATE."</a>";    
  echo "</form>";
  echo "</center>";
  
}

function sp_setEventInfo($type){
  
  $query = "SELECT * FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);

  $is_course=false;
  
  $query = "SELECT `event`.* FROM `event_insc`, `event` WHERE `event_insc`.`user_id`='".USER_ID."' and `event`.`id` = `event_insc`.`event_id` and `event`.`type` = '".$type."'  and `event`.`disable` = '0' UNION SELECT `event`.* FROM `event` , `access_right_g`, `event_type`, `user` WHERE `event_type`.`is_insc`='2' and `event`.`type`='".$type."' and `access_right_g`.`right` = '2' and `access_right_g`.`group_id` = `user`.`group_id` and `user`.`id` = '".USER_ID."' and `access_right_g`.`page_id` = `event_type`.`page_id` and `event`.`type` = `event_type`.`id` and `event`.`disable` = '0' UNION SELECT `event`.* FROM `event`, `event_prio` WHERE `event`.`type` = '".$type."' and `event`.`id` = `event_prio`.`event_id` and `event_prio`.`user_id` = '".USER_ID."' and `event`.`disable` = '0'";
  $result = mysql_query($query);
  if(mysql_num_rows($result)!=0){
    echo "<tr><td><b>&nbsp;</b></td><td><b>&nbsp;</b></td>";
    if(get_ectsStatus($type)){echo "<td align=center><b>".TXT_ECTS."</b></td>";}
    echo "<td align=center><b>".TXT_NOTES."</b></td><td align=center><b>".TXT_AVERAGE."</b></td></tr>";
    while($event = mysql_fetch_object($result)){
  
      $query2 = "SELECT * FROM `event_type` WHERE id='".$event->type."'";
      $result2 = mysql_query($query2);
      $event_type = mysql_fetch_object($result2);
      
      $query2 = "SELECT * FROM `event_insc` WHERE event_id='".$event->id."' and user_id='".USER_ID."'";
      $result2 = mysql_query($query2);
      $event_insc = mysql_fetch_object($result2);
      
      $query2 = "SELECT * FROM `event_prio` WHERE event_id='".$event->id."' and user_id='".USER_ID."'";
      $result2 = mysql_query($query2);
      $event_prio = mysql_fetch_object($result2);
  
      $is_course=true;
      echo "<tr><td><a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."')\" class=\"insidelink\">".$event->title."</a> ";
      echo "</td><td>";
      if(get_inscStatus($event->type)=="2" && get_isStudent($user->group_id, $event_type->page_id)){
        echo "<b>".TXT_OBLIGATORY."</b>";
      }elseif(!empty($event_insc)){
        echo "<b>".TXT_SUBSCRIBED."</b>";
      }elseif(!empty($event_prio)){
        echo get_choiceNum($event_prio->priority);
      }
      echo "</td>";
      if(get_ectsStatus($type)){echo "<td align=center>".$event->ects."</td>";}
      echo "<td align=center>";
      $query2 = "SELECT * FROM `test_note`, `test` WHERE `test`.`id` = `test_note`.`test_id` and `test_note`.`user_id`='".USER_ID."' and `test`.`event_id` = '".$event->id."'";
      $result2 = mysql_query($query2);
      $first=true;
      $sum=0;
      $sum_p=0;
      if(mysql_num_rows($result2)!=0){
        while($note = mysql_fetch_object($result2)){
          if($first){$first=false;}else{echo " | ";}
          echo $note->note;
          $sum += $note->note;
          $sum_p += $note->pond;
        }
      }else{
        echo TXT_NONE;
      }
      echo "</td><td align=center>";
      if($sum_p){echo round(($sum/$sum_p), 2);}else{echo TXT_NA;}
      echo "</td></tr>";
    }
  }else{
    echo "<tr><td colspan=100 align=center><b>".get_TypeToNoItem($type)."</b></td></tr>";
  }
  
}

function sp_setEventManInfo($type){
  
  $is_course=false;
  
  $query = "SELECT * FROM `event_author`, `event` WHERE `event_author`.`user_id`='".USER_ID."' and `event`.`id` = `event_author`.`event_id` and `event`.`type` = '".$type."' and `event`.`disable`='0'";
  $result = mysql_query($query);
  if(mysql_num_rows($result)!=0){
    echo "<tr><td><b>&nbsp;</b></td><td></td><td align=center><b>".TXT_STUDENTS."</b></td></tr>";
    while($event = mysql_fetch_object($result)){
      $is_course=true;
      echo "<tr><td><a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."')\" class=\"insidelink\">".$event->title."</b></td>";
      echo "<td>";
      echo "<a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'edit_ev=1&event_id=".$event->id."')\" class=\"insidelink\">".TXT_EDIT."</a>";
      echo " | <a href=\"javascript:custRequest('reqtype=disableevent&event_id=".$event->id."')\" class=\"insidelink\">".TXT_DISABLE."</a>";
      //echo " | <a href=\"javascript:custRequest('reqtype=remevent_conf&event_id=".$event->id."')\" class=\"insidelink\">".TXT_DELETE."</a>";
      if(get_inscStatus($event->type)>="1"){
        echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."&man_ev=1')\" class=\"insidelink\">".TXT_MANAGE."</a>";
      }
      echo "</td>";
      echo "<td align=center>";
      $query2 = "SELECT * FROM `event_insc` WHERE `event_id`='".$event->id."'";
      $result2 = mysql_query($query2);
      echo mysql_num_rows($result2);
      echo "</td>";
      echo "</tr>";
    }
  }else{
    echo "<tr><td colspan=100 align=center><b>".get_TypeToNoItem($type)."</b></td></tr>";
  }
  
}

function sp_eventDetail(){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event_type` WHERE id='".$event->type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".$event_type->page_id."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  echo "<center>";
  echo "<h1>".$event->title."</h1>";
  
  if(login_checkAuth($user, $page, "6", false, $event->id)){
    echo "<b>".TXT_DETAILS."</b>";
    echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','edit_ev=1&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_EDIT."</a>";
    echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','man_ev=1&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_MANAGE."</a>";
    echo "<br/>";
  }
  
  // CHECK SUBSCRIBE
  
  if(get_isStudent($user->group_id, $event_type->page_id, true)){
    $inscStatus = get_inscStatus($event->type);
    $query = "SELECT * FROM `event_insc` WHERE event_id='".$event->id."' and user_id='".USER_ID."'";
    $result = mysql_query($query);
    $event_insc = mysql_fetch_object($result);
    $query = "SELECT * FROM `event_author` WHERE event_id='".$event->id."' and user_id='".USER_ID."'";
    $result = mysql_query($query);
    $event_auth = mysql_fetch_object($result);
    $query = "SELECT * FROM `event_prio` WHERE event_id='".$event->id."' and user_id='".USER_ID."'";
    $result = mysql_query($query);
    $event_prio = mysql_fetch_object($result);
    if($inscStatus=="2" && get_isStudent($user->group_id, $event_type->page_id)){
      echo "<b>".TXT_OBLIGATORY."</b><br/>";
    }elseif(empty($event_insc) && get_prioStatus($event->type)=="1" && get_isopen($event->type)>=1){
      if(empty($event_prio)){
        echo "<a href=\"javascript:custRequest('reqtype=evprio_form&user_id=".USER_ID."&event_id=".$event->id."&event_type=".$event->type."')\" class=\"insidelink\">".TXT_PRIOCH."</a><br/>";
      }else{
        echo "<b>".get_choiceNum($event_prio->priority)."</b>";        
        if(get_isopen($event->type)=="2"){
          echo "<br/>(<a href=\"javascript:custRequest('reqtype=unsubsc&event_id=".$event->id."&user_id=".USER_ID."')\" class=\"insidesmlink\">".TXT_UNSUBSC."</a>)";
        }
        echo "<br/>";
      }
    }elseif(empty($event_insc) && $inscStatus>="1" && get_isopen($event->type)>=1){
      echo "<a href=\"javascript:custRequest('reqtype=evsub&user_id=".USER_ID."&event_id=".$event->id."')\" class=\"insidelink\">".TXT_SUBSCRIBE."</a><br/>";
    }elseif(!empty($event_insc)){
      echo "<b>".TXT_SUBSCRIBED."</b>";
      if(get_isopen($event->type)=="2"){
          echo "<br/>(<a href=\"javascript:custRequest('reqtype=unsubsc&event_id=".$event->id."&user_id=".USER_ID."')\" class=\"insidesmlink\">".TXT_UNSUBSC."</a>)";
      }
      echo "<br/>";
    }elseif(get_isopen($event->type)=="0"){
      echo "<b>".TXT_INSC." ".TXT_CLOSED."</b><br/>";
    }else{
      echo "&nbsp;";
    }
  }
  
  // //
  
  echo "<br/><table width=100%>";
  echo "<tr><td height=5 align=center style=\"background-color:#".$event_type->color.";\">";
  echo "</td></tr>";
  echo "</table><br/>";
  
  echo "<br/>";
  echo "<table cellpadding=10 width=100%>";
  if($event->room!=""){$roomf=$event->room;}else{$roomf=TXT_NA;}
  echo "<tr>";
  echo "<td width=33%>";
    echo "<b>".TXT_TIME." : </b>".date('H:i', strtotime($event->btime))." - ".date('H:i', strtotime($event->etime))."<br/>";
    echo "<b>".TXT_ROOM." : </b>".$roomf."<br/>";
    
    if(get_ectsStatus($event->type)){
      echo "<b>".TXT_ECTS." : </b>";
      echo $event->ects;
      echo "<br/>";
    }
    if(get_inChargeStatus($event->type)){
      echo "<b>".TXT_INCHARGE.": </b>";
      $query = "SELECT `event_author`.* , `user_profile`.`forename`, `surname` FROM `event_author`, `user_profile` WHERE `event_author`.`event_id`='".$event->id."' and `user_profile`.`user_id`=`event_author`.`user_id`";
      $result = mysql_query($query);
      while($event_author = mysql_fetch_object($result)){
        echo $event_author->forename." ".$event_author->surname.", ";
      }
      echo "<br/>";
    }
  echo "</td>";
  
  echo "<td width=33% align=center><b>".TXT_DATES."</b><br/><br/>";
    echo "  <table>";
    echo "<tr><td>";
    get_minDates($event, true);
    echo "</td></tr>";
    echo "</table>";
  echo "</td>";
  
  echo "<td width=33% align=center>";
    echo "<b>".TXT_DOCUMENTS."</b><br/><br/>";
    
    if(defined('MAIN_URL')){
      $url = MAIN_URL;
    }else{$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      $url = substr  ( $url  , "0"  , (strrpos($url, "/")+1));
    }
    $query = "SELECT * FROM `event_doc`, `doc` WHERE `event_doc`.`event_id`='".$event->id."' and `event_doc`.`doc_id`=`doc`.`id`";
    $result = mysql_query($query);
    while($doc = mysql_fetch_object($result)){
      echo "<a target=\"_blank\" href=\"".$url."upload/doc/".$doc->file.".".$doc->ext."\" class=\"insidesmlink\">".$doc->name."</a><br/>";
    }
  echo "</td>";
  
  echo "</tr><tr><td colspan=100><hr/></td></tr>";
  
  echo "<tr><td><b>".TXT_DESC."</b></td><td colspan=100>".$event->desc."</td></tr>";
  echo "</table>";
  
  echo "</center>";
  
}

function sp_rightBox($user){
  
  echo "<table border=1 width=100%>";
  echo "<tr><td align=center><b>".TXT_WELCOME." ".$user->login."</b></td></tr><tr><td align=center></td></tr>";

  echo "<tr><td align=center><b>".TXT_SPLINKS."</b>";
  $page = new stdClass();
  $page->id = -1 * MAINLINK_SR_ID;
  $page->auth_type="2";
  if(login_checkAuth($user, $page, "4")){
    echo " <a href=\"javascript:custRequest('reqtype=addlink_form')\"><img src=\"img/plus_2.png\" height=12 width=12></a>";
  }
  echo "</td></tr>";
    
  $query = "SELECT * FROM `link` ORDER BY pos";
  $result = mysql_query($query);
  if(mysql_num_rows($result) != "0"){
    echo "<tr><td align=center>";
    while($link = mysql_fetch_object($result)){
      echo "<a target=\"_blank\" class=\"insidesmlink\" href=\"".$link->link."\">".$link->name."</a>";    
      if(login_checkAuth($user, $page, "4")){
        echo " <a href=\"javascript:custRequest('reqtype=remlink&link_id=".$link->id."')\"><img src=\"img/minus_2.png\" height=12 width=12></a>";
      }
      echo "<br/>";
    }
    echo "</td></tr>";
  }
  echo "</table>";
  
}

function sp_setUserList($fields, $event_id = null, $group_id = null, $output="1"){
    
    //$output="1";
    
    if($output=="1"){
      
      echo "<table align=center cellpadding=5>";
      
    }elseif($output=="2"){
      error_reporting(E_ALL);
      date_default_timezone_set('Europe/Zurich');
      require_once '../Classes/PHPExcel.php';

      $objPHPExcel = new PHPExcel();

      $objPHPExcel->getProperties()->setCreator(MAIN_NAME)
                     ->setLastModifiedBy(MAIN_NAME)
                     ->setTitle(MAIN_NAME." User list")
                     ->setSubject(MAIN_NAME." User list")
                     ->setDescription("User list, generated using PHP classes.")
                     ->setKeywords("")
                     ->setCategory("");
              
    }
    
    $line=0;
    
    $query = "SELECT `user_profile`.*, `user`.`group_id`, `user`.`id` FROM `user_profile`, `user` WHERE `user`.`id` = `user_profile`.`user_id` ORDER BY `user_profile`.`surname`";
    $result = mysql_query($query);
    while($user = mysql_fetch_array($result)){
      $show=true;
                  
      if($group_id != null && $user['group_id'] != $group_id){
        $show=false;
      }
      
      if($event_id!=null){
        $query2 = "SELECT * FROM `event` WHERE `id` = '".$event_id."'";
        $result2 = mysql_query($query2);
        $event = mysql_fetch_object($result2);
        
        $query2 = "SELECT * FROM `event_type` WHERE `id` = '".$event->type."'";
        $result2 = mysql_query($query2);
        $event_type = mysql_fetch_object($result2);
        
        $query2 = "SELECT * FROM `event_insc` WHERE `user_id` = '".$user['id']."' and `event_id` = '".$event_id."'";
        $result2 = mysql_query($query2);
        if(mysql_num_rows($result2)=="0" && $event_type->is_insc != "2"){
          $show=false;
        }elseif($event_type->is_insc == "2"){            
            $query2 = "SELECT * FROM `access_right_g` WHERE `group_id` = '".$user['group_id']."' and `page_id` = '".$event_type->page_id."'";
            $result2 = mysql_query($query2);
            $ar = mysql_fetch_object($result2);
            
            if(mysql_num_rows($result2)!="0"){
              if($ar->right!="2"){
                $show=false;
              }
            }else{
              $show=false;
            }
        }
      }
      
      if($show){
        if($output=="1"){
          echo "<tr>";
        }
        $line++;
        $column=0;
        foreach($fields as $key => $value){
          $column++;
          if($value == "true"){
            if($output=="1"){
              echo "<td>".sp_getText($key, $user[$key])."</td>";
            }elseif($output=="2"){
              $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue(chr($line+64).$column, html_entity_decode(sp_getText($key, $user[$key]), ENT_COMPAT, 'UTF-8'));

            }
          }elseif($value!="false"){
            if($output=="1"){
              echo "<td>".sp_getText($value, $user[$value])."</td>";
            }elseif($output=="2"){
              $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue(chr($column+64).$line, html_entity_decode(sp_getText($value, $user[$value]), ENT_COMPAT, 'UTF-8'));

            }
          }
        }
        if($output=="1"){
          echo "</tr>";
        }
      }
    }
    
    if($output=="1"){
      echo "</table>";
    }elseif($output=="2"){
      $column=0;
      foreach($fields as $key => $value){
        $column++;
        if($value == "true"){
          $objPHPExcel->getActiveSheet()->getColumnDimension(chr($column+64))->setAutoSize(true);
        }elseif($value!="false"){
          $objPHPExcel->getActiveSheet()->getColumnDimension(chr($column+64))->setAutoSize(true);
        }
      }
      
      $objPHPExcel->getActiveSheet()->setTitle('User list');
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="userlist.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      exit;
    }
  
}

function sp_folderLink($folder_id, $type="1"){
    $query = "SELECT * FROM `folder` WHERE `id` = '".$folder_id."'";
    $result = mysql_query($query);
    $folder = mysql_fetch_object($result);
    
    if($folder->folder_id != "0"){
      sp_folderLink($folder->folder_id, $type);
    }
    
    switch($type){
      case "1":
        echo "<a href=\"javascript:loadPage('".DOCUMENT_PAGE_ID."', '', '', '', 'folder_id=".$folder->id."')\" class=\"insidesmlink\">".$folder->name."</a>";
        echo "<b>/</b>";
        break;
        
      case "2":
        echo "<a href=\"javascript:document.getElementById('folder_id').value=".$folder->id.";setReq('reqtype_sp', true, 'reqtype', 'showomy', true, false, 'showoul', true, false, 'event_id', true, false, 'folder_id', true, false)\" class=\"insidesmlink\">".$folder->name."</a><br/>";
        break;
        
      }
}

function sp_eventMan(){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event_type` WHERE id='".$event->type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".$event_type->page_id."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  echo "<center>";
  echo "<h1>".$event->title."</h1>";
  
  if(login_checkAuth($user, $page, "6", false, $event->id)){
    echo "<a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_DETAILS."</a>";
    echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).",'','','','edit_ev=1&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_EDIT."</a>";
    echo " | <b>".TXT_MANAGE."</b>";
    echo "<br/>";
  }
  
  echo "<br/><table width=100%>";
  echo "<tr><td height=5 align=center style=\"background-color:#".$event_type->color.";\">";
  echo "</td></tr>";
  echo "</table><br/>";
  
  echo "<table width=100%>";
  echo "<tr>";
  
  if($page->auth_mod=="3"){
    echo "<td align=center><h3>".TXT_INSCRIPS."</h3>";
    
    $is_insc=false;
    
    $user_list='';
    $test_list='';
    
    if(get_inscStatus($event->type)=="1"){
      $query = "SELECT * FROM `event_insc` WHERE event_id='".$_REQUEST['event_id']."'";
      $result = mysql_query($query);
      while($ev_insc = mysql_fetch_object($result)){
        
        $is_insc=true;
        
        $query2 = "SELECT * FROM `user_profile` WHERE user_id='".$ev_insc->user_id."'";
        $result2 = mysql_query($query2);
        $user_profile = mysql_fetch_object($result2);
        
        $user_list[] = $user_profile;
          
        echo $user_profile->forename." ".$user_profile->surname." (<a href=\"javascript:custRequest('reqtype=reminsc&event_id=".$_REQUEST['event_id']."&user_id=".$ev_insc->user_id."')\" class=\"insidesmlink\">".TXT_REMOVE."</a>)<br/>";  
        
      }
    }elseif(get_inscStatus($event->type)=="2"){
      $query = "SELECT `user`.* FROM `user`, `access_right_g`, `user_profile` WHERE `user`.`id` = `user_profile`.`user_id` and `access_right_g`.`page_id` = '".$event_type->page_id."' and `access_right_g`.`right` = '2' and `user`.`group_id` = `access_right_g`.`group_id` ORDER BY `user_profile`.`surname`";
      $result = mysql_query($query);
      while($user = mysql_fetch_object($result)){
        
        $is_insc=true;
        
        $query2 = "SELECT * FROM `user_profile` WHERE user_id='".$user->id."'";
        $result2 = mysql_query($query2);
        $user_profile = mysql_fetch_object($result2);
        
        $user_list[] = $user_profile;
          
        echo $user_profile->forename." ".$user_profile->surname."<br/>";  
        
      }
      
      
    }
    
    if(!$is_insc){
      echo TXT_NOINSCRIP;
    }
    
    echo "</td>";
  }
  $lpr=null;
  
  if($event_type->is_prio=="1"){

    $ncell = "<td align=center><h3>".TXT_BYCHOICE."";
     
    $ncell .= " (<a href=\"javascript:custRequest('reqtype=choicetable&event_id=".$event->id."')\" class=\"insidelink\">".TXT_TABEL."</a>)</h3>";
     
    $query = "SELECT * FROM `event_prio` WHERE event_id='".$_REQUEST['event_id']."' ORDER BY priority";
    $result = mysql_query($query);
    $first=true;
    while($ev_prio = mysql_fetch_object($result)){
      $query2 = "SELECT * FROM `user_profile` WHERE user_id='".$ev_prio->user_id."'";
      $result2 = mysql_query($query2);
      $userp = mysql_fetch_object($result2);
      
      $query3 = "SELECT * FROM `event_insc` WHERE user_id='".$ev_prio->user_id."' and `event_id`='".$ev_prio->event_id."'";
      $result3 = mysql_query($query3);
      
      if(mysql_num_rows($result3)=="0"){
        if($lpr!=$ev_prio->priority){
          if($first){$first=false;}else{echo "<br/>";}
          $ncell .= "<b>".get_choiceNum($ev_prio->priority)."</b><br/>";
        }
        $ncell .= "(<a href=\"javascript:custRequest('reqtype=evsub&event_id=".$ev_prio->event_id."&user_id=".$ev_prio->user_id."&comebevent=1')\" class=\"insidesmlink\"><--</a>) ".$userp->forename." ".$userp->surname."<br/>";
        
        $lpr=$ev_prio->priority;
      }
    }
    $ncell .= "</td>";
  }

  if($lpr!=null){
    echo $ncell;
  }
  
  $is_test=false;
  if($event_type->is_test=="1"){

    echo "<td align=center>";
    echo "<table>";
    echo "<tr>";
    echo "<td><b>".TXT_TESTS."</b></td>";
    echo "<td><b>".TXT_POND."</b></td>";
    echo "<td></td></tr>";

    $query = "SELECT * FROM `test` WHERE event_id='".$_REQUEST['event_id']."'";
    $result = mysql_query($query);
    while($test = mysql_fetch_object($result)){
      
      $is_test=true;
      
      $test_list[] = $test;
        
      echo "<tr><td>".$test->name."</td><td align=center>";
      echo "<a href=\"javascript:custRequest('reqtype=editPond_form&test_id=".$test->id."&event_id=".$event->id."')\" class=\"insidesmlink\">";
      echo $test->pond;
      echo "</a>";
      echo "</td><td>(<a href=\"javascript:custRequest('reqtype=remtest&test_id=".$test->id."&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_REMOVE."</a>)</td></tr>";  
      
    }
    if(!$is_test){
      echo "<tr><td colspan=100 align=center>".TXT_NOTEST."</td></tr>";
    }
    echo "</table>";
    echo "<br/><a href=\"javascript:custRequest('reqtype=addtest_form&event_id=".$event->id."')\" class=\"insidelink\">".TXT_MENU_ADDTEST."</a>";

  }
  echo "</td>";
  echo "<td>";
  echo "<table width=90% align=center>";
  echo "<tr><td align=center><b>".TXT_DOCUMENTS."</b> (<a href=\"javascript:custRequest('reqtype=linkdoc_form&event_id=".$event->id."')\" class=\"insidelink\">".TXT_LINK."</a>)</td></tr>";
  $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  $url = substr  ( $url  , "0"  , (strrpos($url, "/")+1));
  $query = "SELECT * FROM `event_doc`, `doc` WHERE `event_doc`.`event_id`='".$event->id."' and `event_doc`.`doc_id`=`doc`.`id`";
  $result = mysql_query($query);
  while($doc = mysql_fetch_object($result)){
    echo "<tr><td align=center><a target=\"_blank\" href=\"".$url."upload/doc/".$doc->file.".".$doc->ext."\" class=\"insdielink\">".$doc->name."</a>";
    echo " (<a href=\"javascript:custRequest('reqtype=remlinkdoc&doc_id=".$doc->id."&event_id=".$event->id."')\" class=\"insidesmlink\">".TXT_REMOVE."</a>)";
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</td>";
  echo "</tr>";
  
  if(!empty($user_list) && !empty($test_list) && $event_type->is_test=="1"){
  
    echo "<tr><td colspan=100>";
    
    echo "<hr/>";
    
    echo "<h2>".TXT_NOTES."</h2>";
    
    echo "<table width=100%>";
    
    echo "<tr><td>&nbsp;</td>";
    for($j=0; $j<count($test_list); $j++){
      echo "<td align=center><b>".$test_list[$j]->name."</b></td>";
    }
    echo "<td align=center><b>".TXT_AVERAGE."</b></td>";
    echo "</tr>";

    for($i=0; $i<count($user_list); $i++){
    
      $sum = 0;
      $sum_pond = 0;
        
      echo "<tr><td>".$user_list[$i]->forename." ".$user_list[$i]->surname."</td>";  
      
      if($event_type->is_test=="1"){
        for($j=0; $j<count($test_list); $j++){
      
          $query = "SELECT * FROM `test_note` WHERE test_id='".$test_list[$j]->id."'";
          $query .= " and user_id='".$user_list[$i]->user_id."'";
          $result = mysql_query($query);
          $note = mysql_fetch_object($result);
          
          echo "<td align=center>";
          if(!empty($note)){
            echo "<a href=\"javascript:custRequest('reqtype=editnote_form&test_id=".$note->test_id."&event_id=".$event->id."&user_id=".$user_list[$i]->user_id."')\" class=\"insidesmlink\">";
            echo $note->note;
            echo "</a>";
            $sum += ($note->note * $test_list[$j]->pond);
            $sum_pond += $test_list[$j]->pond;
          }else{
            echo "<a href=\"javascript:custRequest('reqtype=editnote_form&test_id=".$test_list[$j]->id."&event_id=".$event->id."&user_id=".$user_list[$i]->user_id."')\" class=\"insidesmlink\">";
            echo TXT_NA;
            echo "</a>";
          }
          echo "</td>";
        }
      }
      echo "<td align=center>";
      if($sum_pond!="0"){
        echo "<b>".round($sum/$sum_pond, 2)."</b>";
      }else{
        echo TXT_NA;
      }
      echo "</td>";
      
      echo "</tr>";
      
    }
    
  }
  
  echo "</table>";
  
  echo "</td></tr>";
  echo "</table>";
  echo "</center>";
  
}

function sp_eventList($type){
  
  $query = "SELECT id, group_id, fgroup_id FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);

  $ar = login_getAuth($user, $page);
  
  echo "<table align=center>";
  echo "<tr><td align=center>";
  if(login_checkAuth($user, $page, "5", false)){
    echo "<a href=\"javascript:custRequest('reqtype=addevent_form&event_type=".$type."')\" class=\"insidelink\">".get_addEventTxt($type)."</a><br/>";
  }
  echo "</td></tr>";
  echo "<tr><td>";  
  
  $isevent=false;
  
  echo "<br/><br/><table cellpadding=2 cellspacing=0>";
  
  $lsembeg="";
  
  $isdone = array();
  
  $query = "SELECT `event`.* FROM `event`, `event_date` WHERE `event`.`type`='".$type."' and `event_date`.`event_id`=`event`.`id` and `event`.`disable`='0' ORDER BY `event_date`.`date`";
  $result = mysql_query($query);
  while($event = mysql_fetch_object($result)){
    if(!isset($isdone[$event->id])){
      
      $isdone[$event->id]=true;    
      $isevent=true;
      
      $query2 = "SELECT `date` FROM `event_date` WHERE `event_id`='".$event->id."' ORDER BY date";
      $result2 = mysql_query($query2);
      $ed = mysql_fetch_object($result2);
      
      $f_date = $ed->date;
      
      $query2 = "SELECT `date` FROM `event_date` WHERE `event_id`='".$event->id."' ORDER BY date DESC";
      $result2 = mysql_query($query2);
      $ed = mysql_fetch_object($result2);
      
      $l_date = $ed->date;
      
      $sembeg = get_semester(strtotime($f_date));
      $semend = get_semester(strtotime($l_date));
      
      if($sembeg!=$lsembeg){
        $lsembeg=$sembeg;
        $sarr = explode("|", $sembeg);
        echo "<tr><td colspan=100>&nbsp;</td></tr>";
        echo "<tr><td colspan=2><h2>".get_semText($sarr[1])." ".$sarr[0]."</h2></td>";
        if(get_inChargeStatus($type)=="1"){
          echo "<td align=center><b>".TXT_INCHARGE."</b></td>";
        }else{
          echo "<td>&nbsp;</td>";
        }
        if(get_ectsStatus($type)=="1"){
          echo "<td align=center><b>".TXT_ECTS."</b></td>";
        }else{
          echo "<td>&nbsp;</td>";
        }
        echo "<td>&nbsp;</td><td align=center><b>".TXT_DATES."</b></td></tr>";
        
        echo "<tr><td colspan=100><hr/></td></tr>";
      }
      
      echo "<tr>";
      echo "<td style=\"padding-left:5px;padding-right:5px;\"><a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."')\" class=\"insidelink\">".$event->title."</a>";
      if(login_getAuth($user, $page, false, $event->id)>="6"){
        echo "<td style=\"padding-left:5px;padding-right:5px;\">";
        echo "<a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'edit_ev=1&event_id=".$event->id."')\" class=\"insidelink\">".TXT_EDIT."</a>";
        //echo " | <a href=\"javascript:custRequest('reqtype=remevent_conf&event_id=".$event->id."')\" class=\"insidelink\">".TXT_DELETE."</a>";
        echo " | <a href=\"javascript:custRequest('reqtype=disableevent&event_id=".$event->id."')\" class=\"insidelink\">".TXT_DISABLE."</a>";
        if(get_inscStatus($event->type)>="1"){
          echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."&man_ev=1')\" class=\"insidelink\">".TXT_MANAGE."</a>";
        }
        echo "</td>";
      }else{
        echo "<td>&nbsp;</td>";
      }
      echo "</td>";
      if(get_inChargeStatus($event->type)){
        echo "<td style=\"padding-left:5px;padding-right:5px;\" align=center>";
        $query2 = "SELECT `event_author`.* , `user_profile`.`forename`, `surname` FROM `event_author`, `user_profile` WHERE `event_author`.`event_id`='".$event->id."' and `user_profile`.`user_id`=`event_author`.`user_id`";
        $result2 = mysql_query($query2);
        while($event_author = mysql_fetch_object($result2)){
          echo $event_author->forename." ".$event_author->surname."<br/>";
        }
        echo "</td>";
      }else{
        echo "<td>&nbsp;</td>";
      }
      if(get_ectsStatus($event->type)){
        echo "<td style=\"padding-left:5px;padding-right:5px;\" align=center>";
        echo $event->ects;
        echo "</td>";
      }else{
        echo "<td>&nbsp;</td>";
      }
      //echo "<td style=\"padding-left:5px;padding-right:5px;\">".$event->sh_desc."</td>";
      // sh_desc disactivated here.
      echo "<td>&nbsp;</td>";
      
      echo "<td style=\"padding-left:5px;padding-right:5px;\">";
      get_minDates($event, false);
      echo "</td>";
      echo "</tr>";
      echo "<tr><td colspan=100><hr/></td></tr>";
    }
  }
  
  if(!$isevent){
    echo "<tr><td>".TXT_NOEVENT."</td></tr>";
  }
  
  echo "</table>";
  
  echo "</td></tr>";
  echo "</table>";
  
}

function sp_eventListDis(){
  
  $query = "SELECT id, group_id, fgroup_id FROM `user` WHERE id='".USER_ID."'";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".EVENTDIS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);

  $ar = login_getAuth($user, $page);
  
  echo "<table align=center>";
  echo "<tr><td align=center>";
  echo "</td></tr>";
  echo "<tr><td>";  
  
  $isevent=false;
  
  echo "<br/><br/><table cellpadding=2 cellspacing=0>";
  
  echo "<tr><td colspan=100><hr/></td></tr>";
  
  $query = "SELECT * FROM `event` WHERE disable='1'";
  $result = mysql_query($query);
  while($event = mysql_fetch_object($result)){
    
    $isevent=true;
    
    echo "<tr>";
    echo "<td style=\"padding-left:5px;padding-right:5px;\"><a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."')\" class=\"insidelink\">".$event->title."</a>";
    if(login_getAuth($user, $page, false, $event->id)>="6"){
      echo "<td style=\"padding-left:5px;padding-right:5px;\">";
      //echo "<a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'edit_ev=1&event_id=".$event->id."')\" class=\"insidelink\">".TXT_EDIT."</a>";
      echo "<a href=\"javascript:custRequest('reqtype=remevent_conf&event_id=".$event->id."')\" class=\"insidelink\">".TXT_DELETE."</a>";
      echo " | <a href=\"javascript:custRequest('reqtype=enableevent&event_id=".$event->id."')\" class=\"insidelink\">".TXT_ENABLE."</a>";
      //if(get_inscStatus($event->type)>="1"){
      //  echo " | <a href=\"javascript:loadPage(".get_TypeToPage($event->type).", '', '', '', 'event_id=".$event->id."&man_ev=1')\" class=\"insidelink\">".TXT_MANAGE."</a>";
      //}
      echo "</td>";
    }else{
      echo "<td>&nbsp;</td>";
    }
    echo "</td>";
    echo "<td>(".get_typeToName($event->type).")</td>";
    if(get_inChargeStatus($event->type)){
      echo "<td style=\"padding-left:5px;padding-right:5px;\" align=center>";
      $query2 = "SELECT `event_author`.* , `user_profile`.`forename`, `surname` FROM `event_author`, `user_profile` WHERE `event_author`.`event_id`='".$event->id."' and `user_profile`.`user_id`=`event_author`.`user_id`";
      $result2 = mysql_query($query2);
      while($event_author = mysql_fetch_object($result2)){
        echo $event_author->forename." ".$event_author->surname."<br/>";
      }
      echo "</td>";
    }else{
      echo "<td>&nbsp;</td>";
    }
    echo "<td style=\"padding-left:5px;padding-right:5px;\">".$event->sh_desc."</td>";
    echo "<td style=\"padding-left:5px;padding-right:5px;\">";
    $nbdate=0;
    $query2 = "SELECT * FROM `event_date` WHERE event_id='".$event->id."' ORDER BY date";
    $result2 = mysql_query($query2);
    while($event_date = mysql_fetch_object($result2)){
      if($nbdate>=3){
        echo "<span class=\"list\">[...]</span>";
        break;
      }else{
        echo "<span class=\"list\">".date('D d M Y', strtotime($event_date->date))."</span><br/>";
      }
      $nbdate++;
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr><td colspan=100><hr/></td></tr>";
    
  }
  
  if(!$isevent){
    echo "<tr><td>".TXT_NOEVENT."</td></tr>";
  }
  
  echo "</table>";
  
  echo "</td></tr>";
  echo "</table>";
  
}

function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>\n/i', "\n", $string);
}

function sp_setTimeOptionsHH($name, $time="00:00:00", $notime=false){
  
  $time = explode(':', $time);
  $hh = $time[0];
  
  echo "<select id='".$name."'>";
  if($notime){
    echo "<option value=\"\" selected=\"selected\">---</option>";
  }
  for($i="8"; $i<22; $i++){
    echo "<option value=\"".$i."\"";
    if($hh == $i){echo " selected=\"selected\"";}
    echo ">".$i."</option>";
  }
  echo "</select>";
  
}

function sp_setTimeOptionsMM($name, $time="00:00:00", $notime=false){
  
  $time = explode(':', $time);
  $mm = $time[1];

  echo "<select id='".$name."'>";
  if($notime){
    echo "<option value=\"\" selected=\"selected\">---</option>";
  }
  for($i="00"; $i<46; $i+=15){
    echo "<option value=\"".$i."\"";
    if($mm == $i){echo " selected=\"selected\"";}
    echo ">".$i."</option>";
  }
  echo "</select>";
  
}

function sp_GroupUsers($group_id){ // depreciated
  
  $query = "SELECT id FROM user WHERE group_id = '".$group_id."' order by login";
  $result = mysql_query($query);
  $user = mysql_fetch_object($result);
  
  if(!isset($user->id)){
    echo TXT_NOUSERINGROUP;
    }else{
    
    echo "<tr><td><b>".TXT_NAME."</b></td></tr>";
    
    $query = "SELECT * FROM user WHERE group_id = '".$group_id."' order by login";
    $result = mysql_query($query);
    while($user = mysql_fetch_object($result)){
      
      echo "<tr>";
      
      echo "<td>".$user->login."</td>";
      echo "</tr>";
      
    }
  
  }
  
}

function sp_InstGroup($ar){
  
  if(empty($inst)){$inst_id="0";}else{$inst_id=$inst->id;}
  
  $isgroup = false;
  
  $query2 = "SELECT * FROM `group`";
  $result2 = mysql_query($query2);
  while($group = mysql_fetch_object($result2)){
    
    $isgroup=true;
    
    echo "<tr>";
    echo "<td width=\"5px\">&nbsp;</td>";
    echo "<td><b>".$group->name."</b></td>";
    if($ar>="6"){
      echo "<td><a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=renameGroup_form&group_id=".$group->id."')\">".TXT_RENAME."</a></td>";
    }
    echo "</tr>";
    
  }
  
  if(!$isgroup){echo "<tr><td colspan=".NB_ROW_INSTGROUP.">".TXT_NOGROUPININST."</td></tr>";}
  
  echo "<tr><td colspan=".NB_ROW_INSTGROUP."><br/></td></tr>";
  
}

function sp_setFieldOption($type, $value){
  
  switch($type){
    case "sex":
      echo "<option value=\"1\"";
      if($value=="1"){echo " selected=\"selected\"";}
      echo ">".TXT_MALE."</option>";
      echo "<option value=\"2\"";
      if($value=="2"){echo " selected=\"selected\"";}
      echo ">".TXT_FEMALE."</option>";
      break;
    
  }
  
}

function sp_recheckPagePos($submenu = "0"){
  
  if($submenu!="0"){
    $menu_level="2";
  }else{
    $menu_level="1";
  }
  
  $pos=0;
  
  $query = "SELECT `id`, `pos` FROM page WHERE menu_level='".$menu_level."' and `submenu_attach`='".$submenu."' ORDER BY pos, name";
  $result = mysql_query($query);
  while($page = mysql_fetch_object($result)){
  
    if($page->pos != $pos){
      $query2 = "UPDATE page SET pos='".$pos."' WHERE id='".$page->id."'";
      $result2 = mysql_query($query2);
    }
    $pos++;
    
  }
  
}

function sp_recheckLinkPos(){
  
  $pos=0;
  
  $query = "SELECT `id`, `pos` FROM `link`";
  $result = mysql_query($query);
  while($link = mysql_fetch_object($result)){
  
    if($link->pos != $pos){
      $query2 = "UPDATE `link` SET pos='".$pos."' WHERE id='".$link->id."'";
      $result2 = mysql_query($query2);
    }
    $pos++;
    
  }
  
}

function sp_setMenuLink($page, $user, $submenu = false){
  $ar = login_getAuth($user, $page);
    
  if($ar>=4 || $page->type=="4" || $page->type=="6"){
    if($page->type == "1"){
      echo "<a class=\"";
      if($submenu){echo "submenulink";}else{echo "menulink";}
      echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a><br/>\n";
    }elseif($page->type == "2"){
      if($ar=="4"){
        echo "<a class=\"";
        if($submenu){echo "submenulink";}else{echo "menulink";}
        echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a><br/>\n";
      }elseif($ar=="6"){
        echo "<a class=\"";
        if($submenu){echo "submenulink";}else{echo "menulink";}
        echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a>";
        echo " <a href=\"javascript:loadPage('".$page->id."', '', '', '1')\"><img src=\"img/edit.png\" width=\"18\" height=\"18\"></a>";
        echo "<br/>\n";
      }
    }elseif($page->type == "3"){
      $query2 = "SELECT * FROM slink WHERE page_id = ".$page->id;
      $result2 = mysql_query($query2);
      $slink = mysql_fetch_object($result2);
      
      echo "<a class=\"";
      if($submenu){echo "submenulink";}else{echo "menulink";}
      echo "\" href=\"".$slink->link."\"";
      if($slink->blank){ echo " target=\"_blank\"";}
      echo ">".$page->name."</a><br/>\n";
    }elseif($page->type == "4"){
      echo "<br/>\n";
    }elseif($page->type == "5"){
      $query2 = "SELECT * FROM sreq WHERE page_id = ".$page->id;
      $result2 = mysql_query($query2);
      $sreq = mysql_fetch_object($result2);
      
      echo "<a class=\"";
      if($submenu){echo "submenulink";}else{echo "menulink";}
      echo "\" href=\"javascript:custRequest('".$sreq->req."')\">".$page->name."</a><br/>\n";
    }elseif($page->type == "6"){
      sp_menu_fakegroup($user, $page, $submenu);
    }elseif($page->type == "7"){
      if($ar=="4"){
        echo "<a class=\"";
        if($submenu){echo "submenulink";}else{echo "menulink";}
        echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a><br/>\n";
      }elseif($ar=="6"){
        echo "<a class=\"";
        if($submenu){echo "submenulink";}else{echo "menulink";}
        echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a>";
        echo " <a href=\"javascript:loadPage('".$page->id."', '', '', '1')\"><img src=\"img/edit.png\" width=\"18\" height=\"18\"></a>";
        echo "<br/>\n";
      }
    }elseif($page->type == "8"){
      echo "<a class=\"";
      if($submenu){echo "submenulink";}else{echo "menulink";}
      echo "\" href=\"javascript:loadPage('".$page->id."')\">".$page->name."</a><br/>\n";
    }
  }
}

function sp_menu_fakegroup($user, $page, $submenu){
  if($user->fgroup_id == "0"){
    $ar = login_getAuth($user, $page, true);
    if($ar>="6"){
      echo "<a class=\"";
      if($submenu){echo "submenulink";}else{echo "menulink";}
      echo "\" href=\"javascript:custRequest('reqtype=fakegroup_form')\">".TXT_FAKEGROUP."</a><br/>\n";
    }
  }else{
    echo "<a style=\"background-color:#aaaaaa;\" class=\"";
    if($submenu){echo "submenulink";}else{echo "menulink";}
    echo "\" href=\"javascript:custRequest('reqtype=cfakegroup')\">".TXT_CANCELFG."</a><br/>\n";
    
  }
}

function sp_setPageAccRiRow($page, $ar){
  
  if($page->id >= 0){
    $query2 = "SELECT * FROM `event_type` WHERE `page_id`='".$page->id."'";
    $result2 = mysql_query($query2);
    $event_type = mysql_fetch_object($result2);
    
    if(empty($event_type)){$insc_mod = "0";}else{$insc_mod=$event_type->is_insc;}
  }
  
  echo "<tr>";
  
  echo "<td>";
  if($page->menu_level=="2"){echo "- ";}
  echo "<b>".$page->name."</b></td>";
  $query2 = "SELECT * FROM `group` WHERE '1'";
  $result2 = mysql_query($query2);
  while($group = mysql_fetch_object($result2)){
    $query3 = "SELECT `right` FROM `access_right_g` WHERE `group_id`='".$group->id."' and `page_id`='".$page->id."'";
    $result3 = mysql_query($query3);      
    $accri = mysql_fetch_object($result3);
    
    if(empty($accri)){
      $rights="0";
    }else{
      $rights=$accri->right;
    }
    
    echo "<td align=center>";
    echo "<form id=\"cpg".$page->id."_".$group->id."\">";
    echo "<input type=\"hidden\" id=\"reqtype".$page->id."_".$group->id."\" value=\"charg\">";
    echo "<input type=\"hidden\" id=\"group_id".$page->id."_".$group->id."\" value=\"".$group->id."\">";
    echo "<input type=\"hidden\" id=\"page_id".$page->id."_".$group->id."\" value=\"".$page->id."\">";
    if($ar>="6"){
      echo "<select id='right".$page->id."_".$group->id."' onchange=\"setReq('reqtype".$page->id."_".$group->id."', true, 'reqtype', 'right".$page->id."_".$group->id."', true, 'right', 'group_id".$page->id."_".$group->id."', true, 'group_id', 'page_id".$page->id."_".$group->id."', true, 'pagech_id')\">";
      echo "<option value=0";
      if($rights == "0"){ echo " selected=\"selected\"";}
      echo ">".TXT_NORIGHTS."</option>";
      if($page->type=="8"){
        echo "<option value=2";
        if($rights == "2"){ echo " selected=\"selected\"";}
        echo ">".TXT_STUDENT."</option>";
      }
      if($page->auth_mod=="2" || $page->auth_mod=="3"){
        echo "<option value=4";
        if($rights == "4"){ echo " selected=\"selected\"";}
        echo ">".TXT_READ."</option>";
      }
      if($page->auth_mod=="3"){
        echo "<option value=5";
        if($rights == "5"){ echo " selected=\"selected\"";}
        echo ">".TXT_AUTHOR."</option>";
      }
      echo "<option value=6";
      if($rights == "6"){ echo " selected=\"selected\"";}
      echo ">".TXT_READWRITE."</option>";
      echo "</select>";
    }elseif($ar>="4"){
      switch($rights){
        case "0":
          echo TXT_NORIGHTS;
          break;
          
        case "2":
          echo TXT_STUDENT;
          break;
          
        case "4":
          echo TXT_READ;
          break;
          
        case "5":
          echo TXT_AUTHOR;
          break;
          
        case "6":
          echo TXT_READWRITE;
          break;
      }
    }
    echo "</form>";
    echo "</td>";
  }
  echo "</tr>";
  
}


function sp_setPageRow($page, $lastpos, $lastpage, $submenu = false){
  
  echo "<tr>";
  echo "<td>";
  if($submenu){
    echo "<img src=\"img/blank.png\" height=\"16\" width=\"16\"/ />";
    echo "<img src=\"img/arrow-curve-right.png\" height=\"16\" width=\"16\"/>";
    echo "<img src=\"img/blank.png\" height=\"16\" width=\"16\"/ />";
  }
  if($page->pos != $lastpos){
    $query2 = "SELECT id FROM page WHERE pos = '".($page->pos+1)."'";
    if(!$submenu){
      $query2 .= " and menu_level='1'";
    }else{
      $query2 .= " and menu_level='2' and submenu_attach='".$page->submenu_attach."'";
    }
    $result2 = mysql_query($query2);
    $nextpage = mysql_fetch_object($result2);
    echo "<a href=\"javascript:custRequest('reqtype=switch_page_pos&page1_id=".$page->id."&page2_id=".$nextpage->id."')\"><img src=\"img/bullet_arrow_down.png\"/></a>";
  }else{
    echo "<img src=\"img/blank.png\"/>";
  }
  if($page->pos != "0"){
    echo "<a href=\"javascript:custRequest('reqtype=switch_page_pos&page1_id=".$lastpage->id."&page2_id=".$page->id."')\"><img src=\"img/bullet_arrow_up.png\"/></a>";
  }else{
    echo "<img src=\"img/blank.png\"/>";
  }
  if(!$submenu){
    echo "<img src=\"img/blank.png\" height=5 width=\"50\"/>";
  }
  echo "</td>";
  echo "<td>".$page->name."</td>";
  if($page->type!="8"){
    echo "<td><a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=renamePage_form&pagech_id=".$page->id."')\">".TXT_RENAME."</a>";
  }
  if($page->type=="2" || $page->type=="4"){echo " | <a class=\"insidesmlink\" href=\"javascript:custRequest('reqtype=remPage_conf&pagech_id=".$page->id."')\">".TXT_DELETE."</a>";}
  echo "</td>";
  echo "<td align=center>";
  echo "<input type=\"hidden\" id=\"pagech_id".$page->id."\" value=\"".$page->id."\">";
  $query2 = "SELECT id FROM page WHERE submenu_attach = '".($page->id)."'";
  $result2 = mysql_query($query2);
  $issubm = mysql_fetch_object($result2);
  if(empty($issubm) && ($page->type == "1" || $page->type == "2" || $page->type == "7")){
    echo "<select id=\"tosubmenu_id".$page->id."\" onchange=\"setReq('reqtype_tosm', true, 'reqtype', 'tosubmenu_id".$page->id."', true, 'tosubmenu_id', 'pagech_id".$page->id."', true, 'pagech_id')\"><option value=\"0\">".TXT_NOSUBM."</option>";
    $query2 = "SELECT * FROM page WHERE menu_level = '1' and (type = '1' or type = '2') ORDER BY pos, name";
    $result2 = mysql_query($query2);
    while($topage = mysql_fetch_object($result2)){
      if($topage->id!=$page->id){
        echo "<option value=\"".$topage->id."\"";
        if($page->submenu_attach == $topage->id){echo "selected=\"selected\"";}
        echo ">".$topage->name."</option>";
      }
    }
    echo "</select>";
  }
  echo "</td>";
  echo "</tr>";
  
}

function sp_profileTable($u_profile, $ar, $field = 'user_fields', $reqtype = 'updateprofile'){
  
  echo "<table align=center>";
  
  foreach($_SERVER[$field] as $key => $value){
    
    if($u_profile['id'] == false){
      $u_profile[$value[0]] = '';
    }
    
    echo "<tr><td><b>".constant("TXT_".$value[0])." : </b></td>";
    if($ar>="6"){
      if($value[1]==1){
        echo "<td><input onchange=\"loadMessage('".TXT_TOUPDATE."')\" type=text id=\"".$value[0]."\" value=\"".$u_profile[$value[0]]."\"></td>";
      }elseif($value[1]==2){
        echo "<td><input onchange=\"loadMessage('".TXT_TOUPDATE."')\" type=text id=\"".$value[0]."\" value=\"".$u_profile[$value[0]]."\">";
        ?>
        <button id="trigger<?php echo $value[0];?>">...</button>
        <?php
        echo "</td>";
      }elseif($value[1]==3){
        echo "<td><select onchange=\"loadMessage('".TXT_TOUPDATE."')\" id=\"".$value[0]."\">";
        sp_setFieldOption($value[0], $u_profile[$value[0]]);
        echo "</select></td>";
      }
      echo "<td><p class=\"comlist\">".$value[2]."</p></td>";
    }elseif($ar>="4"){
      if($value[1]==1){
        echo "<td><p>".$u_profile[$value[0]]."</p></td>";
      }elseif($value[1]==2){
        echo "<td><p>".$u_profile[$value[0]]."</p></td>";
      }elseif($value[1]==3){
        echo "<td><p>".sp_getText('sex', $u_profile[$value[0]])."</p></td>";
      }
    }else{
      echo "<td>".TXT_NORIGHTS."</td>";
    }
    echo "</tr>";
  }
  
  if($ar>="6"){
    if(!isset($_REQUEST['user_id'])){$_REQUEST['user_id']=USER_ID;}
    echo "<tr><td colspan=3 align=center><br/><input type=\"hidden\" id=\"reqtype\" value=\"".$reqtype."\"><input type=\"hidden\" id=\"user_id\" value=\"".$_REQUEST['user_id']."\"><a href=\"javascript:if(checkRegexp(";
    $first=true;
    foreach($_SERVER[$field] as $key => $value){
      if($first){$first=false;}else{echo ", ";}
      echo "'".$value[0]."', '".$value[3]."'";
    }
    echo ")){setReq('user_id', true, false, 'reqtype', true, false";
    $first=true;
    foreach($_SERVER[$field] as $key => $value){
      echo ", '".$value[0]."', false, false";
    }
    echo ");}\" class=\"insidelink\">";
    if(!isset($_REQUEST['reqtype'])){$_REQUEST['reqtype'] = '';}
    if($_REQUEST['reqtype']=='adduser_form'){echo TXT_ADD;}else{echo TXT_UPDATE;}
    echo "</a></td></tr>";
  }
  
  echo "</table>";
  
}

function sp_setReplytoOption($page_id){
  $query = "SELECT * FROM `access_right_g` WHERE page_id = '".$page_id."'";
  $result = mysql_query($query);
  while($isar = mysql_fetch_object($result)){
    $query2 = "SELECT * FROM `user` WHERE group_id = '".$isar->group_id."'";
    $result2 = mysql_query($query2);
    while($user = mysql_fetch_object($result2)){
      $query3 = "SELECT * FROM `user_profile` WHERE user_id = '".$user->id."'";
      $result3 = mysql_query($query3);
      while($user_profile = mysql_fetch_object($result3)){
        echo "<option value=\"".$user->id."\">".$user_profile->forename." ".$user_profile->surname."</option>";
      }
    }
  }
  
  
}
function sp_getText($type, $value){
  
  switch($type){
    case "sex":
      switch($value){
        case "1":
          return TXT_MALE;
          break;
        case "2":
          return TXT_FEMALE;
          break;
      }
      break;
      
    default:
      return $value;
      break;
    
    
  }
  
  
}

?>
