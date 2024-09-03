<?php
session_start();
	include("../../../Php/conexion.php");
	$Id_actividadAlumno=$_GET['id'];
	$periodo=$_SESSION['perioso'];
	$estatusGrupo="Aceptado";
	$select =" SELECT Estatus FROM actividadalumno WHERE Id_actividadAlumno='$Id_actividadAlumno'";
	$query=mysqli_query($conex,$select);
	$mstQuery=mysqli_fetch_array($query);
	if($mstQuery['Estatus']==""){
		$consulta="UPDATE actividadalumno SET Estatus='$estatusGrupo' WHERE Id_actividadAlumno='$Id_actividadAlumno' AND PeriodoExtraescolarId='$periodo'";
		echo $consulta;
		$resultado=mysqli_query($conex,$consulta);
	}
	header("location:../reportecolab.php");
?>