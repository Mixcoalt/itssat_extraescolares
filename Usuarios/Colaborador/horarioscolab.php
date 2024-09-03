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
<?php
		include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		$_SESSION['login'];
		$idDocente=$_SESSION['login'];
		$periodo=$_SESSION['perioso']; 
		$sql="SELECT * FROM docenteextraescolares,actividadesextraescolares WHERE id_Actividad=IdActE " ; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
			$actividad=$mostrar['numControlDocente'];
?> 
<center><h3 style="text-transform:uppercase;">HORARIO DE <?php echo $mostrar['nombreActividad']?> </h3></center>
<h4 style="text-transform:uppercase;">C. <?php echo($mostrar['nombre_Docente']); echo(" "); echo ($mostrar['apellidoPDocente']); echo(" "); echo ($mostrar['apellidoMDocente']);?></h4>
<table>
<thead>
<tr>
	<th>NO.</th>
	<th>GRUPO</th>
	<th>L</th>
	<th>M</th>
	<th>M</th>
	<th>J</th>
	<th>V</th>
	<th>S</th>
	<th>Disponibles</th>
</tr>
</thead>

<?php 
		$sql1="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$actividad' AND estatusGrupo='Activo' AND IdPeriodoExtraGrupos='$periodo'"; //Consulta
		//$sql1="SELECT * FROM docenteextraescolares INNER JOIN grupos ON docenteextraescolares.id_Actividad = grupos.id_ActividadE"; //Consulta
			$resultado1=mysqli_query($conex,$sql1); //Llamado de la conexion con la consulta	
			while($row=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla	
?>
<tr>

	<td><?php echo $row['numeroGrupo']?></td>
	<td><?php echo $row['nombreGrupo']?></td>
	<td><?php if($row['diaGrupo']=='Lunes'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Martes'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Miercoles'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Jueves'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Viernes'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Sabado'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['disponiblesGrupo']<=0){
			echo("Lleno");
		}else{
			echo $row['disponiblesGrupo'];
		}?>
	</td>
</tr>
<?php 		
			} mysqli_free_result($resultado1); //Cierre del While 
?> 
		
</table>
<?php } mysqli_free_result($resultado); //Cierre del While ?> 


<script src="../../js/menu.js"></script>
</body>		
</html>