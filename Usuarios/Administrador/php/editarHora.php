<?php
		include ("../../../Php/conexion.php"); 	
		$id_Grupo=$_GET['id'];
		$numeroGrupo=$_POST['numeroGrupo'];
		$nombreGrupo=$_POST['nombreGrupo'];
		$diaGrupo=$_POST['diaGrupo'];
		$horaGrupo=$_POST['horaGrupo'];
		$capacidadGrupo=$_POST['capacidadGrupo'];
		$sql="SELECT * FROM grupos WHERE Id_Grupos='$id_Grupo'";
		$resultado1=mysqli_query($conex,$sql);
		$mostrar=mysqli_fetch_array($resultado1);
		$capacidad=$mostrar['capacidadGrupo'];
		$disponibles=$mostrar['disponiblesGrupo'];
		if($mostrar['nombreGrupo']=='TALLER'){
			$sql="SELECT id_actividadAlumnoAvanzado FROM actividadalumnoavanzado WHERE IDgrupoA='$id_Grupo'";
			$query=mysqli_query($conex,$sql);
			$counter=mysqli_num_rows($query);
		}else{
			$sql="SELECT Id_actividadAlumno FROM actividadalumno WHERE 	IdGrupo='$id_Grupo'";
			$query=mysqli_query($conex,$sql);
			$counter=mysqli_num_rows($query);
			echo($sql);
		}
		
			if($capacidadGrupo>$capacidad){
				$cap=$capacidadGrupo-$capacidad;
				$resultado=$cap+$disponibles;
			}else if($capacidadGrupo<$counter){
				$capacidadGrupo=$counter;
				$resultado=0;
			}else{
				$resultado=$capacidadGrupo-$counter;
			}
			$consulta="UPDATE grupos SET numeroGrupo='$numeroGrupo', nombreGrupo='$nombreGrupo', diaGrupo='$diaGrupo', horaGrupo='$horaGrupo', capacidadGrupo='$capacidadGrupo', disponiblesGrupo='$resultado' WHERE Id_Grupos='$id_Grupo'";
			mysqli_query($conex,$consulta);
			
			header("location:../editar.php");
?>