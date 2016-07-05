<?php
    /*<!----Maldita costumbre de poner todo en un solo archivo ahora veo como lo sumo a al resto del proyecto---!>
	 * aca iran todas las funciones sueltas que se encuentran en ajax
	 * */
function listar($tableName,$conexion,$option=NULL){
	$slq="SELECT * FROM $tableName";
	if(!$option){
			$offset = null;
			$limit = null;
			$result = $conexion->Execute($slq);
	}else {
			$offset = $option[0];
			$limit = $option[1];
			$result = $conexion->selectLimit($slq,$limit,$offset);
	}
	
	if ($result){
			while(!$result->EOF){
			$lineas[] = $result->fields;
			$result->MoveNext();
			}
			$retorno = array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tableName,"cabezeras"=>getRowName($tableName, $conexion),"cantidadDatos"=>count($lineas),"datos"=>$lineas,"index"=>$offset,"limit"=>$limit);
	return $retorno;}else{
							return array("Estatus"=>"ERROR","TYPE"=>"Tabla No encontrada","tabla"=>$tableName,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>NULL,"index"=>$offset=null,"limit"=>$limit=null);
						}
	
}
/*Esta funcion busca dependiendo de las opciones que se le envian si no se le envian opciones entonces actua igual que listar
 * las opciones son en formato SQL'ERAN EN FORMATO SQL AHORA ES STRING CON LA BUSQUEDA A SECAS PERO REQUIERE EL NOMBRE DEL CAMPO' */
function buscar($tableName,$conexion,$datos=''){
	$lineas=null;
	if($datos[1]==0){
		$opciones= $datos[2];
		$offset = null;
		$limit = null;
		$slq="SELECT * FROM $tableName where $opciones";
		//echo $slq;
		$result = $conexion->Execute($slq);
	}else{
			//echo"else IF <br>";
			$offset = $datos[0];
			$limit = $datos[1];
			if(count($datos)==3){
				$opciones = $datos[2];
			}else{
				$opciones ="";
			}
			$slq="SELECT * FROM $tableName where $opciones";
			$result = $conexion->selectLimit($slq,$limit,$offset);
	}
	//var_dump($result);
	if ($result){
			while(!$result->EOF){
			$lineas[] = $result->fields;
			$result->MoveNext();
			}
	//var_dump($lineas);
			return array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tableName,"cabezeras"=>getRowName($tableName, $conexion),"cantidadDatos"=>count($lineas),"datos"=>$lineas,"index"=>$offset,"limit"=>$limit); 
				}else{
							return array("Estatus"=>"ERROR","TYPE"=>"opciones de busqueda incorrectas","tabla"=>$tableName,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>null,"index"=>$offset=null,"limit"=>$limit=null);
									}
}
function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else if (is_string ($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}
function getRowName($tableName,$conexion)
  {
  	 $lngCountFields=0;
  	 $sql= "SELECT * FROM $tableName LIMIT 1";
  	 $resultado = $conexion->Execute($sql);
	 if (!$resultado->EOF) {
        for ($i = 0; $i < $resultado->FieldCount(); $i++) {
            $fld = $resultado->FetchField($i);
            $aRet[$lngCountFields] = $fld->name;
            $lngCountFields++;
        }
    }
	 $resultado->close();
	 $resultado=NULL;
	 return $aRet;
	 
  }
 function categorias($tabla,$conexion,$opciones)
 {
 	 $sap =$opciones[2];	
     $sql="select * from $tabla where sap='$sap'";
     $resultado=$conexion->Execute($sql);
	 if($resultado->RowCount()==1){
	 	$lineas[] = $resultado->fields;
		 return array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tabla,"cabezeras"=>getRowName($tabla, $conexion),"cantidadDatos"=>count($lineas),"datos"=>$lineas,"index"=>$offset=null,"limit"=>$limit=null);
	 }else{
	 	return array("Estatus"=>"ERROR","TYPE"=>"opciones de busqueda incorrectas","tabla"=>$tabla,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>null,"index"=>$offset=null,"limit"=>$limit=null);
	 }
 }
?>