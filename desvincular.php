<?php

session_start();	

if(isset($_SESSION['rol']))
	if($_SESSION['rol']!='lider') header('Location:inicio.php?auth=false');

	
	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{	
			require './dbManager/connectdb.php';

			$mysqli->query('DELETE FROM asignacion WHERE IdUser =' . $_GET['id']);
			header('Location:proyectoActual.php');
		}

		else
		{
			header('Location:proyectoActual.php');
		}			

	}

	else
	{
		header('Location:proyectoActual.php');
	}

?>