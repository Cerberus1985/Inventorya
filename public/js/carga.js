$(document).on("ready",main);
function main (){
	$("#descripcion").attr("disabled",true);
	$("#insertarM").on("change",function(){
		var datos = $("#insertarM").val();
		if(validar(datos)){
			$("#descripcion").attr("disabled",false);
			$("#insertarM").on("change",validaD);
		}else{
			
		}
		console.log(datos);
	});
}
function validar (datos) {
  return true;
}
function validaD(){
	var descripcion=$("#insertarM").val();
	if(validar(descripcion)){
		$("#descripcion").attr("disabled",true);
		$("#insertarM").attr("disabled",true);
		$('<tr>',{
			id:"algo",
			
		}).appendTo($("#tabla"));
	}else{
		
	}
}
