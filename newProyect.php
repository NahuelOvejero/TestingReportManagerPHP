<?php


session_start();	
	
	if(isset($_POST['enviar']))
	{
		require './dbManager/connectdb.php';

		$nombre = $_POST['nombre'];
		$empresa = $_POST['empresa'];
		$desc = $_POST['descripcion'];
		$entrega = $_POST['entrega'];
		$inicio = date('y-m-d'); //CAMBIO y por Y




		$consulta = "INSERT INTO proyecto (nombre,empresa,descripcion,entrega,inicio) 
					VALUES ('$nombre' , '$empresa' , '$desc' , '$entrega' , '$inicio' )";


		if($mysqli->query($consulta))
		{


			$consulta = "INSERT INTO version VALUES(". $mysqli->insert_id . ",'$inicio','Activo',1,0)";
			$mysqli->autocommit(true);
				if($mysqli->query($consulta))
					header('Location:nuevoProyecto.php?new=true');
				else
					echo $mysqli->insert_id . '<br>' . $mysqli->error;
		}
		else
		{
			echo $mysqli->error;
			header('Location:nuevoProyecto.php?error=true');
		}


	}
	else
	{
		header('Location:registro.php?result=false');
	}

?>