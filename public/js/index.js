/**
 * @author inventorya
 */
var _busqueda_;
$(document).on("ready",main);
function main(value){
	$("#buscador").focus();
	$("#buscador").on("keyup",function(){
		$("#pregunta1").removeClass("hidden");
	});
}
function showLogout(){
	$("#user-logout").removeClass("hidden");
}
function chequeradios(){
	var selected = $('input[name=optionsRadios]:checked');
	var selectedVal = selected.val();
	switch (selectedVal){
	case 'equipo':
		$('#pregunta2equipo').removeClass("hidden");
		$('#pregunta2usuario').addClass("hidden");
		$('#pregunta2deposito').addClass("hidden");
		var select=$('input[name=optionsRadios2]:checked');
		if(select.length > 0){
			_busqueda_=select.val();
		}else{
			_busqueda_='';
		}

		break;
	case 'usuario':
		$('#pregunta2usuario').removeClass("hidden");
		$('#pregunta2equipo').addClass("hidden");
		$('#pregunta2deposito').addClass("hidden");
		var select=$('input[name=optionsRadios3]:checked');
		if(select.length > 0){
			_busqueda_=select.val();
		}else{
			_busqueda_='';
		}

		break;
	case 'deposito':
		$('#pregunta2deposito').removeClass("hidden");
		$('#pregunta2usuario').addClass("hidden");
		$('#pregunta2equipo').addClass("hidden");
		_busqueda_='deposito';
		break;
	case 'sap':
		$('#pregunta2usuario').addClass("hidden");
		$('#pregunta2equipo').addClass("hidden");
		_busqueda_='sapS';
	default:
		}
}
function buscar(){
	var selected1 =$('input[name=optionsRadios]:checked');
	if(_busqueda_==''){
		alert("elija una opcion");
	}else{
			var busqueda = $('#buscador').val();
			$('#pregunta2usuario').addClass("hidden");
			$('#pregunta2deposito').addClass("hidden");
			$('#pregunta2equipo').addClass("hidden");
			$("#pregunta1").addClass("hidden");
			pedirDatos(busqueda,_busqueda_);
			$("#microMenu").removeClass("hidden");
			busqueda='';
			
	}
}
/* En esta funcion se piden los datos del server este envia todo en un formato estandar json 
 
 * {"Estatus":"ok||ERROR","TYPE":"Success||Error description","tabla":"TableName","cabezeras":["string1","string2","...."],"cantidadDatos":1,"datos":[["1","100207416","ANTENA","11111111111","netacom"]],"index":null,"limit":null}
 * la manera de enviar los datos es la siguiente 
 * {operacion:operacion,tabla:tableName,opciones:opciones(index(int)/limit(int)/namecampo='busqueda'(string))}
 * pedirDatos(datos=searchUser,busqueda=campoDetabla)
 * 
 * */
