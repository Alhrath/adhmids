<?php


class session {
	
	var $cUser;
	var $cPage;
				
	function __construct() {
		sql_connect();
		
		$this->std_output();
  }
	
	function std_output(){
		?>
		
		<html>
		<head>
		<script type="text/javascript" src="scripts.js"></script>
		</head>
		<body>
		</body>
		</html>
		
		<?php
	}
  
}

?>
