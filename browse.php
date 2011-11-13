
<head>
</head>
<body>


<?php

	$callback=$_GET['CKEditorFuncNum'];

	$dir = "upload/images/";

	// Open a known directory, and proceed to read its contents
	if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
					echo "<table>";
					$c=0;
					while (($file = readdir($dh)) !== false) {
						if(filetype($dir . $file) == "file"){
							$ext = substr(strrchr($dir . $file, '.'), 1);
							if(in_array($ext, array("jpg", "jpeg", "JPG", "JPEG" , "png", "PNG", "gif", "GIF"))){
								if($c % 6 == 0){echo "<tr>";}
								echo "<td><a href=\"javascript:choose_image('".$dir.$file."')\"><img width=\"150\" src=\"".$dir.$file."\"></a></td>";
								if($c % 6 == 6){echo "</tr>";}
								$c ++;
							}
						}
					}
					if($c == 0){ echo "No image were uploaded yet.";}
					echo "</table>";
					closedir($dh);
			}
	}
	
?>

<SCRIPT language="Javascript">
		function choose_image(url) {
			window.opener.CKEDITOR.tools.callFunction(<?php echo $callback; ?>, url);
			window.close();
		}
	</script>
</body>
