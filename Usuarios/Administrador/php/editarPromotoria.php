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
		$nombre=$_POST['nombre']; 	
		$consulta="UPDATE actividadesextraescolares SET nombreActividad='$nombre' WHERE IdActE='$id'";
		$resultado=mysqli_query($conex,$consulta);	
		header("location:../registroPromotoria.php");
?>