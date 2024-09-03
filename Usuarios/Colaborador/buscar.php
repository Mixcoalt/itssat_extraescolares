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
	function imprimir(){
			var respuesta = confirm("¿Desea imprimir?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
		
	function permitir(){
			var respuesta = confirm("¿Desea permitir?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
		
	function negar(){
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
			<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes </a>
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




<?php
	include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
	$ActividadDocente=$_SESSION['id_Actividad'];
	$periodo=$_SESSION['perioso']; 
?>

<div id="divTab">
<?php 
	if(isset($_POST['Ingresar'])){ 
		if(!empty($_POST['PalabraClave']) AND $_POST['carrera']==0 AND  $_POST['grupos']==0){
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND Id_NumControlAlumno like '%" . $_POST['PalabraClave'] . "%'"; //Consulta	
		}else if($_POST['PalabraClave']=='' AND !empty($_POST['carrera']) AND  $_POST['grupos']==0){
			$carrera=$_POST['carrera'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND dclist.carcve='$carrera'"; //Consulta	
		}else if($_POST['PalabraClave']=='' AND $_POST['carrera']==0 AND  !empty($_POST['grupos'])){
			$grupos=$_POST['grupos'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND Id_Grupos='$grupos'"; //Consulta	
		}else if($_POST['PalabraClave']=='' AND $_POST['carrera']==0 AND  $_POST['grupos']==0){
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado'"; //Consulta	
		}else if(!empty($_POST['PalabraClave']) AND  !empty($_POST['carrera']) AND  !empty($_POST['grupos'])){
			$carrera=$_POST['carrera'];
			$grupos=$_POST['grupos'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND Id_Grupos='$grupos' AND dclist.carcve='$carrera' AND Id_NumControlAlumno like '%" . $_POST['PalabraClave'] . "%'";//Consulta	
		}else if($_POST['PalabraClave']=='' AND  !empty($_POST['carrera']) AND  !empty($_POST['grupos'])){
			$carrera=$_POST['carrera'];
			$grupos=$_POST['grupos'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND Id_Grupos='$grupos' AND dclist.carcve='$carrera'";//Consulta	
		}else if(!empty($_POST['PalabraClave']) AND  $_POST['carrera']==0 AND  !empty($_POST['grupos'])){
			$grupos=$_POST['grupos'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND Id_Grupos='$grupos' AND Id_NumControlAlumno like '%" . $_POST['PalabraClave'] . "%'";//Consulta	
		}else if(!empty($_POST['PalabraClave']) AND  !empty($_POST['carrera']) AND  $_POST['grupos']==0){
			$carrera=$_POST['carrera'];
			$sqlBusqueda="SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno WHERE dalumn.aluctr=Id_NumControlAlumno AND id_AlumnoCTR=Id_NumControlAlumno AND dclist.aluctr=Id_NumControlAlumno AND datosalumno.id_AlumnoCTR AND dcarre.Carcve=dclist.carcve AND Id_Grupos=IdGrupo AND actividadE='$ActividadDocente' AND IdActE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo' AND PeriodoExtraescolarId='$periodo' AND Estatus!='Negado' AND dclist.carcve='$carrera' AND Id_NumControlAlumno like '%" . $_POST['PalabraClave'] . "%'";//Consulta";//Consulta	
		}
?>



</br>
<form action="reportecolab.php" method="post" >
<center>
	  <button class="boton" type="submit" name="Ingresar" id="Ingresar" class="btn btn-success mb-2">Regresar</button>
</center>
</form>
<?php 
	$resultado=mysqli_query($conex,$sqlBusqueda); //Llamado de la conexion con la consulta
	if(mysqli_num_rows($resultado) > 0){
?>
<h2>Datos del alumno</h2>
<table>
<thead>
<tr>
	<th>Nro. de control</th>
	<th>Nombre</th>
	<th>Carrera</th>
	<th>Sem</th>
	<th>Teléfono</th>
	<th>Correo institucional</th>
	<th>Horario</th>
	<th>Documento</th>
	<th>Actividad</th>
	<th>Grupo</th>
	<th>Hora</th>
	<th>Alerta medica</th>
	<th>Permitir</th>
	<th>Estatus</th>
	<th>Calificar</th>
	<th>Evaluación</th>
	
</tr>
</thead>
<?php 	
		while($mostrar=mysqli_fetch_array($resultado)){ //Inicio del While para mostrar datos en la tabla
?>
<tr>
	<td><?php echo $mostrar['aluctr']?></td>
	<td><?php echo ($mostrar['alunom'].' '. $mostrar['aluapp'].' '. $mostrar['aluapm'])?></td>
	<td><?php echo $mostrar['Carnco']?></td>
	<td><?php echo $mostrar['clinpe']?></td>
	<td><?php echo $mostrar['telefonoAvanzadoAlumno']?></td>
	<td><?php echo $mostrar['correoAvanzadoAlumno']?></td>
	<td><a href="../../Php/download.php?filename=<?php echo $mostrar['nombreHorario'];?>&f=<?php echo $mostrar['nombreHorario']?>" onclick="return imprimir()">Horario <?php echo $mostrar['aluctr']?></a></td>
	<td><?php if($mostrar['nombreCertificado']!=''){ ?> <a href="../../Php/download.php?filename=<?php echo $mostrar['nombreCertificado'];?>&f=<?php echo $mostrar['nombreCertificado']?>" onclick="return imprimir()">Documento <?php echo $mostrar['aluctr']?></a> <?php }else{ echo (''); }?></td>
	<td><?php echo $mostrar['nombreActividad']?></td>
	<td><?php echo $mostrar['numeroGrupo']?></td>
	<td><?php echo $mostrar['horaGrupo']?></td>
	<td><label><a class="boton" href="visualizarAlterta.php?id=<?php echo $mostrar['Id_NumControlAlumno'];?>">Visualizar</label></td>
	<td>
		<label><a href="php/activarAlumno.php?id=<?php echo $mostrar['Id_actividadAlumno'];?>" onclick="return permitir()">Si  |</label>
		<label><a href="php/negarAlumno.php?id=<?php echo $mostrar['Id_actividadAlumno'] ?>" onclick="return negar()"> No</label>
	</td>
	<td><?php echo $mostrar['Estatus']; echo(" ")?></td>
	<?php if ($mostrar['Estatus'] == 'Aceptado') { ?>
	<td><button class="boton"><a class="boton" href="calificarAlumno.php?id=<?php echo $mostrar['Id_NumControlAlumno']?>&tipo=<?php echo ('Regular');?>">Calificar</a></button></td>
	<?php }else{echo '<td></td>';}?>
	<?php if ($mostrar['Estatus'] == 'Aceptado') { ?>
	<td><button class="boton"><a class="boton" href="EvaluarAlumno.php?id=<?php echo $mostrar['Id_NumControlAlumno']?>&tipo=<?php echo ('Regular');?>">Evaluación</a></button></td>
	<?php }else{echo '<td></td>';}?>
	

</tr>
<?php 
		} mysqli_free_result($resultado); //Cierre del While 
		
	}else{
            echo"<h1>No existe registro</h1>";
	}
?> 


</thead>
</table>
</div>
<?php 
	}
?>
<script src="../../js/menu.js"></script>
</body>		
</html>