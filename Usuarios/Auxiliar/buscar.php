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
	include("../../Php/conexion.php");
	$sql="SELECT * FROM logos WHERE id_logos=2";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>

<link rel="icon" type="image/ico" href="<?php echo ('../../Imagen/'.$fila['nombre_imagen']);?>">

<?php }?>
<!link href="../../Css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../Css/style.css" />
<link rel="stylesheet" type="text/css" href="../../Css/tablas.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<head/>

<body>
<div class="encabezado" align="center">
<?php
	$periodo=$_SESSION['perioso'];
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
if(isset($_POST['Ingresar'])){
?>
	<div id="main-container">
	<!--BUSQUEDA DE ALUMNOS INSCRITOS Y ACEPTADOS POR MEDIO DEL NÚMERO DE CONTROL-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnos.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $aKeyword=explode(" ",$_POST['PalabraClave']);
					  $query="SELECT Id_NumControlAlumno,dalumn.aluapp,dalumn.aluapm,dalumn.alunom,dcarre.Carnco,dclist.clinpe,nombreActividad,nombreHorario,IdGrupo,nombreCertificado,dalumn.aluctr,Estatus,PeriodoExtraescolarId FROM actividadalumno 
								INNER JOIN grupos ON Id_Grupos=IdGrupo
								INNER JOIN actividadesextraescolares ON actividadE=IdActE  
								INNER JOIN dalumn ON dalumn.aluctr=Id_NumControlAlumno
								INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno
								INNER JOIN dcarre ON  dcarre.Carcve=dclist.carcve 
								WHERE Estatus='Aceptado' AND dalumn.aluctr like '%" . $aKeyword[0] . "%'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Actividad elegida</th>
										<th>Horario academico</th>
										<th>Documento</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++;                         
							echo "<tr>
									  <td>".$row['Id_NumControlAlumno']." </td>
									  <td>".$row['aluapp'].' '.$row['aluapm'].' '.$row['alunom']."</td>
									  <td>".$row['Carnco']."</td>
									   <td>".$row['clinpe']."</td>
									   <td>".$row['nombreActividad']."</td>";?>
										<td><a href="../../Php/download.php?filename=<?php echo $row['nombreHorario'];?>&f=<?php echo $row['nombreHorario']?>"><?php echo $row['nombreHorario']; ?></a></td></td>	
										<td><?php if($row['nombreCertificado']!=''){ ?> <a href="../../Php/download.php?filename=<?php echo $row['nombreCertificado'];?>&f=<?php echo $mostrar['nombreCertificado']?>" onclick="return imprimir()">Documento <?php echo $row['aluctr']?></a> <?php }else{ echo (''); }?></td>
										<?php if ($row['Estatus']=='Aceptado') { ?>
										<td><button class="boton"><a class="boton" href="EvaluarAlumno.php?id=<?php echo $row['Id_NumControlAlumno']?>&periodo=<?php echo $row['PeriodoExtraescolarId']?>">Evaluación</a></button></td>
									<?php }else{echo '<td></td>';}?>	
								<?php  echo "</tr>"; 
						}
						echo "</table>";
					
					}
					else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}
				 }

		 ?>
		</div>
		</form>
<?php } ?>

