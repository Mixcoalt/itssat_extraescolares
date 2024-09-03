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

<script>
	function mensajes(){
			var respuesta = confirm("¿Desea actualizar?");
			if(respuesta==true){
				return true;
			}else{
				return false;
			}
		}
</script>

<body>
<center>

<?php
		include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		$_SESSION['login'];
		$idDocente=$_SESSION['login'];

		$sql="SELECT * FROM docenteextraescolares,actividadesextraescolares WHERE numControlDocente='$idDocente' AND id_Actividad=IdActE"; //Consulta
		$resultado=mysqli_query($conex,$sql); //Llamado de la conexion con la consulta
		while($mostrar=mysqli_fetch_assoc($resultado)){ //Inicio del While para mostrar datos en la tabla
?>

<div id="main-container">
<center><h3>HORARIO DE <?php echo $mostrar['nombreActividad']?> </h3></center>
<h4>C. <?php echo($mostrar['nombre_Docente']); echo(" "); echo ($mostrar['apellidoPDocente']); echo(" "); echo ($mostrar['apellidoMDocente']);?></h4>

<?php } mysqli_free_result($resultado); //Cierre del While ?> 

<!PHP PARA MOSTRAR EN EL FORMULARIO Y PODER ACTUALIZAR EN LA BD>
<?php
		include("../../Php/conexion.php"); //Llamado al archivo que conecta a la BD		
		$id_Grupo=$_GET['id'];
		$sql1="SELECT * FROM grupos WHERE Id_Grupos='$id_Grupo'"; //Consulta
		$resultado1=mysqli_query($conex,$sql1);
		$row=mysqli_fetch_array($resultado1);
		$nombre=$row['nombreGrupo'];
?>
<Form action="php/editarHora.php?id=<?php echo $row['Id_Grupos']?>" method="post">
	<center>
	<table>
	<thead><h2>Editar grupo</h2></thead>
	<tr height="50">
	<td>NO.</td>
	<td><input type="text"id="numeroGrupo" name="numeroGrupo" size="25" maxlength="25"/ value="<?php echo $row['numeroGrupo']?>"> </td>
	</tr>
	
	<tr height="50">
	<td>GRUPO:</td>
	<?php if($nombre<>"TALLER"){?>
	<td><input style="text-transform:uppercase" type="text" id="nombreGrupo" name="nombreGrupo" size="50" maxlength="50"/ value="<?php echo $row['nombreGrupo']?>"></td>
	<?php }else{ echo '<td><input type="text" id="nombreGrupo" name="nombreGrupo" size="50" required="obligatorio"  maxlength="50" value="TALLER" readonly></td>'; }?>	
	</tr>
	
	<tr height="50">
	<td>CAPACIDAD:</td>
	<td><input type="text" id="capacidadGrupo" name="capacidadGrupo" size="25" maxlength="25"/ value="<?php echo $row['capacidadGrupo']?>"></td>
	</tr>
	
	<tr>
	<td>DIA:</td>
	<td><select id="diaGrupo" name="diaGrupo">
			<option hidden selected><?php echo $row['diaGrupo']?></option>
			 <option >Lunes</option>
			 <option>Martes</option>
			 <option>Miercoles</option>
			 <option>Jueves</option>
			 <option>Viernes</option>
			 <option>Sabado</option>
	</select></td>
	</tr>

	<tr>
	<td>HORA:</td>
	<td><select id="horaGrupo" name="horaGrupo">
			<option hidden selected><?php echo $row['horaGrupo']?></option>
			 <option>9:00-11:00 H.
			 <option>10:00-12:00 H.
			 <option>11:00-13:00 H.
			 <option>13:00-15:00 H.
			 <option>12:00-14:00 H.
			 <option>14:00-16:00 H.
			 <option>15:00-17:00 H.
			 <option>17:00-19:00 H.
			 <option>16:00-18:00 H.
			 <option>18:00-20:00 H.
			 <option>8:00-13:00 H.
			 <option>14:00-19:00 H.
	</select></td>
	</tr>
	</table>
	<br>
	<button class="boton" type="submit" name="Ingresar" id="Ingresar" onclick="return mensajes()" >Actualizar</button>
</form>

	<script src="../../js/menu.js"></script>
</body>		
</html>