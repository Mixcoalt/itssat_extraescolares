
<?php
	include("conexion.php");
	//include("../Php/inicioSesion.php");
	if(isset($_POST['Actualizar'])){
		$id= $_GET['id'];
		echo($id);
		
		$contrasena = $_POST['contrasena'];
		$contrasena2 = $_POST['contrasena2'];
		echo($contrasena2);			
		if($contrasena == $contrasena2 ){
			$contra = sha1($contrasena);
			$consulta = "UPDATE usuarios SET contrasena = '$contra' WHERE Id='$id'";
			echo ($consulta);
			$resultado = mysqli_query($conex,$consulta);
		}
		header("location:../index.php");		
	}
?>
