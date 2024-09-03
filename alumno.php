<?php
	session_start();
	include ("Php/conexion.php");
	$sql="SELECT * FROM logos WHERE id_logos=2";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"> 
<title>Extraescolares </title>


<link rel="icon" type="image/ico" href="<?php echo ('Imagen/'.$fila['nombre_imagen']);?>">

<?php }?>
<link rel="stylesheet" type="text/css" href="Css/style.css" />




<head/>

<body align="center">

<script type="text/javascript">

document.oncontextmenu = function(){return false;}

</script>
<div class="encabezado" align="center">
<?php

	$sql="SELECT * FROM logos WHERE id_logos=1";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>
<img src="<?php echo ('Imagen/'.$fila['nombre_imagen']);?>" alt="Imagen" title="Logos" align="center"/>
<?php
}
?>
</div>
<center>
<h1> DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES</h1>
<h1 style="color: red;">Tu número de control no se encuentra</h1>
<h1>Envia los siguientes datos:</h1>
<table style="text-align: left;">
<tr><td>
<li>Número de control.</li>
<li>Nombre completo (apellido paterno, materno y nombre(s)).</li>
<li>Sexo(H/M)</li>
<li>Curp</li>
<li>Carrera</li>
<li>Semestre</li></td>
</tr>
</table>
</center>
<h3>al correo: <p style="color: blue;">oficina_extraescolares@itssat.edu.mx<p></h3>
<h2 style="color: red;">Verifica tus datos antes de enviar la siguiente información:</h2>

</body>		
</html>

<?php
	if(session_destroy()){
		exit();	
	}
?>