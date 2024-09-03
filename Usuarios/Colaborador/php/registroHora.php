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
			include("../../../Php/conexion.php"); //Llamado a la conexion
			if(isset($_POST['agregar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$periodo=$_SESSION['perioso']; //Periodo extraescolar actual
				$id_DocenteExtraescolar=$_GET['id'];
				$numeroGrupo=$_POST['numeroGrupo'];
				$nombreGrupo=$_POST['nombreGrupo']; 
				$diaGrupo=$_POST['diaGrupo'];
				$horaGrupo=$_POST['horaGrupo'];
				$capacidadGrupo=$_POST['capacidadGrupo'];
				
				$consulta1="SELECT * FROM docenteextraescolares WHERE numControlDocente='$id_DocenteExtraescolar'";
				$resultado1=mysqli_query($conex,$consulta1);
				while($row=mysqli_fetch_array($resultado1)){
					$id_Actividad=($row['id_Actividad']);
				}
			
				$consulta="INSERT INTO grupos(numeroGrupo, nombreGrupo, diaGrupo, horaGrupo, numControlDocenteExtraescolar,id_ActividadE,capacidadGrupo,disponiblesGrupo,IdPeriodoExtraGrupos) 
				VALUES ('$numeroGrupo', '$nombreGrupo', '$diaGrupo', '$horaGrupo' , '$id_DocenteExtraescolar','$id_Actividad','$capacidadGrupo','$capacidadGrupo','$periodo')";
				
				$resultado=mysqli_query($conex,$consulta);
				header("location:../registrohora.php");
			}
?>