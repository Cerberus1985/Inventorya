<?php
include "../core/core.php";
if (isset($_GET['cadena'])) {
	$respuesta= verifica($_GET['cadena']);
}else{
	$respuesta='false';
}
?>
<form action="pruebas.php" method="get">
<input type="text" placeholder="cadena..." name="cadena" />
<input type="submit" value="Enviar" />
</form>
<div id="salida">
	<?php if(isset($respuesta)){
		//echo $respuesta;
		$timestamp=1469190321-10800;
		date_default_timezone_set('UTC');
		echo date('H:i:s d-m-Y ', $timestamp);
	}?>
</div>