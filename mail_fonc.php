<?php

function mail_sendMail($dest_mail, $page_id, $data){
  
      $query = "SELECT * FROM page_automail WHERE page_id = '".$page_id."'";
      $result = mysql_query($query);
      $automail = mysql_fetch_object($result);
  
      $query = "SELECT * FROM user_profile WHERE user_id = '".$automail->replyto_id."'";
      $result = mysql_query($query);
      $rt_prof = mysql_fetch_object($result);
      
      $obj = mail_replace($automail->obj, $data);
      $content = mail_replace($automail->content, $data);
      $replyto = $rt_prof->email;
      
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'From: '.$replyto . "\r\n";
      
      mail($dest_mail, $obj, $content, $headers);
}

function mail_replace($str, $data){
  
  foreach($data as $key => $value){
    $str = str_replace( "%".$key."%"  , $value  , $str);
  }
  
  return $str;
  
}

?>
