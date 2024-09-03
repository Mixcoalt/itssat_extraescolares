<?php
	include ("Php/conexion.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"> 
<title>Extraescolares </title>

<link rel="icon" type="image/ico" href="../Imagen/Icon.png">
<link rel="stylesheet" type="text/css" href="../Css/style.css" />




<head/>

<body align="center">

<script type="text/javascript">

document.oncontextmenu = function(){return false;}

</script>
<div class="encabezado" align="center">


<img class="logo-feo" src="../Imagen/Header.jpg" alt="Imagen" title="Logos" align="center"/>


</div>

<h1> DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES</h1>
	<h2>INSCRIPCIÓN A ACTIVIDADES</h2>
		<h3> INICIO DE SESIÓN</h3>
		
<form action="../Php/login.php" method="POST">
	<br><p>Nombre de usuario<p><br>
	<input type="nombre" name="usuario" id="usuario" required="obligatorio" size="40" maxlength="30"><br>

	<br><p>Contraseña<p><br>
	<input type="password" name="contrasena" id="contrasena" required="obligatorio" size="40" maxlength="30"><br>

	<br><button class="boton" type="submit" name="enviar" id="enviar">Iniciar sesión</button><br>
</form>

</body>
</html>