<?php 
if(isset($_POST['acreditados'])){
	//$actividad=$_POST['numControlDocente'];
	$numPeriodo=$_POST['numPeriodo'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS INSCRITOS Y ACREDITADOS POR MEDIO DEL PERIODO-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnos.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $query ="SELECT Id_NumControlAlumno,dalumn.aluapp,dalumn.aluapm,dalumn.alunom,dcarre.Carnco,dclist.clinpe,nombreActividad,nombreHorario,IdGrupo,nombreCertificado,dalumn.aluctr,Estatus,PeriodoExtraescolarId
								FROM actividadalumno 
								INNER JOIN grupos ON Id_Grupos=IdGrupo
								INNER JOIN actividadesextraescolares ON actividadE=IdActE  
								INNER JOIN dalumn ON dalumn.aluctr=Id_NumControlAlumno
								INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno
								INNER JOIN dcarre ON  dcarre.Carcve=dclist.carcve 
								INNER JOIN calificacionesalumno ON Id_NumeroControl=Id_NumControlAlumno
								WHERE Estatus='Aceptado' AND promedio>=70 AND periodoCalificacionesExtraescolar='$numPeriodo' AND PeriodoExtraescolarId='$numPeriodo'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Actividad elegida</th>
										<th>Horario academico</th>
										<th>Documento</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++;                         
							echo "<tr>
									  <td>".$row['Id_NumControlAlumno']." </td>
									  <td>".$row['aluapp'].' '.$row['aluapm'].' '.$row['alunom']."</td>
									  <td>".$row['Carnco']."</td>
									   <td>".$row['clinpe']."</td>
									   <td>".$row['nombreActividad'] . "</td>";?>
										<td></br><a href="../../Php/download.php?filename=<?php echo $row['nombreHorario'];?>&f=<?php echo $row['nombreHorario']?>"><?php echo $row['nombreHorario']; ?></a></td></td>	
										<td><?php if($row['nombreCertificado']!=''){ ?> <a href="../../Php/download.php?filename=<?php echo $row['nombreCertificado'];?>&f=<?php echo $mostrar['nombreCertificado']?>" onclick="return imprimir()">Documento <?php echo $row['aluctr']?></a> <?php }else{ echo (''); }?></td>
									<?php if ($row['Estatus']=='Aceptado') { ?>
										<td><button class="boton"><a class="boton" href="EvaluarAlumno.php?id=<?php echo $row['Id_NumControlAlumno']?>&periodo=<?php echo $row['PeriodoExtraescolarId']?>">Evaluación</a></button></td>
									<?php }else{echo '<td></td>';}?>	
								<?php  echo "</tr>"; 
						}
						echo "</table>";
					
					}
					else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}
				 }

		 ?>
		</div>
		</form>
<?php } ?>



<?php 
if(isset($_POST['noAcreditados'])){
	//$actividad=$_POST['numControlDocente'];
	$numPeriodo=$_POST['numPeriodo'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS INSCRITOS Y NO ACREDITADOS POR MEDIO DEL PERIODO-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnos.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $query="SELECT Id_NumControlAlumno,dalumn.aluapp,dalumn.aluapm,dalumn.alunom,dcarre.Carnco,dclist.clinpe,nombreActividad,nombreHorario,IdGrupo,nombreCertificado,dalumn.aluctr,Estatus,PeriodoExtraescolarId
								FROM actividadalumno 
								INNER JOIN grupos ON Id_Grupos=IdGrupo
								INNER JOIN actividadesextraescolares ON actividadE=IdActE  
								INNER JOIN dalumn ON dalumn.aluctr=Id_NumControlAlumno
								INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno
								INNER JOIN dcarre ON  dcarre.Carcve=dclist.carcve 
								INNER JOIN calificacionesalumno ON Id_NumeroControl=Id_NumControlAlumno
								WHERE Estatus='Aceptado' AND promedio<70 AND periodoCalificacionesExtraescolar='$numPeriodo' AND PeriodoExtraescolarId='$numPeriodo'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Actividad elegida</th>
										<th>Horario academico</th>
										<th>Documento</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++;                         
							echo "<tr>
									  <td>".$row['Id_NumControlAlumno'] ." </td>
									  <td>".$row['aluapp'].' '.$row['aluapm'].' '.$row['alunom']."</td>
									  <td>".$row['Carnco']."</td>
									   <td>".$row['clinpe']."</td>
									   <td>".$row['nombreActividad'] . "</td>";?>
										<td></br><a href="../../Php/download.php?filename=<?php echo $row['nombreHorario'];?>&f=<?php echo $row['nombreHorario']?>"><?php echo $row['nombreHorario']; ?></a></td></td>	
										<td><?php if($row['nombreCertificado']!=''){ ?> <a href="../../Php/download.php?filename=<?php echo $row['nombreCertificado'];?>&f=<?php echo $mostrar['nombreCertificado']?>" onclick="return imprimir()">Documento <?php echo $row['aluctr']?></a> <?php }else{ echo (''); }?></td>
									<?php if ($row['Estatus']=='Aceptado') { ?>
										<td><button class="boton"><a class="boton" href="EvaluarAlumno.php?id=<?php echo $row['Id_NumControlAlumno']?>&periodo=<?php echo $row['PeriodoExtraescolarId']?>">Evaluación</a></button></td>
									<?php }else{echo '<td></td>';}?>	
								<?php  echo "</tr>"; 
						}
						echo "</table>";
					
					}
					else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}
				 }

		 ?>
		</div>
		</form>
