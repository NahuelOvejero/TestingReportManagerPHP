<?php

session_start();	

?>

<html>

<head>
<title>login - Testing Tool</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="estilos/bootstrap.css">
<link rel="stylesheet" type="text/css" href="estilos/logeo.css">
</head>

<script type="text/javascript">
	function validar(){
		var pass1 = document.getElementById('pass').value;		
		var usuario = document.getElementById('user').value;

		if(pass.length < 8)
		{
			alert("Contraseña Incorrecta.");
			return false;
		}
		else if(user.length < 6)
		{
			alert("Usuario Incorrecto.");
			return false;

		}


	}
</script>


<div id="banner" class="flexbox-container">
	<a href="inicio.php"><p class="titulo"> Testing Tool </p></a>
	<div id="contenedorlog">
	<a class="log" href="logeo.php">Logeo</a> / 
	<a class="log" href="registro.php">Registro</a>
	</div> 
</div>
	
	<?php
	if(isset($_GET['correo'])){
		if($_GET['correo']=='true')
			echo '<h1 class="text-center error">Registro Exitoso. Verifique su correo electronico.</h1>';
		else
			echo '<h1 class="text-center error">Registro Exitoso. No se alcanzo su casilla de correo electronico.</h1>';
	}

				if(isset($_GET['error'])){
					if($_GET['error']=='log'){
						echo '<h1 class="text-center error">Usuario y/o contraseña incorrecto.</h1>';
					}
					else
						echo '<h1 class="text-center error">El usuario no posee cuenta Registresé.</h1>';
				}
			?>

<div class="alineador">
	<div class="centro">

		<form method="post" action="logear.php">
			<p class="text-center">Correo Electronico</p>
			<input type="text" id="user" name="user" placeholder="Nombre de Usuario" required> <br>
			<p class="text-center">Contraseña</p>
			<input type="password" id="pass1" name="pass" placeholder="Contraseña" required> <br>
			<br>
			<input type="submit" value="Login" name="enviar" onclick="return validar()"> <br>
			<a href="registro.php">No tienes cuenta? Registrate</a>
		</form>
	</div>

</div>

</html>