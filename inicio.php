<?php

session_start();	

?>

<html>
<head>
<title>Bienvenido - Testing Tool</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="estilos/bootstrap.css">
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

			if(isset($_SESSION['rol']))
				include 'navBar.php';
				
				if(isset($_GET['new']))
					echo '<div class="container-fluid contenido">
					<h1 class="text-center titulo"> Proyecto Creado Exitosamente </h1>
					
						<div class="alineador">
							<div class="centro">';

							if(isset($_GET['auth'])){
								echo '<h1 class="text-center titulo"> No posee permisos para acceder a esa area </h1>';
							}

					echo'
							</div>
						</div>
					</div>';

		?>



</body>


</html>