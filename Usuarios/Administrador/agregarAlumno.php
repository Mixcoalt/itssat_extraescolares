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
				alert('Verifique curp(Mayúsculas,números, 18 dígitos)');
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
<br/>


<button class="boton" style="position:absolute;right:25%"><a class="boton" href="buscarAlumno.php">Buscar Alumno</a></button>

<center>
<form action="php/agregarAlumno.php" method="post" onsubmit="return validarFormulario()">

<thead><h2>Registro de datos del alumno</h2></thead>

<table>
<tr height="50">
<td>Número de control:</td>
<td><input type="text" id="numControl" name="numControl" required="obligatorio" size="25" maxlength="50" placeholder="111U0000"/></td>
</tr>

<tr height="50">
<td  colspan="2"/>
	<label/> Nombre:
	<br></br>
	<input type="text" id="nom" name="nom" required="obligatorio" size="28" maxlength="25" placeholder="Apellido Paterno"/>
	<input type="text" id="app" name="app" required="obligatorio" size="28" maxlength="25" placeholder="Apellido Materno"/>
	<input type="text" id="apm" name="apm" required="obligatorio" size="25" maxlength="20" placeholder="Nombre"/>
</td>
</tr>



<tr height="50">
<td>Sexo:</td><br>
<td> <select name="sexo">
	<option value="1">H</option>
	<option value="2">M</option>
</tr>

<tr height="50">
<td>CURP:</td>
<td><input type="text" id="curp" name="curp" required="obligatorio" size="25" maxlength="50" placeholder="Mayúsculas"/></td>
</tr>

<tr height="50">
<td>Programa Educativo:</td><br>
<td> <select id="carrera" name="carrera">
<?php	
	$sql1="SELECT * FROM dcarre";
	$resultado1=mysqli_query($conex,$sql1);
	while($mostrar1=mysqli_fetch_assoc($resultado1)){
		echo '<option value="'.$mostrar1['Carcve'].'">'.$mostrar1['Carnom'].'</option>';
	} mysqli_free_result($resultado1);
?> 
</tr>

	<tr height="50">
	<td>Semestre del alumno:</td>
	<td> <select id="semestre" name="semestre">
	<?php for($a=1;$a<=13;$a++){ ?>	
		<option value=<?php echo "$a" ; ?>><?php echo "$a" ;?></option>
	<?php } ?>	
	</select></td>
	</tr>

</table>
<br>
<td><button class="boton" type="submit" name="Ingresar" id="Ingresar" onclick="return mensajes()">Registrar Alumno</button></td>
</center>
</form>
<script src="../../js/menu.js"></script>

</body>		
</html>