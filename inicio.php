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
			else{
				header('Location:logeo.php');
			}

			if(isset($_GET['requerimiento']))
				if($_GET['requerimiento'] == 'true')
					echo '<div class="container-fluid contenido">
					<h1 class="text-center titulo">Caso Prueba Creado exitosamente </h1>';
				else
				echo '<div class="container-fluid contenido">
				<h1 class="text-center titulo">Ocurrio un error creando el caso de prueba </h1>';


				

				
				if(isset($_GET['new']))
					echo '<div class="container-fluid contenido">
					<h1 class="text-center titulo"> Proyecto Creado Exitosamente </h1>
					
						<div class="alineador">
							<div class="centro">';

							if(isset($_GET['auth'])){
								echo '<h1 class="text-center titulo"> No posee permisos para acceder a esa area </h1>';
							}

							if($_SESSION['rol'] == 'lider'){

								require './dbManager/connectdb.php';

								echo '<h1 class="text-center titulo"> Reportes: </h1>';

							
								
								$r = $mysqli->query('SELECT COUNT(*) as "total" FROM requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1)');
								$obj = $r->fetch_object(); 

								echo '<h3 class="text-center"> Requerimientos del Proyecto : '.$obj->total.' </h3>';
								$req_totales = $obj->total;

								$r = $mysqli->query("SELECT COUNT(*) as total FROM requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1) AND estado = 'Exitoso'");
								$obj = $r->fetch_object(); 

								$req_exitosos = $obj->total;

								echo '
								<h3 class="text-center"> Requerimientos Exitosos : '. $obj->total . ' </h3>
								<h3 class="text-center"> Requerimientos Fallidos : '. ($req_totales - $req_exitosos) .' </h3>';



								
								$r = $mysqli->query("SELECT COUNT(*) as total FROM prueba where IdReq IN 
									(SELECT IdReq from requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1))");
								$obj = $r->fetch_object();
								
								echo '
								<h3 class="text-center"> Pruebas del Proyecto : '.$obj->total.' </h3>';

								$r = $mysqli->query("SELECT COUNT(*) as total FROM prueba where IdReq IN 
								(SELECT IdReq from requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1))
								AND estado ='Exitoso'");
							$obj = $r->fetch_object();

							echo '<h3 class="text-center"> Pruebas Exitosas : '. $obj->total .' </h3>';

							$r = $mysqli->query("SELECT COUNT(*) as total FROM prueba where IdReq IN 
							(SELECT IdReq from requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1))
							AND estado ='Fallido'");
						$obj = $r->fetch_object();

							echo '<h3 class="text-center"> Pruebas Fallidos : '.$obj->total.' </h3>';

							$r = $mysqli->query("SELECT COUNT(*) as total FROM prueba where IdReq IN 
							(SELECT IdReq from requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1))
							AND estado ='Pausado'");
						$obj = $r->fetch_object();


						echo '
								<h3 class="text-center"> Pruebas Pausadas : '.$obj->total.' </h3>';

								$r = $mysqli->query("SELECT COUNT(*) as total FROM prueba where IdReq IN 
								(SELECT IdReq from requerimientos where IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1))
								AND estado ='Incompleto'");
							$obj = $r->fetch_object();

								echo '
								<h3 class="text-center"> Pruebas Incompletas : '. $obj->total.' </h3>';

								
								$r = $mysqli->query("SELECT entrega FROM proyecto WHERE IdProyecto = (SELECT IdProyecto from proyecto order by IdProyecto desc LIMIT 1)");
								$obj = $r->fetch_object();


								$now = time(); 
								if(isset($obj->entrega)){
									$limite = strtotime($obj->entrega);
								}
								else{
									$limite = time();
								}
								

								$dias_diff = ceil(($limite - $now) / 86400) + 1;
								

							echo 	'<h2 class="text-center"> Dias restantes para que finalice le proyecto: </h2> 
								<h1 class="text-center"> '. $dias_diff .'<br>';

							}



							if($_SESSION['rol']=='requerimiento'){
								require './dbManager/connectdb.php';
								echo '<h1 class="text-center titulo"> Mis Requerimientos Creados: </h1>';

								$consulta= 'SELECT * FROM requerimientos WHERE IdProyecto = 
								(SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1)
								AND IdUser ='. $_SESSION['id'];
								
								echo '<h3 class="text-center titulo"> Requerimientos : </h3> 					
								<ul>';
								if($result = $mysqli->query($consulta))
								while ($req = $result->fetch_object()) {
										echo '<li class="text-center">'. $req->nombre . ' - ( '. strtoupper($req->modulo) . ' )

										<a href="requerimientodatos.php?req='. $req->nombre.'" ><button type="button" class="btn btn-warning">Datos</button> </a>  </li> <br>';

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