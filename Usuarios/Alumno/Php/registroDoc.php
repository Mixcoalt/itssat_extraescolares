<?php
session_start();
include("../../../Php/conexion.php"); 
	if(isset($_POST['Registrar'])){
		$periodo=$_SESSION['perioso']; 
		
		$Id_Alumno=$_GET['id'];
		
		$datosAlum="SELECT tipoSangre,alergia,telefonoAvanzadoAlumno,correoAvanzadoAlumno FROM datosalumno WHERE id_AlumnoCTR='$Id_Alumno'";
		$queryDatos=mysqli_query($conex,$datosAlum);
		$mstr=mysqli_fetch_array($queryDatos);
		$countDatosAlumno=mysqli_num_rows($queryDatos);	
		
		$actAlum="SELECT IdGrupo,edadA,preg1,preg2,preg3,preg4,preg5,preg6,PeriodoExtraescolarId FROM actividadalumno WHERE Id_NumControlAlumno='$Id_Alumno' AND PeriodoExtraescolarId='$periodo'";
		$queryactAlum=mysqli_query($conex,$actAlum);
		$mstrAlumno=mysqli_fetch_array($queryactAlum);
		$countActAlumn=mysqli_num_rows($queryactAlum);	
		
		if(empty($_POST['tipoSangre'])){ $tipoSangre=$mstr['tipoSangre']; }
		else{ $tipoSangre=$_POST['tipoSangre']; }
		
		if(empty($_POST['alergia'])){ $alergia=$mstr['alergia']; }
		else{ $alergia=$_POST['alergia']; }
		
		if(empty($_POST['edadA'])){ $edadA=$mstrAlumno['edadA']; }
		else{ $edadA=$_POST['edadA']; }
		
		if(empty($_POST['telefono'])){ $telefono=$mstr['telefonoAvanzadoAlumno']; }
		else{ $telefono=$_POST['telefono']; }
		
		if(empty($_POST['correo'])){ $correo=$mstr['correoAvanzadoAlumno']; }
		else{ $correo=$_POST['correo']; }
		
		if(empty($_POST['preg1'])){ $preg1=$mstrAlumno['preg1']; }
		else{ $preg1=$_POST['preg1']; }
		
		if(empty($_POST['preg2'])){ $preg2=$mstrAlumno['preg2']; }
		else{ $preg2=$_POST['preg2']; }
		
		if(empty($_POST['preg3'])){ $preg3=$mstrAlumno['preg3']; }
		else{ $preg3=$_POST['preg3']; }
		
		if(empty($_POST['preg4'])){ $preg4=$mstrAlumno['preg4']; }
		else{ $preg4=$_POST['preg4']; }
		
		if(empty($_POST['preg5'])){ $preg5=$mstrAlumno['preg5']; }
		else{ $preg5=$_POST['preg5']; }
		
		if(empty($_POST['preg6'])){ $preg6=$mstrAlumno['preg6']; }
		else{ $preg6=$_POST['preg6']; }
		
		if(empty($_POST['actividadE'])){ $Id_Grupos=$mstrAlumno['IdGrupo']; }
		else{ $Id_Grupos=$_POST['actividadE']; }
		
		$sql1="SELECT disponiblesGrupo,id_ActividadE FROM grupos WHERE Id_Grupos='$Id_Grupos'"; 
		$resultado1=mysqli_query($conex,$sql1); 
		$row=mysqli_fetch_array($resultado1); 
			$disponible=$row['disponiblesGrupo'];
			$actividadE=$row['id_ActividadE'];
			$disponiblesGrupo=$disponible - 1;
		
		$name=$_FILES['horario']['name'];
		$type=$_FILES['horario']['type'];
		$size=$_FILES['horario']['size'];
		if ($type=="application/pdf" AND $size<=150000){
				$temp=$_FILES['horario']['tmp_name'];
				$fname='HorarioAcademico'.$Id_Alumno.'.pdf';
				move_uploaded_file($temp,"temp/".$fname);
				
				$name2=$_FILES['documento']['name'];
				if($name2==''){
					$fname2='';
				}else{
					$type2=$_FILES['documento']['type'];
					$size2=$_FILES['documento']['size'];
					if ($type2=="application/pdf" AND $size2<=150000){
						$temp2=$_FILES['documento']['tmp_name'];
						$fname2='documento'.$Id_Alumno.'.pdf';
						move_uploaded_file($temp2,"temp/".$fname2);
					}
				}
				
				if ($countDatosAlumno==0 AND $countActAlumn==0){
					$alumno="INSERT INTO datosalumno(id_AlumnoCTR,tipoSangre,alergia,telefonoAvanzadoAlumno,correoAvanzadoAlumno) 
					VALUES('$Id_Alumno','$tipoSangre','$alergia','$telefono','$correo')";
					mysqli_query($conex,$alumno);
					
					$consulta1="INSERT INTO actividadalumno(Id_NumControlAlumno, IdGrupo, actividadE, PeriodoExtraescolarId,horarioAcademico,nombreHorario,cetificadoMedico,nombreCertificado,preg1,preg2,preg3,preg4,preg5,preg6,edadA) 
							VALUES ('$Id_Alumno','$Id_Grupos','$actividadE','$periodo','$name','$fname','$name2','$fname2','$preg1','$preg2','$preg3','$preg4','$preg5','$preg6','$edadA')";
					mysqli_query($conex,$consulta1);
				}else if($countActAlumn==1){
					$consulta="UPDATE actividadalumno SET IdGrupo='$Id_Grupos', actividadE='$actividadE',horarioAcademico='$name',nombreHorario='$fname',cetificadoMedico='$name2',nombreCertificado='$fname2',Estatus='' WHERE  Id_NumControlAlumno='$Id_Alumno' AND PeriodoExtraescolarId='$periodo'";
					$resultado1=mysqli_query($conex,$consulta);
				}
				
				$consulta="UPDATE grupos SET disponiblesGrupo='$disponiblesGrupo' WHERE Id_Grupos='$Id_Grupos'";
				mysqli_query($conex,$consulta);
		}
	}
	
	if(isset($_POST['actualizar'])){
		$periodo=$_SESSION['perioso']; 
		
		$Id_Alumno=$_GET['id'];
		
		$actAlum="SELECT IdGrupo,edadA,preg1,preg2,preg3,preg4,preg5,preg6,PeriodoExtraescolarId FROM actividadalumno WHERE Id_NumControlAlumno='$Id_Alumno' AND PeriodoExtraescolarId='$periodo'";
		$queryactAlum=mysqli_query($conex,$actAlum);
		$mstrAlumno=mysqli_fetch_array($queryactAlum);
		$countActAlumn=mysqli_num_rows($queryactAlum);	
		
		if(empty($_POST['edadA'])){ $edadA=$mstrAlumno['edadA']; }
		else{ $edadA=$_POST['edadA']; }
		
		if(empty($_POST['preg1'])){ $preg1=$mstrAlumno['preg1']; }
		else{ $preg1=$_POST['preg1']; }
		
		if(empty($_POST['preg2'])){ $preg2=$mstrAlumno['preg2']; }
		else{ $preg2=$_POST['preg2']; }
		
		if(empty($_POST['preg3'])){ $preg3=$mstrAlumno['preg3']; }
		else{ $preg3=$_POST['preg3']; }
		
		if(empty($_POST['preg4'])){ $preg4=$mstrAlumno['preg4']; }
		else{ $preg4=$_POST['preg4']; }
		
		if(empty($_POST['preg5'])){ $preg5=$mstrAlumno['preg5']; }
		else{ $preg5=$_POST['preg5']; }
		
		if(empty($_POST['preg6'])){ $preg6=$mstrAlumno['preg6']; }
		else{ $preg6=$_POST['preg6']; }
		
		if(empty($_POST['actividadE'])){ $Id_Grupos=$mstrAlumno['IdGrupo']; }
		else{ $Id_Grupos=$_POST['actividadE']; }
		
		
		$name=$_FILES['horario']['name'];
		$type=$_FILES['horario']['type'];
		$size=$_FILES['horario']['size'];
		if ($type=="application/pdf" AND $size<=150000){
				$temp=$_FILES['horario']['tmp_name'];
				$fname='HorarioAcademico'.$Id_Alumno.'.pdf';
				move_uploaded_file($temp,"temp/".$fname);
				
				$name2=$_FILES['documento']['name'];
				if($name2==''){
					$fname2='';
				}else{
					$type2=$_FILES['documento']['type'];
					$size2=$_FILES['documento']['size'];
					if ($type2=="application/pdf" AND $size2<=150000){
						$temp2=$_FILES['documento']['tmp_name'];
						$fname2='documento'.$Id_Alumno.'.pdf';
						move_uploaded_file($temp2,"temp/".$fname2);
						
					}
				}

				$sql1="SELECT disponiblesGrupo,id_ActividadE FROM grupos WHERE Id_Grupos='$Id_Grupos'"; 
				$resultado1=mysqli_query($conex,$sql1); 
				$row=mysqli_fetch_array($resultado1); 
					$disponible=$row['disponiblesGrupo'];
					$actividadE=$row['id_ActividadE'];
					$disponiblesGrupo=$disponible - 1;
				
				
				if ($countActAlumn==0){
					$consulta1="INSERT INTO actividadalumno(Id_NumControlAlumno, IdGrupo, actividadE, PeriodoExtraescolarId,horarioAcademico,nombreHorario,cetificadoMedico,nombreCertificado,preg1,preg2,preg3,preg4,preg5,preg6,edadA) 
							VALUES ('$Id_Alumno','$Id_Grupos','$actividadE','$periodo','$name','$fname','$name2','$fname2','$preg1','$preg2','$preg3','$preg4','$preg5','$preg6','$edadA')";
					mysqli_query($conex,$consulta1);
					
				}else if($countActAlumn==1){
					$consulta="UPDATE actividadalumno SET IdGrupo='$Id_Grupos', actividadE='$actividadE',horarioAcademico='$name',nombreHorario='$fname',cetificadoMedico='$name2',nombreCertificado='$fname2',Estatus='' WHERE  Id_NumControlAlumno='$Id_Alumno' AND PeriodoExtraescolarId='$periodo'";
					$resultado1=mysqli_query($conex,$consulta);
				}
				$consulta="UPDATE grupos SET disponiblesGrupo='$disponiblesGrupo' WHERE Id_Grupos='$Id_Grupos'";
				mysqli_query($conex,$consulta);
		}	
	}
	header("location:../registrodoc.php");
?>