<?php } ?>



<?php 
if(isset($_POST['buscar'])){
	//$actividad=$_POST['numControlDocente'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS LIBERADOS POR MEDIO DE NUMERO DE CONTROL-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="estadisticas.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $aKeyword=explode(" ", $_POST['PalabraClave']);
					  $query="SELECT * FROM dalumn WHERE aluctr like '%" . $aKeyword[0] . "%'";
					 
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Actividad elegida</th>
										<th>Anexo XVI</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++;  
								$Id_NumControlAlumno= $row['aluctr'];
								$consultaAlumno="SELECT * FROM calificacionesalumno WHERE promedio>=70 AND Id_NumeroControl='$Id_NumControlAlumno' "; 
								$alumno=mysqli_query($conex,$consultaAlumno);
								$count=mysqli_num_rows($alumno);
								$arreglo=mysqli_fetch_array($alumno);
								if($count==2){
									$Id_NumeroControl=$arreglo['Id_NumeroControl'];
									$sqlA="SELECT * FROM dalumn,dclist,dcarre,actividadalumno,grupos,actividadesextraescolares,calificacionesalumno WHERE dclist.aluctr=dalumn.aluctr AND dclist.carcve=dcarre.carcve AND dalumn.aluctr='$Id_NumeroControl' AND actividadE=IdActE AND IdGrupo=Id_Grupos AND Id_NumeroControl='$Id_NumeroControl' AND Id_NumControlAlumno='$Id_NumeroControl' AND Id_ElegidaActividadAlumno=Id_actividadAlumno AND promedio>=70 ORDER BY periodoCalificacionesExtraescolar DESC LIMIT 0,1"; //Consult
									$SQLresultadoA=mysqli_query($conex,$sqlA); //Llamado de la conexion con la consulta
									$countLista=mysqli_num_rows($SQLresultadoA); 
									while($Alumno=mysqli_fetch_array($SQLresultadoA)){
								
							echo "<tr>
									  <td>".$Alumno['Id_NumeroControl'] ." </td>
									  <td>".$Alumno['aluapp'].' '.$Alumno['aluapm'].' '.$Alumno['alunom']."</td>
									  <td>".$Alumno['Carnco']."</td>
									   <td>".$Alumno['clinpe']."</td>
									   <td>".$Alumno['nombreActividad']."</td>"; 
						?>
										<td><button class="boton"><a class="boton" href="php/DOCAnexoXVI.php?id=<?php echo ($Alumno['idCalificaciones']);?>">Imprimir</a></button> </td>
					<?php  echo "</tr>"; 
								} mysqli_free_result($SQLresultadoA);  
						
							}
						}
							echo "</table>";
						} 
					}else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}

		 ?>

		</div>
		</form>
<?php } ?>


<?php 
if(isset($_POST['irregulares'])){
	//$actividad=$_POST['numControlDocente'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS IRREGULARES INSCRITOS POR MEDIO DEL NUMERO DE CONTROL-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnoIrregulares.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $aKeyword=explode(" ", $_POST['PalabraClave']);
					 $query="SELECT * FROM dalumn,dcarre,dclist,actividadalumnoavanzado,grupos,docenteextraescolares,actividadesextraescolares WHERE dalumn.aluctr=Id_ctrAlumno AND dclist.aluctr=dalumn.aluctr AND dcarre.Carcve=dclist.carcve AND estatusAvanzado!='' AND IDgrupoA=Id_Grupos AND 	numControlDocenteExtraescolar=numControlDocente AND id_Actividad=IdActE AND IdActE=actividadAvanzado AND Id_ctrAlumno like '%" . $aKeyword[0] . "%'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Taller MOOCS</th>
										<th>Permitir</th>
										<th>Estatus</th>
										<th>Actividad</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++; 						
						?>
							<tr>
								<td><?php echo $row['Id_ctrAlumno'] ?></td>
								<td><?php echo ($row['aluapp'].' '.$row['aluapm'].' '.$row['alunom'])?></td>
								<td><?php echo $row['Carnco']?></td>
								<td><?php echo $row['clinpe']?></td>
								<td><a href="../../Php/download.php?filename=<?php echo $row['nombreactividadesfisicas_1'];?>&f=<?php echo $row['nombreactividadesfisicas_1']?>"><?php echo ('Curso1'.$row['Id_ctrAlumno']) ?></a></td></td>
								<td>
									<label><a href="promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'];?>" onclick="return permitir()">Si  |</label>
									<label><a href="php/promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'] ?>" onclick="return negar()"> No</label>
								</td>
								<td><?php echo $row['estatusAvanzado'] ?></td>
								<td><?php echo $row['nombreActividad'] ?></td>
								<td>
									<?php if ( $row['evaluacionDesempeño']!=''){?>
									<button class="boton" type="submit" name="evaluar" id="evaluar"><a class="boton" href="EvaluarAlumnoI.php?id=<?php echo $row['Id_ctrAlumno']?>&periodo=<?php echo $row['periodoAlumnoAvanzado']?>">Evaluación</a></button>
									<?php }?>
								</td></tr>
							<?php
						}
							echo "</table>";
						} 
					}else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}

		 ?>

		</div>
		</form>
