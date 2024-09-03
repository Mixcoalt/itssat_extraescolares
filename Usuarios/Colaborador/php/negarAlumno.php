<?php
	include("../../../Php/conexion.php");
	session_start();
		$Id_actividadAlumno=$_GET['id'];
		$razon=$_POST['razon'];
		$estatusGrupo="Negado";
		$periodo=$_SESSION['perioso'];
		$consulta="UPDATE actividadalumno SET Estatus='$estatusGrupo',observacionAlumno='$razon' WHERE Id_actividadAlumno='$Id_actividadAlumno' AND PeriodoExtraescolarId='$periodo'";
		$resultado=mysqli_query($conex,$consulta);
		$sql="SELECT * FROM actividadalumno WHERE Id_actividadAlumno='$Id_actividadAlumno'"; 
		$resultado=mysqli_query($conex,$sql); 
		while($mostrar=mysqli_fetch_assoc($resultado)){ 
			$IdGrupo=$mostrar['IdGrupo'];
		}
		$sql="SELECT * FROM grupos WHERE Id_Grupos='$IdGrupo'"; 
		$resultado=mysqli_query($conex,$sql);
		while($mostrar=mysqli_fetch_assoc($resultado)){
			$disponible=$mostrar['disponiblesGrupo'];
		}	
		$disponiblesGrupo=$disponible + 1;
		$consulta1="UPDATE grupos SET disponiblesGrupo='$disponiblesGrupo' WHERE Id_Grupos='$IdGrupo'";
		$resultado=mysqli_query($conex,$consulta1);
		header("location:../reportecolab.php");
?>