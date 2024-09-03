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
<!link href="../../Css/bootstrap.min.css" rel="stylesheet">
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

<div id="main-container">
<br><br>
<?php
	$idAlumno=$_GET['id'];
	$periodo=$_SESSION['perioso']; 
?>
<center> 
	<a href="alumnoIrregulares.php"> Regresar</a></button>
	<form>	
		<table>
			<thead>
				<tr>
					<th>Nombre promotor</th>
					<th>Actividad</th>
					<th>Grupos</br>(Nombre - Grupo - Hora - Disponibles)</th>
				</tr>
			</thead>
			<?php 
				$sql="SELECT * FROM docenteextraescolares,actividadesextraescolares WHERE id_Actividad=IdActE";
				$querysql=mysqli_query($conex, $sql);
				while($datos=mysqli_fetch_assoc($querysql)){
						$numControlDocente=$datos['numControlDocente'];
						$IdActE=$datos['IdActE'];
					echo '<tr>
						<td>'.$datos['nombre_Docente'].' '.$datos['apellidoPDocente'].' '.$datos['apellidoMDocente'].'</td>
						<td>'.$datos['nombreActividad'].'</td><td>';
							$sqlG="SELECT * FROM grupos WHERE id_ActividadE='$IdActE' AND numControlDocenteExtraescolar='$numControlDocente' AND IdPeriodoExtraGrupos='$periodo' AND estatusGrupo='Activo'";
							$queryG=mysqli_query($conex, $sqlG);
							while($rowG=mysqli_fetch_assoc($queryG)){
							
								if($rowG['nombreGrupo']=="TALLER"  OR $rowG['nombreGrupo']=="taller" OR $rowG['nombreGrupo']=="Taller"){
									echo '<select name="actividadE">
										<option value="'.$rowG['Id_Grupos'].'">'.$rowG['nombreGrupo'].' ---- '.$rowG['numeroGrupo'].' ---- '.$rowG['horaGrupo'].' ---- '.$rowG['disponiblesGrupo'].'</option>';	
									echo '</select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
								?> <a href="php/promotoriaTaller.php?id=<?php echo $idAlumno?>&idG=<?php echo $rowG['Id_Grupos']?>">Elegir <?php echo'</a></td>';
								}
							}
					echo '</tr>';
				}mysqli_free_result($querysql);
		?>	
		</table>
	</form>
</center>

 <script src="../../js/menu.js"></script>
</body>		
</html>




