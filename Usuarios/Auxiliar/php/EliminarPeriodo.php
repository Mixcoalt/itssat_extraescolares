<?php
session_start();
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
	include("../../../Php/conexion.php");
		$id=$_GET['id'];	
		$consulta="DELETE FROM periodosescolares WHERE idPeriodosEscolares='$id'";
		$resultado=mysqli_query($conex,$consulta);
				//Eliminacion de la sesion iniciada
				if(session_destroy()){
					header("location:../../../index.php");	//Llamado del Login
					exit();	
				}
?>