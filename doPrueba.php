<?php

session_start();	


if(isset($_SESSION['developer']))
	if($_SESSION['developer']!='analista') header('Location:inicio.php?auth=false');


if(isset($_POST['enviar'])){

    
    require './dbManager/connectdb.php';

    $hoy =  date('y-m-d');
    if($_POST['resultado'] == $_POST['esperado'])
     $consulta = "UPDATE prueba SET observaciones = '".
                 $_POST['observaciones'] ."', resultado = '" . $_POST['resultado'] . "',ultimotest='".$hoy."',
                 estado = 'Aprobado'
                 WHERE nombre ='" . $_GET['req'] . "'";
    else 
        header('Location:defecto.php?req='. $_GET['req'] );
        //REDIRIGIR A DEFECTUOSO

    if($mysqli->query($consulta)){
        header('Location:mispruebas.php?result=true');
    }
    else{
        echo $mysqli->error;
    }
                 

}


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

                    
                    require './dbManager/connectdb.php';

                    $consulta = "SELECT * FROM prueba WHERE nombre = '" . $_GET['req']. "'";

                    if($result = $mysqli->query($consulta)){
                        
                        if($obj = $result->fetch_object()){

                            echo '<div class="alineador">
                            <div class="centro">
                            
                            <form action="doPrueba.php?req='. $_GET['req']  .'" method="post">';


                            
                                                                        
                    



                            echo '                                
                                <p class="text-center">Entrada:</p>
                            
                                <input type="text" value="'. $obj->entrada .'" readonly>

                                <p class="text-center">Resultado Esperado:</p>
                                
                                <input type="text" name="esperado" value="'. $obj->esperado .'" readonly>

                                <p class="text-center">Resultado Obtenido:</p>                               
                                
                                <input type="text" name="resultado">

                                <p class="text-center">Observaciones:</p>                               
                                
                                <input type="text" name="observaciones"> <br> <br>

                                <input type="submit" value="Ejecutar" class="btn btn-warning" name="enviar"> <br>
                                
                                                
                                </form>';


                        }
                        else{
                            echo $mysqli->error;
                        }


                }
                  
                    

                else{
                    echo $mysqli->error;
                }


					echo '					</div>


									</div>
								</div>





							</div>
							'

							;

					}
                



		?>



</body>


</html>