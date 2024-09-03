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
	include ("../../../Php/conexion.php"); //Llamado a la conexion
	if(isset($_POST['Ingresar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$apellidoP=$_POST['apellidoP'];
				$apellidoM=$_POST['apellidoM'];
				$nombre=$_POST['nombre'];
				$login=$_POST['login'];
				$numTipoUsuario=$_POST['numTipoUsuario'];
				$numProgEdu=$_POST['numProgEdu'];
				$periodo =$_SESSION['perioso']; 
					//$options=array("cos"=>2);
					$contra=$_POST['contrasena'];
					$contrasena=sha1($contra);
					//Consulta
					$consulta="INSERT INTO usuarios(nombre, login, apellidoPUsuario, apellidoMUsuario, numTipoUsuario, numProgEdu, contrasena) 
					VALUES ('$nombre', '$login','$apellidoP', '$apellidoM', '$numTipoUsuario', '$numProgEdu', '$contrasena')";
					//$resultado=mysqli_query($conex,$consulta);
					if($numTipoUsuario==4){
						$consultaD="INSERT INTO docenteextraescolares(id_Actividad, nombre_Docente, apellidoPDocente, apellidoMDocente, numControlDocente, IdPeriodoExtraDocente) 
						VALUES ('$numProgEdu', '$nombre', '$apellidoP', '$apellidoM', '$login', '$periodo')";
						//$resultado=mysqli_query($conex,$consultaD);
	}
				//Reubicacion al archivo registrousuarios.php
	header("location:../registrousuarios.php");
?>