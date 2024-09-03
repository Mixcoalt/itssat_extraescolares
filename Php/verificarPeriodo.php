<?php
		$perioso =$_SESSION['perioso'];
		$periodo="SELECT * FROM actividadalumno WHERE Id_NumControlAlumno='$idAlumno'";
		$periodos = mysqli_query($conex,$periodo);
		$verPeriodo = mysqli_fetch_array($periodos);
		$periodoalumno = $verPeriodo['PeriodoExtraescolarId'];
?>