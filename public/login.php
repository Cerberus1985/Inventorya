<?php
    include '../core/core.php';
	//echo $_POST['userlogin'];
	//echo $_POST['passwordlogin'];
	//echo md5('demo');
	$userloggin= (isset ($_POST['userlogin'])) ? $_POST['userlogin'] : "";
	$passwordlogin= (isset ($_POST['passwordlogin'])) ? md5($_POST['passwordlogin']) : "";
	if($userloggin=="" || $passwordlogin ==""){
		echo "ERROR";
		$msg="Ningun-campo-puede-estar-incompleto";
		header("Location: /public/index.php?msg=$msg" );
	}else{
		$db = newADOConnection($driver);
		$db->connect($host,$user,$pass,$BaseDatos);
		$sql2="SELECT iduser,nombre,usuario,`password`,estatus,`group` FROM `user` WHERE usuario=".$db->qstr($userloggin).";";
		$resultado = $db->Execute($sql2);
		//var_dump($resultado);
		if($resultado){
			$datos[] = $resultado->fields;
			var_dump($datos);
			//var_dump($passwordlogin);
			if($datos[0]['password']== $passwordlogin){
			$_SESSION['loggin']='true';
			$_SESSION['nombre']=$datos[0]['nombre'];
			$_SESSION['iduser']=$datos[0]['iduser'];
			$_SESSION['estatus']=$datos[0]['estatus'];
			$_SESSION['group']=$datos[0]['group'];
			echo "ok";
			header("Location: /" );
			}else{
				$msg= "contraseña-incorrecta";
				header("Location: /public/index.php?msg=$msg" );
				unset($msg);
			}
		}else{
			$msg= "el-usuario-no-existe";
			header("Location: /public/index.php?msg=$msg" );
			unset($msg);
		}
	}
?>