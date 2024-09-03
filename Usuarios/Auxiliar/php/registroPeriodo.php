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

			include ("../../../Php/conexion.php"); 
			if(isset($_POST['Ingresar'])){ 
				$mesInicio=date('Y-m-01',strtotime($_POST['idMesInicio']));
				$mesFin=date('Y-m-01',strtotime($_POST['idMesFin']));
				
				$consulta="INSERT INTO periodosescolares(FechaInicioExtraescolar,FechaFinExtraescolar) VALUES ('$mesInicio','$mesFin')";
				$resultado=mysqli_query($conex,$consulta);
		
				if(session_destroy()){
					header("location:../../../index.php");	
					exit();	
				}
			}
?>
