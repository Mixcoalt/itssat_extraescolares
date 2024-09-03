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
	$consulta="DELETE FROM actividadesextraescolares WHERE IdActE='$id'";
	$mysql=mysqli_query($conex,$consulta);
	header("location:../registroPromotoria.php");
?>
