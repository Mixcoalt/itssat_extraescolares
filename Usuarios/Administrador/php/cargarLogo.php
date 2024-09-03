<?php
session_start();
	session_id();
	
	if(!isset($_SESSION['id'])){
		header("location:../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=1){
		header("location:../../index.php");
		exit;
		}
	}	
include("../../../Php/conexion.php");
if(isset($_POST['enviar'])){
		$tipoIcon=$_POST['tipoIcon'];
		
		$name=$_FILES['imagen']['name'];
		$temporal=$_FILES['imagen']['tmp_name'];
		$size=$_FILES['imagen']['size'];
		$type=$_FILES['imagen']['type'];
		$directorio='../../../Imagen';
		$extension=strtolower(pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION));
		
		if($tipoIcon==1){
			$new=('Header.'.$extension);
			$ruta=$directorio.'/'.$new;
			move_uploaded_file($temporal,$directorio.'/'.$new);
			$sql="UPDATE logos SET imagenes_ruta='$ruta', nombre_imagen='$new' WHERE id_logos='$tipoIcon'";
			$resultad=mysqli_query($conex,$sql);
		}else if($tipoIcon==2){
			$new=('Icon.'.$extension);
			$ruta=$directorio.'/'.$new;
			move_uploaded_file($temporal,$directorio.'/'.$new);
			$sql="UPDATE logos SET imagenes_ruta='$ruta', nombre_imagen='$new' WHERE id_logos='$tipoIcon'";
			$resultad=mysqli_query($conex,$sql);
		}else if($tipoIcon==3){
			$new=('PDF.'.$extension);
			$ruta=$directorio.'/'.$new;
			move_uploaded_file($temporal,$directorio.'/'.$new);
			$sql="UPDATE logos SET imagenes_ruta='$ruta', nombre_imagen='$new' WHERE id_logos='$tipoIcon'";
			$resultad=mysqli_query($conex,$sql);
		}
		
		header("location:../cargarLogos.php");

}
?>