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
		}else{
			$fechaGuardada=$_SESSION['ultimoAcceso'];
			$ahora=date('Y-n-j H:i:s');
			$tiempo_transcurrido=(strtotime($ahora)-strtotime($fechaGuardada));
			if($tiempo_transcurrido>=4800){
				session_destroy();
				header("location:../../index.php");
			}else{
				$_SESSION['ultimoAcceso']=$ahora;
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
<title>Extraescolares </title>
<?php
	date_default_timezone_set("America/Mexico_City");
	include ("../../Php/conexion.php");
	$sql="SELECT * FROM logos WHERE id_logos=2";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>

<link rel="icon" type="image/ico" href="<?php echo ('../../Imagen/'.$fila['nombre_imagen']);?>">

<?php }?>

<link rel="stylesheet" type="text/css" href="../../Css/style.css" />
<link rel="stylesheet" type="text/css" href="../../Css/tablas.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<head/>

<script>
		function validarFormulario(){
			var varContra = document.getElementById('contrasena').value;
			var VarLogin = document.getElementById('login').value;
			
			
			if(!(/^\S{1,10}$/.test(VarLogin)) ) {
				alert('Login: Es mayor de 10 caracteres');
				  return false;
			}
			if(!(/^\S{1,10}$/.test(varContra)) ) {
				alert('Contraseña: Es mayor de 10 caracteres');
				  return false;
			}
		}
		
		
		function mensajes(){
			var respuesta = confirm("¿Desea agregar?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
		
		function eliminar(){
			var respuesta = confirm("¿Desea eliminar?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
		
		
		
</script>

<body>
<div class="encabezado" align="center">
<?php

	$sql="SELECT * FROM logos WHERE id_logos=1";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>
<img src="<?php echo ('../../Imagen/'.$fila['nombre_imagen']);?>" alt="Imagen" title="Logos" align="center"/>
<?php
}
?>
</div>

<span class="nav-bar" id="btnMenu"><i class="fas fa-bars"></i> Menú</span>
	<nav class="main-nav">
	<ul class="menu" id="menu">
		<li class="menu__item container-submenu">
			<a href="#" class="menu__link submenu-btn">Catálogo <i class="fas fa-caret-down"></i></a>
				<ul class="submenu">
				<li class="menu__item"><a href="alumnos.php" class="menu__link">Alumnos</a></li>
				<li class="menu__item"><a href="alumnoIrregulares.php" class="menu__link">Alumnos Irregulares</a></li>
				<li class="menu__item"><a href="escolarizado.php" class="menu__link">Grupos Escolarizado</a></li>
				<li class="menu__item"><a href="semi.php" class="menu__link">Grupos SemiEscolarizado</a></li>	
				</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Registro <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">
			<li class="menu__item"><a href="registrousuarios.php" class="menu__link">Registrar nuevo usuario</a></li>
			<li class="menu__item"><a href="registroPeriodo.php" class="menu__link">Registrar periodo escolar</a></li>
			<li class="menu__item"><a href="registroPromotoria.php" class="menu__link">Registrar promotoria</a></li>
			<li class="menu__item"><a href="registroCalificaciones.php" class="menu__link">Registrar fecha de parcial</a></li>
			<li class="menu__item"><a href="agregarAlumno.php" class="menu__link">Registrar nuevo alumno</a></li>
			</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">
			<li class="menu__item"><a href="estadisticas.php" class="menu__link">Documentos</a></li>
			</ul>
		</li>
		
		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Configuracion <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">
			<li class="menu__item"><a href="contra.php" class="menu__link">Cambiar contraseña</a></li>
			<li class="menu__item"><a href="cargarLogos.php" class="menu__link">Cambiar logos</a></li>
			<li class="menu__item"><a href="exportacionSQL.php" class="menu__link">Base de datos</a></li>
			<li class="menu__item"><a href="privilegios.php" class="menu__link">Asignar privilegios</a></li>
			</ul>
		</li>

		<li class="menu__item"><a href="../../Php/cerrarSesion.php" class="menu__link">Cerrar Sesión</a></li>
	</ul>
	</nav>

<!form action="php/registroUsuarios.php" method="post" onsubmit="return validarFormulario()">
<?php 
	setlocale(LC_TIME,"es_MX.UTF-8");

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=1";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
?>
<form method="post" onsubmit="return validarFormulario()">
<center>

<h2>Registro fechas de calificaciones</h2>
<table style="text-align: center;">
<thead>
<tr>
	<td>Parcial</td>
	<td  colspan="2">Fecha - Hora</td>
	<td></td>
</tr>
</thead>
<tr>
	<td> 1</td >
	<td><input type="datetime-local" name="fechaCa1" id="fechaCa1"></td>
	<td><?php if($rowQuey['fechaC1']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey['fechaC1'])));}else{echo('');} ?></td>
	<td><button class="boton" type="submit" name="C1" id="C1" onclick="return mensajes()">Registrar</button></td>
</tr>
<tr>
	<td>2</td>
	<td><input type="datetime-local" name="fechaCa2" id="fechaCa2"></td>
	<td><?php if($rowQuey['fechaC2']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey['fechaC2'])));}else{echo('');}?></td>
	<td><button class="boton" type="submit" name="C2" id="C2" onclick="return mensajes()">Registrar</button></td>
