<?php
session_start();
			include("../../../Php/conexion.php");//Llamado a la conexion
			if(isset($_POST['Enviar'])){
				$Id_Alumno=$_GET['id'];
				$periodo=$_SESSION['perioso'];
				$Id_Grupos=$_POST['actividadE'];
				$nombreTaller=$_POST['nombreTaller'];
				$sqlGrupo="SELECT id_ActividadE FROM  grupos WHERE Id_Grupos='$Id_Grupos'";
				$queryGrupo=mysqli_query($conex,$sqlGrupo);
				$mostrarGrupo=mysqli_fetch_array($queryGrupo);
				$actidadGrupo=$mostrarGrupo['id_ActividadE'];
				
				$consultaAlumno="SELECT Id_ctrAlumno FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$Id_Alumno' AND periodoAlumnoAvanzado='$periodo'";
				$resultadoAlumno=mysqli_query($conex,$consultaAlumno);
				$counterAlumno=mysqli_num_rows($resultadoAlumno);
				if($counterAlumno==0){
					if(empty($_POST['telefono']) AND empty($_POST['correo']) AND $mostrarGrupo['IdPeriodoExtraGrupos']!=$periodo){
							$edadAvanzado=$_POST['edadA'];
							$consulta1="INSERT INTO actividadalumnoavanzado(Id_ctrAlumno,actividadesfisicas_1,actividadAvanzado,IDgrupoA,periodoAlumnoAvanzado,edadAvanzado) 
							VALUES ('$Id_Alumno','$nombreTaller','$actidadGrupo','$Id_Grupos','$periodo','$edadAvanzado')";
							$resultado1=mysqli_query($conex,$consulta1);
					}else{
						if(empty($_POST['edadAvanzado']) AND empty($_POST['telefono']) AND empty($_POST['correo'])){
							$consulta1="UPDATE actividadalumnoavanzado SET actividadAvanzado='$actidadGrupo',actividadesfisicas_1='$nombreTaller',nombreactividadesfisicas_1='',IDgrupoA='$Id_Grupos',estatusAvanzado='' WHERE Id_ctrAlumno='$Id_Alumno' AND periodoAlumnoAvanzado='$periodo'";
							$resultado1=mysqli_query($conex,$consulta1);
						}else{
							$edadAvanzado=$_POST['edadA'];
							$telefono=$_POST['telefono'];
							$correo=$_POST['correo'];
							
							$consulta1="INSERT INTO actividadalumnoavanzado(Id_ctrAlumno,actividadesfisicas_1,actividadAvanzado,IDgrupoA,periodoAlumnoAvanzado,edadAvanzado) 
							VALUES ('$Id_Alumno','$nombreTaller','$actidadGrupo','$Id_Grupos','$periodo','$edadAvanzado')";
							$resultado1=mysqli_query($conex,$consulta1);
								
							$consulta1="INSERT INTO datosalumno(id_AlumnoCTR,telefonoAvanzadoAlumno,correoAvanzadoAlumno) 
							VALUES ('$Id_Alumno','$telefono','$correo')";
							$resultado1=mysqli_query($conex,$consulta1);
						}
					}
				}else{
					$consultaAlumno="UPDATE actividadalumnoavanzado SET actividadAvanzado='$actidadGrupo',actividadesfisicas_1='$nombreTaller',nombreactividadesfisicas_1='',IDgrupoA='$Id_Grupos',estatusAvanzado='' WHERE Id_ctrAlumno='$Id_Alumno' AND periodoAlumnoAvanzado='$periodo'";
					$resultado1=mysqli_query($conex,$consultaAlumno);
				}
			}
			
			if(isset($_POST['Actualizar'])){
				$Id_Alumno=$_GET['id'];
				$periodo=$_SESSION['perioso'];
			
				$type=$_FILES['C1']['type'];
				$size=$_FILES['C1']['size'];
				if ($type=="application/pdf" AND $size<=150000){
					$temp=$_FILES['C1']['tmp_name'];
					$fname='Curso_'.$Id_Alumno.'.pdf';
					move_uploaded_file($temp,"temp/".$fname);
					$consulta1="UPDATE actividadalumnoavanzado SET nombreactividadesfisicas_1='$fname' WHERE Id_ctrAlumno='$Id_Alumno' AND periodoAlumnoAvanzado='$periodo'";	
					$resultado1=mysqli_query($conex,$consulta1);
				}
			}
			header("location:../registrodoc.php");		
?>