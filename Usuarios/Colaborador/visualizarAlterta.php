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
			$fechaGuardada = $_SESSION['ultimoAcceso'];
			$ahora = date ('Y-n-j H:i:s');
			$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
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



<?php
	$idAlumno = $_GET['id'];
	$perioso =$_SESSION['perioso']; 
	$sql1="SELECT * FROM actividadalumno,dalumn WHERE Id_NumControlAlumno='$idAlumno' AND aluctr='$idAlumno' AND PeriodoExtraescolarId='$perioso'";
	$query = mysqli_query($conex,$sql1);
	$counter = mysqli_num_rows($query);
	$ver = mysqli_fetch_array($query);	
?>
<center><h1> <?php echo $ver['alunom'].' '.$ver['aluapp'].' '.$ver['aluapm']?> </h1>
<button class="boton"><a class="boton" href="reportecolab.php?>">Regresar</a></button>
</br></br>
<table>
<thead>
<tr>
	<th>Programa de atención al alumno</th>
	<th>Si</th>
	<th>No</th>
</tr>
</thead>
<!CODIGO PARA MOSTRAR LOS USUARIOS EN LA TABLA>
	<tr>
		<td>¿Te han diagnosticado algún problema cardiaco?</td>
		<?php if ($ver['preg1']==''){
				echo '<td><input type="radio" name="preg1" value="Si"></input></td>
					<td><input type="radio" name="preg1" value="No"></input></td>';
			}else{
				if ($ver['preg1']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
	<tr>
		<td>¿Tienes dolores en el corazón o pecho con frecuencia y sin causa aparente?</td>
		<?php if ($ver['preg2']==''){
				echo '<td><input type="radio" name="preg2" value="Si"></input></td>
					<td><input type="radio" name="preg2" value="No"></input></td>';
			}else{
				if ($ver['preg2']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
	<tr>
		<td>¿Sueles sentirte cansado(a), con mareos frecuentes o haber perdido el conocimiento sin ninguna causa aparente?</td>
		<?php if ($ver['preg3']==''){
				echo '<td><input type="radio" name="preg3" value="Si"></input></td>
					<td><input type="radio" name="preg3" value="No"></input></td>';
			}else{
				if ($ver['preg3']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
	<tr>
		<td>¿Tienes dolores en los huesos o articulaciones por cirugía, artritis u otras causas que te afecten con cualquier movimiento o ejercicio?</td>
		<?php if ($ver['preg4']==''){
				echo '<td><input type="radio" name="preg4" value="Si"></input></td>
						<td><input type="radio" name="preg4" value="No"></input></td>';
			}else{
				if ($ver['preg4']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
	<tr>
		<td>¿Tomas algún medicamento por enfermedad crónica?</td>
		<?php if ($ver['preg5']==''){
				echo '<td><input type="radio" name="preg5" value="Si"></input></td>
					<td><input type="radio" name="preg5" value="No"></input></td>';
			}else{
				if ($ver['preg5']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
	<tr>
		<td>¿Existen alguna actividad no mencionada aquí por la cual no deberías hacer actividad deportiva o cultural?</td>
		<?php if ($ver['preg6']==''){
				echo '<td><input type="radio" name="preg6" value="Si"></input></td>
					<td><input type="radio" name="preg6" value="No"></input></td>';
			}else{
				if ($ver['preg6']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	
</table>
</center>
<script src="../../js/menu.js"></script>
</body>		
</html>