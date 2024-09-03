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
	include ("../../Php/conexion.php");
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
		<a href="#" class="menu__link submenu-btn">Catálogo <i class="fas fa-caret-down"></i></a>
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


<div id="main-container">

<h2>Alumnos Irregulares</h2>

<form action="buscar.php" method="post" >
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
		<tr> 
	<td>
      <input required name="PalabraClave" type="text" class="form-control mb-2"  placeholder="Ingrese número de control">  
	  </td>
	 <td>
	  <button class="boton" type="submit" name="irregulares" id="irregulares" class="btn btn-success mb-2">Buscar Ahora</button>
	  </td>
	  </tr>
    </div>
	</div>
	</table>
</form> 

<form action="buscar.php" method="post" >

	 
	
	<table>
	<div>
	 <div class="col-auto">
		<tr>
	 <td>
	 <select id="numPeriodo" name="numPeriodo">
						  <?php
							$sql="SELECT * FROM periodosescolares ORDER BY idPeriodosEscolares DESC"; //Consulta
							$resultado1=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
							while($mostrar=mysqli_fetch_assoc($resultado1)){ //Inicio del While para mostrar datos en la tabla
							setlocale(LC_TIME,"es_ES.UTF-8");
								$anoInicio=strftime("%Y",strtotime($mostrar['FechaInicioExtraescolar']));
								$anoFin=strftime("%Y",strtotime($mostrar['FechaFinExtraescolar']));
								
							?>
							 <option value="<?php echo $mostrar['idPeriodosEscolares']?>">
									<?php
										if($anoInicio==$anoFin){
											echo strftime("%B",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" al ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));
										}else{
										  echo strftime("%B %Y",strtotime($mostrar['FechaInicioExtraescolar'])); echo(" al ");echo strftime("%B %Y",strtotime($mostrar['FechaFinExtraescolar']));
										}
									?>
							 </option>
							<?php
						} mysqli_free_result($resultado1); //Cierre del While ?> 
						</select>
	  </td>
	  
	  <td>
				<button class="boton" type="submit" name="acreditadosIrre" id="acreditadosIrre" class="btn btn-success mb-2">Acreditados</button>
				<button class="boton" type="submit" name="noAcreditadosIrre" id="noAcreditadosIrre" class="btn btn-success mb-2">No acreditados</button>
		</td>
		<td>
	  <button class="boton" type="submit" name="evaluar" id="Evaluar" >Sin aceptar</button>
	  </td>
	  </tr>
    </div>
	</div>
	</table>
	
</form>

 <script src="../../js/menu.js"></script>
</body>		
</html>