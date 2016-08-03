<?php 
if(file_exists("../config/config.ini"))
{
	die("ya esta configurado no se puede configurar de nuevo");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			body
			{
				background-image: url(background.png);
			}
			input
			{
				display: block;
			}
			h1
			{
				font-size: 15px;
				font-family: Arial, "MS Trebuchet", sans-serif;
			}
			label
			{
				color:#505050;
			}
			label:hover
			{
				color:red;
			}
		</style>
	</head>
	<h1>Comencemos a configurar inventorya</h1>
	<p>Por el momento hay limitaciones como por ejemplo solo esta disponible para bases de datos MySQL</p>
	<form action="" method="post">
		<label for="dbhost">*generalmente es 127.0.0.1
			<input type="text" placeholder="127.0.0.1"  name="dbhost"/>
		</label>
		<label for="mysqluser">*generalmente es root
			<input type="text" placeholder="Mysql user...(root)"  name="mysqluser"/>
		</label>
		<label for="mysqlpass">*generalmente se encuentra vacia
			<input type="password" placeholder="Mysql passw...('')"  name="mysqlpass"/>
		</label>
		<label for="dbname">*generalmente no es requerida
			<input type="text" placeholder="Db Name..."  name="dbname"/>
		</label>
		<label for="summit">
			<input type="submit" value="summit"  name="summit"/>
		</label>
	</form>
	<div id="error">
		<?php 
			if(isset($_POST['error']) && $_POST['error']!="")
			{
				echo $_POST['error'];
			}
		?>
	</div>
</html>
<?php
include '../core/core.php';
//set_error_handler("warning_handler", E_WARNING);
if(isset($_POST['summit']))
{
	$script_path=realpath(dirname(__FILE__));
	$user=($_POST['mysqluser']!="") ? $_POST['mysqluser']:"root";
	$pass=($_POST['mysqlpass']!="") ? $_POST['mysqlpass']:"";
	$dbName=($_POST['dbname']!="") ? $_POST['dbname']:"inventorya";
	$dbhost=($_POST['dbhost']!="") ? $_POST['dbhost']:"127.0.0.1";
	try{
	$enlace = mysqli_connect($dbhost,$user,$pass,$dbName);
	}catch(Exception $e){
		echo "hola";
	}
	
	$resultado=run_sql_file("test.sql",$enlace);
	if($resultado["general"]==TRUE)
	{
		$fileIniMg= new Inidriver("../config/config.template.ini");
		$arrayIn=$fileIniMg->getIniFile();
		$arrayIn["Base_Datos_Config"]["db.user"]=$user;
		$arrayIn["Base_Datos_Config"]["db.password"]=$pass;
		$arrayIn["Base_Datos_Config"]["db.host"]=$dbhost;
		$arrayIn["Base_Datos_Config"]["db.dbname"]=$dbName;
		$fileIniMg->SetiniFile($arrayIn,"../config/config.ini");
	}
}
restore_error_handler();
function warning_handler($errno, $errstr,$errfile, $errline) {
	echo "revisa los datos sumistrados";
	die();
}

?>