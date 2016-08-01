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
		/*$tmp = explode(" LIKE ", $datos[2]);
		if(count($tmp>1)){
			var_dump($tmp);
		} ALERTA SPOILER SE VIENE NEGRAAAAAASS*/
		$opciones= verifica($datos[2]);
		$offset = null;
		$limit = null;
		$slq="SELECT * FROM $tableName WHERE $opciones;";
		//echo $slq;
		$result = $conexion->Execute($slq);
		//var_dump($conexion->ErrorMsg());
	}else{
			//echo"else IF <br>";
			$offset = $datos[0];
			$limit = $datos[1];
			if(count($datos)==3){
				$opciones = $datos[2];
			}else{
				$opciones ="";
			}
			$slq="SELECT * FROM $tableName where $opciones;";
			$result = $conexion->selectLimit($slq,$limit,$offset);
	}

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
  	 $sql= "SELECT * FROM $tableName LIMIT 1;";
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
     $sql="select * from $tabla where sap='$sap';";
     $resultado=$conexion->Execute($sql);
	 if($resultado->RowCount()==1){
	 	$lineas[] = $resultado->fields;
		 return array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tabla,"cabezeras"=>getRowName($tabla, $conexion),"cantidadDatos"=>count($lineas),"datos"=>$lineas,"index"=>$offset=null,"limit"=>$limit=null);
	 }else{
	 	return array("Estatus"=>"ERROR","TYPE"=>"opciones de busqueda incorrectas","tabla"=>$tabla,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>null,"index"=>$offset=null,"limit"=>$limit=null);
	 }
 }
function insertar($tabla,$conexion,$opciones)
 {
 	/* Los datos se envian en opciones siendo la secuencia la siguiente 
	 * 0/0/(puesto para retrocompatibilidad con las otras funciones)
	 * PrimerValor(sap)||
	 * SegundoValor(codigoBarras||cantidad)||
	 * TercerValor(ubicacion string ejemplo 'netacom')||
	 * CuartoValor (informacion (string (60)))
	 * esta claro que para poder insertar en la tabla productos debe ser usuario*/
 	 $limpio=$opciones[2];
     $datos[]= explode('||', $limpio);
	 $sap=verifica($datos[0][0]);
	 $codigoBarras=verifica($datos[0][1]);
	 $userid= verifica($_SESSION['iduser']);
	 $ubicacion =verifica($datos[0][2]);
	 $informacion=verifica($datos[0][3]);
     $sql="CALL insertarp ('$sap','$codigoBarras','$userid','$ubicacion','$informacion');";
	 $resultado=$conexion->Execute($sql);
	 var_dump($resultado);
 }
function verifica($cadena){
 	$regular="/[-@+\\\]/";
	if(preg_match($regular, $cadena)){
		return 'FALSE';
	}else{
		return $cadena;
	}
 }
/*Chequea que el serial no este en la base de datos si se encuentra y en caso que  los encuentre regresa error*/
function checkSerial($tableName,$conexion,$opciones=NULL)
{
	$codigo_barra =verifica($opciones[2]);
	$sql="select * from $tableName where codigo_barra='$codigo_barra';";
	$resultado=$conexion->Execute($sql);
	if($resultado->RowCount()==1){
	 	$lineas[] = $resultado->fields;
		 return array("Estatus"=>"ERROR","TYPE"=>"El serial esta duplicado","tabla"=>$tableName,"cabezeras"=>getRowName($tableName, $conexion),"cantidadDatos"=>count($lineas),"datos"=>$lineas,"index"=>$offset=null,"limit"=>$limit=null);
	 }else{
	 	return array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tableName,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>null,"index"=>$offset=null,"limit"=>$limit=null);
	 }
}
/*Funcion solo con el propocito de mostrar el funcionamiento de la verificacion para evitar el sql inyection*/
function verificaDebug($cadena){
	 $regular="/^NT+|^nt+|^Nt+|^nT+/";
	if(preg_match($regular, $cadena)){
		return 'FALSE';
	}else{
		return $cadena;
	}
}
/*chequea la cantidad de los productos no serializados */
function checkcantidad($tableName,$conexion,$opciones)
{	$sap=$opciones[2];
	$sql="Select cantidad,unidad,nombre from vista_cantidad where sap='$sap';";
	//echo $sql;
	$resultado=$conexion->Execute($sql);
	if($resultado!=null){
		$lineas[] = $resultado->fields;
		//var_dump($lineas);
		return array("Estatus"=>"ok","TYPE"=>"Success","tabla"=>$tableName,"cabezeras"=>getRowName($tableName, $conexion),"cantidadDatos"=>1,"datos"=>$lineas,"index"=>$offset=null,"limit"=>$limit=null);
	 }else{
	 	return array("Estatus"=>"ERROR","TYPE"=>"El error es ni idea","tabla"=>$tableName,"cabezeras"=>array("Estatus","Descripcion"),"cantidadDatos"=>0,"datos"=>null,"index"=>$offset=null,"limit"=>$limit=null);
	 }
	
}
/*Esta funcion borra todos los productos pasados por las opciones estando separados por || entre cada id como respuesta si existieran errores
 * regresa eso no son tomados en cuenta por la aplicacion principal ajax por que no es respuesta json standar*/
