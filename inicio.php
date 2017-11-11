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



							if($_SESSION['rol']=='requerimiento'){
								require './dbManager/connectdb.php';
								echo '<h1 class="text-center titulo"> Mis Requerimientos Creados: </h1>';

								$consulta= 'SELECT * FROM requerimientos WHERE IdProyecto = 
								(SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1)
								AND IdUser ='. $_SESSION['id'];
								
								echo '<h3 class="text-center titulo"> Requerimientos : </h3> <ul class="list-group">';
								if($result = $mysqli->query($consulta))
								while ($req = $result->fetch_object()) {
										echo '<li class="list-group-item text-center">'. $req->nombre . ' - ( '. strtoupper($req->modulo) . ' )

										<a href="requerimientodatos.php?req='. $req->nombre.'" ><button type="button" class="btn btn-warning">Datos</button> </a>  </li>';

								}	

								echo '</ul>';

							}


					echo'
							</div>
						</div>
					</div>';

		?>



</body>


</html>