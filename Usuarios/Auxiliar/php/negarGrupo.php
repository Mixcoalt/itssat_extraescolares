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
		$estatusGrupo="Negado";	
		$consulta="UPDATE grupos SET estatusGrupo='$estatusGrupo' WHERE Id_Grupos='$id'";
		$resultado=mysqli_query($conex,$consulta);
		header("location:../escolarizado.php");
?>
