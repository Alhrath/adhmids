<?php

function get_isStudent($group_id, $page_id, $allowguest = false){
  
  $query = "SELECT * FROM `access_right_g` WHERE page_id='".$page_id."' and `group_id`='".$group_id."'";
  $result = mysql_query($query);
  $accri = mysql_fetch_object($result);
  
  if($accri->right=="2" || ($accri->right=="4" && $allowguest)){
    return true;
  }else{
    return false;
  }
  
}

function get_evStudents($event_id){
  
  $query = "SELECT * FROM `event` WHERE id='".$event_id."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event_type` WHERE id='".$event->type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  $studentlist = null;
  
  if($event_type->is_insc == "1"){
    
    $query = "SELECT * FROM `event_insc` WHERE event_id='".$event_id."'";
    $result = mysql_query($query);
    while($ev_insc = mysql_fetch_object($result)){
      $studentlist[] = $ev_insc->user_id;
    }
  }elseif($event_type->is_insc == "2"){
    $query = "SELECT `user`.* FROM `user`, `access_right_g` WHERE `access_right_g`.`page_id` = '".$event_type->page_id."' and `access_right_g`.`right` = '2' and `user`.`group_id` = `access_right_g`.`group_id`";
    $result = mysql_query($query);
    while($user = mysql_fetch_object($result)){
      $studentlist[] = $user->id;
    }
  }
  
  return $studentlist;
  
}

function get_minDates($event, $showsp = false){
  
  $query2 = "SELECT * FROM `event_date` WHERE event_id='".$event->id."' and `date` >= CURDATE() ORDER BY date LIMIT 3";
  $result2 = mysql_query($query2);
  if(mysql_num_rows($result2)=="0"){
    $query2 = "SELECT * FROM `event_date` WHERE event_id='".$event->id."' ORDER BY date LIMIT 3";
    $result2 = mysql_query($query2);
  }
  while($event_date = mysql_fetch_object($result2)){
    echo "<span class=\"list\">".date('D d M Y', strtotime($event_date->date));
    if($event_date->room!="" && $showsp){
      echo " | ".TXT_ROOM." : ".$event_date->room;
    }
    if($event_date->btime!="00:00:00" && $showsp){
      echo " | ".TXT_TIME." : ".date('H:i', strtotime($event_date->btime))." - ".date('H:i', strtotime($event_date->etime));
    }
    echo "</span><br/>";
  }
  echo "<span class=\"list\">[... </span>";
  echo "<a href=\"javascript:custRequest('reqtype=showdates&event_id=".$event->id."')\" class=\"list\">".TXT_SHOWALL."</a>";
  echo "<span class=\"list\"> ...]</span>";
}

function get_semText($n){
  
  switch($n){
    case "1":
      return TXT_SPRING;
      break;
    case "2":
      return TXT_AUTUMN;
      break;
    
    
  }
  
}

function get_semester($tstmp){
  
  //echo date('d m Y', $tstmp)."<br>";
  //echo date('d m Y', strtotime("2010-01-01"));

  if($tstmp <= strtotime("2010-01-01")){
    return false;
  }
  
  for($i="2010"; $i<"2100"; $i++){
    if($tstmp < strtotime(($i-1)."-07-15")){
      return ($i-1)."|1";
    }
    if($tstmp < strtotime($i."-01-01")){
      return ($i-1)."|2";
    }
  }
  
  return false;
}

function get_inChargeStatus($type){
  
  $query = "SELECT `page_id` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".$event_type->page_id."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if($page->auth_mod=="3"){
    return true;
  }else{
    return false;
  }
  
}

function get_ectsStatus($type){
  
  $query = "SELECT `is_ects` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  if($event_type->is_ects=="1"){
    return true;
  }else{
    return false;
  }
  
}

function get_inscStatus($type){
  
  $query = "SELECT `is_insc` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->is_insc;
  
}

function get_isopen($type){
  
  $query = "SELECT `is_open` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->is_open;
  
}

