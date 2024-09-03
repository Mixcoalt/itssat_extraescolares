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
		function aceptar(){
			var respuesta = confirm("¿Desea activar?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
		
		function rechazar(){
			var respuesta = confirm("¿Desea negar?");
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



<div id="divTab">
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
</tr>
<tr>
	<th>NO.</th>
	<th>GRUPO</th>
	<th>L</th>
	<th>M</th>
	<th>M</th>
	<th>J</th>
	<th>V</th>
	<th>Capacidad</th>
	<th>Disponibles</th>
	<th>Permitir</th>
	<th>Estatus</th>
	<th></th>
</tr>
</thead>

<?php 
		$sql1="SELECT * FROM grupos WHERE numControlDocenteExtraescolar='$actividad' AND IdPeriodoExtraGrupos='$periodo'"; //Consulta
		//$sql1="SELECT * FROM docenteextraescolares INNER JOIN grupos ON docenteextraescolares.id_Actividad = grupos.id_ActividadE"; //Consulta
			$resultado1=mysqli_query($conex,$sql1); //Llamado de la conexion con la consulta	
			while($row=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla	
				if($row['diaGrupo']<>'Sabado'){
					//echo "select id_NumControlAlumno from actividadalumno where IdGrupo = ".$row['Id_Grupos']." and Estatus = 'Aceptado'";
					$totinscrip = mysqli_query($conex,"select id_NumControlAlumno from actividadalumno where IdGrupo = ".$row['Id_Grupos']." and Estatus = 'Aceptado'");
					$num = mysqli_num_rows($totinscrip);
					$dispon = $row['capacidadGrupo'] - $num;
			
?>
<tr>

	<td><?php echo $row['numeroGrupo']?></td>
	<td><?php echo $row['nombreGrupo']?></td>
	<td><?php if($row['diaGrupo']=='Lunes'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Martes'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Miercoles'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Jueves'){echo $row['horaGrupo'];}?></td>
	<td><?php if($row['diaGrupo']=='Viernes'){echo $row['horaGrupo'];}?></td>
	<td><?php echo $row['capacidadGrupo']?></td>
	<td><?php if ($dispon<=0){
			echo("Lleno");
		}else{
			echo $dispon;
		}?>
	</td>	
	<td>
		<label><a onclick="return aceptar()" href="php/activarGrupo.php?id=<?php echo $row['Id_Grupos'];?>">Si  |</label>
		<label><a onclick="return rechazar()" href="php/negarGrupo.php?id=<?php echo $row['Id_Grupos'] ?>"> No</label>
	</td>
	<td><?php echo $row['estatusGrupo']; echo(" ")?></td>
	<td><a href="editar.php?id=<?php echo $row['Id_Grupos'] ?>">Editar</td>
</tr>

<?php 		
				}
		} mysqli_free_result($resultado1); //Cierre del While 
?> 

</table>
<?php } mysqli_free_result($resultado); //Cierre del While ?> 



<script src="../../js/menu.js"></script>
</body>		
</html>