<?php } ?>

<?php 
if(isset($_POST['acreditadosIrre'])){
	$numPeriodo=$_POST['numPeriodo'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS INSCRITOS IRREGULARES ACREDITADOS POR MEDIO DEL PERIODO-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnoIrregulares.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					 $query="SELECT * FROM dalumn,dcarre,dclist,actividadalumnoavanzado,grupos,docenteextraescolares,actividadesextraescolares WHERE dalumn.aluctr=Id_ctrAlumno AND dclist.aluctr=dalumn.aluctr AND dcarre.Carcve=dclist.carcve AND estatusAvanzado!='' AND IDgrupoA=Id_Grupos AND 	numControlDocenteExtraescolar=numControlDocente AND id_Actividad=IdActE AND IdActE=actividadAvanzado AND p>69 AND periodoAlumnoAvanzado='$numPeriodo'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Taller MOOCS</th>
										<th>Permitir</th>
										<th>Estatus</th>
										<th>Actividad</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++; 						
						?>
							<tr>
								<td><?php echo $row['Id_ctrAlumno'] ?></td>
								<td><?php echo ($row['aluapp'].' '.$row['aluapm'].' '.$row['alunom'])?></td>
								<td><?php echo $row['Carnco']?></td>
								<td><?php echo $row['clinpe']?></td>
								<td><a href="../../Php/download.php?filename=<?php echo $row['nombreactividadesfisicas_1'];?>&f=<?php echo $row['nombreactividadesfisicas_1']?>"><?php echo ('Curso1'.$row['Id_ctrAlumno']) ?></a></td></td>
								<td>
									<label><a href="promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'];?>" onclick="return permitir()">Si  |</label>
									<label><a href="php/promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'] ?>" onclick="return negar()"> No</label>
								</td>
								<td><?php echo $row['estatusAvanzado'] ?></td>
								<td><?php echo $row['nombreActividad'] ?></td>
								<td>
									<?php if ( $row['evaluacionDesempeño']!=''){?>
									<button class="boton" type="submit" name="evaluar" id="evaluar"><a class="boton" href="EvaluarAlumnoI.php?id=<?php echo $row['Id_ctrAlumno']?>&periodo=<?php echo $row['periodoAlumnoAvanzado']?>">Evaluación</a></button>
									<?php }?>
								</td></tr>
							<?php
						}
							echo "</table>";
						} 
					}else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}

		 ?>

		</div>
		</form>
<?php } ?>

