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
			$ahora=date ('Y-n-j H:i:s');
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
			<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes <i class="fas fa-caret-down"></i></a>
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


<div id="main-container">
<script src="../../js/menu.js"></script>
<?php $login=$_SESSION['login']; $periodo=$_SESSION['perioso'];?>
<form action="php/redireccionamiento.php" method="POST">
	<div id="main-container">
	<center>
	<h2>Visualizar documentos</h2>
	<table width=800 style = "text-align: center;";>
		<thead>
			<tr>
				<th colspan="5" rowspan="2">Seleccionar grupo y operación a realizar</th>
			</tr>
		</thead>
			
			<tr>
				<td>
					  <?php
						$sql="SELECT * FROM docenteextraescolares WHERE numControlDocente='$login'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						$mostrar=mysqli_fetch_array($resultado1);
						$idDocente=$mostrar['numControlDocente'];
							echo ($mostrar['nombre_Docente'].' '.$mostrar['apellidoPDocente'].' '.$mostrar['apellidoMDocente'])
						?> 
				</td>
					
				<td><select id="idGrupos" name="idGrupos" >
					  <?php
						$sql="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$login' AND IdPeriodoExtraGrupos='$periodo' AND estatusGrupo='Activo'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						while($mostrar=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
						?>
						 <option value="<?php echo $mostrar['Id_Grupos']?>">
								<?php echo ($mostrar['numeroGrupo'].' --- '.$mostrar['nombreGrupo'])?>
						 </option>
						<?php
						} mysqli_free_result($resultado1); //Cierre del While ?> 
				</select></td>
					
				<td><select id="operacion" name="operacion">
						<option value="1">Listas</option>
						<option value="2">Calificaciones</option>
						<!--option value="3">Cedula Inscripción</option>
						<option value="4">Cedula Resultado</option-->	 
				</select></td>
					<td><button class="boton" type="submit" name="Visualizar" id="Visualizar">Visualizar</button> </td>
				</tr>
	</table>	
	</center>
</form>


<br></br>
<form action="php/imprimirDoc.php" method="POST">
	<div id="main-container">
	<center> 
	<h2>Imprimir documentos</h2>
	<table width=800 style = "text-align: center;";>
		<thead>
			<tr>
				<th colspan="5" rowspan="2">Seleccionar grupo y operación a realizar</th>
			</tr>
		</thead>
			
			<tr>
				<td>
					  <?php
						$sql="SELECT * FROM docenteextraescolares WHERE numControlDocente='$login'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						$mostrar=mysqli_fetch_array($resultado1);
						$idDocente=$mostrar['numControlDocente'];
							echo ($mostrar['nombre_Docente'].' '.$mostrar['apellidoPDocente'].' '.$mostrar['apellidoMDocente'])
						?> 
				</td>
					
				<td><select id="idGrupos" name="idGrupos" >
					  <?php
						$sql="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$login' AND IdPeriodoExtraGrupos='$periodo' AND estatusGrupo='Activo'"; //Consulta
						$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
						while($mostrar=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
						?>
						 <option value="<?php echo $mostrar['Id_Grupos']?>">
								<?php echo ($mostrar['numeroGrupo'].' --- '.$mostrar['nombreGrupo'])?>
						 </option>
						<?php
						} mysqli_free_result($resultado1); //Cierre del While ?> 
				</select></td>
				
				<td><select id="operacion" name="operacion">
						<option value="1">Listas</option>
						<option value="2">Calificaciones</option>
						<!--option value="3">Cedula Inscripción</option>
						<option value="4">Cedula Resultado</option-->	 
				</select></td>
					<td><button class="boton" type="submit" name="Imprimir" id="Imprimir" onclick="return mensajes()">Imprimir</button> </td>
				</tr>
	</table>	
	</center>
</form>

</body>		
</html>