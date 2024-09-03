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
			$ahora=date ('Y-n-j H:i:s');
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

<form action="../../Php/modificarContraseña.php?id=<?php echo $_SESSION['id']?>" method="post" onsubmit="return validarFormulario()">
	<center>
	<table>
	<thead><h2>Nueva contraseña</h2></thead>
	<tr>
	<td>Usuario</td>
	<td><?php echo $_SESSION['login'];?></td><br>
	</tr>

	<tr>
	<td>Nueva contraseña</td>
	<td><input type="text" id="contrasena" name="contrasena" required="obligatorio" size="40" maxlength="30"/></td>
	</tr>

	<tr>
	<td>Confirmar nueva contraseña</td>
	<td><input type="text" id="contrasena2" name="contrasena2"  size="40" maxlength="30"></td><br>
	</tr>

	<tr>
	<td><button type="submit" name="Actualizar" id="Actualizar" onclick="return mensajes()">Actualizar</button></td>
	</tr>
	</table>
	</center>
</form >

<script src="../../js/menu.js"></script>
 
</body>		
</html>