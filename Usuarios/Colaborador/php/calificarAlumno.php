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
			if(isset($_POST['Ingresar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$id=$_GET['id'];
				$calificacion=$_POST['calificacion'];
				$periodo=$_SESSION['perioso'];
				$idDocente=$_SESSION['login'];
				$parcial=$_POST['parcial'];
				echo($parcial);
				$consultaActividad="SELECT * FROM actividadalumno WHERE Id_NumControlAlumno='$id' AND PeriodoExtraescolarId='$periodo'";
				$resultado=mysqli_query($conex,$consultaActividad);
				$mostrar=mysqli_fetch_array($resultado);
				$idActividadAlumno=$mostrar['Id_actividadAlumno'];
				
				if($calificacion=='' OR $calificacion=='na' OR $calificacion==0 OR $calificacion=='N/A' OR $calificacion=='n/a'){
						$calificacion=0;
				}
				
				//Consulta
				$consultaCal="SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
				$resultado1=mysqli_query($conex,$consultaCal);
				$mostrar1=mysqli_fetch_array($resultado1);
				$counter=mysqli_num_rows($resultado1);	
				
				if($counter==1){
						$cali1=$mostrar1['calificacionUno'];
						$cali2=$mostrar1['calificacionDos'];
						$cali3=$mostrar1['calificacionTres'];
						if($cali1==''){
							$cali1=0;
						}else if($cali2==''){
							$cali2=0;
						}else if($cali3==''){
							$cali3=0;
						}
				}
				
				if($parcial==1){
					$promedio=$calificacion;
					if($counter==0){
						$consulta="INSERT INTO calificacionesalumno(Id_ElegidaActividadAlumno, Id_NumeroControl, Id_Docente, periodoCalificacionesExtraescolar,calificacionUno,promedio) 
						VALUES ('$idActividadAlumno', '$id','$idDocente', '$periodo','$calificacion','$promedio')";
						$resultado=mysqli_query($conex,$consulta);
					}else if($counter==1){
						if($cali2==0 OR $cali2>0  AND $cali3>0){
							$promedio = ($calificacion + $cali2 + $cali3)/3;
						}else if($cali2>0 AND $cali3==0){
							$promedio = ($calificacion + $cali2)/2;
						}
						$actualizar="UPDATE calificacionesalumno SET calificacionUno='$calificacion', promedio='$promedio' WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
						$resultado=mysqli_query($conex,$actualizar);
					}else{
						$actualizar="UPDATE calificacionesalumno SET calificacionUno='$calificacion', promedio='$promedio' WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
						$resultado=mysqli_query($conex,$actualizar);
					}
				}else if($parcial==2){
					$promedio=($calificacion+$cali1)/2;
					if($counter==0){
						$consulta="INSERT INTO calificacionesalumno(Id_ElegidaActividadAlumno, Id_NumeroControl, Id_Docente, periodoCalificacionesExtraescolar,calificacionDos,promedio) 
						VALUES ('$idActividadAlumno', '$id','$idDocente', '$periodo','$calificacion','$promedio')";
						$resultado=mysqli_query($conex,$consulta);
					}else if($counter==1){
						if($cali1==0 OR $cali1>0 AND $cali3>0){
							$promedio = ($cali1 + $calificacion + $cali3)/3;
						}
						$actualizar="UPDATE calificacionesalumno SET calificacionDos='$calificacion', promedio='$promedio' WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
						$resultado=mysqli_query($conex,$actualizar);
					}else{
						$actualizar="UPDATE calificacionesalumno SET calificacionDos='$calificacion', promedio='$promedio' WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
						$cal2=mysqli_query($conex,$actualizar);
					}
				}else if($parcial==3){
					$promedio=($calificacion+$cali1+$cali2)/3;
					if($counter==0){
						$consulta="INSERT INTO calificacionesalumno(Id_ElegidaActividadAlumno, Id_NumeroControl, Id_Docente, periodoCalificacionesExtraescolar,calificacionTres,promedio) 
						VALUES ('$idActividadAlumno', '$id','$idDocente', '$periodo','$calificacion','$promedio')";
						$resultado=mysqli_query($conex,$consulta);
					}else{
						$actualizar="UPDATE calificacionesalumno SET calificacionTres='$calificacion', promedio='$promedio' WHERE Id_NumeroControl='$id' AND periodoCalificacionesExtraescolar='$periodo'";
						$cal3=mysqli_query($conex,$actualizar);
					}
				}
				header("location:../reportecolab.php");
			}
			
			
			if(isset($_POST['calIrre'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$id=$_GET['id'];
				$calificacion=$_POST['calificacion'];
				$periodo=$_SESSION['perioso'];
				$idDocente=$_SESSION['login'];
				$parcial=$_POST['parcial'];
				
				
				if($calificacion=='' OR $calificacion=='na' OR $calificacion==0 OR $calificacion=='N/A' OR $calificacion=='n/a'){
						$calificacion=0;
				}
				
				$consultaCal="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$id' AND periodoAlumnoAvanzado='$periodo'";
				$resultado1=mysqli_query($conex,$consultaCal);
				$mostrar1=mysqli_fetch_array($resultado1);
				
				$cali1=$mostrar1['c1'];
				$cali2=$mostrar1['c2'];
				$cali3=$mostrar1['c3'];
				
				if($parcial==1){
					if($cali3>0){
						$promedio = ($calificacion + $cali2 + $cali3)/3;
					}else if($cali2>0 AND $cali3==0){
						$promedio = ($calificacion + $cali2)/2;
					}else{
						$promedio=$calificacion;
					}
					$actualizar="UPDATE actividadalumnoavanzado SET c1='$calificacion', p='$promedio' WHERE Id_ctrAlumno='$id' AND periodoAlumnoAvanzado='$periodo'";
					$cal1=mysqli_query($conex,$actualizar);
				}else if($parcial==2){
					if($cali3>0){
						if($cali1==''){ $cali1=0; }
						$promedio = ($cali1 + $calificacion + $cali3)/3;
					}else{
						if($cali1==''){ $cali1=0; }
						$promedio=($calificacion+$cali1)/2; echo($cali1);
					}
					$actualizar="UPDATE actividadalumnoavanzado SET c2='$calificacion', p='$promedio' WHERE Id_ctrAlumno='$id' AND periodoAlumnoAvanzado='$periodo'";
					$cal2=mysqli_query($conex,$actualizar);
					echo($actualizar);
				}else if($parcial==3){
					if($cali1==''){ $cali1=0; }
					else if($cali2==''){ $cali2=0; }
					$promedio=($calificacion+$cali1+$cali2)/3;
					$actualizar="UPDATE actividadalumnoavanzado SET c3='$calificacion', p='$promedio' WHERE Id_ctrAlumno='$id' AND periodoAlumnoAvanzado='$periodo'";
					$cal3=mysqli_query($conex,$actualizar);
				}
				header("location:../reportecolabMOOCS.php");
			}
			
?>