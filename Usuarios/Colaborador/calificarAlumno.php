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
			include ("../../Php/conexion.php");
			$periodo = $_SESSION['periodoEscolar'];
			$ActividadDocente=$_SESSION['id_Actividad'];
			$fechaGuardada=$_SESSION['ultimoAcceso'];
			$ahora=date('Y-n-j H:i:s');
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
<link rel="icon" type="image/ico" href="../../Imagen/Icon.png">
<link rel="stylesheet" type="text/css" href="../../Css/style.css" />
<link rel="stylesheet" type="text/css" href="../../Css/newStyle.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../../js/Colaborador/ajaxCalificacionAlumnos.js"></script>
	</head>

<body>
<div class="encabezado" align="center">
<img src="../../Imagen/Header.png" alt="Imagen" title="Logos" align="center"/>
</div>
<?php include('../Colaborador/navColab.php')?>
<h2>Filtro de búsqueda</h2>
	<table>
	<div class="form-row align-items-center">
	 <div class="col-auto">
		<tr> 
	<td>
      <input name="PalabraClave" id='numControl' type="text" class="form-control mb-2"  placeholder="Ingrese número de control">  
	</td>
	<td>
	  <select id="carrera" name="carrera">
			<option value="0" selected>Seleccione una carrera</option>
		<?php	
			$sql1="SELECT * FROM dcarre";
			$resultado1=mysqli_query($conex,$sql1);
			while($mostrar1=mysqli_fetch_assoc($resultado1)){
				echo '<option value="'.$mostrar1['Carcve'].'">'.$mostrar1['Carnom'].'</option>';
			} mysqli_free_result($resultado1);
		?>
	</td>
	<td>
	  <select id="grupos" name="grupos">
		<option value="0">Seleccione un grupo</option>
		<?php	
			$sql1="SELECT Id_Grupos,numeroGrupo,nombreGrupo FROM grupos WHERE id_ActividadE='$ActividadDocente' AND IdPeriodoExtraGrupos='$periodo'";
			$resultado1=mysqli_query($conex,$sql1);
			while($mostrar1=mysqli_fetch_assoc($resultado1)){
				echo '<option value="'.$mostrar1['Id_Grupos'].'">'.$mostrar1['numeroGrupo'].' - '.$mostrar1['nombreGrupo'].'</option>';
			} mysqli_free_result($resultado1);
		?> 
	</td>
	<td>
	  <button class="boton" id="Ingresar" class="btn btn-success mb-2">Buscar Alumno</button>
	</td>
	<td>
	  <button id="limpiar" type="button" class="btn btn-primary mb-2">Limpiar Filtros</button>
	</td>
	  </tr>
    </div>
	</div>
	</table>
<h2>Datos del alumno</h2>
<div id="calificaciones"></div>
<div>
	<div class="button-container">
  		<button id="prevPage" data-page="1" class="custom-button">Anterior</button>
  		<button id="nextPage" data-page="1" class="custom-button">Siguiente</button>
	</div>
</div>

<script src="../../js/menu.js"></script>
</body>		
</html>