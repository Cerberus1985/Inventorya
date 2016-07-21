/**
 * @author inventorya
 */
var _IsNotCat_;
var _busqueda_;
var _insertar_;
var _selectData_;
$(document).on("ready",main);
function main(value){
	$("#buscador").focus();
	$('[data-toggle="tooltip"]').tooltip();
	cargarSelect();
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
	//console.log("estas entrando en buscar");
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
/* En esta funcion se piden los datos del server este envia todo en un formato estandar json y los muestra en formato HTML TABLE sobre un id salida
 
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
		opciones+="sap='"+datos+"'";
		break;
		
	case 'descripcion':	
		opciones+='nombre'+' LIKE "'+datos+'%"';
		break;
	case 'codigo_barra':
		opciones+="codigo_barra='"+datos+"'";
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
	/* Pide los datos al server y los muestra tambien se implemento un filtro con una expresion regular
	 por el momento solo busca cuando un dato contiene el inicio NT (no importa mayusculas minusculas)
	 y marca el dato con un link para llamar la atencion y posibles futuros usos*/
		success:function(data){
			var salida = $("#salida");
			var regExpre=/^NT+|^nt+|^Nt+|^nT+/;
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
					if (regExpre.exec(value)){
						html +='<td data-value='+value+'>'+'<a href="#" onclick="pedirCantidad(this)">'+value+'</a>'+'</td>';
					}else{
						html +='<td data-value='+value+'>'+value+'</td>';
						}
				});
				html +='<td><input type="checkbox" name="opciones" value="'+data['datos'][i][0]+'"></td>';
				html +='</tr>';}
				html +='<tr id="insertar" class="" data-tabla='+data['tabla']+'>';
				/* aca viene el alma de insertar datos en la tabla dependiendo la tabla de la base de datos que responda implementa
				 distintos campos y estos campos pueden tener funciones asociados como por ejemplo verificar que un numero no se repita
				 */
				//console.log(data['tabla']);
				switch(data['tabla']){
					case 'vista_productos':
							$.each(data['cabezeras'],function(key,value){
								switch(key){
									case 0:
											html +='<td data-value='+value+' disabled>'+'<input type="text" placeholder='+value+' id='+value+' disabled="true"></td>';
										break;
									case 1:
											html +='<td data-value='+value+' ">'+'<input type="text" placeholder='+value+' onblur="chequearSap(this.value)" id="sapp"></td>';
										break;
									case 2:
											html +='<td data-value='+value+' id="NombreInsertar">'+'<input type="text" placeholder='+value+' id='+value+' disabled="true"></td>';
										break;
									case 3:
											html +='<td data-value='+value+'  >'+'<input type="text" placeholder='+value+' id="MIT2016" onblur="chequeaSerial(this.value)"></td>';
										break;
									case 4:
											html +='<td data-value='+value+' onchage="cargarUbicacion()">'+'<select id="ubica">'+generarOption(value)+'</select></td>';
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
				/*Se agrega el icono para mostrar feelback con respeto a insertar una linea*/
				html +='<td data-value='+"borrame"+'><img  height="30" width="30" src="img/error.png" id="imgchk" data-toggle="tooltip" title="algo para decir"></td>';
				//fin de insertar
				html +='</tr>';
				html +='</tbody></table>';
				//console.log(html);
				}
				salida.html(html);
				
			}
		}
	});
}
function chequearSap(algo){
	var valor=algo;
	//console.log(valor);
	var regExpre=/^NT+|^nt+|^Nt+|^nT+/;
	var isNoSerial= regExpre.exec(valor);
	if(isNoSerial!=null){
		$("#imgchk").attr("src","img/warning.png");
		$("#MIT2016").attr("placeholder","cantidad");
		$("#MIT2016").attr("onblur","chequeaCantidad(this.value)");
		$("#MIT2016").attr("title","Estas por modificar un dato que requiere algunos");
		var boton=$("#insertarbtn1");
		boton.attr("onclick","updateCantidad()");
		boton.html("update");
		//$("#MIT2016").empty();
	}
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
					//console.log(info);
					nombre.removeClass("bg-danger");
					nombre.addClass("bg-success");
					nombre.empty();
					nombre.html(info[2]);
					_insertar_=true;
				}else{
					nombre.removeClass("bg-success");
					nombre.addClass("bg-danger");
					nombre.empty();
					nombre.html("No corresponde el SAP con uno valido");
					$("#insertarbtn").addClass("hidden");
					$("#imgchk").attr("src","img/error.png");
					_insertar_=false;
				}
		}
	});
}
function chequearUbicacion(){
	
}
function generarOption(info){
	switch (info){
		case 'nombre_ubicacion':
			return '<option value=NETACOM>NETACOM </option>'+'<option value="somewhere">somewhere</option>';
		break;
	}
}
function chequeaSerial(algo){
	var valor=algo;
	if(valor==""){
		$("#imgchk").attr("src","img/error.png");
		$("#insertarbtn").addClass("hidden");
		return false;
		}
	var operacion ='chequearSerial';
	var tabla ='productos';
	var opciones='0/0/'+valor;
	$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
	$.ajax({
		success:function(data){
				//console.log(data);
				if(data['Estatus']=='ok' & _insertar_){
					var boton=$("#insertarbtn");
					var imgchk=$("#imgchk");
					//console.log(boton);
					boton.removeClass("hidden");
					imgchk.attr("src","img/success.png");
				}else{
					var boton=$("#insertarbtn");
					var imgchk=$("#imgchk");
					//console.log(boton);
					boton.addClass("hidden");
					imgchk.attr("src","img/error.png");
				}
		}
	});
}
function chequeaCantidad(algo){
	var regExpre=/^[0-9]*$|^\-[0-9]*$/;
	if (algo==""){
		var boton=$("#insertarbtn");
		var imgchk=$("#imgchk");
		boton.addClass("hidden");
		imgchk.attr("src","img/warning.png");
		return false;
		
	}
	if(regExpre.exec(algo)){
		var boton=$("#insertarbtn");
		var imgchk=$("#imgchk");
		boton.removeClass("hidden");
		imgchk.attr("src","img/success.png");
	}else{
		var boton=$("#insertarbtn");
		var imgchk=$("#imgchk");
		boton.addClass("hidden");
		imgchk.attr("src","img/warning.png");
	}
}
function insertar(){
	var sap=$("#sapp").val();
	var cantidadorSerial="";
	var codigobarras=$("#MIT2016").val();
	var ubicacion=$("#ubica").val();
	var informacion="borrame";
	if(_IsNotCat_){
		var operacion="update";
		var tabla="productos";
		var opciones="0/0/";
	}else{
		var operacion="insertar";
		var tabla="--";
		var opciones="0/0/";
		opciones+=sap+"||";
		opciones+=codigobarras+"||";
		opciones+=ubicacion+"||";
		opciones+=informacion+"||";

		
	}
		$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
	$.ajax({
		success:function(data){
			$("#salida").empty();
			pedirDatos("","descripcion");
		}
	});
	
}
function pedirCantidad(info){
	//console.log(info.innerHTML);
	var tabla='vista_cantidad';
	var operacion="checkcantidad";
	var opciones="0/0/";
	opciones+=info.innerHTML;
	$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
	$.ajax({
		success:function(data){
			var placeholder=$("#MIT2016").attr("placeholder");
			placeholder+=' '+data['datos'][0];
			$("#MIT2016").attr("placeholder",placeholder);
			console.log(data);
		}
	});
}
function del(){
	var check=[];
	$("input:checkbox[name=opciones]:checked").each(function(){
    check.push($(this).val());
});
	//console.log(check);
	var confirmacion=confirm("Estas a punto de eliminar muchos item");
	if(confirmacion){
	var tabla='productos';
	var operacion="del_productos";
	var opciones="0/0/";
	for(var i=0;i<check.length;i++){
		opciones+=check[i]+'||';
	}
	//console.log(opciones);
		$.ajaxSetup({
		url:'ajax.php',
		type:"POST",
		dataType:'json',
		data:{operacion:operacion,tabla:tabla,opciones:opciones},
	});
		$.ajax({
		success:function(data){
			$('#buscarMain').trigger('click');
		}
	});
	}else{
		alert("cancelado con exito");
	}
}
function cargarSelect()
{
	$.ajaxSetup
	({
		url:'ajax.php',
		type:'POST',
		dataType:'json',
		data:{operacion:'select',tabla:'default',opciones:'0/0/'}
	});
	$.ajax
	({
		success:function(data)
		{
			if(data['Estatus']=='ok')
			{
				console.log(data);
			}
		}
	});
}
