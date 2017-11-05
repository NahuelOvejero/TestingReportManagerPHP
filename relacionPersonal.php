<?php

session_start();	

if(isset($_SESSION['rol']))
	if($_SESSION['rol']!='lider') header('Location:inicio.php?auth=false');

		
	if(isset($_POST['enviar']))
	{
		//Iniciar proceso de logeo, verificar en BD.

		require './dbManager/connectdb.php';

		$IdProyectoAcutal = 0;
		
		$consulta= 'SELECT * FROM proyecto order by IdProyecto desc';

			if($result = $mysqli->query($consulta))	{
				  if ($obj = $result->fetch_object()) {
							$IdProyectoAcutal = $obj->IdProyecto;
					}						
				$result->close();
			}


		$mysqli->autocommit(false);

		if(isset($_POST['personal'])) {

				$inicio = date('y-m-d');

		    foreach($_POST['personal'] as $check) {
		       	$mysqli->query('INSERT INTO asignacion VALUES ('. $IdProyectoAcutal . ',' .$check. ',"' . $inicio .'")');
		    }
		}

		


		if($mysqli->commit())
		{
			header('Location:proyectoActual.php?status=ok');
		}
		else
		{
			header('Location:proyectoActual.php?status=error');
		}

	}

	else
	{
		header('Location:proyectoActual.php');
	}



?>