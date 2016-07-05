<?php
	if($_SERVER['SERVER_NAME']=='admin.inventorya.com'){
		header('Location: public/index.php');
	}else{
		header('Location: http://www.google.com.ar');
	}
    
?>