<?php 
if(isset($_POST['noAcreditadosIrre'])){
	$numPeriodo=$_POST['numPeriodo'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS IRREGULARES NO ACREDITADOS POR MEDIO DEL PERIODO-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnoIrregulares.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					 $query="SELECT * FROM dalumn,dcarre,dclist,actividadalumnoavanzado,grupos,docenteextraescolares,actividadesextraescolares WHERE dalumn.aluctr=Id_ctrAlumno AND dclist.aluctr=dalumn.aluctr AND dcarre.Carcve=dclist.carcve AND estatusAvanzado!='' AND IDgrupoA=Id_Grupos AND 	numControlDocenteExtraescolar=numControlDocente AND id_Actividad=IdActE AND IdActE=actividadAvanzado AND p<70 AND periodoAlumnoAvanzado='$numPeriodo'";
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Taller MOOCS</th>
										<th>Permitir</th>
										<th>Estatus</th>
										<th>Actividad</th>
										<th>Anexo XVII</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++; 						
						?>
							<tr>
								<td><?php echo $row['Id_ctrAlumno'] ?></td>
								<td><?php echo ($row['aluapp'].' '.$row['aluapm'].' '.$row['alunom'])?></td>
								<td><?php echo $row['Carnco']?></td>
								<td><?php echo $row['clinpe']?></td>
								<td><a href="../../Php/download.php?filename=<?php echo $row['nombreactividadesfisicas_1'];?>&f=<?php echo $row['nombreactividadesfisicas_1']?>"><?php echo ('Curso1'.$row['Id_ctrAlumno']) ?></a></td></td>
								<td>
									<label><a href="promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'];?>" onclick="return permitir()">Si  |</label>
									<label><a href="php/promotoriaTaller.php?id=<?php echo $row['Id_ctrAlumno'] ?>" onclick="return negar()"> No</label>
								</td>
								<td><?php echo $row['estatusAvanzado'] ?></td>
								<td><?php echo $row['nombreActividad'] ?></td>
								<td>
									<?php if ( $row['evaluacionDesempeño']!=''){?>
									<button class="boton" type="submit" name="evaluar" id="evaluar"><a class="boton" href="EvaluarAlumnoI.php?id=<?php echo $row['Id_ctrAlumno']?>&periodo=<?php echo $row['periodoAlumnoAvanzado']?>">Evaluación</a></button>
									<?php }?>
								</td></tr>
							<?php
						}
							echo "</table>";
						} 
					}else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}

		 ?>

		</div>
		</form>
<?php } ?>


<?php 
if(isset($_POST['evaluar'])){
	//$actividad=$_POST['numControlDocente'];
?>
	<div id="divTab">
	<!--BUSQUEDA IRREGULARES NO ACEPTADOS-->
		<h2>Resultados </h2> <button class="boton"><a class="boton" href="alumnoIrregulares.php"> Regresar</a></button>
		<form>	
<table>
<thead>
	<tr>
		<th>Numero de control</th>
		<th>Nombre</th>
		<th>Carrera</th>
		<th>Semestre</th>
		<th>Taller</th>
		<th>Actividad</th>
		<th>Grupo</th>
		<th>Hora</th>
		<th>Permitir</th>
		
</thead>
<?php
		include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD			
		$sql="SELECT * FROM dalumn,dcarre,dclist,actividadalumnoavanzado,actividadesextraescolares,grupos WHERE periodoAlumnoAvanzado='$periodo' AND dalumn.aluctr=Id_ctrAlumno AND dclist.aluctr=dalumn.aluctr AND dcarre.Carcve=dclist.carcve AND id_ActividadE=IdActE AND Id_Grupos=IDgrupoA AND IdActE=actividadAvanzado AND estatusAvanzado=''"; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
		
		$numControlAlumno=$mostrar['Id_ctrAlumno']; 
		setlocale(LC_TIME,"es_ES.UTF-8");
?> 
<tr>
	<td><?php echo $mostrar['Id_ctrAlumno'] ?></td>
	<td><?php echo ($mostrar['aluapp'].' '.$mostrar['aluapm'].' '.$mostrar['alunom'])?></td>
	<td><?php echo $mostrar['Carnco']?></td>
	<td><?php echo $mostrar['clinpe']?></td>
	<td><?php echo $mostrar['actividadesfisicas_1']?></td>
	<td><?php echo $mostrar['nombreActividad']?></td>
	<td><?php echo $mostrar['numeroGrupo']?></td>
	<td><?php echo $mostrar['horaGrupo']?></td>
	<td>
		<label><a href="php/promotoriaTaller.php?id=<?php echo $mostrar['Id_ctrAlumno'];?>&estatus=<?php echo('Aceptado')?>" onclick="return permitir()">Si  |</label>
		<label><a href="php/promotoriaTaller.php?id=<?php echo $mostrar['Id_ctrAlumno'] ?>&estatus=<?php echo('Negado')?>" onclick="return negar()"> No</label>
	</td>
</tr>
<?php
 } mysqli_free_result($resultado);  
