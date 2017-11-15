<?php

session_start();	


if(isset($_POST['enviar'])){

    require './dbManager/connectdb.php';

    
    $consulta='SELECT * FROM usuario where IdUser = "'. $_SESSION['id'] .'"';

    if($result = $mysqli->query($consulta)){


        if($obj = $result->fetch_object()){

            $clavePlana = $_POST['pass'];
            $claveSalt = $clavePlana . $obj->salt;
            $claveHash = hash('sha256',$claveSalt);    

            if($claveHash == $obj->pass)
            {                                   
            

                if($_POST['new1'] == $_POST['new2']){

                    $saltn = bin2hex(mcrypt_create_iv(32,MCRYPT_DEV_URANDOM));
                    $clavePlanan = $_POST['new1'];
					$clavesaltn = $clavePlanan.$saltn;
                    $claveHashn = hash('sha256',$clavesaltn);      
                    

                    $cambio = "UPDATE usuario SET pass ='" .$claveHashn. "', salt='" .$saltn. "' 
                                WHERE IdUser = " . $_SESSION['id'] ;

                    if($mysqli->query($cambio)){
                      header('Location:miperfil.php?s=true');
                    }
                    else{
                      header('Location:miperfil.php?s=false');
                    }
                }

            }
            else{
               header('Location:miperfil.php?s=dif');
              }
     
        }
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
                }
                
                echo '<div class="container-fluid contenido">';		
                
                        if(isset($_GET['s']))
                            if($_GET['s']=='true')
                                echo
                                    '<h1 class="text-center titulo" style="color:red;"> Perfil Actualizado Correctamente </h1>';
                            else if ($_GET['s']=='dif')
                                  echo'<h1 class="text-center titulo">Las contraseñas ingresadas no coinciden o su contraseña fue incorrecta</h1>';
                            else
                                 echo'<h1 class="text-center titulo"> Verifique la contraseña ingresada </h1>';
                
                                                
                    require './dbManager/connectdb.php';

                    $cons = "SELECT * FROM USUARIO WHERE IdUser = " . $_SESSION['id'];

                    if($res = $mysqli->query($cons)){
                        
                        if($objx = $res->fetch_object()){                           

                            $rol = 'Sin asignar';
                            
                            switch ($objx->IdRol){
                                case 1 :
                                        $rol = 'lider'; break;
                                case 2:
                                        $rol = 'requerimiento'; break;
                                case 3:
                                        $rol = 'analista'; break;
                                case 4:
                                        $rol = 'developer'; break;

                                    }

                            echo'<h1 class="text-center titulo"> Mi Perfil: '.$objx->mail . '</h1>';
                            echo'<h1 class="text-center titulo">Mi Rol: '. $rol . '</h1>';

                            echo '<br>';
                            echo '<br>';
                            echo'<h1 class="text-center titulo"> Cambio de clave </h1>';
                            

                            echo '<form method="post" action="miperfil.php">

                            <p class="text-center">Clave Actual</p>
                            <input class="text-center" style="margin-left:500px" type="password" name="pass" placeholder="Antigua" required> <br>
                            <p class="text-center">Nueva Clave</p>
                            <input class="text-center"style="margin-left:500px" type="password" name="new1" placeholder="Nueva" required> <br>
                            <p class="text-center">Ingrese la nueva Clave</p>
                            <input class="text-center" style="margin-left:500px" type="password" name="new2" placeholder="Verifique" required> <br>

                                    <br><br>
                            <input type="submit" name="enviar" style="margin-left:530px" value="Cambiar Clave" class="btn btn-warning">
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
                            ';
            
?>



</body>


</html>