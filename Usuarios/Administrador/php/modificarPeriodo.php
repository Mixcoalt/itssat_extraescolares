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
		$MesInicio=$mesInicio=date('Y-m-01',strtotime($_POST['idMesInicio']));
		$MesFin=$mesFin=date('Y-m-01',strtotime($_POST['idMesFin']));	
		$consulta="UPDATE periodosescolares SET FechaInicioExtraescolar='$MesInicio', FechaFinExtraescolar='$MesFin' WHERE idPeriodosEscolares='$id'";	
		$resultado=mysqli_query($conex,$consulta);
		header("location:../registroPeriodo.php");
?>