?> 

</table>
</div>
</form>
<?php } ?>


<?php 
if(isset($_POST['buscarIrre'])){
	//$actividad=$_POST['numControlDocente'];
?>
	<div id="divTab">
	<!--BUSQUEDA DE ALUMNOS MOOCS LIBERADOS POR MEDIO DE NUMERO DE CONTROL-->
		<h2>Resultados </h2> <button class="boton"><a class="boton"href="estadisticas.php"> Regresar</a></button>
		<form>
		<?php
		 include ("../../Php/conexion.php");
				if(!empty($_POST))
				{
					$a=0;
					
					  $aKeyword=explode(" ", $_POST['PalabraClave']);
					  $query="SELECT aluctr FROM dalumn WHERE aluctr like '%" . $aKeyword[0] . "%'";
					 
					 $result=mysqli_query($conex, $query);
									 
					 if(mysqli_num_rows($result) > 0) {
						$row_count=0;
						echo "<br><table>
								<thead>
									<tr>
										<th>Numero de control</th>
										<th>Nombre</th>
										<th>Carrera</th>
										<th>Semestre</th>
										<th>Actividad elegida</th>
										<th>Anexo XVI</th>
									</tr>
								</thead>";
						While($row=$result->fetch_assoc()) {   
							$row_count++; 
									$Id_NumControlAlumno=$row['aluctr'];							
									$consultaAlumno="SELECT * FROM calificacionesalumno WHERE promedio>=70 AND Id_NumeroControl='$Id_NumControlAlumno' "; 
											$alumnoC=mysqli_query($conex,$consultaAlumno);
											$count=mysqli_num_rows($alumnoC);
											
											$consultaA2="SELECT * FROM actividadalumnoavanzado WHERE p>=70 AND Id_ctrAlumno='$Id_NumControlAlumno'"; 
											$alumnoA2=mysqli_query($conex,$consultaA2);
											$countA2=mysqli_num_rows($alumnoA2);
											
											if($count==1 AND $countA2==1 OR $countA2==2){
											$arreglo=mysqli_fetch_array($alumnoA2);
												$Id_NumeroControl=$arreglo['Id_ctrAlumno'];
												$sqlA="SELECT * FROM dalumn,dclist,dcarre,grupos,actividadesextraescolares,actividadalumnoavanzado WHERE dclist.aluctr=dalumn.aluctr AND dclist.carcve=dcarre.carcve AND dalumn.aluctr='$Id_NumeroControl' AND actividadAvanzado=IdActE AND Id_Grupos=IDgrupoA  AND Id_ctrAlumno='$Id_NumeroControl' AND p>=70 ORDER BY periodoAlumnoAvanzado ASC LIMIT 0,1"; //Consult
												$SQLresultadoA=mysqli_query($conex,$sqlA); //Llamado de la conexion con la consulta
												$countLista=mysqli_num_rows($SQLresultadoA); 
												while($Alumno=mysqli_fetch_array($SQLresultadoA)){
						?>
							<tr>
								<td><?php echo $Alumno['aluctr'] ?></td>
								<td><?php echo ($Alumno['aluapp'].' '.$Alumno['aluapm'].' '.$Alumno['alunom'])?></td>
								<td><?php echo $Alumno['Carnom']?></td>
								<td><?php echo $Alumno['clinpe']?></td>
								<td><?php echo $Alumno['nombreActividad']?></td>
							
								<td><button class="boton"><a class="boton" href="php/LiberacionAlumnoI.php?id=<?php echo ($Alumno['id_actividadAlumnoAvanzado']);?>&count=<?php echo ($count);?>&countA2=<?php echo ($countA2);?>">Imprimir</a></button> </td>
							</tr>
	<?php 
							 } mysqli_free_result($SQLresultadoA);  
						
								}
						}
							echo "</table>";
						} 
					}else {
						echo "<br>Resultados encontrados: Ninguno";
						
					}

		 ?>
		</div>
		</form>
<?php } ?>


 <script src="../../js/menu.js"></script>
</body>		
</html>