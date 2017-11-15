<?php

session_start();	


if(isset($_SESSION['rol']))
	if($_SESSION['rol']!='lider') header('Location:inicio.php?auth=false');

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

						if(isset($_GET['error']))
							echo
								'<h1 class="text-center titulo"> Error al crear Proyecto, Intente nuevamente </h1>';
						else{
							echo
								'<h1 class="text-center titulo"> Nuevo Proyecto </h1>';
						}
								
						echo    '<div class="alineador">
									<div class="centro">

										<form method="post" action="newProyect.php" >
											<p class="text-center">Nombre de Proyecto</p>
											<input class="text-center" type="text" name="nombre" placeholder="Nombre de Proyecto" required> <br>

											<p class="text-center">Empresa Solicitante</p>
											<input class="text-center" value="Sin Empresa" type="text" name="empresa" placeholder="Empresa" required> <br>

											<p class="text-center">Descripcion del proyecto</p>
											<textarea name="descripcion" required></textarea>

											<br>

											<p class="text-center">Fecha de Entrega</p>
											<input class="text-center" type="date" name="entrega" required> <br>

											<br>

											<br>
											<input type="submit" value="Empezar Proyecto" class="btn btn-warning" name="enviar"> <br>

										</form>


									</div>
								</div>





							</div>
							'

							;
				}



		?>



</body>


</html>