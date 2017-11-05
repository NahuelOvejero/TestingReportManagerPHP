<html>

<head>
<title>Registro - Testing Tool</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="estilos/bootstrap.css">
<link rel="stylesheet" type="text/css" href="estilos/logeo.css">
</head>

<script type="text/javascript">

	function validar(){


		var pass1 = document.getElementById('pass1').value;		
		var pass2 = document.getElementById('pass2').value;
		var mail = document.getElementById('mail').value;

		var patt = /\S+@\S+/i;


		if(pass1 !== pass2 || pass1.length == 0 )
			{
				alert("Las contraseñas ingresadas no coinciden.");
				return false;
			}
		else if(pass1.length < 8)
			{
				alert("La contraseña debe tener un minimo de 8 caracteres.")
				return false;
			}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			
				alert("Eso no es un correo, ni parecido");
				return false;
			}
		}

			

</script>

<?php
	if(isset($_GET['registro']))
		echo '<h1>Ocurrio un problema en la base de datos. Intente unos minutos.</h1>';
?>

<div id="banner" class="flexbox-container">
	<a href="inicio.php"><p class="titulo"> Testing Tool </p></a>
	<div id="contenedorlog">
	<a class="log" href="logeo.php">Logeo</a> / 
	<a class="log" href="registro.php">Registro</a>
	</div> 
</div>


<div class="alineador">
	<div class="centro">
		<form method="post" action="registrar.php">
			<p class="text-center">Correo Electronico</p>
			<input type="text" id="mail" name="mail" placeholder="sucorreo@servidor.com"> <br>
			<p class="text-center">Contraseña</p>
			<input type="password" id="pass1" name="pass" placeholder="Contraseña"> <br>
			<p class="text-center">Repita Contraseña</p>
			<input type="password" id="pass2" name="verificacion" placeholder="Repita Contraseña"> <br>
			<p class="text-center">Tipo de usuario</p>
			<select name="rol">
				<option value="1"> Lider QA </option>
				<option value="2"> Requerimiento </option>
				<option value="3"> Tester Analista </option>
				<option value="4"> Tester Developer </option>
			</select> <br>
			<p class="text-center">Confirmar Registro</p>
			<input type="submit" name="enviar" onclick="return validar()"> <br>
			<?php if(isset($_GET['er'])) echo '<p class="error">El mail se encuentra en uso.</p>' ?>
			<a href="logeo.php">Ya tienes cuenta? Logea</a>
		</form>
	</div>
</div>

</html>