<?php

session_start();	


if(isset($_SESSION['rol']))
    if($_SESSION['rol']!='developer') header('Location:inicio.php?auth=false');
    

    if(isset($_POST['enviar'])){

        require './dbManager/connectdb.php';	
        	
		$getreq = "SELECT * FROM requerimientos WHERE nombre = '" .  $_GET['req'] . "'";

		$IdReq = 0;

		if($res = $mysqli->query($getreq)){
			if($objetoId = $res->fetch_object()){
				$IdReq = $objetoId->IdReq;
			}
			else{
				echo $mysqli->error;
			}
        }
        		
		$consulta = "INSERT INTO defecto 
		VALUES( '" .$_POST['nombre'] ."' , '". $_POST['developer'] ."' , '". $_POST['entrada']." '
		, '" . $_POST['esperado'] . "' , '" . $_POST['tipo'] . "' ,NULL,NULL,NULL,'Sin Probar',".$IdReq.")";

		if($res = $mysqli->query($consulta)){
			header('Location:inicio.php?requerimiento=true');
		}
		else{
			header('Location:inicio.php?requerimiento=false');
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

					//contenido nuevo proyecto

                    echo '<div class="container-fluid contenido">
                    <h1 class="text-center titulo"> Nueva Defecto De ' . $_GET['req']. ' </h1>';
								
						echo    '<div class="alineador">
									<div class="centro">

										<form method="post" enctype="multipart/form-data" action="defecto.php?req='.$_GET['req'].'" >
											<p class="text-center">Descripcion Del Defecto</p>
                                            <textarea style="width: 308px; class="text-center" type="text" name="descripcion" placeholder="Descripcion" required> </textarea><br>
                                            
                                            <p class="text-center">Adjunto</p> <br>
                                            <input type="file" image name="adjunto" id="adjunto">
                                            
                                            <br>

                                            <br>

											<input type="submit" value="Cargar Nuevo Defecto" class="btn btn-warning" name="enviar"> <br>

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