function get_prioStatus($type){
  
  $query = "SELECT `is_prio` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->is_prio;
  
}

function get_ordinal($number){
 // get first digit
 $digit = abs($number) % 10;
 $ext = 'th';
 // if the last two digits are between 4 and 21 add a th
 if(abs($number) %100 < 21 && abs($number) %100 > 4){
  $ext = 'th';
 }else{
  if($digit < 4){
   $ext = 'rd';
  }
  if($digit < 3){
   $ext = 'nd';
  }
  if($digit < 2){
   $ext = 'st';
  }
  if($digit < 1){
   $ext = 'th';
  }
 }
 return $number.$ext;
}

function get_choiceNum($n){
  return get_ordinal($n)." ".TXT_CHOICE;
}

function get_inscModText($imod){
  
  switch($imod){
    case "0":
      return TXT_NOINSCRIP;
      break;
    case "1":
      return TXT_INSC;
      break;
    case "2":
      return TXT_OBLIGATORY;
      break;
    
  }
  
}

function get_openModText($imod){
  
  switch($imod){
    case "0":
      return TXT_CLOSED;
      break;
    case "1":
      return TXT_ONEWAY;
      break;
    case "2":
      return TXT_OPEN;
      break;
    
  }
  
}

function get_yesNo($bool){
  
  if($bool){
    return TXT_YES;
  }else{
    return TXT_NO;
  }
  
}

function get_PageToAuthTable($page_id){
  
  $query = "SELECT `id` FROM `event_type` WHERE page_id='".$page_id."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  if(mysql_num_rows($result)!="0"){$page_id="event";}
  
  switch($page_id){
    case "event" :
      return "event_author";
      break;
      
    case DOCUMENT_PAGE_ID:
      return "doc_author";
      break;
      
    }
}

function get_PageToAuthCol($page_id){
  
  $query = "SELECT `id` FROM `event_type` WHERE page_id='".$page_id."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  
  
  if(mysql_num_rows($result)!="0"){ $page_id="event";}
  
  
  switch($page_id){
    case "event" :
      return "event_id";
      break;
      
    case DOCUMENT_PAGE_ID:
      return "doc_id";
      break;
      
    }
}

function get_typeBgcolor($type){
  
  $query = "SELECT `color` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->color;
  
}

function get_TypeToPage($type){
  
  $query = "SELECT `page_id` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->page_id;
  
}

function get_typeToName($type){
  
  $query = "SELECT `name` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return $event_type->name;
  
}

function get_TypeToNoItem($type){
  
  $query = "SELECT `name` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return TXT_NO." ".$event_type->name;
  
}

function get_addEventTxt($type){
  
  $query = "SELECT `name` FROM `event_type` WHERE id='".$type."'";
  $result = mysql_query($query);
  $event_type = mysql_fetch_object($result);
  
  return TXT_ADD." ".$event_type->name;
  
}

function get_timestamp($string) {
	
	list($date, $time) = explode(' ', $string);
	list($year, $month, $day) = explode('-', $date);
	list($hour, $minute, $second) = explode(':', $time);

	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

	return $timestamp;
}

function get_datediff($date){
	$nowts = time();
	
	$datets = get_timestamp($date);
		
		$diffts = $nowts-$datets;
		
    if($diffts>31536000){
			$return = floor($diffts/31536000);
			if($return==1){$return = $return." year";}else{$return = $return." years";}
		}elseif($diffts>2628000){
			$return = floor($diffts/2628000);
			if($return==1){$return = $return." month";}else{$return = $return." months";}
		}elseif($diffts>86400){
			$return = floor($diffts/86400);
			if($return==1){$return = $return." day";}else{$return = $return." days";}
		}elseif($diffts>3600){
			$return = floor($diffts/3600);
			if($return==1){$return = $return." hour";}else{$return = $return." hours";}
		}elseif($diffts>60){
			$return = floor($diffts/60);
			if($return==1){$return = $return." minute";}else{$return = $return." minutes";}
		}else{
			$return = "connected";
		}
		
		return $return;
		
}

?>
