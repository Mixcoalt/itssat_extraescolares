<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=1){
		header("location:../../../index.php");
		exit;
		}
	}
	include("../../../Php/conexion.php");
	$id=$_GET['id'];
	$consultaDocente="SELECT * FROM usuarios WHERE Id='$id'";
	$queryDocente=mysqli_query($conex,$consultaDocente);
	$arrayDocente=mysqli_fetch_array($queryDocente);
	if($arrayDocente['numTipoUsuario']==4){
		$login=$arrayDocente['login'];
		$consulta="DELETE FROM docenteextraescolares WHERE numControlDocente='$login'";
		$mysql=mysqli_query($conex,$consulta);
	}
	$consulta="DELETE FROM usuarios WHERE Id='$id'";
	echo($consulta);
	$mysql=mysqli_query($conex,$consulta);
	header("location:../registrousuarios.php");
?>