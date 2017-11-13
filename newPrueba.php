<?php

session_start();	


if(isset($_SESSION['rol']))
    if($_SESSION['rol']!='analista') header('Location:inicio.php?auth=false');
    

    if(isset($_POST['enviar'])){
        //CARGAR PRUEBA
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
                    <h1 class="text-center titulo"> Nueva Prueba Para ' . $_GET['req']. ' </h1>';
								
						echo    '<div class="alineador">
									<div class="centro">

										<form method="post" action="newProyect.php?req='.$_GET['req'].'" >
											<p class="text-center">Nombre de la Prueba</p>
											<input class="text-center" type="text" name="nombre" placeholder="Nombre de Prueba" required> <br>

											<p class="text-center">Tipo de Prueba</p>
											<input class="text-center"  type="text" name="tipo" placeholder="Tipo" required> <br>

											<p class="text-center">Entrada</p>
                                            <input class="text-center"  type="text" name="entrada" placeholder="Entrada" required> <br>
                                            
                                            <br>
                                            
                                            <p class="text-center">Salida Esperada</p>
                                            <input class="text-center" type="text" name="salida" placeholder="Salida" required> <br>
                                            
											<br>

											<br>
											<input type="submit" value="Generar Nueva Prueba" class="btn btn-warning" name="enviar"> <br>

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