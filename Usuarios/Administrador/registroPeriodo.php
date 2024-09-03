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

<form action="php/registroPeriodo.php" method="post">
<center>
<table>
<thead><h2>Registro de periodo escolar</h2></thead>
<tr>
	<td >
	<label/> Inicio:
	<td>
	<input type="month" name="idMesInicio" id="idMesInicio">
	</td>
</tr>

<tr>
	<td >
	<label/> Fin:
	<td>
	<input type="month" name="idMesFin" id="idMesFin">
	</td>
</tr>

	
</table>
<br>
	<td colspan="2"/><button class="boton" type="submit" name="Ingresar" id="Ingresar" onclick="return mensajes()">Ingresar</button></td>

<br></br>
<?php
		include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		
		
		
		$sql="SELECT * FROM periodosescolares ORDER BY idPeriodosEscolares DESC LIMIT 0,1"; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
			setlocale(LC_TIME,"es_MX.UTF-8");
				$anoInicio=strftime("%Y",strtotime($mostrar['FechaInicioExtraescolar']));
				$anoFin=strftime("%Y",strtotime($mostrar['FechaFinExtraescolar']));
				if($anoInicio==$anoFin){
?> 
	Periodo Actual: <?php echo strftime("%B",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" - ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));?>
<?php
	}else{
?>
	Periodo Actual: <?php echo strftime("%B %Y",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" - ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));?>
<?php
	}
 } mysqli_free_result($resultado);  
?> 


</form>

</br></br></br>
<table>
	<thead>
		<tr>
			<th>Periodo</th>
			<th></th>
		</tr>
	</thead>
	
		<!CONEXION A LA BASE DE DATOS Y CONSULTA PARA MOSTRAR LOS USUARIOS>
	<?php
		$sql="SELECT * FROM periodosescolares ORDER BY idPeriodosEscolares DESC"; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
			setlocale(LC_TIME,"es_ES.UTF-8");
				$anoInicio=strftime("%Y",strtotime($mostrar['FechaInicioExtraescolar']));
				$anoFin=strftime("%Y",strtotime($mostrar['FechaFinExtraescolar']));
	?>
	<tr>
		
		<td>
		<?php 
			if($anoInicio==$anoFin){
				echo strftime("%B",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" - ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));
			}else{
				echo strftime("%B %Y",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" - ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));
			}
		?> 
		</td>
		
		<td>
			<button class="boton" onclick="return eliminar()"><a class="boton" href="php/EliminarPeriodo.php?id=<?php echo $mostrar['idPeriodosEscolares']?>">Eliminar</a></button> 
			<button class="boton"><a class="boton" href="modicarPeriodo.php?id=<?php echo $mostrar['idPeriodosEscolares']?>"> Modificar</a></button>
		</td>
	</tr>
	<?php } mysqli_free_result($resultado); //Cierre del While ?> 
</table>

</center>

<script src="../../js/menu.js"></script>
</body>		
</html>