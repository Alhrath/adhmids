<?php

function jsconn_loadPage($page_id, $menu_req = "0"){
  ?><SCRIPT LANGUAGE="JavaScript">loadPage("<?php echo "$page_id"; ?>", "<?php echo "$menu_req"; ?>");</SCRIPT><?php
}

function jsconn_loadMessage($message){
  ?><SCRIPT LANGUAGE="JavaScript">loadMessage("<?php echo "$message"; ?>");</SCRIPT><?php
}

function jsconn_alert($message){
  ?><SCRIPT LANGUAGE="JavaScript">alert("<?php echo "$message"; ?>");</SCRIPT><?php
}

function jsconn_error($error){
  ?><SCRIPT LANGUAGE="JavaScript">display_error("<?php echo "$error"; ?>");</SCRIPT><?php
}

?>
