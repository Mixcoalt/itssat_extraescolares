<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=4){
		header("location:../../../index.php");
		exit;
		}
	}
		include("../../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		$id_Grupo=$_GET['id'];
		$consulta="DELETE FROM grupos WHERE Id_Grupos='$id_Grupo'";
		echo($consulta);
		$resultado=mysqli_query($conex,$consulta);
		header("location:../editarhora.php");
?>