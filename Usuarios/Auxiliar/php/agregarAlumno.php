<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=3){
		header("location:../../../index.php");
		exit;
		}else{
			$fechaGuardada=$_SESSION['ultimoAcceso'];
			$ahora=date('Y-n-j H:i:s');
			$tiempo_transcurrido=(strtotime($ahora)-strtotime($fechaGuardada));
			if($tiempo_transcurrido>=4800){
				session_destroy();
				header("location:../../../index.php");
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
	include ("../../../Php/conexion.php");
	$sql="SELECT * FROM logos WHERE id_logos=2";
	$resultado=mysqli_query($conex,$sql);
	while($fila=mysqli_fetch_assoc($resultado)){
?>

<link rel="icon" type="image/ico" href="<?php echo ('../../../Imagen/'.$fila['nombre_imagen']);?>">

<?php }?>

<link rel="stylesheet" type="text/css" href="../../../Css/style.css" />
<link rel="stylesheet" type="text/css" href="../../../Css/tablas.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<head/>
<script>

	function validarFormulario(){
			var varControl = document.getElementById('numControl').value;
			var VarCurp = document.getElementById('curp').value;
			
			
			if(!(/^[A-Z0-9]{8}$/.test(varControl)) ) {
				alert('Verifique Num. Control ("U" mayúscula, 8 dígitos)');
				  return false;
			}
			if(!(/^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[0-9]{2}$/.test(VarCurp))) {
				alert('Verifique curp(Mayúsculas,números, 18 dígitos)');
				  return false;
			}
	}

	function mensajes(){
			var respuesta=confirm("Desea agregar?");
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
<img src="<?php echo ('../../../Imagen/'.$fila['nombre_imagen']);?>" alt="Imagen" title="Logos" align="center"/>
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
				if ($auxiliarArray['p1']==1){ echo '<li class="menu__item"><a href="../alumnos.php" class="menu__link">Alumnos</a></li>';}
				if ($auxiliarArray['p2']==1){ echo '<li class="menu__item"><a href="../alumnoIrregulares.php" class="menu__link">Alumnos Irregulares</a></li>';}
				if ($auxiliarArray['p3']==1){ echo '<li class="menu__item"><a href="../escolarizado.php" class="menu__link">Grupos Escolarizado</a></li>';}
				if ($auxiliarArray['p4']==1){ echo ' <li class="menu__item"><a href="../semi.php" class="menu__link">Grupos SemiEscolarizado</a></li>';}
				echo '</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Registro <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">';
			if ($auxiliarArray['p5']==1){ echo '<li class="menu__item"><a href="../registrousuarios.php" class="menu__link">Registrar nuevo usuario</a></li>';}
			if ($auxiliarArray['p6']==1){ echo '<li class="menu__item"><a href="../registroPeriodo.php" class="menu__link">Registrar periodo escolar</a></li>';}
			if ($auxiliarArray['p7']==1){ echo '<li class="menu__item"><a href="../registroPromotoria.php" class="menu__link">Registrar promotoria</a></li>';}
			if ($auxiliarArray['p8']==1){ echo '<li class="menu__item"><a href="../registroCalificaciones.php" class="menu__link">Registrar fecha de parcial</a></li>';}
			if ($auxiliarArray['aC']==1){ echo '<li class="menu__item"><a href="../agregarAlumno.php" class="menu__link">Registrar nuevo alumno</a></li>';}
			echo '</ul>
		</li>

		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Reportes <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">';
			if ($auxiliarArray['p9']==1){ echo '<li class="menu__item"><a href="../estadisticas.php" class="menu__link">Documentos</a></li>';}
			echo '</ul>
		</li>
		
		<li class="menu__item container-submenu"><a href="#" class="menu__link submenu-btn">Configuracion <i class="fas fa-caret-down"></i></a>
			<ul class="submenu">
			<li class="menu__item"><a href="contra.php" class="menu__link">Cambiar contraseña</a></li>';
			if ($auxiliarArray['p0']==1){ echo '<li class="menu__item"><a href="../cargarLogos.php" class="menu__link">Cambiar logos</a></li>';}
			if ($auxiliarArray['aM']==1){ echo '<li class="menu__item"><a href="../privilegios.php" class="menu__link">Asignar privilegios</a></li>';}
			echo '</ul>
		</li>';

		
?>
	<li class="menu__item"><a href="../../../Php/cerrarSesion.php" class="menu__link">Cerrar Sesión</a></li>
	</ul>
	</nav>

	
<?php
	if(isset($_POST['Ingresar'])){ 
		$numControl=$_POST['numControl'];
		$nom=$_POST['nom'];
		$app=$_POST['app'];
		$apm=$_POST['apm'];
		$sexo=$_POST['sexo'];
		$curp=$_POST['curp'];
		$carrera=$_POST['carrera'];
		$semestre=$_POST['semestre'];
		
		$sql="SELECT aluctr FROM dalumn WHERE aluctr='$numControl'";
		$query=mysqli_query($conex,$sql);
		$count=mysqli_num_rows($query);
		if($count!=0){
			echo '<center><br></br> <form action="../agregarAlumno.php";><h1 style="color:red";>Número de control existente</h1>
						<button class="boton">Regresar</button>
					<form> <br></br></center>';
		}else{
					
			$dalumn="INSERT INTO dalumn(aluctr, aluapp, aluapm, alunom, alusex, alucur) 
			VALUES ('$numControl', '$app','$apm', '$nom', '$sexo', '$curp')";
			$resultado=mysqli_query($conex,$dalumn);
					
			$sql="SELECT pdocve FROM dclist WHERE id_DCLIST='1'";
			$query=mysqli_query($conex,$sql);
			$mostrar=mysqli_fetch_array($query);
			$pdocve=$mostrar['pdocve'];
			$dclist="INSERT INTO dclist(aluctr, pdocve, carcve, clinpe) 
			VALUES ('$numControl', '$pdocve','$carrera', '$semestre')";
			echo '<center><br></br> <form action="../agregarAlumno.php";><h1 style="color:red";>Agregado exitosamente</h1>
						<button class="boton">Regresar</button>
					<form> <br></br></center>';
			$resultado=mysqli_query($conex,$dclist);	
		}
	}
?>

<script src="../../../js/menu.js"></script>

</body>		
</html>