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


<div id="main-container">
<?php 
if(isset($_POST['Listas'])){
	//$actividad = $_POST['numControlDocente'];
?>
<!-- Búsqueda por número de control:!-->
<h2>Alumnos</h2>
<form action="buscar.php" method="post" >
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
	  <tr> 
		<td style="text-align: center;" colspan="2"> Búsqueda por número de control: </td>
		<td> <input required name="PalabraClave" type="text" class="form-control mb-2"  placeholder="Ingrese número de control">  </td>
		<td> <button class="boton" type="submit" name="buscar" id="buscar" class="btn btn-success mb-2">Buscar Ahora</button></td>
	  </tr>
    </div>
	</div>
	</table>
</form>
<!-- Búsqueda por periodo de liberación!-->
<form method="post">
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
		<tr> 
		<td style="text-align: center;" colspan="2"> Búsqueda por periodo de liberación: </td>
	<td><select id="numPeriodo" name="numPeriodo">
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
		</select></td>
	<td><button class="boton" type="submit" name="buscarRegulares" id="buscarRegulares" class="btn btn-success mb-2">Buscar Ahora</button></td>
		
	  </tr>
    </div>
	</div>
	</table>
</form>

<br>
<button class="boton"><a class="boton" href="estadisticas.php"> Regresar</a></button>
<br>
<?php 
}
?>

<?php 
if(isset($_POST['ListasIrre'])){
	//$actividad = $_POST['numControlDocente'];
?>

<h2>Alumnos MOOCS</h2>
<form action="buscar.php" method="post" >
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
	<tr> 
		 <td style="text-align: center;" colspan="2"> Búsqueda por número de control: </td>
		<td><input required name="PalabraClave" type="text" class="form-control mb-2"  placeholder="Ingrese número de control"> </td>
		<td><button class="boton" type="submit" name="buscarIrre" id="buscarIrre" class="btn btn-success mb-2">Buscar Ahora</button> </td>
	</tr>
    </div>
	</div>
	</table>
</form>


<form method="post">
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
		<tr> 
		<td style="text-align: center;" colspan="2"> Búsqueda por periodo de liberación: </td>
		<td><select id="numPeriodo" name="numPeriodo">
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
		</select></td>
		<td> <button class="boton" type="submit" name="buscarIregulares" id="buscarIregulares" class="btn btn-success mb-2">Buscar Ahora</button></td>
	  </tr>
    </div>
	</div>
	</table>
</form>

<button class="boton"><a class="boton" href="estadisticas.php"> Regresar</a></button>

<?php 
}
?>


 <script src="../../js/menu.js"></script>
</body>		
</html>

<!-- CODIGO PHP PARA Búsqueda por periodo de liberación PARA ALUMNOS REGULARES!-->
<?php 
if(isset($_POST['buscarRegulares'])){
	$periodoBuscar = $_POST['numPeriodo'];
?>
</br>
<button class="boton"><a class="boton" href="estadisticas.php"> Regresar</a></button>

	<form>
	<table>
	<thead>
		<tr>
			<th>Numero de control</th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Semestre</th>
			<th>Anexo XVI</th>
		</tr>
	</thead>
	<?php
			include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD	
			
				$sql="SELECT aluctr FROM dalumn"; //Consulta
				$SQLresultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
				while($array=mysqli_fetch_array($SQLresultado)){
					$Id_NumControlAlumno=$array['aluctr'];
					$consultaAlumno="SELECT periodoCalificacionesExtraescolar,Id_NumeroControl FROM calificacionesalumno WHERE promedio>=70 AND Id_NumeroControl='$Id_NumControlAlumno' ORDER BY periodoCalificacionesExtraescolar DESC"; 
					$alumno=mysqli_query($conex,$consultaAlumno);
					$count=mysqli_num_rows($alumno);
					$arreglo=mysqli_fetch_array($alumno);
					if($count==2){
						$Id_NumeroControl=$arreglo['Id_NumeroControl'];
						$idPeriodo = $arreglo['periodoCalificacionesExtraescolar'];
						if($idPeriodo==$periodoBuscar){
							$sqlA="SELECT * FROM dalumn,dclist,dcarre,actividadalumno,grupos,actividadesextraescolares,calificacionesalumno WHERE dclist.aluctr=dalumn.aluctr AND dclist.carcve=dcarre.carcve AND dalumn.aluctr='$Id_NumeroControl' AND actividadE=IdActE AND IdGrupo=Id_Grupos AND Id_NumeroControl='$Id_NumeroControl' AND Id_NumControlAlumno='$Id_NumeroControl' AND Id_ElegidaActividadAlumno=Id_actividadAlumno AND promedio>=70 ORDER BY periodoCalificacionesExtraescolar DESC LIMIT 0,1"; //Consulta
							$SQLresultadoA=mysqli_query($conex,$sqlA); //Llamado de la conexion con la consulta
							$countLista=mysqli_num_rows($SQLresultadoA); 
							while($Alumno=mysqli_fetch_array($SQLresultadoA)){
							
	?> 
	<tr>
		<td><?php echo $Alumno['aluctr'] ?></td>
		<td><?php echo ($Alumno['alunom'].' '.$Alumno['aluapp'].' '.$Alumno['aluapm']); ?></td>
		<td><?php echo $Alumno['Carnom'] ?></td>
		<td><?php echo $Alumno['clinpe'] ?></td>
		<?php 
		?>
		<td><button class="boton"><a class="boton" href="php/DocAnexoXVI.php?id=<?php echo ($Alumno['idCalificaciones']);?>">Imprimir</a></button> </td>
			<?php ?>
	</tr>
<?php
							} mysqli_free_result($SQLresultadoA);  
						}
					}
		} mysqli_free_result($SQLresultado);   
?> 
</table>
</div>
</form>
<?php
}
?>

