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
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
<title>Extraescolares </title>
<?php
	date_default_timezone_set("America/Mexico_City");
	include("../../Php/conexion.php");
	$ctr=$_SESSION['login'];
	$periodo=$_SESSION['perioso'];
	
	$sqlIcon="SELECT * FROM logos WHERE id_logos=2";
	$queryIcon=mysqli_query($conex,$sqlIcon);
	$icon=mysqli_fetch_array($queryIcon);
	
	$sqlEncabezado="SELECT * FROM logos WHERE id_logos=1";
	$queryEncabezado=mysqli_query($conex,$sqlEncabezado);
	$encabezado=mysqli_fetch_array($queryEncabezado);
?>

<link rel="icon" type="image/ico" href="<?php echo ('../../Imagen/'.$icon['nombre_imagen']);?>">
<link rel="stylesheet" type="text/css" href="../../Css/style.css" />
<link rel="stylesheet" type="text/css" href="../../Css/tablas.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<head/>

<script>
	//validacion de documentos con peso mayor a 150KB
	Filevalidation = () => {
        const fi = document.getElementById('file');
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
                const fsize = fi.files.item(i).size;
                if (fsize >= 150000) {
                   alert(
                      "El archivo supera el peso de 150KB");
                } 
            }
        }
    }

	function validarFormularioAvanzado(){
		var varEdad = document.getElementById('edadA').value;
		var varTelefono = document.getElementById('telefono').value;
		var varCorreo = document.getElementById('correo').value;
		
		
		if(!(/^([1][7-9]|[2-5][0-9]|[6][0-5])$/.test(varEdad)) ) {
				alert('Edad Verifica la edad.');
			return false;
		}
		
		if(!(/^(\d{10})$/.test(varTelefono)) ) {
				alert('Teléfono: Verifica tu núm. de telefono.');
			return false;
		}
			
		if(!(/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.itssat)*(.edu)*(.mx)$/.test(varCorreo)) ) {
				alert('Teléfono: Verifica el formato(Ej.: ***@alumno.itssat.edu.mx).');
			return false;
		}
	}

	function validarFormulario(){
		var varSangre = document.getElementById('tipoSangre').value;
		var varEdad = document.getElementById('edadA').value;
		var varTelefono = document.getElementById('telefono').value;
		var varCorreo = document.getElementById('correo').value;
		
		if(!(/^([A|B|AB|O|a|b|ab|o]+[\+|\-])$/.test(varSangre)) ) {
				alert('Tipo de sangre: Verifica el formato (Ej.: O+).');
			return false;
		}
		
		if(!(/^([1][7-9]|[2-5][0-9]|[6][0-5])$/.test(varEdad)) ) {
				alert('Edad: Verifica la edad.');
			return false;
		}
		
		if(!(/^(\d{10})$/.test(varTelefono)) ) {
				alert('Teléfono: Verifica tu núm. de telefono.');
			return false;
		}
			
		if(!(/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.itssat)*(.edu)*(.mx)$/.test(varCorreo)) ) {
				alert('Teléfono: Verifica el formato(Ej.: ***@alumno.itssat.edu.mx).');
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

<script type="text/javascript">
document.oncontextmenu = function(){return false;}
</script>
<div class="encabezado" align="center"> <img src="<?php echo ('../../Imagen/'.$encabezado['nombre_imagen']);?>" alt="Imagen" title="Logos" align="center"/></div>
<span class="nav-bar" id="btnMenu"><i class="fas fa-bars"></i> Menú</span>
	<nav class="main-nav">
<?php	
$sqlAlumnoA="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$ctr' AND periodoAlumnoAvanzado='$periodo'";
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
<?Php
$sqlDalumn="SELECT aluctr,aluapp,aluapm,alunom FROM dalumn WHERE aluctr='$ctr'";
$qryDalumn=mysqli_query($conex,$sqlDalumn);
$mstraDalumn=mysqli_fetch_array($qryDalumn); 
$nombre=$mstraDalumn['alunom'].' '.$mstraDalumn['aluapp'].' '.$mstraDalumn['aluapm'];

$sqlSemestreAlumno="SELECT clinpe,carcve FROM dclist WHERE aluctr='$ctr'";
$qrySem=mysqli_query($conex,$sqlSemestreAlumno);
$mstraSem=mysqli_fetch_array($qrySem);

$carrera=$mstraSem['carcve'];
$sqlCarreraA="SELECT Carcve,Carnom FROM dcarre WHERE Carcve='$carrera'";
$qryCarrera=mysqli_query($conex,$sqlCarreraA);
$mstraCarrera=mysqli_fetch_array($qryCarrera);

$sqlDtosA="SELECT tipoSangre,alergia,telefonoAvanzadoAlumno,correoAvanzadoAlumno FROM datosalumno WHERE id_AlumnoCTR='$ctr'";
$qryDtosA=mysqli_query($conex,$sqlDtosA);
$mstraDtosA=mysqli_fetch_array($qryDtosA);
$counterActa=mysqli_num_rows($qryDtosA);

$sqlGrupos="SELECT Id_Grupos,nombreActividad,numeroGrupo,horaGrupo,IdActE,nombreGrupo,diaGrupo FROM grupos,actividadesextraescolares WHERE id_ActividadE=IdActE AND estatusGrupo='Activo' AND IdPeriodoExtraGrupos='$periodo' AND disponiblesGrupo>0"; 
$qryGrupos=mysqli_query($conex,$sqlGrupos); 	
if($mstraSem['clinpe']<=5){
	$sqlActA="SELECT * FROM actividadalumno WHERE Id_NumControlAlumno='$ctr' AND PeriodoExtraescolarId='$periodo'";
	$qryActA=mysqli_query($conex,$sqlActA);
	$counter=mysqli_num_rows($qryActA);
	$mtrsActA=mysqli_fetch_array($qryActA);
	$grupo=$mtrsActA['IdGrupo'];
	
	$sqlActElegida="SELECT nombreActividad,numeroGrupo,horaGrupo FROM grupos,actividadesextraescolares WHERE id_ActividadE=IdActE AND Id_Grupos='$grupo'"; 
	$qryActElegida=mysqli_query($conex,$sqlActElegida); 	
	$mstraActEle=mysqli_fetch_array($qryActElegida);
	
	$sqlCal="SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$ctr' AND promedio>=70";
	$qryCal=mysqli_query($conex,$sqlCal);
	$mstrCal=mysqli_fetch_array($qryCal);
	$cal2=mysqli_num_rows($qryCal);
	
?>
<Form action="Php/registroDoc.php?id=<?php echo $ctr?>" method="post" enctype="multipart/form-data"  onSubmit="return validarFormulario()">
<div id="main-container">
<!--DATOS ALUMNOS TABLA SUPERIOR-->
<h2>Datos del alumno</h2>
<table>
	<thead>
	<tr>
		<th>Numero de control</th>
		<th>Nombre</th>
		<th>Carrera</th>
		<th>Semestre</th>
		<th>Tipo sanguíneo</th>
		<th>Alergia o padecimiento</th>
		<th>Edad</th>
		<th>Teléfono</th>
		<th>Correo institucional</th>
		
	</tr>
	</thead>
	<tr>
	<?php 
		echo '
		<td>'.$ctr.'</td>
		<td>'.$nombre.'</td>
		<td>'.$mstraCarrera['Carnom'].'</td>
		<td>'.$mstraSem['clinpe'].'</td>'; 
		if($mstraDtosA['tipoSangre']==''){ echo '<td><input type="text" id="tipoSangre" name="tipoSangre" size="25" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['tipoSangre'].'</td>';} 
		if($mstraDtosA['alergia']==''){ echo '<td><input type="text" id="alergia" name="alergia" size="10" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['alergia'].'</td>';} 
		if($mtrsActA['edadA']==''){ echo '<td><input type="text" id="edadA" name="edadA" size="10" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mtrsActA['edadA'].'</td>';} 
		if($mstraDtosA['telefonoAvanzadoAlumno']==''){ echo '<td><input type="text" id="telefono" name="telefono" size="20" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['telefonoAvanzadoAlumno'].'</td>';} 
		if($mstraDtosA['correoAvanzadoAlumno']==''){ echo '<td><input type="text" id="correo" name="correo" size="25" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['correoAvanzadoAlumno'].'</td>';} 
	?>
	</tr>
	</table>
<br/></br>

<!--Programa de atención al alumno(PREGUNTAS)-->
<table> 
<thead>
<tr>
	<th>Programa de atención al alumno</th>
	<th>Si</th>
	<th>No</th>
</tr>
</thead>
	<tr>
		<td>¿Te han diagnosticado algún problema cardiaco?</td>
		<?php if($mtrsActA['preg1']==''){
				echo'<td><input type="radio" name="preg1" value="Si" required="obligatorio"></input></td>
					<td><input type="radio" name="preg1" value="No" required="obligatorio"></input></td>';
			}else{
				if ($mtrsActA['preg1']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	<tr>
		<td>¿Tienes dolores en el corazón o pecho con frecuencia y sin causa aparente?</td>
		<?php if($mtrsActA['preg2']==''){
				echo'<td><input type="radio" name="preg2" value="Si" required="obligatorio"></input></td>
					<td><input type="radio" name="preg2" value="No" required="obligatorio"></input></td>';
			}else{
				if($mtrsActA['preg2']=='Si'){echo '<td>X</td><td></td>';}else{echo '<td></td><td>X</td>';}
			}
		?>
	</tr>
	<tr>
		<td>¿Sueles sentirte cansado(a), con mareos frecuentes o haber perdido el conocimiento sin ninguna causa aparente?</td>
		<?php if($mtrsActA['preg3']==''){
				echo'<td><input type="radio" name="preg3" value="Si" required="obligatorio"></input></td>
					<td><input type="radio" name="preg3" value="No" required="obligatorio"></input></td>';
			}else{
				if ($mtrsActA['preg3']=='Si'){echo'<td>X</td><td></td>';}else{echo'<td></td><td>X</td>';}
			}
		?>
	</tr>
	<tr>
		<td>¿Tienes dolores en los huesos o articulaciones por cirugía, artritis u otras causas que te afecten con cualquier movimiento o ejercicio?</td>
		<?php if($mtrsActA['preg4']==''){
				echo'<td><input type="radio" name="preg4" value="Si" required="obligatorio"></input></td>
						<td><input type="radio" name="preg4" value="No" required="obligatorio"></input></td>';
			}else{
				if($mtrsActA['preg4']=='Si'){echo'<td>X</td><td></td>';}else{echo'<td></td><td>X</td>';}
			}
			error_reporting(0);
		?>
	</tr>
	<tr>
		<td>¿Tomas algún medicamento por enfermedad crónica?</td>
		<?php if($mtrsActA['preg5']==''){
				echo'<td><input type="radio" name="preg5" value="Si" required="obligatorio"></input></td>
					<td><input type="radio" name="preg5" value="No" required="obligatorio"></input></td>';
			}else{
				if($mtrsActA['preg5']=='Si'){echo'<td>X</td><td></td>';}else{echo'<td></td><td>X</td>';}
			}	
	?>
	</tr>
	<tr>
		<td>¿Existen alguna actividad no mencionada aquí por la cual no deberías hacer actividad deportiva o cultural?</td>
		<?php if($mtrsActA['preg6']==''){
				echo'<td><input type="radio" name="preg6" value="Si" required="obligatorio"></input></td>
					<td><input type="radio" name="preg6" value="No" required="obligatorio"></input></td>';
			}else{
				if($mtrsActA['preg6']=='Si'){echo'<td>X</td><td></td>';}else{echo'<td></td><td>X</td>';}
			}
		?>
	</tr>
</table>
<br/></br>

<!--Acreditacion de documentos.1 Opcion de subir un documento extra, 2 Volver a subir documento en caso de rechazo-->
<h2>Acreditación de documentos (PDF - Menor a 150KB)</h2>
<table>
<thead>
<tr>
	<th>Horario academico</th>
	<?php if($alumnoArray['AD1']==1){ echo '<th>Otros documentos</th>';} ?>
</tr>
</thead>
<tr><?php 
	if($counter<1 OR $periodo!=$mtrsActA['PeriodoExtraescolarId'] OR $mtrsActA['Estatus']=='Negado'){ 
		echo'<td><input type="file" name="horario" id="file" onchange="Filevalidation()" size="5"></td></td>';
		if($alumnoArray['AD1']==1){
			echo '<td><input type="file" name="documento" id="file" onchange="Filevalidation()" size="5"></td></td>';
		}
	}else if($mtrsActA['Estatus']=='Aceptado' OR $mtrsActA['Estatus']==''){  ?>
			<td><?php echo $mtrsActA['nombreHorario'] ?></br><button type="submit" class="boton"><a class="boton" href="../../Php/download.php?filename=<?php echo $mtrsActA['nombreHorario'];?>&f=<?php echo $mtrsActA['nombreHorario']?>"> Descargar</button></td></td>
		<?php if($alumnoArray['AD1']==1){ ?>
			<td><?php echo $mtrsActA['cetificadoMedico'] ?></br><button type="submit" class="boton"><a class="boton" href="../../Php/download.php?filename=<?php echo $mtrsActA['nombreCertificado'];?>&f=<?php echo $mtrsActA['nombreCertificado']?>"> Descargar</button></td></td><?php 
		}	
	}
?>
</tr>
</table>
<br/></br>

<?php

if($mtrsActA['Estatus']=='Negado' OR $counter<1 ){ 
			//Mostrará las actividades disponibles  
?>
		<h2>Listado de actividades disponibles</h2>
			<table><thead><tr>
					<th>Actividad, grupo y horarios disponibles</th>
				</tr></thead>
				<tr>
				<td> <select name="actividadE"> 
				<?php  
					while($row=mysqli_fetch_assoc($qryGrupos)){  
						if($carrera==9 OR $carrera==12 OR $carrera==13 OR $carrera==14){  
							if($row['diaGrupo']=="Sabado" AND $row['nombreGrupo']!="TALLER"){
								 echo '<option value="'.$row['Id_Grupos'].'">'.$row['nombreActividad'].' ---- '.$row['numeroGrupo'].' ---- '.$row['horaGrupo'].'</option>';	
							}
						}else{ 
							if($row['diaGrupo']!="Sabado" AND $row['nombreGrupo']!="TALLER"  AND $row['nombreGrupo']!="taller" AND $row['nombreGrupo']!="Taller" ){
								echo '<option value="'.$row['Id_Grupos'].'">'.$row['nombreActividad'].' ---- '.$row['numeroGrupo'].' ---- '.$row['horaGrupo'].'</option>';	
							}
						}
					}mysqli_free_result($qryGrupos); ?>
				</td></tr>
			</table>
<?php 
}else if($mtrsActA['Estatus']=='Aceptado' OR $mtrsActA['Estatus']=='' ){ 
		echo'<h2>Datos de la actividad seleccionada</h2>
			<table><thead><tr>
					<th>Actividad</th>
					<th>Grupo</th>
					<th>Horario</th>
				</tr></thead>
				<tr><td>'.$mstraActEle['nombreActividad'].'</td>
				<td>'.$mstraActEle['numeroGrupo'].'</td>
				<td>'.$mstraActEle['horaGrupo'].'</td></tr>
			</table>';
}

if($cal2==2){
	echo($cal2);
		echo'<h2><center/><p2>Solicitar liberación en el departamento extraescolares</p2></h2>';
}else if($counterActa!=0 AND $counter==0) { //envia edad, tabla atencion alumno, actividada y grupo
		echo'<center/><button class="boton" type="submit" name="actualizar" id="actualizar" onclick="return mensajes()">Enviar</button>';
}else{
	if($periodo!=$mtrsActA['PeriodoExtraescolarId']){	//formulario completo
		echo'<center/><button class="boton" type="submit" name="Registrar" id="Registrar" onclick="return mensajes()">Enviar</button>';
	}else if($counter!=0){ //enviar en el periodo actual en caso de rechazo, actividad y documento
	
		if($mtrsActA['Estatus']=='Aceptado'){
			 echo'';
		}else if($mtrsActA['Estatus']==''){
			echo'<h2><center/><p2>En espera</p2></h2>';
		}else if($mtrsActA['Estatus']=='Negado'){
			 echo'<center/><button class="boton" type="submit" name="Registrar" id="Registrar" onclick="return mensajes()">Enviar</button>';
		}
	}
}

?>
</form>
<?php }else{ 

		$sql1="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$ctr' AND periodoAlumnoAvanzado='$periodo'";
		$query=mysqli_query($conex,$sql1);
		$counter=mysqli_num_rows($query);
		$mstrAlumAvan=mysqli_fetch_array($query);
		$grupo=$mstrAlumAvan['IDgrupoA'];
	
		$sqlActElegida="SELECT nombreActividad,numeroGrupo,horaGrupo FROM grupos,actividadesextraescolares WHERE id_ActividadE=IdActE AND Id_Grupos='$grupo'"; 
		$qryActElegida=mysqli_query($conex,$sqlActElegida); 	
		$mstraActEle=mysqli_fetch_array($qryActElegida);
		
		

?>
<form action="Php/registroAvanzado.php?id=<?php echo $ctr?>" method="post" enctype="multipart/form-data" onSubmit="return validarFormularioAvanzado()">
<div id="main-container">
<h2>Datos del alumno</h2>
<table>
	<thead>
	<tr>
		<th>Numero de control</th>
		<th>Nombre</th>
		<th>Carrera</th>
		<th>Semestre</th>
		<th>Edad</th>
		<th>Teléfono</th>
		<th>Correo institucional</th>
	</tr>
	</thead>
<!CODIGO PARA MOSTRAR LOS USUARIOS EN LA TABLA>
	<tr>
		<?php 
		echo '
		<td>'.$ctr.'</td>
		<td>'.$nombre.'</td>
		<td>'.$mstraCarrera['Carnom'].'</td>
		<td>'.$mstraCarrera['Carcve'].'</td>'; 
		if($mstrAlumAvan['edadAvanzado']==''){ echo '<td><input type="text" id="edadA" name="edadA" size="10" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstrAlumAvan['edadAvanzado'].'</td>';} 
		if($mstraDtosA['telefonoAvanzadoAlumno']==''){ echo '<td><input type="text" id="telefono" name="telefono" size="20" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['telefonoAvanzadoAlumno'].'</td>';} 
		if($mstraDtosA['correoAvanzadoAlumno']==''){ echo '<td><input type="text" id="correo" name="correo" size="25" required="obligatorio" maxlength="50"></td>'; }else{ echo '<td>'.$mstraDtosA['correoAvanzadoAlumno'].'</td>';} 
	?>
	</tr>
</table>
<br/></br>
<?php 
 
if($mstrAlumAvan['estatusAvanzado']=='Negado' OR $counter<1){
	echo '<h2>Listado de actividades disponibles</h2>
			<table><thead><tr>
					<th>Nombre del taller(TECNM)</th>
					<th colspan="2">Actividad, grupo y horarios disponibles</th>
				</tr></thead>
				<tr>
				<td><input type="text" id="nombreTaller" name="nombreTaller" size="25" required="obligatorio"></td>
				<td><select name="actividadE">';
					while($row=mysqli_fetch_array($qryGrupos)){
						if($row['nombreGrupo']=="TALLER"){
							echo '<option value="'.$row['Id_Grupos'].'">'.$row['nombreActividad'].' ---- '.$row['numeroGrupo'].' ---- '.$row['horaGrupo'].'</option>';	
						}
					}
					echo '
				</select></td>
				<td><button class="boton" type="submit" name="Enviar" id="Enviar" onclick="return mensajes()">Enviar</button></td>
				</tr>
			</table>
	<br></br>';
}else if($mstrAlumAvan['estatusAvanzado']=='Aceptado' OR $mstrAlumAvan['estatusAvanzado']==''){
	echo '<h2>Datos de la actividad seleccionada</h2>
			<table><thead><tr>
					<th>Taller</th>
					<th>Actividad</th>
					<th>Grupo</th>
					<th>Horario</th>
				</tr></thead>
				<tr><td>'.$mstrAlumAvan['actividadesfisicas_1'].'</td>
				<td>'.$mstraActEle['nombreActividad'].'</td>
				<td>'.$mstraActEle['numeroGrupo'].'</td>
				<td>'.$mstraActEle['horaGrupo'].'</td></tr>
			</table>
	<br></br>';
}
if($mstrAlumAvan['estatusAvanzado']=='Aceptado' AND $counter==1 AND $mstrAlumAvan['nombreactividadesfisicas_1']==''){	
	echo'<h2>Acreditacion de documentos (PDF - Menor a 150K)</h2>
	<table>
	<thead>
	<tr>
		<th colspan="2">Constancia del taller</th>
	</tr>
	</thead>
	<tr>
		<td><input type="file" name="C1" id="file" onchange="Filevalidation()" size="5"></td></td>
		<td><button class="boton" type="submit" name="Actualizar" id="Actualizar" onclick="return mensajes()">Enviar</button></td>
	</tr>
		
	</table>';
}else if($mstrAlumAvan['nombreactividadesfisicas_1']!=''){
	echo'<h2>Acreditacion de documentos (PDF - Menor a 150KB)</h2>
	<table>
	<thead>
	<tr>
		<th colspan="2">Constancia del taller</th>
	</tr>
	</thead>
	<tr>
		<td><a href="../../Php/download.php?filename='.$mstrAlumAvan['nombreactividadesfisicas_1'].'&f='.$mstrAlumAvan['nombreactividadesfisicas_1'].'">Curso1'.$mstrAlumAvan['Id_ctrAlumno'].'</a></td>
	</tr>
	</table>';
}
?>
<br></br>
<?php 
	$sql1="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$ctr' AND periodoAlumnoAvanzado='$periodo'";
	$query=mysqli_query($conex,$sql1);
	$counter=mysqli_num_rows($query);	 
	$row=mysqli_fetch_assoc($query);
	
	$sqlA="SELECT * FROM actividadalumnoavanzado WHERE Id_ctrAlumno='$ctr' AND p>70";
	$queryA=mysqli_query($conex,$sqlA);
	$counterA=mysqli_num_rows($queryA);
					
	$sqlC="SELECT * FROM calificacionesalumno WHERE Id_NumeroControl='$ctr' AND promedio>70";
	$queryC=mysqli_query($conex,$sqlC);
	$counterC=mysqli_num_rows($queryC);
				
	if($counter!=0 AND $counterA==2 OR $counterC==1){
		if($ver['evaluacionNumero']!=''){
				echo('<center><h3>Solicitar liberación</h3></center>');
		}
	}
	?>
</form>		
<?php } ?>
<script src="../../js/menu.js"></script>
</body>		
</html>