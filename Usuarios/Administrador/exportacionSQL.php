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
			var varControl = document.getElementById('numControl').value;
			var VarCurp = document.getElementById('curp').value;
			
			
			if(!(/^[A-Z0-9]{8}$/.test(varControl)) ) {
				alert('Verifique Num. Control ("U" mayúscula, 8 dígitos)');
				  return false;
			}
			if(!(/^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{2}$/.test(VarCurp))) {
				alert('Verifique curp(Mayúscula,números, 18 dígitos)');
				  return false;
			}
	}

	function mensajes(){
			var respuesta=confirm("Desea agregar?");
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



<center>
<thead><h2>Descarga de la Base de datos</h2></thead>
<table>
<thead>
<form action="php/descargaExcel.php" method="post" onsubmit="return validarFormulario()">
<tr>
<th colspan="1">Formato SQL</th>
<th colspan="2">EXCEL</th>
</tr>
</thead>
<tr>
<td><button class="boton"><a class="boton" href="php/exportacionSQL.php">Descargar (.sql)</a></button></td>
<td>
	<select id="opcion" name="opcion">
	<option value="1">Alumnos</option>
	<option value="2">Alumnos Avanzados</option>
	<option value="3">Grupos</option>
	<option value="4">Usuarios</option>		
	</select> </br></br>
</td>
<td><button class="boton" type="submit" name="descargar" id="descargar">Descargar (.xlsx)</button></td>
</form>
</table>
<?php 
	$sqldalumn="SELECT * FROM dalumn";
	$querydalumn=mysqli_query($conex,$sqldalumn);
	$numero1=mysqli_num_rows($querydalumn);
	
	$sqldclist="SELECT * FROM dalumn";
	$querydclist=mysqli_query($conex,$sqldclist);
	$numero2=mysqli_num_rows($querydclist);
	
	?>
<thead><h2>Carga de la Base de datos</h2></thead>
<form   method="post" id="addproduct" action="php/importarExcel.php" enctype="multipart/form-data" role="form">
<table>
<thead>
<tr>
    <th colspan="2">Archivo (.xlsx)*
		</br> Formato [Num. ctrl | App | Apm | Nom | Sexo | Curp | Periodo actual | Carrera | Semestre] </br></br> 
		Número de alumnos:
		<?php echo ($numero2); ?>
	</th>
</tr>
</thead>

<tr>
	<td> <input type="file" name="name"  id="name" placeholder="Archivo (.xlsx)"> </td>
    <td> <button class="boton" type="submit" class="btn btn-primary">Importar Datos</button> </td>
</tr>

</table>
</form>
</center>
<script src="../../js/menu.js"></script>
</body>		
</html>