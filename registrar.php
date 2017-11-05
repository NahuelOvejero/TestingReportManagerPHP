<?php



	if(isset($_POST['enviar']))
	{
		//verificar que el correo no este repetido


		require './dbManager/connectdb.php';

		$consulta= 'SELECT * FROM usuario where mail = "' . $_POST['mail'] . '"';
			
		if($result = $mysqli->query($consulta))	{
				if($result->num_rows > 0)
					 header('Location:registro.php?er=mail');			
				else{


					$clavePlana = $_POST['pass'];
					$correo = $_POST['mail'];
					$rol = $_POST['rol'];



					//ENCRYPT
					$salt = bin2hex(mcrypt_create_iv(32,MCRYPT_DEV_URANDOM));
					$clavesalt = $clavePlana.$salt;
					$claveHash = hash('sha256',$clavesalt);


					$command = "INSERT INTO usuario VALUES (0,'$correo',$rol,'$claveHash','$salt')";

					if($result = $mysqli->query($command)){

						include("./mailer/class.phpmailer.php");
						include("./mailer/class.smtp.php");

						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->SMTPAuth = true;
						$mail->SMTPSecure = "ssl";
						$mail->Host = "smtp.gmail.com";
						$mail->Port = 465;
						$mail->Username = "nahuelovejero@gmail.com";
						$mail->Password = "chipchip123"; 


						$mail->From = "nahuelovejero@gmail.com";
						$mail->FromName = "Testing-Tool";
						$mail->Subject = "Cuenta creada";
						$mail->AltBody = "Gracias por unirse a nuestra herramienta de Testing.";
						$mail->MsgHTML("Te agradecemos confiar en nosotros ," . $correo);
						//$mail->AddAttachment("files/files.zip");
						$mail->AddAddress( $correo , 'Usuario');
						$mail->IsHTML(true);

						if($mail->Send()){
							header('Location:logeo.php?correo=true');
						}
						else {
							header('Location:logeo.php?correo=false');
						} 
						
					}
					else{
						header('location:registro.php?registro=false');
					}


				}
			}
			else
			{
				echo 'Error: ' . $mysqli->error;
			}









	}
	else
	{
		header('Location:registro.php');
	}


?>