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
				$periodo = $_SESSION['periodoEscolar'];
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
<link rel="stylesheet" type="text/css" href="../../Css/newStyle.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../../js/Colaborador/ajaxAlumnos.js"></script>
<script src="../Colaborador/modales/infoModalAlumno.js"></script>
</head>


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
<?php
include('navColab.php');
?>




<?php
	include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
	$ActividadDocente=$_SESSION['id_Actividad'];
	
?>

<div id="divTab">
</br>
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

</div>


<div id="catalogo"></div>
<div>
	<div class="button-container">
  		<button id="prevPage" data-page="1" class="custom-button">Anterior</button>
  		<button id="nextPage" data-page="1" class="custom-button">Siguiente</button>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del Alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Alumno</th>
                        <td id="nombre"></td>
                    </tr>
                    <tr>
                        <th>Número de Control</th>
                        <td id="controlAlumno"></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td id="telefono"></td>
                    </tr>
                    <tr>
                        <th>Correo</th>
                        <td id="correo"></td>
                    </tr>
                    <tr>
                        <th>Horario</th>
                        <td id="horario"></td>
                    </tr>
                    <tr>
                        <th>Alergia</th>
                        <td id="alergia"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="status"></td>
                    </tr>
                    <tr>
                        <th>Documento</th>
                        <td id="documento"></td>
                    </tr>
                </table>
            </div>
			<div class="modal-footer d-flex justify-content-between">
    		<!-- Botón "Cerrar" -->
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    
    			<!-- Contenedor para los botones "Permitir" y "Calificar" -->
    			<div>
					<a  id="btnPermitir" href="#"><button type="button" class="btn btn-success">Permitir</button></a>
        			<a  id="btnCalificar" href="#"><button type="button" class="btn btn-primary">Calificar</button></a>
    			</div>
			</div>

        </div>
    </div>
</div>
<script src="../../js/menu.js"></script>
</body>		
</html>