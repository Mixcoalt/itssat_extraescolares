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
			$ahora=date('Y-n-j H:i:s');
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

$_SESSION['login'];
$idDocente=$_SESSION['login'];
$perioso=$_SESSION['perioso'];

$sqlAlumnoA="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$idDocente' AND periodoAlumnoAvanzado='$perioso'";
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


<div id="main-container">
<?php
		include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		
		$sql="SELECT * FROM docenteextraescolares,actividadesextraescolares WHERE id_Actividad=IdActE   " ; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
			$actividad=$mostrar['id_Actividad'];
			$sqlGrupos="SELECT Id_Grupos FROM grupos WHERE IdPeriodoExtraGrupos = '$perioso' AND id_ActividadE='$actividad'";
			$queryGrupos=mysqli_query($conex,$sqlGrupos);
			$mostrarGrupos=mysqli_fetch_array($queryGrupos);	
			if($mostrarGrupos['Id_Grupos']<>""){
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
		$sql1="SELECT * FROM grupos WHERE id_ActividadE='$actividad' AND estatusGrupo='Activo' AND IdPeriodoExtraGrupos = '$perioso'"; //Consulta
		//$sql1="SELECT * FROM docenteextraescolares INNER JOIN grupos ON docenteextraescolares.id_Actividad = grupos.id_ActividadE"; //Consulta
			$resultado1=mysqli_query($conex,$sql1); //Llamado de la conexion con la consulta	
			while($row=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla	
				if($row['nombreGrupo']!="TALLER"  AND $row['nombreGrupo']!="taller" AND $row['nombreGrupo']!="Taller"){
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
				}
			} mysqli_free_result($resultado1); //Cierre del While 
			}
?> 
		
</table>
<?php } mysqli_free_result($resultado); //Cierre del While ?> 


<script src="../../js/menu.js"></script>
 
</body>		
</html>