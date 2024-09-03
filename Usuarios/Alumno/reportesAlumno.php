<?php
session_start();
	session_id();
	if(!isset($_SESSION['login'])){
		header("location:../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=2){
		header("location:../../index.php");
		exit;
		}else{
			$fechaGuardada=$_SESSION['ultimoAcceso'];
			$ahora=date('Y-n-j H:i:s');
			$tiempo_transcurrido=(strtotime($ahora)-strtotime($fechaGuardada));
			if($tiempo_transcurrido>=1200){
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

<body>

<script type="text/javascript">
document.oncontextmenu = function(){return false;}
</script>


<div class="encabezado" align="center">
<?php

	$sql="SELECT * FROM logos WHERE id_logos=1";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>
<img src="<?php echo ('../../Imagen/'.$fila['nombre_imagen']);?>" alt="Imagen" title="Logos" align="center"/>
<?php
}
?></div>

<span class="nav-bar" id="btnMenu"><i class="fas fa-bars"></i> Menú</span>
	<nav class="main-nav">
<?php 
$id_alumno=$_SESSION['login'];
$perioso=$_SESSION['perioso'];

$sqlAlumnoA="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$id_alumno' AND periodoAlumnoAvanzado='$perioso'";
$alumnoQueryA=mysqli_query($conex,$sqlAlumnoA);
$alumnoArrayA=mysqli_fetch_array($alumnoQueryA);

$sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'";
$alumnoQuery=mysqli_query($conex,$sqlAlumno);
$alumnoArray=mysqli_fetch_array($alumnoQuery);
?>
	<ul class="menu" id="menu">
		<?php 
			if ($alumnoArray['p1']==1){ echo '
				<li class="menu__item container-submenu">
					<a href="#" class="menu__link submenu-btn">Catalogo <i class="fas fa-caret-down"></i></a>
						<ul class="submenu">
						<li class="menu__item"><a href="horarios.php" class="menu__link">Horarios de Grupos</a></li>
						</ul>
				</li>'; 
			} else{ echo (""); }
			
		if ($alumnoArray['p2']==1 OR $alumnoArrayA['estatusAvanzado']=='Aceptado'){ echo '
				<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Registro <i class="fas fa-caret-down"></i></a>
					<ul class="submenu"><li><a href="registrodoc.php" class="menu__link">Registrar datos</a></li>
					</ul>
				</li>';
			}else{ echo (""); }
			
			if ($alumnoArray['p3']==1){ echo '
				<li class="menu__item"><a href="reportesAlumno.php" class="menu__link">Reportes </a></li>';
			}else{ echo (""); }	

		?>
		<li class="menu__item"><a href="../../Php/cerrarSesion.php" class="menu__link">Cerrar Sesión</a></li>
	</ul>
	</nav>

	<div id="main-container">
<?php
	include("../../Php/conexion.php"); 
	
	$consulta="SELECT * FROM actividadalumno WHERE Id_NumControlAlumno='$id_alumno'"; //Consulta
	$resultado=mysqli_query($conex,$consulta);
	$count=mysqli_num_rows($resultado);
	if($count!=0){
	$consulta="SELECT * FROM actividadalumno,actividadesextraescolares WHERE IdActE=actividadE AND Id_NumControlAlumno='$id_alumno' AND PeriodoExtraescolarId='$perioso'"; //Consulta
	$resultado=mysqli_query($conex,$consulta);

	while($mostrar=mysqli_fetch_assoc($resultado)){
			
?>	
	<table>
		<thead><h2>Resultado</h2></thead>
		<td>Estatus:</td>
		<td><input style="color:red;" type="text" id="nombre" name="nombre" size="50" maxlength="50" value="<?php  echo ($mostrar['Estatus']); if ($mostrar['Estatus']=='Negado'){ echo ('--'.$mostrar['observacionAlumno']); };?>" readonly></td>
		</tr>
	</table>
<?php } mysqli_free_result($resultado); //Cierre del While ?> 
	</br>
	
	<table>
		<thead> <h2>Historial</h2>
		<tr>
			<th>Actividad</th>
			<th>Calificación</th>
		</tr>
		</thead>
		<?php 
			$consulta="SELECT * FROM actividadalumno,actividadesextraescolares,calificacionesalumno WHERE IdActE=actividadE AND  Estatus='Aceptado' AND Id_NumeroControl='$id_alumno' AND Id_ElegidaActividadAlumno=Id_actividadAlumno"; //Consulta
			$resultado = mysqli_query($conex,$consulta);
			while($mostrar=mysqli_fetch_assoc($resultado)){
					
		?>		<tr>
				<td><?php echo $mostrar['nombreActividad'];?></td>
				<td><?php if($mostrar['promedio']==0){
						echo ('N/A');
							}else{
							echo($mostrar['promedio']);	
						}?>
				</td>
				</tr>
			<?php } mysqli_free_result($resultado); //Cierre del While ?> 
	</table>
	</br></br>
<?php }?>	
	
	<?php
	$consulta="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$id_alumno'"; //Consulta
	$resultado=mysqli_query($conex,$consulta);
	$count=mysqli_num_rows($resultado);
	
	if($count!=0){
	$consulta="SELECT * FROM actividadalumnoavanzado,actividadesextraescolares WHERE IdActE=actividadAvanzado AND Id_ctrAlumno='$id_alumno' AND periodoAlumnoAvanzado='$perioso'"; //Consulta
	$resultado=mysqli_query($conex,$consulta);
	$count=mysqli_num_rows($resultado);
	while($mostrar=mysqli_fetch_assoc($resultado)){
			
?>	
	<table>
		<thead><h2>Resultado MOOCS</h2></thead>
		<td>Estatus:</td>
		<td><input style="color:red;" type="text" id="nombre" name="nombre" size="50" maxlength="50" value="<?php  echo $mostrar['estatusAvanzado'];?>" readonly></td>
		</tr>
	</table>
<?php } mysqli_free_result($resultado); //Cierre del While ?> 
	</br>
	
	<table>
		<thead> <h2>Historial MOOCS</h2>
		<tr>
			<th>Actividad</th>
			<th>Calificación</th>
		</tr>
		</thead>
		<?php 
			$consulta="SELECT * FROM actividadalumnoavanzado,actividadesextraescolares WHERE IdActE=actividadAvanzado AND  estatusAvanzado='Aceptado' AND Id_ctrAlumno='$id_alumno'"; //Consulta
			$resultado=mysqli_query($conex,$consulta);
			while($mostrar=mysqli_fetch_assoc($resultado)){
					
		?>		<tr>
				<td><?php echo $mostrar['nombreActividad'];?></td>
				<td><?php if($mostrar['p']==0){
						echo('N/A');
							}else{
							echo($mostrar['p']);	
						}?>
				</td>
				</tr>
			<?php } mysqli_free_result($resultado); //Cierre del While ?> 
	</table>
	<?php } ?>
	
	<script src="../../js/menu.js"></script>
</body>		
</html>