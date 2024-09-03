<?php
	include("../../../Php/conexion.php");
	$id=$_GET['id'];
		$estatusGrupo="Activo";
		$consulta="UPDATE grupos SET estatusGrupo='$estatusGrupo' WHERE Id_Grupos='$id'";
		$resultado=mysqli_query($conex,$consulta);
		header("location:../escolarizado.php");
?>