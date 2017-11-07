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



					echo '<div class="container-fluid contenido">

							 <h1 class="text-center titulo"> Requerimientos Actuales </h1>
							  <div class="alineador">
							 <div class="centro">
                                        <div class="maomeno">';
                                        
                    //REQUERIMIENTOS YA CARGADO

                    require './dbManager/connectdb.php';

                    $consulta = 'SELECT * FROM `requerimientos` WHERE version = (SELECT version FROM version WHERE IdProyecto = (SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1))';

                    if($result = $mysqli->query($consulta))
                    {

                        if($mysqli->affected_rows == 0) {

                            echo 'No hay requerimientos actuales para este proyecto.';

                        }

                        echo '<table class="table">';
                        echo '<th>Nombre</th>
                        <th>Modulo</th>
                        <th>Fecha</th>
                        <th>Prioridad</th>
						<th>Estado</th>
						<th>Detalle</th>
						';

                        while($obj = $result->fetch_object()){

                            //VERIFICAR FILA , ACOMODAR, MOSTRAR COLOR SEGUN ESTADO

							if($obj->estado == 'Incompleto')							
								echo '<tr class="bg-danger">';
							if($obj->estado == 'Exitoso')							
								echo '<tr class="bg-info">';
							if($obj->estado == 'Defectuoso')
								echo '<tr class="bg-warning">';
							

							echo "
                            <td> $obj->nombre</td>
                            <td> $obj->modulo</td>
                            <td> $obj->fecha</td>
                            <td> $obj->prioridad</td>
							<td> $obj->estado</td>
							<td>" . '<a href="requerimientodatos.php?req='. $obj->nombre.'" ><button type="button" class="btn">Datos</button> </a></td>
                            </tr>                            
                            ';


                        }

                        echo '</table>';

                    }
                    else
                    {

                       echo ' <h1 class="text-center titulo"> Error al conectar con la Base de Datos. </h1>';

                    }

					echo '					</div>


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