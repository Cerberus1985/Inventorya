<?php
/* Smarty version 3.1.29, created on 2016-07-11 21:40:43
  from "C:\workspace\Inventorya\public\templates\index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5783f63b7ea164_12679549',
  'file_dependency' => 
  array (
    '7f1233fb999ce742ee231122c0d07b410bacd753' => 
    array (
      0 => 'C:\\workspace\\Inventorya\\public\\templates\\index.tpl',
      1 => 1468266038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5783f63b7ea164_12679549 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Inventorya</title>
		<meta name="Invertorya" content="">
		<meta name="Luis" content="luis@pipservice.com.ar">

		<?php echo '<script'; ?>
   src="js/jquery-1.12.4.min.js" ><?php echo '</script'; ?>
>
		<link href="css/bootstrap-slate.min.css" rel="stylesheet" >
		<?php echo '<script'; ?>
 src="js/bootstrap.min.js" ><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/index.js" ><?php echo '</script'; ?>
>
	</head>

	<body>
	
	
		<div class="container-fluid text-center">
			<header class="">
			</header>
			<nav class="nav">
			<div class="row">
				<div class="col-md-4 col-xs-2">
					<a href="#"><img src="img/User-icon.png" height="50px" width="50px" onclick="showLogout()"/></a>
					<a href="loginOut.php" class="hidden" id="user-logout"><div>Logout</div></a>
				</div>
				<div class="col-md-4 col-xs-8">
					<h2>INVENTORYA</h2>
				</div>
				<div class="col-md-4 col-xs-2">
					<a href="#"><img src="img/config.png" height="50px" width="50px" /></a>	
				</div>
			</div>
			</nav>

			<div class="row">
					<div class="col-md-2">
					
					</div>
					<div class="col-md-8">
						<form role="form" action="#" autocomplete="off">
							<div class="form-group">
								<input type="text" placeholder="Buscar..." class="form-control input-lg" id="buscador"/>
							</div>
						</form>
					</div>
				<div class="col-md-2">
					 
				</div>
			</div>
		<div id="pregunta1" class="hidden" onclick="chequeradios()">
			<div class="row" >
				<div class="radio-inline">
						 <label >
    						<input type="radio" name="optionsRadios" id="optionsRadios1" value="equipo" checked>
    								Equipo?
  						</label>
				</div>	
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios" id="optionsRadios2" value="usuario">
    								Usuario?
  						</label>
  				</div>
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios" id="optionsRadios3" value="deposito">
    								Deposito?
  						</label>
  				</div>	
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios" id="optionsRadios4" value="sap">
    								Sap?
  						</label>
  				</div>	
			</div>
		</div>
				<div id="pregunta2equipo" class="hidden" onclick="chequeradios()">
			<div class="row" id="equipo">
				<div class="radio-inline">
						 <label >
    						<input type="radio" name="optionsRadios2" id="optionsSAP" value="sap" checked>
    								SAP?
  						</label>
				</div>	
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios2" id="optionsCODIGOBARRA" value="codigo_barra">
    								Codigo Barra?
  						</label>
  				</div>
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios2" id="optionsDESCRIPCION" value="descripcion">
    								Descripcion?
  						</label>
  				</div>	
				
			</div>
		</div>
		<div id="pregunta2usuario" class="hidden" onclick="chequeradios()">
			<div class="row" id="usuario" >
				<div class="radio-inline">
						 <label >
    						<input type="radio" name="optionsRadios3" id="optionsNOMBRE" value="nombre" checked>
    								Nombre?
  						</label>
				</div>	
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios3" id="optionsTELEFONO" value="telefono">
    								Telefono?
  						</label>
  				</div>
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios3" id="optionsUBICACION" value="ubicacion">
    								ubicacion?
  						</label>
  				</div>	
				
			</div>
		</div>
		<div class="row">
			<button class="btn btn-primary" onclick="buscar()">Buscar</button>
		</div>
			</div>
			<div class="container" id="">
				<div class="row">
					<div id="salida" class="col-md-10">
						
					</div>
					<div class="col-md-2 hidden" id="microMenu">
						<div class="row">
							<div class="col-md-4">
								<a href="#" onclick="save()"><img src="img/save.png" height="40px" width="40px" /></a>
							</div>
							<div class="col-md-4">
								<a href="#" onclick="edit()"><img src="img/edit.ico" height="40px" width="40px"/></a>
							</div>
							<div class="col-md-4">
								<a href="#" onclick="del()"><img src="img/delete.png" height="40px" width="40px"/></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer">
				<div class="container-fluid text-center">
				<p>
					&copy; Copyright  by inventorya 
				</p>
				</div>
			</footer>
			
		
	</body>
</html>
<?php }
}
