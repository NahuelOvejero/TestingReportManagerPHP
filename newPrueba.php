<?php

session_start();	


if(isset($_SESSION['rol']))
    if($_SESSION['rol']!='analista') header('Location:inicio.php?auth=false');
    

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

		
		$consulta = "INSERT INTO prueba 
		VALUES( '" .$_POST['nombre'] ."' , '". $_POST['developer'] ."' , '". $_POST['entrada']." '
		, '" . $_POST['esperado'] . "' , '" . $_POST['tipo'] . "' ,NULL,NULL,NULL,'Sin Probar',".$IdReq.",'".$_POST['precondicion']."','".$_POST['postcondicion']."','".$_POST['fin']."')";

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

					//contenido nueva Prueba

                    echo '<div class="container-fluid contenido">
                    <h1 class="text-center titulo"> Nueva Prueba Para ' . $_GET['req']. ' </h1>';
								
						echo    '<div class="alineador">
									<div class="centro">

										<form method="post" action="newPrueba.php?req='.$_GET['req'].'" >
											<p class="text-center">Nombre de la Prueba</p>
											<input class="text-center" type="text" name="nombre" placeholder="Nombre de Prueba" required> <br>

											<p class="text-center">Tipo de Prueba</p>
											<select style="width: 155px;" name ="tipo">
												<option value="manual">Manual</option>
												<option value="automatico">Automatico</option>
												<option value="semi-automatico">Semi-automatico</option>
											</select>
											<br>
											<p class="text-center">Entrada</p>
                                            <textarea name="entrada" style="width: 155px;resize: none;" required> </textarea>                                           
											<br>
											
											<p class="text-center">Salida Esperada</p>
                                            <textarea name="esperado" style="width: 155px;resize: none;" required> </textarea> 
                                            
                                            
                                            <p class="text-center">Precondicion</p>
                                            <textarea name="precondicion" style="width: 155px;resize: none;" required> </textarea> 
                                            
											<br>

											<p class="text-center">Postcondicion</p>
                                            <textarea name="postcondicion" style="width: 155px;resize: none;" required> </textarea> 
											
											
											<br>

											<p class="text-center">Fecha de Fin</p>
                                            <input type="date" name="fin" required> <br>
											
											<br>';

											require './dbManager/connectdb.php';
											$consulta = "SELECT * FROM usuario WHERE IdRol = 4 ";

											echo '<p class="text-center">Developer Encargado</p>
												<select style="width: 155px;" name="developer">';

											if($result = $mysqli->query($consulta)){

												while($obj = $result->fetch_object()){
													echo '<OPTION value='.$obj->IdUser.'>'.$obj->mail.'</OPTION>';
												}

												echo '</select> <br>';

											}
											else{
												die ('No se pudo contactar con los analistas de la BD');
											}




											echo '<br>
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