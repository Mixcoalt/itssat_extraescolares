<?php
session_start();
	session_id();
	if(!isset($_SESSION['login'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=2){
		header("location:../../../index.php");
		exit;
		}
	}
			include("../../../Php/conexion.php"); //Llamado a la conexion
			if(isset($_POST['Registrar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$Id_Grupos=$_GET['id'];
				$nombreActividad=$_POST['nombreActividad']; 
				$numeroGrupo=$_POST['numeroGrupo'];
				$horaGrupo=$_POST['horaGrupo'];
				$consulta="INSERT INTO actividadalumno(Id_actividadExtraescolar, Id_Alumno, IdGrupo, horaGrupo) 
				VALUES ('$nombreActividad', '$Id_Alumno', '$numeroGrupo', '$horaGrupo')";
				echo($consulta);
				header("location:../registrodoc.php");
			}
?>