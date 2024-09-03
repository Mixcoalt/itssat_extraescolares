<?php
session_start();
include ("../../../Php/conexion.php");
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=3){
		header("location:../../../index.php");
		exit;
		}
	}

	$idAlumno=$_GET['id'];
	$estatus=$_GET['estatus'];
	$perioso=$_SESSION['perioso'];
	
	$sqlG="SELECT IDgrupoA FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$idAlumno'";
	$querySqlG=mysqli_query($conex,$sqlG);
	$rowGrupo=mysqli_fetch_array($querySqlG);
	$idGrupo=$rowGrupo['IDgrupoA'];
		
	$sqlG="SELECT * FROM grupos WHERE Id_Grupos='$idGrupo'";
	$querySqlG=mysqli_query($conex,$sqlG);
	$rowSqlG=mysqli_fetch_array($querySqlG);
		
	if($estatus=='Aceptado'){
		$disponibles=$rowSqlG['disponiblesGrupo']-1;	
		$sqlUG="UPDATE grupos SET disponiblesGrupo='$disponibles' WHERE Id_Grupos='$idGrupo'";
		echo($sqlUG);
		$queryUG=mysqli_query($conex,$sqlUG);
	}else{
		if($rowSqlG['disponiblesGrupo']<$rowSqlG['capacidadGrupo']){
			$disponibles=$rowSqlG['disponiblesGrupo']+1;	
			$sqlUG="UPDATE grupos SET disponiblesGrupo='$disponibles' WHERE Id_Grupos='$idGrupo'";
			echo($sqlUG);
			$queryUG=mysqli_query($conex,$sqlUG);
		}
	}

	$sqlAA="UPDATE actividadalumnoavanzado SET estatusAvanzado='$estatus' WHERE Id_ctrAlumno='$idAlumno' AND periodoAlumnoAvanzado='$perioso'";
	echo($sqlAA);
	$queryAA=mysqli_query($conex,$sqlAA);
	
	header("location:../alumnoIrregulares.php");
?>