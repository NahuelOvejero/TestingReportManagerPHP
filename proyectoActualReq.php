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
				

					echo '<div class="container-fluid contenido">';

							// OPERACION DB

					require './dbManager/connectdb.php';

					$IdProyectoAcutal = 0;
					$version = 1;

					/////// DATOS DEL PROYECTO

					$consulta= 'SELECT * FROM proyecto order by IdProyecto desc';
			
					if($result = $mysqli->query($consulta))	{

						  if ($obj = $result->fetch_object()) {


       							echo '<h1 class="text-center titulo"> Proyecto Actual : '. $obj->nombre .' </h1>';

       							$IdProyectoAcutal = $obj->IdProyecto;

    						}						



						$result->close();

						$consulta= 'SELECT * FROM asignacion where IdUser ='.$_SESSION['id'].' IdProyecto = ' . $IdProyectoAcutal;			

						if($result = $mysqli->query($consulta)){
							if($mysqli->affected_rows <1 )
								header('Location:inicio.php?auth=false');							
						}			

					}



					/////// GENTE ASIGNADA AL PROYECTO


					$consulta= 'SELECT * FROM requerimientos WHERE IdProyecto = ' . $IdProyectoAcutal ;
			

					if($result = $mysqli->query($consulta))	{

						/// DIV IZQUIERDO
						echo '<div class="izq">';

    						echo '<h3 class="text-center titulo">Requerimientos Totales Del Proyecto: '. $mysqli->affected_rows .' </h3>';
    						echo '<a href="agregarRequerimiento.php">	<button class="btn btn-warning btnfix"> Agregar Requerimiento </button> </a>';

    					echo '</div>';




    					/// DIV DERECHO

    					echo '<div class="der">';

						echo '<h3 class="text-center titulo"> Trabajadores : </h3> <ul class="list-group">';
						
						while ($req = $result->fetch_object()) {
									
									echo '<li class="list-group-item text-center">'. $req->nombre . ' - ( '. strtoupper($req->modulo) . ' )

									<a href="requerimientodatos.php?id='. $req->nombre.'" ><button type="button" class="btn btn-warning">Datos</button> </a>  </li>';

							}	

							echo '</ul>';

    					echo '</div>';

					

							// FIN OPERACION DB

					echo '</div>
					</div>';
						}

		?>



</body>


</html>