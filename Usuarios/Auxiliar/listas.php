<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=3){
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
			var respuesta = confirm("¿Desea imprimir?");
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
		
<?php
$sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'";
$auxiliarQuery=mysqli_query($conex,$sqlAuxiliar);
$auxiliarArray=mysqli_fetch_array($auxiliarQuery);

		echo '<li class="menu__item container-submenu">
		<a href="#" class="menu__link submenu-btn">Catalogo <i class="fas fa-caret-down"></i></a>
				<ul class="submenu">';
				if ($auxiliarArray['p1']==1){ echo '<li class="menu__item"><a href="alumnos.php" class="menu__link">Alumnos</a></li>';}
				if ($auxiliarArray['p2']==1){ echo '<li class="menu__item"><a href="alumnoIrregulares.php" class="menu__link">Alumnos Irregulares</a></li>';}
				if ($auxiliarArray['p3']==1){ echo '<li class="menu__item"><a href="escolarizado.php" class="menu__link">Grupos Escolarizado</a></li>';}
				if ($auxiliarArray['p4']==1){ echo ' <li class="menu__item"><a href="semi.php" class="menu__link">Grupos SemiEscolarizado</a></li>';}
				echo '</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Registro <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">';
			if ($auxiliarArray['p5']==1){ echo '<li class="menu__item"><a href="registrousuarios.php" class="menu__link">Registrar nuevo usuario</a></li>';}
			if ($auxiliarArray['p6']==1){ echo '<li class="menu__item"><a href="registroPeriodo.php" class="menu__link">Registrar periodo escolar</a></li>';}
			if ($auxiliarArray['p7']==1){ echo '<li class="menu__item"><a href="registroPromotoria.php" class="menu__link">Registrar promotoria</a></li>';}
			if ($auxiliarArray['p8']==1){ echo '<li class="menu__item"><a href="registroCalificaciones.php" class="menu__link">Registrar fecha de parcial</a></li>';}
			if ($auxiliarArray['aC']==1){ echo '<li class="menu__item"><a href="agregarAlumno.php" class="menu__link">Registrar nuevo alumno</a></li>';}
			echo '</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">';
			if ($auxiliarArray['p9']==1){ echo '<li class="menu__item"><a href="estadisticas.php" class="menu__link">Documentos</a></li>';}
			echo '</ul>
		</li>
		
		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Configuracion <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">
			<li class="menu__item"><a href="contra.php" class="menu__link">Cambiar contraseña</a></li>';
			if ($auxiliarArray['p0']==1){ echo '<li class="menu__item"><a href="cargarLogos.php" class="menu__link">Cambiar logos</a></li>';}
			if ($auxiliarArray['AD1']==1){ echo '<li class="menu__item"><a href="exportacionSQL.php" class="menu__link">Base de datos</a></li>';}
			if ($auxiliarArray['aM']==1){ echo '<li class="menu__item"><a href="privilegios.php" class="menu__link">Asignar privilegios</a></li>';}
			echo '</ul>
		</li>';

		
?>
	<li class="menu__item"><a href="../../Php/cerrarSesion.php" class="menu__link">Cerrar Sesión</a></li>
	</ul>
	</nav>


<?php
if(isset($_POST['Listas'])){
	$numPeriodo=$_POST['numPeriodo'];
	$numControlDocente=$_POST['numControlDocente'];
?>

<form action="php/redireccionamiento.php" method="POST">
	<div id="main-container">
	<center>
	<h2>Visualizar documentos</h2>
	<table width=800 style = "text-align: center;";>
		<thead>
			<tr>
				<th colspan="5" rowspan="2">Seleccionar grupo y operación a realizar</th>
			</tr>
		</thead>
			
			<tr>
				<td>
					  <?php
						$sql="SELECT * FROM docenteextraescolares WHERE id_Actividad='$numControlDocente'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						$mostrar=mysqli_fetch_array($resultado1);
						$idDocente=$mostrar['numControlDocente'];
							echo ($mostrar['nombre_Docente'].' '.$mostrar['apellidoPDocente'].' '.$mostrar['apellidoMDocente'])
						?> 
				</td>
					
				<td><select id="idGrupos" name="idGrupos" >
					  <?php
						$sql="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$idDocente' AND IdPeriodoExtraGrupos='$numPeriodo' AND estatusGrupo='Activo'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						while($mostrar=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
						?>
						 <option value="<?php echo $mostrar['Id_Grupos']?>">
								<?php echo ($mostrar['numeroGrupo'].' --- '.$mostrar['nombreGrupo'])?>
						 </option>
						<?php
						} mysqli_free_result($resultado1); //Cierre del While ?> 
				</select></td>
					
				<td><select id="operacion" name="operacion">
						<option value="1">Listas</option>
						<option value="2">Calificaciones</option>
						<option value="3">Cedula Inscripción</option>
						<option value="4">Cedula Resultado</option>	 
				</select></td>
					<td><button class="boton" type="submit" name="Visualizar" id="Visualizar">Visualizar</button> </td>
				</tr>
	</table>	
	</center>
</form>


<br></br>
<form action="php/imprimirDoc.php" method="POST">
	<div id="main-container">
	<center> 
	<h2>Imprimir documentos</h2>
	<table width=800 style = "text-align: center;";>
		<thead>
			<tr>
				<th colspan="5" rowspan="2">Seleccionar grupo y operación a realizar</th>
			</tr>
		</thead>
			
			<tr>
				<td>
					  <?php
						$sql="SELECT * FROM docenteextraescolares WHERE id_Actividad='$numControlDocente'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						$mostrar=mysqli_fetch_array($resultado1);
						$idDocente=$mostrar['numControlDocente'];
							echo ($mostrar['nombre_Docente'].' '.$mostrar['apellidoPDocente'].' '.$mostrar['apellidoMDocente'])
						?> 
				</td>
					
				<td><select id="idGrupos" name="idGrupos" >
					  <?php
						$sql="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$idDocente' AND IdPeriodoExtraGrupos='$numPeriodo' AND estatusGrupo='Activo'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						while($mostrar=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
						?>
						 <option value="<?php echo $mostrar['Id_Grupos']?>">
								<?php echo ($mostrar['numeroGrupo'].' --- '.$mostrar['nombreGrupo'])?>
						 </option>
						<?php
						} mysqli_free_result($resultado1); //Cierre del While ?> 
				</select></td>
					
				<td><select id="operacion" name="operacion">
						<option value="1">Listas</option>
						<option value="2">Calificaciones</option>
						<option value="3">Cedula Inscripción</option>
						<option value="4">Cedula Resultado</option>	 
				</select></td>
					<td><button class="boton" type="submit" name="Imprimir" id="Imprimir" onclick="return mensajes()">Imprimir</button> </td>
				</tr>
	</table>	
	</center>
</form>


<?php } ?>

<script src="../../js/menu.js"></script>
</body>		
</html>