function del_productos($tableName,$conexion,$opciones){
	 $limpio=$opciones[2];
     $datos[]= explode('||', $limpio);
	 //var_dump($datos);
	 for($i=0;$i<count($datos[0]);$i++){
	 	$id=$datos[0][$i];
	$sql="DELETE FROM productos WHERE idproductos=".$id.";";
	//var_dump( $sql);
		$conexion->Execute($sql);
		echo $conexion->ErrorMsg();
	 }
}
/*ATENCION!!!!!!!!!!! esta funcion no responde de la misma manera de las demas ya que entrega html como respuesta
 * es medio complicado pero la voy a cambiar en breve*/
function select($tableName,$conexion,$opciones)
{
	//var_dump($opciones);
	switch ($opciones[2]) {
		case 'nombre_ubicaciones':
			$tabla='ubicaciones';
			break;
		case'nombre_categorias':
			$tabla='categoria';
			break;
		default:
			$tabla='';
			break;
	}
	$selectes='<select id="ubica">';
	$temporar=listar($tabla, $conexion);
	for ($i=0; $i <$temporar['cantidadDatos'] ; $i++) { 
		$selectes.='<option value="'.$temporar['datos'][$i][1].'">'.$temporar['datos'][$i][1].'</option>';
	}
	$selectes.='</select>';
	echo $selectes;
}
function isAjax()
{
	/*chequea que la peticion sea AJAX caso contrario regresa false*/
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    	{return true;}
    else
    	{return false;}
	
}
/*Envia la informacion de los productos en una tabla lo saca del log por lo cual todavia esta en investigacion la manera
 * en la se mostrara la informacion
 * */
function info_productos($tabla,$db,$opciones)
{
		$limpio=$opciones[2];
     	$datos[]= explode('||', $limpio);
		//var_dump($datos);
		$tabla="<table><thead><tr><th>campo_1</th><th>Campo_2</th><th>campo_3</th><th>campo_4</th><th>campo_5</th><th>Campo_6</th></tr><tbody>";
		for($i=0;$i<count($datos[0]);$i++)
		{
			$id=$datos[0][$i];
			$sql="SELECT * FROM productos_log WHERE idproducto=$id;";
			//echo $sql."</br>";
			$respuesta=$db->Execute($sql);
			if($db->ErrorMsg()=='')
			{
				$z=0;
				while(!$respuesta->EOF)
				{
					
					$tabla.="<tr>";
					$informacion[]=$respuesta->fields;
					for($X=0;$X<count($informacion[$z]);$X++)
					{
						$tabla.="<td>".$informacion[$z][$X]."</td>";
					}
					$tabla.="</tr>";
					$z++;
					$respuesta->MoveNext();
				}
				//var_dump($informacion);
				$tabla.="</tbody></table>";
				unset($informacion);
				echo $tabla;
			}else
			{
				echo $db->ErrorMsg();
			}
		}
}
function startsWith($haystack, $needle)
{
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
}
function run_sql_file($location,$link)
{/*Permite ejecutar todas las sentencias SQL cargadas en un archivo sql
 * requiere un link mysqli y una localizacion del archivo*/
	    //load file
	    $commands = file_get_contents($location);
	    //delete comments
	    $lines = explode("\n",$commands);
	    $commands = '';
	    foreach($lines as $line){
	        $line = trim($line);
	        if( $line && !startsWith($line,'--') ){
	            $commands .= $line . "\n";
	        }
	    }
	
	    //convert to array
	    $commands = explode(";", $commands);
	
	    //run commands
	    $total = $success = 0;
	    foreach($commands as $command){
	        if(trim($command)){
	            $success += (@mysqli_query($link,$command)==false ? 0 : 1);
	            $total += 1;
	        }
	    }
		mysqli_close($link);
		    //return number of successful queries and total number of queries found more one general status
	    return array(
	        "success" => $success,
	        "total" => $total,
	        "general"=>($total==$success)?TRUE:FALSE
	    );
}
?>