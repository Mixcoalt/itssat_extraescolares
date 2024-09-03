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

	function validarFormulario(){
			var varContra = document.getElementById('contrasena').value;
			var VarLogin = document.getElementById('login').value;
			
			if(!(/^\S{1,10}$/.test(VarLogin)) ) {
				alert('Login: Es mayor de 10 caracteres');
				  return false;
			}
			if(!(/^\S{1,10}$/.test(varContra)) ) {
				alert('Contraseña: Es mayor de 10 caracteres');
				  return false;
			}
	}
	
	function modidicar(){
			var respuesta = confirm("¿Desea editar?");
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
	include ("../../Php/conexion.php"); 
	$id=$_GET['id'];
	
	
	$consulta="SELECT * FROM usuarios,tipousuario,actividadesextraescolares WHERE Id='$id' AND numTipoUsuario=IdTipoUsuario AND IdActE=numProgEdu";
	$resultado=mysqli_query($conex,$consulta);
	$mostrar=mysqli_fetch_array($resultado);
?>

<body>
<form action="php/editarUsuario.php?id=<?php echo $mostrar['Id']?>" method="post" onsubmit="return validarFormulario()">
		<center>
		<table>
		<thead><h2>Editar Usuario</h2></thead>

		<tr height="50">
		<td>Nombre</td>
		<td><input type="text"  id="nombre" name="nombre" size="25" maxlength="25"/ value="<?php echo $mostrar['nombre']?>" ></td>
		</tr>


		<tr height="50">
		<td>Login(Maximo 9 caracteres):</td>
		<td><input type="text" id="login" name="login" size="50" maxlength="50"/ value="<?php echo $mostrar['login']?>" ></td>
		</tr>
	<tr height="50">
	<td>Tipo de usuario: </td> <br> 
	<td><select id="numTipoUsuario" name="numTipoUsuario" >
    <?php
		include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD
			
		$sql1="SELECT * FROM tipousuario"; //Consulta
		$resultado1=mysqli_query($conex,$sql1); //Llamado de la conexion con la consulta
		while($mostrar1=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
	?>
		<option hidden selected><?php echo $mostrar['nombreTipoUsuario']?></option>
		 <option value="<?php echo $mostrar1['IdTipoUsuario']?>"><?php echo $mostrar1['nombreTipoUsuario']?></option>
   <?php } mysqli_free_result($resultado1); //Cierre del While ?> 
	</select></td>
	</tr>


		<tr height="50">
		<td>Programa Educativo: </td><br>
		<td> <select id="numProgEdu" name="numProgEdu">
	<?php
		include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD
			
		$sql1="SELECT * FROM actividadesextraescolares"; //Consulta
		$resultado1=mysqli_query($conex,$sql1); //Llamado de la conexion con la consulta
		while($mostrar1=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
	?>
		<option hidden selected><?php echo $mostrar['nombreActividad']?></option>
		 <option value="<?php echo $mostrar1['IdActE']?>"><?php echo $mostrar1['nombreActividad']?></option>
   <?php } mysqli_free_result($resultado1); //Cierre del While ?> 
		 </td>
		</tr>

		<tr height="50">
		<td>Contraseña(Maximo 9 caracteres):</td>
		<td><input type="text" id="contrasena" name="contrasena" required="obligatorio" size="50" maxlength="50"/ value="<?php echo $mostrar['contrasena']?>" ></td>
		</tr>
		


		</table>
		<br>
			<button class="boton" onclick="return modidicar()"> Editar </a>  </button>
		</center>
</form>

<script src="../../js/menu.js"></script>
</body>		
</html>