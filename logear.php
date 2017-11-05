<?php

session_start();	

	if(isset($_POST['enviar']))
	{
		//Iniciar proceso de logeo, verificar en BD.

		require './dbManager/connectdb.php';


		$consulta='SELECT * FROM usuario where mail = "'. $_POST['user'] .'"';
		if($result = $mysqli->query($consulta)){
			

			if($obj = $result->fetch_object()){

				$clavePlana = $_POST['pass'];
				$claveSalt = $clavePlana . $obj->salt;
				$claveHash = hash('sha256',$claveSalt);




				if($claveHash == $obj->pass)
				{
						//crear sesion, nombre de usuario, redireccionar.
					$rol;

					switch ($obj->IdRol){
						case 1 :
								$rol = 'lider'; break;
						case 2:
								$rol = 'requerimiento'; break;
						case 3:
								$rol = 'analista'; break;
						case 4:
								$rol = 'developer'; break;

							}

					$_SESSION['rol'] = $rol;
					$_SESSION['mail']  = $obj->mail;
					$_SESSION['id'] = $obj->IdUser;

					header('Location:inicio.php?inicio=ok');

				}
				else
				{
					header('Location:logeo.php?error=log');
				}

			}
			else
				header('Location:logeo.php?error=log');
		}
		else{

					header('Location:logeo.php?error=user');
		}
		
	}
	else
	{

		//Si no se llego a traves de un form, redirigir
		header('Location:logeo.php');
	}

?>