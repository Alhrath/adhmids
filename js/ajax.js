<SCRIPT LANGUAGE="JavaScript">
<!-- 

function get_ajaxObject(){  
	var ajaxObject;
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxObject = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxObject = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// No AJAX support
				alert("AJAX error!");
				return false;
			}
		}
	}

	return ajaxObject;

}



//-->
</script>
