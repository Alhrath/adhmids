<?php

function file_upload($user_id){
  
  if(!isset($_FILES['file']) || !isset($_REQUEST['file_name'])){
    
    return false;
    
  }else{
    
    $target_path = "upload/doc/";
    
    for ($key = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 32; $x = rand(0,$z), $key .= $a{$x}, $i++);

    $ext = substr(strrchr($_FILES['file']['name'], '.'), 1);

    $target_path = $target_path . $key . "." . $ext;
    
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
      
        $query = "INSERT INTO `doc` (`name`, `file`, `ext`) VALUES ('".$_REQUEST['file_name']."', '".$key."', '".$ext."')";
        $result = mysql_query($query);
        
        $doc_id = mysql_insert_id();
      
        $query = "INSERT INTO `doc_author` (`doc_id`, `user_id`) VALUES ('".$doc_id."', '".$user_id."')";
        $result = mysql_query($query);
      
        return true;
    } else{
        return false;
    }
    
  }
  
}

?>
