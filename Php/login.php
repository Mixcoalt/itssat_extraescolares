<?php
session_start();
include("conexion.php");

function esEstudiante($formatedUser){
	//Expresion regular para saber si es usuario o no
	return (preg_match('/^\d{3}U\d{4}$/', $formatedUser)) ? true : false;	
}

function getPeriodoEscolar($conex){
	$peridoQuery=$conex->prepare("SELECT*FROM periodosescolares ORDER BY idPeriodosEscolares DESC LIMIT 0,1");
	$peridoQuery->execute();
	$periodoResult = $peridoQuery->get_result();
	$periodo = $periodoResult->fetch_assoc();
	return $periodo['idPeriodosEscolares'];
}

function getSemestre($conex, $numControl){
	$sqlQuery = $conex->prepare("SELECT clinpe FROM dclist WHERE aluctr=?");
	$sqlQuery->bind_param("s",$numControl);
	$sqlQuery->execute();
	$result = $sqlQuery->get_result();
	$semestre = $result->fetch_assoc();
	return $semestre['clinpe'];
}

function getArrayTipoUsuario($conex,$tipoUsuario){
	$sqlQuery =$conex->prepare("SELECT * FROM tipousuario WHERE IdTipoUsuario=?");
	$sqlQuery->bind_param("s",$tipoUsuario);
	$sqlQuery->execute();
	$result = $sqlQuery->get_result();
	return $result->fetch_assoc();
}


if(isset($_POST['enviar'])) {
    // Obtención de las credenciales
    $usuario = $_POST['usuario'];
    $password = $_POST['contrasena'];


    // Formateo por seguridad
    $formatedUser = mysqli_real_escape_string($conex, strip_tags($usuario, ENT_QUOTES));
	$formatedPassword = sha1($password);

	//Session de usuario y última conexión
	$_SESSION['login']=$formatedUser;
	$_SESSION['periodoEscolar'] = getPeriodoEscolar($conex);
	$_SESSION['ultimoAcceso']=date('Y-n-j H:i:s');

	//Proceso divido dependiendo si es estudiante o no
	if(esEstudiante($formatedUser)){
		$sqlQuery = $conex->prepare("SELECT * FROM dalumn WHERE aluctr=?");
		$sqlQuery->bind_param("s",$formatedUser);
		$sqlQuery->execute();
		$result = $sqlQuery->get_result();
		if($result->num_rows===1){
			$alumno = $result->fetch_assoc();
			if($password===substr($alumno['alucur'],0,10)){
				$_SESSION['numTipoUsuario']=2;
				$semestre = getSemestre($conex, $formatedUser);
				$alumnoArray = getArrayTipoUsuario($conex,"2");
				if($semestre<6){
					if($alumnoArray['aC']==1){
						header("location:../Usuarios/Alumno/indexalumno.php");
					}else{
						header("location:../servicio.php");
					}
				}else{
					if($alumnoArray['aM']==1){
						header("location:../Usuarios/Alumno/indexalumno.php");
					}else{
						header("location:../servicio.php");
					}
				}
			}else{
				echo "CONTRASEÑA INCORRECTA";
			}
			
		}else{
			echo "NO EXISTE ESE USUARIO";
		}
	}else{
		$sqlQuery = $conex->prepare("SELECT * FROM usuarios WHERE login = ?");
   		$sqlQuery->bind_param("s", $formatedUser);

		$sqlQuery->execute();
		$result = $sqlQuery->get_result();

		if($result->num_rows === 1) {
			$user = $result->fetch_assoc();
			if ($formatedPassword === $user['contrasena']) {
				$_SESSION['id']=$user['Id'];
				$_SESSION['nombre']=$user['nombre'];
				$_SESSION['id_Actividad']=$user['numProgEdu'];
				$_SESSION['numTipoUsuario']=$user['numTipoUsuario'];
				switch ($user['numTipoUsuario']) {
					case '1':
						header("location:../Usuarios/Administrador/indexAd.php");
						break;
					case '3':
						header("location:../Usuarios/Auxiliar/indexauxiliar.php");
						break;
					case '4':
						header("location:../Usuarios/Colaborador/indexcolab.php");
						break;
				}
			
			} else {
				echo "Contraseña incorrecta";
			}
		} else {
			echo "Usuario no encontrado";
		}
	}
    $sqlQuery->close();
}

// Cerrar la conexión
$conex->close();
?>
