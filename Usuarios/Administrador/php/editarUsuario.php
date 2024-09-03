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
		$login=$_POST['login'];
		$numTipoUsuario=$_POST['numTipoUsuario'];
		$numProgEdu=$_POST['numProgEdu'];
		$contrasena=$_POST['contrasena'];
		$contra=sha1($contrasena);
		$select="SELECT * FROM tipousuario,actividadesextraescolares";
		$querySelect=mysqli_query($conex, $select);
		$idTipoUsuario=$numTipoUsuario;
		$nombreActividad=$numProgEdu;
		while($mostrar=mysqli_fetch_assoc($querySelect)){
			if($mostrar['nombreTipoUsuario']==$numTipoUsuario){
				$idTipoUsuario=$mostrar['IdTipoUsuario'];
			}else if($mostrar['nombreActividad']==$numProgEdu){
				$nombreActividad=$mostrar['IdActE'];	
			}
		}
		if($numTipoUsuario<>$idTipoUsuario OR $numProgEdu<>$nombreActividad){
			$consulta="UPDATE usuarios SET nombre='$nombre', login='$login', numTipoUsuario='$idTipoUsuario', numProgEdu='$nombreActividad', contrasena='$contra' WHERE Id='$id'";
			$resultado=mysqli_query($conex,$consulta);
		}else{
			$consulta="UPDATE usuarios SET nombre='$nombre', login='$login', numTipoUsuario='$numTipoUsuario', numProgEdu='$numProgEdu', contrasena='$contra' WHERE Id='$id'";
			$resultado=mysqli_query($conex,$consulta);
		}
		
		
		header("location:../registrousuarios.php");
?>
