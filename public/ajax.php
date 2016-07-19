<?php
/*Este archovo contiene todo lo necesario para realizar las consultas que se realizen por javascript desde el navegador del usuario
 * todo lo envia codeado en json*/
include '../core/core.php';
$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
error_reporting(E_ALL);
//$ADODB_CACHE_DIR = 'c:/tmp/';
$db = newADOConnection($driver);
$db->connect($host,$user,$pass,$BaseDatos);
if((isset($_POST['operacion']) && isset($_POST['tabla']))||(isset($_GET['operacion']) && isset($_GET['tabla']))){
	$operacion = (isset($_POST['operacion']))? $_POST['operacion'] : $_GET['operacion'];
	$tabla = (isset($_POST['tabla']))? $_POST['tabla'] : $_GET['tabla'];
	if(isset($_POST['opciones'])|| isset($_GET['opciones'])){
					$opciones = (isset($_POST['opciones']))? $_POST['opciones'] : $_GET['opciones'];
					$opciones = explode("/", $opciones);
					//var_dump($opciones);
			}else{$opciones =null;}
	switch ($operacion) {
		case 'listar':
			$resultado = listar($tabla, $db,$opciones);
			$limpio = utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'buscar':
			$resultado = buscar($tabla, $db, $opciones);
			$limpio = utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'pedirCabezera':
			$resultado= getRowName($tabla, $db);
			$limpio=utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'chequearCategorias':
			$resultado= categorias($tabla,$db,$opciones);
			$limpio=utf8ize($resultado);
			echo json_encode($limpio);
			//echo $resultado;
			break;
		case 'chequearUbicacion':
			$resultado= ubicaciones($tabla,$db,$opciones);
			$limpio=utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'insertar':
			$resultado=insertar($tabla,$db,$opciones);
			if($resultado){
					echo $resultado;
}
			break;
		case 'chequearSerial':
			$resultado=checkSerial($tabla,$db,$opciones);
			$limpio=utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'checkcantidad':
			$resultado=checkcantidad($tabla,$db,$opciones);
			$limpio=utf8ize($resultado);
			echo json_encode($limpio);
			break;
		case 'del_productos':
			$resultado=del_productos($tabla,$db,$opciones);
			
			break;
		default:
			$temporal=array("Estatus"=>"ERROR","TYPE"=>"Operacion no encontrada||inicializada","tabla"=>$tableName,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>NULL,"index"=>$offset=null,"limit"=>$limit=null);
			echo json_encode($temporal);
			break;
	}
}

?>
