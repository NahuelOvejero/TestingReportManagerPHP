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

    $desc = $_POST['desc'];
    $actor = $_POST['actor'];
    $pre = $_POST['pre'];
    $post = $_POST['post'];
    $trig = $_POST['trigger'];
        
    $consulta= 'SELECT version,subversion,IdProyecto from version where IdProyecto = (SELECT IdProyecto FROM proyecto order by IdProyecto desc LIMIT 1) ';


    if($result = $mysqli->query($consulta))	{

            if ($obj = $result->fetch_object()) {
                    $version=$obj->version.'.'.$obj->subversion;
                    $id = $obj->IdProyecto;
            }	
            else{
                echo $mysqli->error;
            }				

        $result->close();
    }
    $user = $_SESSION['id'];
    $cons="INSERT INTO requerimientos values(0,$id,$user,'$nombre','$modulo','$desc','$actor','$pre','$post','$trig','$fecha','$prioridad','$estado',$version);";
    $mysqli->autocommit(true);
    if($mysqli->query($cons)){
        
        header('location:agregarRequerimiento.php?success=true');
    }
    else
        header('location:agregarRequerimiento.php?success=false');
}
else 

?>