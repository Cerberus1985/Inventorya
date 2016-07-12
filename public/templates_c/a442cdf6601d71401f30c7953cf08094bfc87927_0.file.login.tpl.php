<?php
/* Smarty version 3.1.29, created on 2016-07-06 19:55:26
  from "C:\workspace\Inventorya\public\templates\login.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577d460e104c89_65224995',
  'file_dependency' => 
  array (
    'a442cdf6601d71401f30c7953cf08094bfc87927' => 
    array (
      0 => 'C:\\workspace\\Inventorya\\public\\templates\\login.tpl',
      1 => 1467749516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577d460e104c89_65224995 ($_smarty_tpl) {
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
		<?php echo '<script'; ?>
 src="js/jquery.validate.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/messages_es_AR.min.js"><?php echo '</script'; ?>
>
		<link href="css/bootstrap-slate.min.css" rel="stylesheet" >
		<?php echo '<script'; ?>
 src="js/bootstrap.min.js" ><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/login.js"><?php echo '</script'; ?>
>
	</head>

	<body>
		<div class="container">
			<header>
				<h1>login</h1>
			</header>
			<nav>
				
			</nav>

			<div >
				<div class="row">
					<form  method="post"  action="login.php" id="FormLoggin" novalidate>
						<label for="user">
						<input type="text" placeholder="User..." id="userlogin" name="userlogin" class="required"/>
						</label>
						<label for="password">
							<input type="password" placeholder="Password"  id="passwordlogin" name="passwordlogin" class="required" />
						</label>
						<input type="submit" value="enviar" class="btn btn-primary" />
					</form>
				</div>
			</div>
			<div id="error">
				<!---- ACA va los mensajes de errores o de estatus en login --->
			</div>

			<footer class="footer">
				<p>
					&copy; Copyright  by inventorya
				</p>
			</footer>
		</div>
	</body>
</html>
<?php }
}
