<?php

session_start();	


if(isset($_SESSION['rol']))
    if($_SESSION['rol']!='lider') header('Location:inicio.php?auth=false');
    

    if(isset($_POST['enviar'])){

        require './dbManager/connectdb.php';


        $IdProyectoAcutal = 0;                   
        
                            $cons= 'SELECT * from version WHERE IdProyecto = (SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1) order by version desc ';
                    
                            if($result = $mysqli->query($cons))	{
        
                                    if ($ob = $result->fetch_object()) {
                                        $IdProyectoAcutal = $ob->IdProyecto;
                                    }
                                }
                 
        $hoy = date('y-m-d');
        $insercion = "UPDATE VERSION SET fecha = '".$hoy."',version=".$_POST['version'].",subversion=".$_POST['subversion'];
	
		if($res = $mysqli->query($insercion)){
            header('Location:proyectoActual.php');
		}
		else{			
           header('Location:newRelease.php?error=true');
		}


    }

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
                    require './dbManager/connectdb.php';
                    
                    


                    echo '<div class="container-fluid contenido">
                    <h1 class="text-center titulo"> Nuevo Release </h1>';

                    $IdProyectoAcutal = 0;                   
                    
                                        $consulta= 'SELECT * from version WHERE IdProyecto = (SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1) order by version desc ';
                                
                                        if($result = $mysqli->query($consulta))	{
                    
                                                if ($obj = $result->fetch_object()) {
                    echo  '<h1 class="text-center titulo"> Version Actual: '. $obj->version .'.'. $obj->subversion .' </h1>';
                                                }
                                            }
                       

								
						echo    '<div class="alineador">
                                    <div class="centro">';
                                    
                                    if(isset($_GET['error']))                                      
                                            echo '<div class="alert alert-warning">
                                                  <strong>Error : Verifique la conexion a la base.</strong>
                                                  </div>';

							echo '<form method="post" action="newRelease.php" >
											<p class="text-center">Nueva Version</p>
                                            <input class="text-center" type="number" name="version" required > <br>

                                            <p class="text-center">Nueva Sub-Version</p>
                                            <input class="text-center" type="number" name="subversion" required > <br>';

											echo '<br>
											<input type="submit" value="Release" class="btn btn-warning" name="enviar"> <br>

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