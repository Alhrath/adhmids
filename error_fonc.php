<?php

function customError($errno, $errstr, $errfile, $errline)
{
  if(strlen($_COOKIE['adhmidsdebugmod'])=="32"){
    
    $query = "SELECT * FROM user WHERE skey = '".$_COOKIE['adhmidsdebugmod']."'";
    $result = mysql_query($query);
    $user = mysql_fetch_object($result);
        
  }
  
  if(true||($user->level >= DEBUG_LEVEL)){
  
    echo "Error: [$errno] $errstr\n";
    echo "File: $errfile line $errline";
    die();
    
  }else{
    echo "An error occured.\nPlease contact the webmaster for more informations.";
    die();
  }
} 

set_error_handler("customError"); 

?>
