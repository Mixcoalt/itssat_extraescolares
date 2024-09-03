<?php
			$numControlAlumno=$mostrar['numControlAlumno']; 
			$consultaAlumno = "SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$numControlAlumno' AND promedio>=70 ORDER BY periodoCalificacionesExtraescolar DESC LIMIT 0,1";
			$query = mysqli_query($conex,$consultaAlumno);
			$arrayAlumno = mysqli_fetch_array($query);
			$contarAlumno = mysqli_num_rows($query);
		if ($mostrar['numControlAlumno'] == $arrayAlumno['Id_NumeroControl']){

			$numeroControlSuma = $numControlAlumno;
			if(){
				echo '<button><a href="php/DocAnexoXVI.php?id='.$arrayAlumno['idCalificaciones'].'">Imprimir</a></button>';
			}
			$a++;
		}
?>