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
	function mensajes(){
			var respuesta=confirm("¿Desea agregar?");
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




<form action="php/privilegios.php" method="post" onsubmit="return validarFormulario()">
<center>
<table>
<thead><h2>USUARIOS</h2></thead>



<thead>
<tr>
    <th>Alumnos</th>
    <th>Colaborador</th>
    <th>Auxiliar</th>
</tr>
</thead>

<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>
    <td><label><input type="checkbox" name="A1" value="1" <?php if ($alumnoArray['p1']==1){ echo ("checked"); }?>> Horarios de grupos</label></td>
<?php $sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'"; $promotorQuery=mysqli_query($conex,$sqlPromotor); $promotorArray=mysqli_fetch_array($promotorQuery);?>
    <td><label><input type="checkbox" name="C1" value="1" <?php if ($promotorArray['p1']==1){ echo ("checked"); }?>> Horarios de grupos</label></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?> 
    <td><label><input type="checkbox" name="B1" value="1" <?php if ($auxiliarArray['p1']==1){ echo ("checked"); }?>> Alumnos</label></td>
</tr>


<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>
	<td><label><input type="checkbox" name="A2" value="1" <?php if ($alumnoArray['p2']==1){ echo ("checked"); }?>> Registrar datos</label></td>
<?php $sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'"; $promotorQuery=mysqli_query($conex,$sqlPromotor); $promotorArray=mysqli_fetch_array($promotorQuery);?>
	<td><label><input type="checkbox" name="C2" value="1" <?php if ($promotorArray['p2']==1){ echo ("checked"); }?>> Registrar grupos</label></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B2" value="1" <?php if ($auxiliarArray['p2']==1){ echo ("checked"); }?>> Alumnos irregulares</label></td>
</tr>


<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>
	<td><label><input type="checkbox" name="A3" value="1" <?php if ($alumnoArray['p3']==1){ echo ("checked"); }?>> Reportes</label></td>
<?php $sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'"; $promotorQuery=mysqli_query($conex,$sqlPromotor); $promotorArray=mysqli_fetch_array($promotorQuery);?>
	<td><label><input type="checkbox" name="C3" value="1" <?php if ($promotorArray['p3']==1){ echo ("checked"); }?>> Alumnos</label></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B3" value="1" <?php if ($auxiliarArray['p3']==1){ echo ("checked"); }?>> Grupos escolarizados</label></td>
</tr>


<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>	
	<td><label><input type="checkbox" name="A4" value="1" <?php if ($alumnoArray['aC']==1){ echo ("checked"); }?>> Abrir o cerrar inscripción a ALUMNOS REGULARES</label></td>
<?php $sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'"; $promotorQuery=mysqli_query($conex,$sqlPromotor); $promotorArray=mysqli_fetch_array($promotorQuery);?>
	<td><label><input type="checkbox" name="C4" value="1" <?php if ($promotorArray['p4']==1){ echo ("checked"); }?>> Taller MOOCS</label></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B4" value="1" <?php if ($auxiliarArray['p4']==1){ echo ("checked"); }?>> Grupos semiescolarizados</label></td>
</tr>


<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>
	<td><label><input type="checkbox" name="A5" value="1" <?php if ($alumnoArray['aM']==1){ echo ("checked"); }?>> Abrir o cerrar inscripción a ALUMNOS IRREGULARES</label></td>
<?php $sqlPromotor="SELECT * FROM tipousuario WHERE IdTipoUsuario='4'"; $promotorQuery=mysqli_query($conex,$sqlPromotor); $promotorArray=mysqli_fetch_array($promotorQuery);?>
	<td><label><input type="checkbox" name="C5" value="1" <?php if ($promotorArray['p5']==1){ echo ("checked"); }?>> Listas</label></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B5" value="1" <?php if ($auxiliarArray['p5']==1){ echo ("checked"); }?>> Registrar nuevo usuario</label></td>
</tr>


<tr>
<?php $sqlAlumno="SELECT * FROM tipousuario WHERE IdTipoUsuario='2'"; $alumnoQuery=mysqli_query($conex,$sqlAlumno);$alumnoArray=mysqli_fetch_array($alumnoQuery);?>
	<td><label><input type="checkbox" name="AD1" value="1" <?php if ($alumnoArray['AD1']==1){ echo ("checked"); }?>> Otros documentos</label></td>	
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B6" value="1" <?php if ($auxiliarArray['p6']==1){ echo ("checked"); }?>> Registrar periodo escolar</label></td>
</tr>


<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B7" value="1" <?php if ($auxiliarArray['p7']==1){ echo ("checked"); }?>> Registrar promotoria</label></td>
</tr>


<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B8" value="1" <?php if ($auxiliarArray['p8']==1){ echo ("checked"); }?>> Registrar fecha parcial</label></td>
</tr>

<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="nuevoAlum" value="1" <?php if ($auxiliarArray['aC']==1){ echo ("checked"); }?>> Registrar nuevo alumno</label></td>
</tr>

<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B9" value="1" <?php if ($auxiliarArray['p9']==1){ echo ("checked"); }?>> Documentos</label></td>
</tr>

<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="B0" value="1" <?php if ($auxiliarArray['p0']==1){ echo ("checked"); }?>> Cambiar logos</label></td>
</tr>

<tr>
	<td></td>
	<td></td>
<?php $sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="BD" value="1" <?php if ($auxiliarArray['AD1']==1){ echo ("checked"); }?>> Base de Datos</label></td>
</tr>

<!--tr>
	<td></td>
	<td></td>
<?php //$sqlAuxiliar="SELECT * FROM tipousuario WHERE IdTipoUsuario='3'"; $auxiliarQuery=mysqli_query($conex,$sqlAuxiliar); $auxiliarArray=mysqli_fetch_array($auxiliarQuery);?>
	<td><label><input type="checkbox" name="aM" value="1" <?php //if ($auxiliarArray['aM']==1){ echo ("checked"); }?>> Privilegios</label></td>
</tr-->


</table><br>
	<button class="boton" type="submit" name="Ingresar" id="Ingresar" onclick="return mensajes()">Asignar privilegios</button></td>
</center>


 <script src="../../js/menu.js"></script>
</body>		
</html>