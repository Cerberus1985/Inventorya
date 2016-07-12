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
		<link href="css/bootstrap.min.css" rel="stylesheet" >
		<script src="js/bootstrap.min.js" ></script>
		<script src="js/index.js" ></script>
	</head>

	<body>
		<div class="container-fluid text-center">
			<header class="">
			</header>
			<nav class="nav">
			<div class="row">
				<div class="col-md-4 col-xs-2">
					<a href="#"><img src="img/User-icon.png" height="50px" width="50px" onclick="showLogout()"/></a>
					<a href="#" class="hidden" id="user-logout"><div>Logout</div></a>
				</div>
				<div class="col-md-4 col-xs-8">
					<a href="#"><h1>Inventorya</h1></a>
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
						<form role="form" action="#">
							<div class="form-group">
								<input type="text" placeholder="Buscar..." class="form-control input-lg" onchange="main(this.value)"/>
							</div>
						</form>
					</div>
				<div class="col-md-2">
					 
				</div>
			</div>
			<div class="row">
				<div class="radio-inline">
						 <label>
    						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
    								Equipo
  						</label>
				</div>	
				<div class="radio-inline">
  						<label>
    						<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
    								Usuario
  						</label>
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
