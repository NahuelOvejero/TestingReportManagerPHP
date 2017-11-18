<?php

session_start();	


if(isset($_SESSION['rol']))
    if($_SESSION['rol']!='analista') header('Location:inicio.php?auth=false');
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

				//nav menu

				if(isset($_SESSION['rol'])){

					include 'navBar.php';


                    echo '<div class="container-fluid contenido">
                    <h1 class="text-center titulo"> Pruebas de:  ' . $_GET['req']. ' </h1>';
								
						echo    '<div class="alineador">
									<div class="centro">';

										

                                            require './dbManager/connectdb.php';
                                            

											$consulta = "SELECT * FROM prueba where IdReq =
												(SELECT IdReq FROM requerimientos 
													WHERE nombre = '". $_GET['req'] ."' )";

										

											if($result = $mysqli->query($consulta)){
                                                                                                    
                                                echo '<table class="table">
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>entrada</th>
                                                        <th>esperado</th>                                               
														<th>estado</th>
														<th>tipo</th>
                                                        <th>observaciones</th>
                                                        <th>ultimo test </th>
														<th>estado</th>
														<th>fecha limite</th>
                                                    </tr>
                                                    ';
                                                
												while($obj = $result->fetch_object()){	

                                                    echo '<td>'. $obj->nombre .'</td>'.
                                                        '<td>'. $obj->entrada .'</td>'.
														'<td>'. $obj->esperado .'</td>'.
														'<td>'. $obj->estado .'</td>'. 
                                                        '<td>'. $obj->tipo. '</td>'.
														'<td>'. $obj->observaciones. '</td>'. 
														'<td>'. $obj->ultimotest .'</td>'.
														'<td>'. $obj->estado. '</td>'.
														'<td>'. $obj->fin .'</td>'.  
														'</tr>';
                                                    
                                                }
                                                echo '</table>';
                                                
											}
                                            else
                                            {
												echo $mysqli->error;
                                            }
                                            
                                    echo '</div>
								</div>
							</div>
							'

							;
				}



		?>



</body>


</html>