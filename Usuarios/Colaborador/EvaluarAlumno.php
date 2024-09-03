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


<script>
	function imprimir(){
			var respuesta = confirm("¿Desea imprimir?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
	}
		
	function mensajes(){
			var respuesta = confirm("¿Desea enviar?");
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


<div id="main-container">
<?php
	include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
	$ActividadDocente=$_SESSION['id_Actividad'];
	$periodo=$_SESSION['perioso']; 
	$idAlumno=$_GET['id'];
	$tipo=$_GET['tipo'];

if($idAlumno!='' AND $tipo=='Regular'){
	$sql1="SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$idAlumno' AND periodoCalificacionesExtraescolar='$periodo'";
	$query=mysqli_query($conex,$sql1);
	$ver=mysqli_fetch_array($query);	
		error_reporting(0);
	
?>
<form action="php/evaluarAlumno.php?id=<?php echo $ver['idCalificaciones']?>" method="post">
<center>
<h2>Evaluación alumno</h2>
<table> 
			<?php
				if($ver['nivelDesempeño']=='' AND $ver['observaciones']=='' AND $ver['valorNumerico']=='' AND $ver['nivelDesempeño']==''){
					echo '<button class="boton" type="submit" name="enviar" id="enviar" onclick="return mensajes()"> Enviar </button>' ;
				}else{
					echo ' <button class="boton" type="submit" name="imprimir" id="imprimir" onclick="return imprimir()">Imprimir</button>';
				}
						error_reporting(0);
			?>
			<button class="boton" type="submit" name="regresar" id="regresar"> Regresar </button>
			
			<br></br>
				<thead>
			<tr>
					<th rowspan="2">No. </th>
					<th rowspan="2">Criterios a evaluar:</th>
					<th colspan="5">Nivel de desempeño del criterio(4): </th>
				
			</tr>
			<tr>
				<td class="negritas">Insuficiente </td>
				<td class="negritas">Suficiente </td>
				<td class="negritas">Bueno </td>
				<td class="negritas">Notable </td>
				<td class="negritas">Excelente </td>
			</tr>
				</thead>
				
			<tr>
				<td>1</td>
				<td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>
			<?php 
				
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
			?>
			</tr>
			<tr>
				<td>2</td>
				<td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
			?>
			</tr>
			<tr>
				<td>3</td>
				<td>Muestra liderazgo en las actividades encomendadas.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
				?>
			</tr>
			<tr>
				<td>4</td>
				<td>Organiza su tiempo y trabaja de manera proactiva.</td>
				<?php 
				if($ver['nivelDesempeño']=='') {
					echo '<td><input type="radio" name="nivelDesempeño" value="Insuficiente" required="obligatorio"></input></td>
							<td><input type="radio" name="nivelDesempeño" value="Suficiente" required="obligatorio"></input></td>
							<td><input type="radio" name="nivelDesempeño" value="Bueno" required="obligatorio"></input></td>
							<td><input type="radio" name="nivelDesempeño" value="Notable" required="obligatorio"></input></td>
							<td><input type="radio" name="nivelDesempeño" value="Excelente" required="obligatorio"></input></td>';
							
				}else{
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				}
				?>
			</tr>
			<tr>
				<td>5</td>
				<td>Interpreta la realidad y se Sensibiliza aportando soluciones a la problemática con la actividad. </td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>6</td>
				<td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>7</td>
				<td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
				<?php 
						if ($ver['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['nivelDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td colspan="2"> 
					Observaciones: <br><br>
				</td>
				<td colspan="5">
					<?php
					if ($ver['valorNumerico']==''){ echo '<input type="text"  id="observaciones" name="observaciones" size="80"  maxlength="4000"/ ><br></br>';}
					else{ echo $ver['observaciones'];}	
					?>
				</td>
			</tr>
			<?php
					if ($ver['valorNumerico']!=''){
					echo '
						<tr>
							<td colspan="2"> 
							Valor numérico de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['valorNumerico'].'</td>
						</tr>
						<tr>
							<td colspan="2"> 
								Nivel de desempeño alcanzado de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['nivelDesempeño'].'</td>
						</tr>';
					}
			?>
		</table>
</center>
</form>


<?php }else{ //EVALUAR ALUMNOS MOOCS
	$sql1="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$idAlumno' AND periodoAlumnoAvanzado='$periodo'";
	$query=mysqli_query($conex,$sql1);
	$ver=mysqli_fetch_array($query);	
		error_reporting(0);
?>


<form action="php/evaluarAlumno.php?id=<?php echo $ver['id_actividadAlumnoAvanzado']?>" method="post">
<center>
<h2>Evaluación alumno</h2>
<table> 
			<?php
				if($ver['evaluacionDesempeño']=='' AND $ver['evaluacionObservacion']=='' AND $ver['evaluacionNumero']==''){
					echo '<button class="boton" type="submit" name="enviarIrrE" id="enviarIrrE" onclick="return mensajes()"> Enviar </button>';
				}else{
					echo ' <button class="boton" type="submit" name="imprimirIrre" id="imprimirIrre" onclick="return imprimir()">Imprimir</button>';
				}
			?>
			<button class="boton" type="submit" name="regresarIrre" id="regresarIrre"> Regresar </button>
			
			<br></br>
				<thead>
			<tr>
					<th rowspan="2">No. </th>
					<th rowspan="2">Criterios a evaluar:</th>
					<th colspan="5">Nivel de desempeño del criterio(4): </th>
				
			</tr>
			<tr>
				<td class="negritas">Insuficiente </td>
				<td class="negritas">Suficiente </td>
				<td class="negritas">Bueno </td>
				<td class="negritas">Notable </td>
				<td class="negritas">Excelente </td>
			</tr>
				</thead>
				
			<tr>
				<td>1</td>
				<td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>
			<?php 
				
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
			?>
			</tr>
			<tr>
				<td>2</td>
				<td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
				<?php 
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
			?>
			</tr>
			<tr>
				<td>3</td>
				<td>Muestra liderazgo en las actividades encomendadas.</td>
				<?php 
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				
				?>
			</tr>
			<tr>
				<td>4</td>
				<td>Organiza su tiempo y trabaja de manera proactiva.</td>
				<?php 
				if($ver['evaluacionDesempeño']=='') {
					echo '<td><input type="radio" name="evaluacionDesempeño" value="Insuficiente" required="obligatorio"></input></td>
							<td><input type="radio" name="evaluacionDesempeño" value="Suficiente" required="obligatorio"></input></td>
							<td><input type="radio" name="evaluacionDesempeño" value="Bueno" required="obligatorio"></input></td>
							<td><input type="radio" name="evaluacionDesempeño" value="Notable" required="obligatorio"></input></td>
							<td><input type="radio" name="evaluacionDesempeño" value="Excelente" required="obligatorio"></input></td>';
							
				}else{
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				}
				?>
			</tr>
			<tr>
				<td>5</td>
				<td>Interpreta la realidad y se Sensibiliza aportando soluciones a la problemática con la actividad. </td>
				<?php 
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>6</td>
				<td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
				<?php 
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td>7</td>
				<td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
				<?php 
						if ($ver['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
						else if ($ver['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
						else if ($ver['evaluacionDesempeño']=='Excelente') {echo '<td></td><td></td><td></td><td></td><td>X</td>';}
						else {echo '<td></td><td></td><td></td><td></td><td></td>';}
				?>
			</tr>
			<tr>
				<td colspan="2"> 
					Observaciones: <br><br>
				</td>
				<td colspan="5">
					<?php
					if ($ver['evaluacionNumero']==''){ echo '<input type="text"  id="observaciones" name="observaciones" size="80"  maxlength="4000"/ ><br></br>';}
					else{ echo $ver['evaluacionObservacion'];}	
					?>
				</td>
			</tr>
			<?php
					if ($ver['evaluacionNumero']!=''){
					echo '
						<tr>
							<td colspan="2"> 
							Valor numérico de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['evaluacionNumero'].'</td>
						</tr>
						<tr>
							<td colspan="2"> 
								Nivel de desempeño alcanzado de la actividad complementaria: <br><br>
							</td>
							<td colspan="5">'.$ver['evaluacionDesempeño'].'</td>
						</tr>';
					}
			?>
		</table>
</center>
</form>

<?php } ?>
<script src="../../js/menu.js"></script>
</body>		
</html>