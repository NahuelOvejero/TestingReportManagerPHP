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

					/////// DATOS DEL PROYECTO

					$consulta= 'SELECT * FROM proyecto order by IdProyecto desc';
			
					if($result = $mysqli->query($consulta))	{

						  if ($obj = $result->fetch_object()) {



						  	if(isset($_GET['status'])){
						  		if($_GET['status'] != 'ok')
						  			echo '<div class="alert alert-warning">
											<strong>Error : Verifique la conexion a la base.</strong>
											</div>';
						  		else
						  			echo '<div class="alert alert-success">
											<strong	>Exito al asignar empleados al proyecto!
											</div>';
						  	}

       							echo '<h1 class="text-center titulo"> Proyecto Actual : '. $obj->nombre .' </h1>';
       							$fechaFormat = date('d-m-y',strtotime($obj->entrega));
       							echo '<h1 class="text-center titulo"> Deadline : '. $fechaFormat .' </h1>';
       							$IdProyectoAcutal = $obj->IdProyecto;

    						}		

						$result->close();
					}



					/////// GENTE ASIGNADA AL PROYECTO


					$consulta= 'SELECT * FROM asignacion a JOIN usuario u on a.IdUser = u.IdUser WHERE IdProyecto = ' . $IdProyectoAcutal ;
			

					if($result = $mysqli->query($consulta))	{

						/// DIV IZQUIERDO
						echo '<div class="izq">';


    						echo '<h3 class="text-center titulo">Personal Asignado al Proyecto: '. $mysqli->affected_rows .' </h3>';
    						echo '<a href="agregarPersonal.php">	<button class="btn btn-warning btnfix"> Agregar Personal </button> </a>';

    					echo '</div>';




    					/// DIV DERECHO

    					echo '<div class="der">';

       						echo '<h3 class="text-center titulo"> Trabajadores : </h3> <ul class="list-group">';


						  while ($obj = $result->fetch_object()) {

						  		$rol = 'Sin Definir';

						  		switch ($obj->IdRol){
											case 1 :
													$rol = 'lider'; break;
											case 2:
													$rol = 'requerimiento'; break;
											case 3:
													$rol = 'analista'; break;
											case 4:
													$rol = 'developer'; break;

												}
       							
       							echo '<li class="list-group-item text-center">'. $obj->mail . ' - ( '. strtoupper($rol) . ' )

       							<a href="desvincular.php?id='. $obj->IdUser.'" ><button type="button" class="btn btn-warning">Quitar</button> </a>  </li>';

    						}	

    						echo '</ul>';

    					echo '</div>';

					}





							// FIN OPERACION DB

					echo '</div>
					</div>';

		?>



</body>


</html>