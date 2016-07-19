<?php
/**
 * Sera la clase generica para manejar base de datos la configuracion la tendra de otra clase class.Inidriver.php
 * por lo tango esta funcion recibe opcionalmente un parametro con la ruta de donde obtendra el archivo ini con la configuraion
 */
 include_once 'class.Inidriver.php';
class DBmanager {
	public $userdb,$passdb,$hostdb,$namedb,$portdb;
	private $conexion;
	function __construct($argument='') 
	{
		$archivo_ini_driver= new Inidriver($argument);
		$ini_file_array=$archivo_ini_driver->getIniFile();
		$this->hostdb=$ini_file_array['Base_Datos_Config']['db.host'];
		$this->userdb=$ini_file_array['Base_Datos_Config']['db.user'];
		$this->passdb=$ini_file_array['Base_Datos_Config']['db.password'];
		$this->namedb=$ini_file_array['Base_Datos_Config']['db.dbname'];
		$this->portdb=$ini_file_array['Base_Datos_Config']['db.port'];		
	}
	public function getConexion()
	{
		try{
	
		$this->conexion=mysqli_connect($this->hostdb, $this->userdb, $this->passdb,$this->namedb, $this->portdb);
		return $this->conexion;
			}catch(Exception $e){
				echo 'No es posible conectar : ',  $e->getMessage(), "\n";
			}
	}



}

$algo = new DBmanager;

?>