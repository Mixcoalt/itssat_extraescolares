<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=4){
		header("location:../../index.php");
		exit;
		}else{
			$fechaGuardada=$_SESSION['ultimoAcceso'];
			$ahora=date('Y-n-j H:i:s');
			$tiempo_transcurrido=(strtotime($ahora)-strtotime($fechaGuardada));
			if($tiempo_transcurrido>=2400){
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
	include("../../Php/conexion.php");
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
	$sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'";
	$promotorQuery=mysqli_query($conex,$sqlPromotor);
	$promotorArray=mysqli_fetch_array($promotorQuery);
	
		echo '<li class="menu__item container-submenu">
				<a href="#" class="menu__link submenu-btn">Catálogo <i class="fas fa-caret-down"></i></a>
					<ul class="submenu">';
				if ($promotorArray['p1']==1){
					echo '<li class="menu__item"><a href="horarioscolab.php" class="menu__link">Horarios de grupos</a></li>';
				}
				if ($promotorArray['p5']==1){
					echo '<li class="menu__item"><a href="listas.php" class="menu__link">Listas</a></li>';
				}
		echo '</ul>
			</li>';
		
		if ($promotorArray['p2']==1){ echo '
			<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Registro <i class="fas fa-caret-down"></i></a>
				<ul class="submenu">
				<li class="menu__item"><a href="registrohora.php" class="menu__link">Registrar grupos</a></li>
				<li class="menu__item"><a href="editarhora.php" class="menu__link">Editar grupos</a></li>
				</ul>
			</li>';
		}
		
		echo '
			<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes </a>
				<ul class="submenu">';
				if ($promotorArray['p3']==1){
					echo '<li class="menu__item"><a href="reportecolab.php" class="menu__link">Alumnos</a></li>';
				}
				if ($promotorArray['p4']==1){
					echo '<li class="menu__item"><a href="reportecolabMOOCS.php" class="menu__link">Taller MOOCS</a></li>';
				}
		echo '</ul> 
			</li>';
		?>
		
		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Configuracion <i class="fas fa-caret-down"></i></a>
				<ul class="submenu">
				<li class="menu__item"><a href="contracolab.php" class="menu__link">Cambiar contraseña</a></li>
				</ul>
		</li>
		
		<li class="menu__item"><a href="../../Php/cerrarSesion.php" class="menu__link">Cerrar Sesión</a></li>
	</ul>
	</nav>

<script>
	function mensajes(){
			var respuesta = confirm("¿Desea editar?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
</script>

<body>
<center>

<?php
		include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		$id_calificaciones=$_GET['id'];
		$operacion=$_GET['operacion'];
?>

<div id="main-container">


<Form method="post">
	<center> <h2>Editar calificación</h2>
	<table>
		<thead>
		<tr >
			<th>Cal 1</th>
			<th>Cal 2</th>
			<th>Cal 3</th>
			<th>Promedio</th>
		</tr>
		</thead>
		<?php	
		if($operacion==2){
			$sql1="SELECT * FROM actividadalumnoavanzado WHERE id_actividadAlumnoAvanzado='$id_calificaciones'"; //Consulta
			$resultado1=mysqli_query($conex,$sql1);
			$row=mysqli_fetch_array($resultado1);
				echo '<tr>
						<td><input type="text" id="cal1" name="cal1" size="8" maxlength="10" placeholder="cal1" value='.$row['c1'].'></td>
						<td><input type="text" id="cal2" name="cal2" size="8" maxlength="10" placeholder="cal2" value='.$row['c2'].'></td>
						<td><input type="text" id="cal3" name="cal3" size="8" maxlength="10" placeholder="cal3" value='.$row['c3'].'></td>
						<td>'.$row['p'].'</td>
					</tr>';
				?>
			</table>
			<br>
			<button class="boton" type="submit" name="calAlumno" id="calAlumno" onclick="return mensajes()" >Actualizar</button>
		<?php 
			}else{
			$sql1="SELECT * FROM calificacionesalumno WHERE idCalificaciones='$id_calificaciones'"; //Consulta
			$resultado1=mysqli_query($conex,$sql1);
			$row=mysqli_fetch_array($resultado1); 
			
			echo '<tr>
				<td><input type="text" id="cal1" name="cal1" size="8" maxlength="10" placeholder="cal1" value='.$row['calificacionUno'].'></td>
				<td><input type="text" id="cal2" name="cal2" size="8" maxlength="10" placeholder="cal2" value='.$row['calificacionDos'].'></td>
				<td><input type="text" id="cal3" name="cal3" size="8" maxlength="10" placeholder="cal3" value='.$row['calificacionTres'].'></td>
				<td>'.$row['promedio'].'</td>
			</tr>';
		?>
	</table>
	<br>
	<button class="boton" type="submit" name="calAlumnoNor" id="calAlumnoNor" onclick="return mensajes()" >Actualizar</button>
	<?php } ?>
</form>

	<script src="../../js/menu.js"></script>
</body>		
</html>

<?php
	if(isset($_POST['calAlumnoNor'])){
		if(empty($_POST['cal1'])){ 
			$cal1="";
		}else{ 
			$cal1=$_POST['cal1']; 
			$promedio=$cal1;
		}
		
		if(empty($_POST['cal2'])){ 
			$cal2="";
		}else{ 
			$cal2=$_POST['cal2']; 
			$promedio=($cal1+$cal2)/2;
		}
		
		if(empty($_POST['cal3'])){ 
			$cal3="";
		}else{ 
			$cal3=$_POST['cal3'];
			$promedio=($cal1+$cal2+$cal3)/3;
		}
		
		$actualizar="UPDATE calificacionesalumno SET calificacionUno='$cal1',calificacionDos='$cal2',calificacionTres='$cal3', promedio='$promedio' WHERE idCalificaciones='$id_calificaciones'";
		$resultado=mysqli_query($conex,$actualizar);
		header("location:reportecolab.php");
	}
	if(isset($_POST['calAlumno'])){
		if(empty($_POST['cal1'])){ 
			$cal1="";
		}else{ 
			$cal1=$_POST['cal1']; 
			$promedio=$cal1;
		}
		
		if(empty($_POST['cal2'])){ 
			$cal2="";
		}else{ 
			$cal2=$_POST['cal2']; 
			$promedio=($cal1+$cal2)/2;
		}
		
		if(empty($_POST['cal3'])){ 
			$cal3="";
		}else{ 
			$cal3=$_POST['cal3'];
			$promedio=($cal1+$cal2+$cal3)/3;
		}
		
		$actualizar="UPDATE actividadalumnoavanzado SET c1='$cal1',c2='$cal2',c3='$cal3', p='$promedio' WHERE id_actividadAlumnoAvanzado='$id_calificaciones'";
		$resultado=mysqli_query($conex,$actualizar);
		header("location:reportecolabMOOCS.php");
	}	
	
?>