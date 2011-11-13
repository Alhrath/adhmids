<?php

include("constant.php");
include("sql_fonc.php");
include("login_fonc.php");
include("file_fonc.php");
include("get_fonc.php");

sql_connect();

$user = login_checkKey();

?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php

if(!empty($user)){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_FILES['file']) && isset($_REQUEST['file_name'])){
      
      $success = file_upload($user->id);
      
      if($success){
        
        echo "<br/><center>UPLOAD SUCCESSFUL<br/>CLOSING ...</center>";
        echo "<SCRIPT LANGUAGE=\"JavaScript\"><!--\n window.parent.setTimeout(\"loadPage('".DOCUMENT_PAGE_ID."')\", 1000); \n //--></script>";

      }else{
        
        echo "<br/><center>UPLOAD FAILED</center>";
        
      }
        
    }else{
      echo "<br/><center>MISSING PARAMETER</center>";
    }
  }else{
    echo "<br/><center>NO ACCESS RIGHTS</center>";
  }
  
}else{
  
  echo "<br/><center>NO ACCESS RIGHTS</center>";
  
}


?>

</body>
</html>