function pedirDatos(datos,busqueda){
	var operacion = 'buscar';
	var tabla = '';
	if(busqueda=='sap' || busqueda=='descripcion' || busqueda=='codigo_barra'){
		tabla ='vista_productos';
	};
	if(busqueda=='nombre' || busqueda=='telefono' || busqueda=='ubicacion'){
		tabla ='user_vista';
	}
	if(busqueda=='sapS'){
		tabla ='categoria_subcategoria_view';
	}
	var opciones = '0/0/';
	switch (busqueda){
	case 'sap':
		opciones+='sap='+datos;
		break;
		
	case 'descripcion':	
		opciones+='nombre'+' LIKE "'+datos+'%"';
		break;
	case 'codigo_barra':
		opciones+='codigo_barra='+datos;
		break;
	case 'nombre':
		opciones+='nombre'+' LIKE "'+datos+'%"';
		break;
	case 'telefono':
		opciones+='telefono'+' LIKE "'+datos+'%"';
		break;
	case 'sapS':
		opciones+='nombre'+' LIKE "'+datos+'%"';
		break;
		}
	$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
$.ajax({
		success:function(data){
			var salida = $("#salida");
			if(data['Estatus']=='ok'){//chequea que estatus sea OK y no ERROR 
				var html ='<table class="table"><thead><tr>';
				$.each(data['cabezeras'],function(key,value){
					html +='<td data-value='+value+'>'+value+'</td>';
				});
				html +='<td>#</td>';
				html +='</tr></thead>';
			if(data['cantidadDatos']>0){
				html +='<tbody><tr>';
				for(var i=0;i<data['cantidadDatos'];i++){
				var info =data['datos'][i];
				//console.log(info);
				$.each(info,function(key,value){
					html +='<td data-value='+value+'>'+value+'</td>';
				});
				html +='<td><input type="checkbox" name="opciones" value="'+data['datos'][i][0]+'"></td>';
				html +='</tr>';}
				html +='<tr id="insertar" class="" data-tabla='+data['tabla']+'>';
				/* aca viene el alma de insertar datos en la tabla*/
				//console.log(data['tabla']);
				switch(data['tabla']){
					case 'vista_productos':
							$.each(data['cabezeras'],function(key,value){
								switch(key){
									case 0:
											html +='<td data-value='+value+' disabled>'+'<input type="text" placeholder='+value+' id='+value+' disabled="true"></td>';
										break;
									case 1:
											html +='<td data-value='+value+' ">'+'<input type="text" placeholder='+value+' id='+value+' onblur="chequearSap(this.value)"></td>';
										break;
									case 2:
											html +='<td data-value='+value+' id="NombreInsertar">'+'<input type="text" placeholder='+value+' id='+value+' disabled="true"></td>';
										break;
									case 3:
											html +='<td data-value='+value+' onkeyup="chequeaSerial()">'+'<input type="text" placeholder='+value+' id='+value+'></td>';
										break;
									case 4:
										html +='<td data-value='+value+' onchage="cargarUbicacion()">'+'<select><option value="">'+value+'</option></select></td>';
										break;
									case 5:
										break;
								}
								//html +='<td data-value='+value+'>'+'<input type="text" placeholder='+value+' id='+value+'></td>';
							});
						break;
					case 'categoria_subcategoria_view':
						$.each(data['cabezeras'],function(key,value){
								switch(key){
									case 0:
											html +='<td data-value='+value+' onchange="cargarCategoria()">'+'<select><option value="">'+value+'</option></select></td>';;
										break;
									case 1:
											html +='<td data-value='+value+'>'+'<input type="text" placeholder='+value+' id='+value+'></td>';
										break;
									case 2:
											html +='<td data-value='+value+' onkeyup="chequeaSap(this)">'+'<input type="text" placeholder='+value+' id='+value+'></td>';
										break;
									case 3:
											//html +='<td data-value='+value+'onkeyup="chequeaSerial">'+'<input type="text" placeholder='+value+' id='+value+'></td>';
										break;
									case 4:
										//html +='<td data-value='+value+' onload="cargarUbicacion()">'+'<select><option value="">'+value+'</option></select>'></td>';
										break;
									case 5:
										break;
								}
						});}
				html +='</tr>';
				html +='</tbody></table>';
				//console.log(html);
				}
				html +='<div id="insertar"><button class="btn btn-primary" onclick="insertar()" disabled> insertar</button></div>';
				salida.html(html);
				
			}
		}
	});
}
function chequearSap(algo){
	var valor=algo;
	console.log(valor);
	var operacion ='chequearCategorias';
	var tabla ='categoria_view';
	var opciones='0/0/'+valor;
	$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
	$.ajax({
		success:function(data){
				var nombre;
				nombre= $("#NombreInsertar");
				if(data['Estatus']=='ok'){
					var info=data['datos'][0];
					console.log(info);
					nombre.removeClass("bg-danger");
					nombre.addClass("bg-success");
					nombre.empty();
					nombre.html(info[2]);
					
				}else{
					nombre.removeClass("bg-success");
					nombre.addClass("bg-danger");
					nombre.empty();
					nombre.html("No corresponde el SAP con uno valido");
				}
		}
	});
}
function chequearUbicacion(){
	
}
