<?php

session_start();

if(isset($_SESSION['rol']))
	if($_SESSION['rol']!='lider') header('Location:inicio.php?auth=false');


?>

<html>
<head>
<script>
	function filtrar(){
		var selectBox = document.getElementById("filter");
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		window.location='agregarPersonal.php?filter='+selectedValue;
	}
</script>
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




			if(isset($_SESSION['rol']))
				include 'navBar.php';				

					echo '<div class="container-fluid contenido">';

							// OPERACION DB

					require './dbManager/connectdb.php';


					$IdProyectoAcutal = 0;
				
					
					$consulta= 'SELECT * FROM proyecto order by IdProyecto desc';
			
					if($result = $mysqli->query($consulta))	{

						  if ($obj = $result->fetch_object()) {
						  		echo '<h1 class="text-center titulo"> Proyecto Actual : '. $obj->nombre .' </h1>';
       							$IdProyectoAcutal = $obj->IdProyecto;
       							echo '<h1 class="text-center titulo"> Agregar Personal </h1>';
    						}						

						$result->close();
					}



					/////// DATOS DEL PROYECTO
					
					
					$consulta = 'SELECT COUNT(*) as "total" FROM `usuario` 
					WHERE IdUser NOT IN (SELECT IdUser FROM asignacion WHERE IdProyecto = '. $IdProyectoAcutal.')';
				
						
					if($result =  $mysqli->query($consulta)){
						  if ($obj = $result->fetch_object()) {
						  	$registros = $obj->total;
						  }
					}


					$page = 1;
					if(isset($_GET['page'])) {
					    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
					    if(false === $page)
					    	$page =1;
					}

					$cantidad = 10;
					$offset = ($page -1) * $cantidad;
					$lastPage = ROUND(($registros / $cantidad)+0.5);

					if(!isset($_SESSION['busqueda']))
						$rol = '1,2,3,4';
					else
						$rol = $_SESSION['busqueda'];

					
					

					$consulta= 'SELECT * FROM `usuario` WHERE IdRol  IN (' . $rol .') && IdUser NOT IN (SELECT IdUser FROM asignacion WHERE IdProyecto =' . $IdProyectoAcutal.')  LIMIT '. $offset .','. $cantidad;
					if(isset($_GET['filter']) && $_GET['filter']!=0)
						{
							$consulta= 'SELECT * FROM `usuario` WHERE  IdRol  =' . $_GET['filter'] .' && IdUser NOT IN (SELECT IdUser FROM asignacion WHERE IdProyecto =' . $IdProyectoAcutal.')  LIMIT '. $offset .','. $cantidad;
							
						}
					if($result = $mysqli->query($consulta))	{
						
						$rol = 'Sin asignar';
						
						  	echo '<div class="alineador">
									<div class="centro">';
							if(isset($_GET['filter'])&& $_GET['filter']!=0){
								if($_GET['filter']==1)
									echo '<div class="form-group btnfix">
									<SELECT onChange="filtrar()" id="filter">						
									<option value=0> -- ningun rol en especifico -- </option>
										<OPTION value=1 selected ">lider</OPTION>
										<OPTION value=2 ">requerimiento</OPTION>
										<OPTION value=3 ">analista</OPTION>
										<OPTION value=4 ">developer</OPTION>
									</SELECT>
								</div>';
							  else if($_GET['filter']==2)
								echo '<div class="form-group btnfix">
								<SELECT onChange="filtrar()" id="filter">						
								<option value=0> -- ningun rol en especifico -- </option>
									<OPTION value=1  ">lider</OPTION>
									<OPTION value=2 selected ">requerimiento</OPTION>
									<OPTION value=3 ">analista</OPTION>
									<OPTION value=4 ">developer</OPTION>
								</SELECT>
								</div>';
							else if($_GET['filter']==3)
								echo '<div class="form-group btnfix">
								<SELECT onChange="filtrar()" id="filter">						
								<option value=0> -- ningun rol en especifico -- </option>
									<OPTION value=1  ">lider</OPTION>
									<OPTION value=2  ">requerimiento</OPTION>
									<OPTION value=3 selected ">analista</OPTION>
									<OPTION value=4 ">developer</OPTION>
								</SELECT>
							</div>';
							else
							echo '<div class="form-group btnfix">
							<SELECT onChange="filtrar()" id="filter">						
							<option value=0> -- ningun rol en especifico -- </option>
								<OPTION value=1  ">lider</OPTION>
								<OPTION value=2  ">requerimiento</OPTION>
								<OPTION value=3 ">analista</OPTION>
								<OPTION value=4 selected ">developer</OPTION>
							</SELECT>
						</div>';
							}
							else{
								echo '<div class="form-group btnfix">
								<SELECT onChange="filtrar()" id="filter">						
								<option value=0> -- ningun rol en especifico -- </option>
									<OPTION value=1 ">lider</OPTION>
									<OPTION value=2 ">requerimiento</OPTION>
									<OPTION value=3 ">analista</OPTION>
									<OPTION value=4 ">developer</OPTION>
								 </SELECT>
							  </div>';
							}

							echo '<FORM METHOD="POST" action="relacionPersonal.php">';

							echo '<table class="table">';
							echo '<tr><th>Mail</th><th>Rol</th><th>Incluir</th></tr>';
						  while ($obj = $result->fetch_object()) {   

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

						  	echo '<tr>';

						  	echo '<td>'. $obj->mail .'</td>';

						  	echo '<td>'. $rol .'</td>';

						  	echo '<td class="text-center"> <input type=checkbox name="personal[]" value="'. $obj->IdUser .'"> </td>';

						  	echo '</tr>';

    						}			

    						echo '</table>';			

						$result->close();


						echo '<input type="submit" name="enviar" class="btn btn-warning btnfix" value="Agregar Seleccion"> </form>';
					}



							// FIN OPERACION DB

					echo '

					<div class="pagination">';

					if ($page > 1)
						echo '
						  <a href="agregarPersonal.php?page=1"> ❮❮ </a>';
						  
					echo '<a href="#">'. $page .'</a>';

					if($page < $lastPage)
					  echo'
					  <a href="agregarPersonal.php?page='. $lastPage .'"> ❯❯ </a>';

					echo '
					</div>


					</div>
					</div>
					</div>
					</div>';

		?>



</body>


</html>