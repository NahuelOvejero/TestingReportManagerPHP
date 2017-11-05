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

						 if($_SESSION['rol'] == 'requerimiento') echo '
						   <a href="proyectoActualReq.php">Proyecto Actual</a>';
						  
	
	echo		'</div>
					</div>
				</div>


				<div class="contenido">
				</div>
				';

		
?>