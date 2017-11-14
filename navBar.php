<?php

	if(isset($_SESSION['rol']))
		echo '
				<div>
					<div class="menu-container">
						<div class="vertical-menu">
						  <a href="inicio.php">Inicio</a>';

						if($_SESSION['rol'] == 'lider') echo '<a href="nuevoProyecto.php">Nuevo Proyecto</a>
  						  <a href="proyectoActual.php">Proyecto Actual</a>
						   <a href="agregarPersonal.php">Agregar Personal</a>';

						   if($_SESSION['rol'] == 'requerimiento')
									echo '
							<a href="proyectoActualReq.php">Proyecto Actual</a>
							<a href="agregarRequerimiento.php">Cargar Requerimiento</a>
						   <a href="RequerimientosActuales.php">Requerimientos Actuales</a>
						   <a href="requerimientosSinAsignar.php">Requerimientos Sin Asignar</a>';


						if($_SESSION['rol'] == 'analista') 
						echo '<a href="misrequerimientos.php"> Mis Requerimientos </a>';

						if($_SESSION['rol'] == 'developer') 
						echo '<a href="mispruebas.php"> Mis Pruebas </a>';
							
							 
	
	echo		'</div>
					</div>
				</div>


				<div class="contenido">
				</div>
				';

		
?>