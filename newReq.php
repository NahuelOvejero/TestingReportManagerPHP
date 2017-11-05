<?php


session_start();

if(isset($_POST['enviar']))
{
   
    require './dbManager/connectdb.php';
    $id=0;
    $nombre=$_POST['nombre'];
    $modulo=$_POST['modulo'];
    $prioridad=$_POST['prioridad'];
    $fecha=date('y-m-d');
    $estado='Incompleto';
    $version = 0;
    
        
    $consulta= 'SELECT version,subversion from version where IdProyecto = (SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1) ';

    if($result = $mysqli->query($consulta))	{

            if ($obj = $result->fetch_object()) {
                    $version=$obj->version.'.'.$obj->subversion;
            }	
            else{
                echo $mysqli->error;
            }				

        $result->close();
    }
    $consulta="INSERT INTO requerimientos values($id,'$nombre','$modulo','$fecha','$prioridad','$estado',$version);";
    $mysqli->autocommit(true);
    if($result=$mysqli->query($consulta)){
        
        header('location:agregarRequerimiento.php?success=true');
    }
    else
        header('location:agregarRequerimiento.php?success=false');
}
else 

?>