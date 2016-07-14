<?php
include '../core/core.php';
if (isset($_GET['cadena'])) {
    $respuesta = verifica($_GET['cadena']);
} else {
    $respuesta = 'false';
}
?>
<form action="pruebas.php" method="get">
<input type="text" placeholder="cadena..." name="cadena" />
<input type="submit" value="Enviar" />
</form>
<div id="salida">
	<?php if (isset($respuesta)) {
    echo $respuesta;
}?>
</div>