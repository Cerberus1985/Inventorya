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

		<script   src="js/jquery-1.12.4.min.js" ></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/messages_es_AR.min.js"></script>
		<link href="css/bootstrap-slate.min.css" rel="stylesheet" >
		<script src="js/bootstrap.min.js" ></script>
		<script src="js/login.js"></script>
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
					<form  method="post" id="FormLoggin" novalidate>
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
