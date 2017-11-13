<?php

session_start();	


if(isset($_SESSION['rol']))
	if($_SESSION['rol']!='requerimiento') header('Location:inicio.php?auth=false');

?>

<html>
<head>
<title>Bienvenido - Testing Tool</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="estilos/bootstrap.css">
<link rel="stylesheet" type="text/css" href="estilos/main.css">
</head>



<body>

	<div id="banner" class="flexbox-container">
		<a href="inicio.php"><p class="titulo"> Testing Tool </p></a>
		<div id="contenedorlog">

			<?php

			if(isset($_SESSION['mail']) && isset($_SESSION['rol'])){
				echo '<a class="log" href="#">' . $_SESSION['mail'] . '</a> - <a class="log" href="logout.php">Salir</a>';
			}
			else
				echo 
				'
				<a class="log" href="logeo.php">Logeo</a> / 
				<a class="log" href="registro.php">Registro</a>
				';
			?>
		</div> 
	</div>

		<?php

				//nav menu

				if(isset($_SESSION['rol'])){

					include 'navBar.php';

					//contenido nuevo proyecto

					echo '<div class="container-fluid contenido">';


								
						echo    '<div class="alineador">
									<div class="centro">';

									if(isset($_GET['success'])){
										if($_GET['success'] != 'true')
											echo '<div class="alert alert-warning">
												  <strong>Error : Verifique la conexion a la base.</strong>
												  </div>';
										else
											echo '<div class="alert alert-success">
												  <strong> Exito al agregar nuevo Requerimiento!
												  </div>';
									}


							echo '<h1 class="text-center titulo"> Nuevo Requerimiento </h1>

										<div class="maomeno">
										<form method="post" action="newReq.php" >

											<p class="text-center">Nombre de Requerimiento</p>
											<input class="text-center" type="text" name="nombre" placeholder="Nombre" required> <br>

											<p class="text-center">Modulo</p>
											<input class="text-center" type="text" name="modulo" placeholder="Modulo" required> <br>

											<p class="text-center">Prioridad</p>
											<SELECT name="prioridad" class="btnfix">
												<option value="Baja">Baja</option>
												<option value="Media" selected>Media</option>
												<option value="Alta">Alta</option>
											</SELECT>

											<br>
											
											<p class="text-center">descripcion</p>
											<textarea name="desc">
											</textarea>

											<br>
											<p class="text-center">Actor</p>
											<input class="text-center" type="text" name="actor" placeholder="actor" required> <br>
											
											<p class="text-center">Precondicion</p>
											<input class="text-center" type="text" name="pre" placeholder="Pre" required> <br>
											
											<p class="text-center">Postcondicion</p>
											<input class="text-center" type="text" name="post" placeholder="Post" required>	
											<p class="text-center">Disparador/Trigger</p>
											<input class="text-center" type="text" name="trigger" placeholder="Trigger" required> <br>

											<br>
											<input type="submit" value="Cargar Requerimiento" class=" reqFix btn  btn-fix btn-warning" name="enviar"> <br>

										</form>

										</div>


									</div>
								</div>





							</div>
							'

							;
					if(isset($_GET['success']) && $_GET['success']==false){
						echo '<span>No se pudo insertar el requerimiento</span>';
					}
				}



		?>



</body>


</html>