<?php

session_start();	


if(isset($_SESSION['developer']))
	if($_SESSION['developer']!='analista') header('Location:inicio.php?auth=false');



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



					echo '<div class="container-fluid contenido">';
					
					if(isset($_GET['success'])){
						if($_GET['success'] != 'true')
							echo '<div class="alert alert-warning">
								  <strong>Error : Verifique la conexion a la base.</strong>
								  </div>';
						else
							echo '<div class="alert alert-success">
								  <strong> Se asigno con exito el requerimiento.
								  </div>';
					}



					echo '<h1 class="text-center titulo">Mis Pruebas Asignadas:</h1>
							  <div class="alineador">
							 <div class="centro">
                                        <div class="maomeno">';
                                        
                    //REQUERIMIENTOS YA CARGADO

                    require './dbManager/connectdb.php';

                    $consulta = 'SELECT * FROM prueba WHERE IdUser = ' . $_SESSION['id'];


                    if($result = $mysqli->query($consulta))
                    {

                        
                        

                        echo '<table class="table">';
                        echo '<tr><th>Nombre</th>
                        <th>Entrada</th>
                        <th>Esperado</th>
                        <th>Resultado</th>
						<th>Ultimo Test</th>
						<th>Tipo</th>
						<th>Prueba</th><tr>
						';

                        while($obj = $result->fetch_object()){

							
                            

                            echo 
                            
                            '<tr>
                            <td>'. $obj->nombre .' </td>
                            <td>'. $obj->entrada .' </td>
                            <td>'. $obj->esperado .' </td>
                            <td>'. $obj->resultado .' </td>
                            <td>'. $obj->ultimotest .' </td>
                            <td>'. $obj->tipo .' </td>
                            <td><a href="doPrueba.php?req='. $obj->nombre .'" ><button type="button" class="btn btn-warning">Ejecutar</button> </a></td>
							</tr>                            
                            ';


                        }

                        echo '</table>';

                    }
                    else
                    {
                        $mysqli->error;
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