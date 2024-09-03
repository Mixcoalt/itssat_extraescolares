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
<center>
<div id="main-container">


<h2>Buscar Alumno</h2>

<form method="post" >
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
		<tr> 
	<td>
      <input name="PalabraClave" type="text" class="form-control mb-2"  placeholder="Ingrese numero de control">  
	  </td>
	 <td>
	  <button class="boton" type="submit" name="Ingresar" id="Ingresar" class="btn btn-success mb-2">Buscar Ahora</button>
	  </td>
	  </tr>
    </div>
	</div>
	</table>
</form>
<button class="boton"><a class="boton" href="agregarAlumno.php">Regresar</a></button>
 <script src="../../js/menu.js"></script>
</body>		
</html>


<?php
if(isset($_POST['Ingresar'])){
	$numControl=$_POST['PalabraClave'];
	$consultaAlumno="SELECT aluctr,aluapp,aluapm,alunom,alucur FROM dalumn WHERE aluctr='$numControl'";
	$queryAlumno=mysqli_query($conex,$consultaAlumno);
	$mostrarAlumno=mysqli_fetch_array($queryAlumno);
?>
<form method="post" onsubmit="return validarFormulario()">
<thead><h2>Datos del alumno</h2></thead>


<table>
<tr height="50">
<td>Número de control:</td>
<td><?php echo ($mostrarAlumno['aluctr']) ?></td>
</tr>

<tr height="50">
<td>
	<label/> Nombre:
	<br></br>
	<td><?php echo ($mostrarAlumno['alunom'].' '.$mostrarAlumno['aluapm'].' '.$mostrarAlumno['aluapp']) ?></td>
</td>
</tr>

<tr height="50">
<td>CURP:</td>
<td><?php echo ($mostrarAlumno['alucur']) ?> </td>
</tr>
</center>
</table>
<button class="boton"><a class="boton" href="php/editarCURP.php?id=<?php echo $mostrarAlumno['aluctr']?>"> Editar CURP</a></button>
</form>

<?php	
}
?>