<!-- CODIGO PHP PARA Búsqueda por periodo de liberación PARA ALUMNOS IREGULARES!-->
<?php 
if(isset($_POST['buscarIregulares'])){
	$periodoBuscar = $_POST['numPeriodo'];
?>
</br>
<button class="boton"><a class="boton" href="estadisticas.php"> Regresar</a></button>
<form>
	<table>
	<thead>
		<tr>
			<th>Numero de control</th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Semestre</th>
			<th>Anexo XVI</th>
		</tr>
	</thead>
	<?php
			include ("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD	
			
				$sql="SELECT aluctr FROM dalumn"; //Consulta
				$SQLresultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
				while($array=mysqli_fetch_array($SQLresultado)){
					$Id_NumControlAlumno=$array['aluctr'];
					$consultaAlumno="SELECT  Id_NumeroControl,periodoCalificacionesExtraescolar FROM calificacionesalumno WHERE promedio>=70 AND Id_NumeroControl='$Id_NumControlAlumno' ORDER BY periodoCalificacionesExtraescolar DESC"; 
					$alumnoC=mysqli_query($conex,$consultaAlumno);
					$count=mysqli_num_rows($alumnoC);
					$arrayalunmoRegular=mysqli_fetch_array($alumnoC);
					$periodoAlumno=$arrayalunmoRegular['periodoCalificacionesExtraescolar'];
			
					$consultaA2="SELECT periodoAlumnoAvanzado,Id_ctrAlumno FROM actividadalumnoavanzado WHERE p>=70 AND Id_ctrAlumno='$Id_NumControlAlumno' ORDER BY periodoAlumnoAvanzado DESC"; 
					$alumnoA2=mysqli_query($conex,$consultaA2);
					$countA2=mysqli_num_rows($alumnoA2);
					$arreglo=mysqli_fetch_array($alumnoA2);
					$periodoAvanzado=$arreglo['periodoAlumnoAvanzado'];
					
					if($periodoAlumno > $periodoAvanzado){
						$periodo = $periodoAlumno;
					}else{
						$periodo = $periodoAvanzado;
					}
					if($count==1 AND $countA2==1  OR $countA2==2){
						
						$Id_NumeroControl=$arreglo['Id_ctrAlumno'];
						$sqlA="SELECT * FROM dalumn,dclist,dcarre,grupos,actividadesextraescolares,actividadalumnoavanzado WHERE dclist.aluctr=dalumn.aluctr AND dclist.carcve=dcarre.carcve AND dalumn.aluctr='$Id_NumeroControl' AND actividadAvanzado=IdActE AND Id_Grupos=IDgrupoA  AND Id_ctrAlumno='$Id_NumeroControl' AND p>=70 ORDER BY periodoAlumnoAvanzado ASC LIMIT 0,1"; //Consult
						$SQLresultadoA=mysqli_query($conex,$sqlA); //Llamado de la conexion con la consulta
						$countLista=mysqli_num_rows($SQLresultadoA); 
						while($Alumno=mysqli_fetch_array($SQLresultadoA)){
							if($periodo==$periodoBuscar){
	?> 
	<tr>
		<td><?php echo $Alumno['aluctr'] ?></td>
		<td><?php echo ($Alumno['alunom'].' '.$Alumno['aluapp'].' '.$Alumno['aluapm']); ?></td>
		<td><?php echo $Alumno['Carnom'] ?></td>
		<td><?php echo $Alumno['clinpe'] ?></td>
		<td><button class="boton"><a class="boton" href="php/LiberacionAlumnoI.php?id=<?php echo ($Alumno['id_actividadAlumnoAvanzado']);?>&count=<?php echo ($count);?>&countA2=<?php echo ($countA2);?>">Imprimir</a></button> </td>
	</tr>
<?php
							}
						} mysqli_free_result($SQLresultadoA);  
						
					}
		} mysqli_free_result($SQLresultado);   
?> 
</table>
</div>
</form>
<?php
}
?>