</tr>
<tr>
	<td>3</td >
	<td><input type="datetime-local" name="fechaCa3" id="fechaCa3"></td>
	<td><?php if($rowQuey['fechaC3']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey['fechaC3'])));}else{echo('');}?></td>
	<td><button class="boton" type="submit" name="C3" id="C3" onclick="return mensajes()">Registrar</button></td>
</tr>
</table>
</center>
<br></br>
<center>
<h2>Registro fechas de calificaciones MOOCS</h2>
<?php 
	$sql1="SELECT * FROM fechacalificacion WHERE idFechaCal=2";
	$query1=mysqli_query($conex,$sql1);
	$rowQuey1=mysqli_fetch_array($query1);
?>
<table style="text-align: center;">
<thead>
<tr>

	<td>Parcial</td>
	<td colspan="2">Fecha - Hora</td>
	<td></td>
</tr>
</thead>
<tr>
	<td> 1</td >
	<td><input type="datetime-local" name="fechaCa1A" id="fechaCa1A"></td>
	<td><?php if($rowQuey1['fechaC1']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey1['fechaC1'])));}else{echo('');} ?></td>
	<td><button class="boton" type="submit" name="C1A" id="C1A" onclick="return mensajes()">Registrar</button></td>
</tr>
<tr>
	<td>2</td>
	<td><input type="datetime-local" name="fechaCa2A" id="fechaCa2A"></td>
	<td><?php if($rowQuey1['fechaC2']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey1['fechaC2'])));}else{echo('');} ?></td>
	<td><button class="boton" type="submit" name="C2A" id="C2A" onclick="return mensajes()">Registrar</button></td>
</tr>
<tr>
	<td>3</td >
	<td><input type="datetime-local" name="fechaCa3A" id="fechaCa3A"></td>
	<td><?php if($rowQuey1['fechaC3']!=''){echo (strftime("%d de %B %Y - %r",strtotime($rowQuey1['fechaC3'])));}else{echo('');} ?></td>
	<td><button class="boton" type="submit" name="C3A" id="C3A" onclick="return mensajes()">Registrar</button></td>
</tr>
</table>
</form>
<br></br><br></br>
<script src="../../js/menu.js"></script>
</body>		
</html>
<?php
if(isset($_POST['C1'])){
	

	$fechaCa1=date('Y-m-d H:i:s',strtotime($_POST['fechaCa1']));
	//$ahora = date ('Y-m-d H:i:s');
	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=1";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	
		$sql="UPDATE fechacalificacion SET fechaC1='$fechaCa1' WHERE idFechaCal=1";
		$query=mysqli_query($conex,$sql);
}

if(isset($_POST['C2'])){
	$fechaCa2=date('Y-m-d H:i:s',strtotime($_POST['fechaCa2']));

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=1";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	

		$sql="UPDATE fechacalificacion SET fechaC2='$fechaCa2' WHERE idFechaCal=1";
		$query=mysqli_query($conex,$sql);


}
if(isset($_POST['C3'])){
	$fechaCa3=date('Y-m-d H:i:s',strtotime($_POST['fechaCa3']));

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=1";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	
		$sql="UPDATE fechacalificacion SET fechaC3='$fechaCa3' WHERE idFechaCal=1";
		$query=mysqli_query($conex,$sql);


}


if(isset($_POST['C1A'])){
	

	$fechaCa1=date('Y-m-d H:i:s',strtotime($_POST['fechaCa1A']));
	//$ahora = date ('Y-m-d H:i:s');

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=2";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	
	
		$sql="UPDATE fechacalificacion SET fechaC1='$fechaCa1' WHERE idFechaCal=2";
		$query=mysqli_query($conex,$sql);
	
}

if(isset($_POST['C2A'])){
	$fechaCa2=date('Y-m-d H:i:s',strtotime($_POST['fechaCa2A']));

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=2";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	
		$sql="UPDATE fechacalificacion SET fechaC2='$fechaCa2' WHERE idFechaCal=2";
		$query=mysqli_query($conex,$sql);
	

}
if(isset($_POST['C3A'])){
	$fechaCa3=date('Y-m-d H:i:s',strtotime($_POST['fechaCa3A']));

	$sql="SELECT * FROM fechacalificacion WHERE idFechaCal=2";
	$query=mysqli_query($conex,$sql);
	$rowQuey=mysqli_fetch_array($query);
	
		$sql="UPDATE fechacalificacion SET fechaC3='$fechaCa3' WHERE idFechaCal=2";
		$query=mysqli_query($conex,$sql);
	
}
?>
