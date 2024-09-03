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
	function imprimir(){
			var respuesta = confirm("¿Desea imprimir?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
	}
		
	function mensajes(){
			var respuesta = confirm("¿Desea enviar?");
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
			<a href="#" class="menu__link submenu-btn">Catalogo <i class="fas fa-caret-down"></i></a>
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



<?php
include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
	
	$ActividadDocente=$_SESSION['id_Actividad'];
	$periodo=$_SESSION['perioso']; 
	
	$idAlumno=$_GET['id'];
	$periodoAlumno=$_GET['periodo'];
	
	$sql1="SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$idAlumno' AND periodoCalificacionesExtraescolar='$periodoAlumno'";
	$query=mysqli_query($conex,$sql1);
	$ver=mysqli_fetch_array($query);	
		error_reporting(0);
?>

<div id="main-container">
<form action="php/evaluarAlumno.php?id=<?php echo $ver['idCalificaciones']?>" method="post">
<center>
<h2>Evaluación alumno</h2>
<table> 
			<?php
				
					echo ' <button class="boton" type="submit" name="imprimir" id="imprimir" onclick="return imprimir()">Imprimir </button>';
						
			?>
			<button class="boton" type="submit" name="regresar" id="regresar"> Regresar </button>
			
			<br></br>
				<thead>
			<tr>
					<th rowspan="2">No. </th>
					<th rowspan="2">Criterios a evaluar:</th>
					<th colspan="5">Nivel de desempeño del criterio(4): </th>
				
			</tr>
			<tr>
				<td class="negritas">Insuficiente </td>
				<td class="negritas">Suficiente </td>
				<td class="negritas">Bueno </td>
				<td class="negritas">Notable </td>
				<td class="negritas">Excelente </td>
			</tr>
				</thead>
				
			<tr>
				<td>1</td>
				<td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>
			<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
			?>
			</tr>
			<tr>
				<td>2</td>
				<td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
			?>
			</tr>
			<tr>
				<td>3</td>
				<td>Muestra liderazgo en las actividades encomendadas.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
				?>
			</tr>
			<tr>
				<td>4</td>
				<td>Organiza su tiempo y trabaja de manera proactiva.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>5</td>
				<td>Interpreta la realidad y se Sensibiliza aportando soluciones a la problemática con la actividad. </td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>6</td>
				<td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>7</td>
				<td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td colspan="2"> 
					Observaciones: <br><br>
				</td>
				<td colspan="5">
					<?php
						echo $ver['observaciones'];
					?>
				</td>
			</tr>
			<?php
					if ($ver['valorNumerico']!=''){
					echo '
						<tr>
							<td colspan="2"> 
							Valor numérico de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['valorNumerico'].'</td>
						</tr>
						<tr>
							<td colspan="2"> 
								Nivel de desempeño alcanzado de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['nivelDesempeño'].'</td>
						</tr>';
					}
			?>
		</table>
</center>
</form>


<script src="../../js/menu.js"></script>
</body>		
</html>