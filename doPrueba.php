<?php

session_start();	


if(isset($_SESSION['developer']))
	if($_SESSION['developer']!='analista') header('Location:inicio.php?auth=false');


if(isset($_POST['enviar'])){

    
    require './dbManager/connectdb.php';

    $hoy =  date('y-m-d');
    if(isset($_POST['resultado'])){
     $consulta = "UPDATE prueba SET observaciones = '".
                 $_POST['observaciones'] ."', estado = '" . $_POST['resultado'] . "',ultimotest='".$hoy."' 
                  WHERE nombre ='" . $_GET['req'] . "'";
                 
            if($mysqli->query($consulta)){

                echo $consulta;

                if($_POST['defectuoso'] == 'true'){
                    if(isset($_POST['enviar'])){
                            
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
                                        
                                $versionActual = 1;
                                $v = $mysqli->query('SELECT version FROM version  ORDER BY IdProyecto DESC LIMIT 1');
                                $objv = $v->fetch_object();
                                $versionActual = $objv->version;                                

                                $consultaDef = "INSERT INTO defecto 
                                VALUES( '" .$_POST['nombre'] ."' , '". $_POST['descripcion'] ."' , 'NULL'
                                ,". $versionActual  .");";

                        
                                if($res = $mysqli->query($consultaDef)){
                                    header('Location:inicio.php?requerimiento=true');
                                }
                                else{
                                    header('Location:inicio.php?requerimiento=false');
                                }
                        
                        
                            }
                 }


                header('Location:mispruebas.php?result=true');                
            }
            else{
                echo $mysqli->error;
            }
        }
}


?>

<html>
<head>


<script>
	function defecto(){
		var selectBox = document.getElementById("estado");
        var miDiv = document.getElementById("divDefecto");
        var miDef = document.getElementById("defectuoso");
        if(selectBox.value != 'Exitoso'){
       
            miDiv.style.display = 'block';           // Hide
            miDef.value = 'true';            

        }
        else{
            miDiv.style.display = 'none';          // Show
            miDef.value = 'false';   
        }

		
	}
</script>



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



					echo '<div class="container-fluid contenido">';				

                    
                    require './dbManager/connectdb.php';

                    $consulta = "SELECT * FROM prueba WHERE nombre = '" . $_GET['req']. "'";

                    if($result = $mysqli->query($consulta)){
                        
                        if($obj = $result->fetch_object()){

                            echo '<div class="alineador">
                            <div class="centro">
                            
                            <form action="doPrueba.php?req='. $_GET['req']  .'" method="post">';


                            
                                                                        
                    



                            echo '                                
                                <p class="text-center">Entrada:</p>
                            
                                <input type="text" value="'. $obj->entrada .'" readonly>

                                <p class="text-center">Resultado Esperado:</p>
                                
                                <input type="text" name="esperado" value="'. $obj->esperado .'" readonly>

                                <p class="text-center">Resultado del Test:</p>                               
                                
                                <SELECT id="estado" name="resultado" onChange="defecto()" class="text-center" style="width: 378px;">
                                    <OPTION  value="Exitoso">Exitoso</OPTION>
                                    
                                    <OPTION value="Fallido">Fallido</OPTION>
                                    
                                    <OPTION value="Pausado">Pausado</OPTION>
                                </SELECT>

                                <p class="text-center">Observaciones:</p>                               
                                
                                <textarea name="observaciones"> </textarea> <br> <br>

                                <div id="divDefecto" style="display:none;">

                               
                                <h1 class="text-center titulo"> Nueva Defecto De ' . $_GET['req']. ' </h1>
                                <p class="text-center"    style="width: 378px;">Descripcion Del Defecto</p>
                                <textarea style="width: 378px;" class="text-center" type="text" name="descripcion" placeholder="Descripcion" required> </textarea><br>
                                
                                <p class="text-center">Adjunto</p> <br>
                                <input type="file" image name="adjunto" id="adjunto">

                                <input type="hidden" name="defectuoso" id="defectuoso" value="false">
                                <br>
                                </div>
                                


                                <input type="submit" value="Guardar" class="btn btn-warning" name="enviar"> <br>
                                
                                                
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
							'

							;

					}
                



		?>



</body>


</html>