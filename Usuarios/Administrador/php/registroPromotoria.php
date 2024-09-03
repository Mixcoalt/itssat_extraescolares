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

			include ("../../../Php/conexion.php"); //Llamado a la conexion
			if(isset($_POST['Ingresar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$periodo=$_SESSION['perioso']; 
				$nombre=$_POST['nombre'];
				
				$consulta="INSERT INTO actividadesextraescolares(nombreActividad,IdPeriodoExtraAct) 
				VALUES ('$nombre','$periodo')";
				$resultado=mysqli_query($conex,$consulta);
				//Reubicacion al archivo registrousuarios.php
				header("location:../registroPromotoria.php");
			}
?>
