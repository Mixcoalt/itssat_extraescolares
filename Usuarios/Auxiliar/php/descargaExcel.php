<?php
include ("../../../Php/conexion.php");	
if(isset($_POST['descargar'])){
	setlocale(LC_TIME,"es_ES.UTF-8");
	
	$opcion=$_POST['opcion'];
	
	if($opcion==1){ $opcionNombre="Alumnos"; }
	else if($opcion==2){ $opcionNombre="Alumnos Avanzados"; }
	else if($opcion==3){ $opcionNombre="Grupos"; }
	else{ $opcionNombre="Usuarios";	}
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;Filename=RespaldoExcel '.$opcionNombre.'.xls');
	
	$header='<html> 
				<style>
				table.lineas{ border-collapse: collapse; border: black 1px solid;}
				body{ font-family:Arial; font-size:11px;}
				p.titulo{ text-align: center; font-weight:bold; font-size:15px;}
				p.operacion{ text-align: center; font-weight:bold; font-size:17px;}
				td.negritas{font-weight:bold;}
				td.centro{text-align: center;}
				td.mayusculas{text-transform:uppercase;}
				td.titulos{ border-collapse: collapse; border: black 1px solid; }
			</style>
				<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
			<body>
				<p class="Titulo"><td></td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRES TUXTLA<br></br>
								DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS 
				</p> ';
	$pie='<br></br><br></br>
				
						<p class="Titulo">ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></p>
					
				
			</body>
		</html>';
	if($opcion==1){
		echo($header);
		echo'<p></br>
				PROGRAMA DE ATENCIÓN AL ALUMNO:   </br>
				Preg1.-¿Te han diagnosticado algún problema cardiaco?</br>
				Preg2.-¿Tienes dolores en el corazón o pecho con frecuencia y sin causa aparente?</br>
				Preg3.-¿Sueles sentirte cansado(a), con mareos frecuentes o haber perdido el conocimiento sin ninguna causa aparente?</br>
				Preg4.-¿Tienes dolores en los huesos o articulaciones por cirugía, artritis u otras causas que te afecten con cualquier movimiento o ejercicio?	</br>
				Preg5.-¿Tomas algún medicamento por enfermedad crónica?</br>
				Preg6.-¿Existen alguna actividad no mencionada aquí por la cual no deberías hacer actividad deportiva o cultural?<p>';
		echo'
			<p class="operacion"><td></td> ALUMNOS</br>
			</p> 
			<table>
				<tr>
				<td class="titulos" rowspan="2">No.</td>
				<td class="titulos" rowspan="2">NÚM. CONTROL</td>
				<td class="titulos" rowspan="2">NOMBRE</td>
				<td class="titulos" rowspan="2">EDAD</td>
				<td class="titulos" rowspan="2">TELEFONO</td>
				<td class="titulos" rowspan="2">CORREO</td>
				<td class="titulos" rowspan="2">TIPO DE SANGRE</td>
				<td class="titulos" rowspan="2">ALERGIA</td>
				<td class="titulos" colspan="6">PROGRAMA DE ATENCIÓN AL ALUMNO</td>
				<td class="titulos"  rowspan="2">NOM. GRUPO</td>
				<td class="titulos"  rowspan="2">ESTATUS</td>
				<td class="titulos"  rowspan="2">PROMEDIO</td>
				<td class="titulos"  rowspan="2">NÚM.(EVALUACION DE DESEMPEÑO)</td>
				<td class="titulos"  rowspan="2">OBSERVACION</td>
				<td class="titulos"  rowspan="2">PERIODO</td>
				</tr><tr>
					 <td class="titulos">Preg1</td>
					 <td class="titulos">Preg2</td>
					 <td class="titulos">Preg3</td>
					 <td class="titulos">Preg4</td>
					 <td class="titulos">Preg5</td>
					 <td class="titulos">Preg6</td></tr>';
				
				$sqlAlumno="SELECT Id_NumControlAlumno,Id_actividadAlumno,edadA,preg1,preg2,preg3,preg4,preg5,preg6,IdGrupo,Estatus,PeriodoExtraescolarId FROM actividadalumno ORDER BY PeriodoExtraescolarId";
				$queryAlumno=mysqli_query($conex,$sqlAlumno);
				$a=1;
				while($mostrarAlumno=mysqli_fetch_assoc($queryAlumno)){
					$ctr=$mostrarAlumno['Id_NumControlAlumno'];
					$sqlDalumn="SELECT aluapp,aluapm,alunom,aluctr FROM dalumn WHERE aluctr='$ctr'";
					$queryDalumn=mysqli_query($conex, $sqlDalumn);
					$mostrarDalumn=mysqli_fetch_array($queryDalumn);
					if($mostrarDalumn['aluapp']<>''){
						$ctr=$mostrarDalumn['aluctr']; $grupo=$mostrarAlumno['IdGrupo']; 
						$calificaciones=$mostrarAlumno['Id_actividadAlumno']; $IdPeriodoExtraGrupos=$mostrarAlumno['PeriodoExtraescolarId'];
						
						$sqlDatosAlumno="SELECT tipoSangre,alergia,telefonoAvanzadoAlumno,correoAvanzadoAlumno FROM datosalumno WHERE id_AlumnoCTR='$ctr'";
						$queryDatosAlumno=mysqli_query($conex,$sqlDatosAlumno);
						$mostrarDatosAlumno=mysqli_fetch_array($queryDatosAlumno);
						
						$sqlGrupo="SELECT nombreGrupo FROM grupos WHERE Id_Grupos='$grupo'";
						$queryGrupo=mysqli_query($conex,$sqlGrupo);
						$mostrarGrupo=mysqli_fetch_array($queryGrupo);
						
						$sqlCalificaciones="SELECT promedio,valorNumerico,nivelDesempeño,observaciones FROM calificacionesalumno WHERE idCalificaciones='$calificaciones'";
						$queryCalificaciones=mysqli_query($conex,$sqlCalificaciones);
						$mostrarCalificaciones=mysqli_fetch_array($queryCalificaciones);
						
						$sqlPeriodo="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$IdPeriodoExtraGrupos' ";
						$queryPeriodo=mysqli_query($conex,$sqlPeriodo);
						$mostrarPeriodo=mysqli_fetch_array($queryPeriodo);
						$anoInicio=strftime("%Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
						$anoFin=strftime("%Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						if($anoInicio==$anoFin){
							$mesInicio=strftime("%B",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
							$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						}else{
							$mesInicio=strftime("%B %Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar'])); 
							$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						}
						
					echo '<tr>
							<td>'.$a.'</td>
							<td>'.$ctr.'</td>
							<td>'.$mostrarDalumn['aluapp'].' '.$mostrarDalumn['aluapm'].' '.$mostrarDalumn['alunom'].'</td>
							<td>'.$mostrarAlumno['edadA'].'</td>
							<td>'.$mostrarDatosAlumno['telefonoAvanzadoAlumno'].'</td>
							<td>'.$mostrarDatosAlumno['correoAvanzadoAlumno'].'</td>
							<td>'.$mostrarDatosAlumno['tipoSangre'].'</td>
							<td>'.$mostrarDatosAlumno['alergia'].'</td>
							<td>'.$mostrarAlumno['preg1'].'</td>
							<td>'.$mostrarAlumno['preg2'].'</td>
							<td>'.$mostrarAlumno['preg3'].'</td>
							<td>'.$mostrarAlumno['preg4'].'</td>
							<td>'.$mostrarAlumno['preg5'].'</td>
							<td>'.$mostrarAlumno['preg6'].'</td>
							<td>'.$mostrarGrupo['nombreGrupo'].'</td>
							<td>'.$mostrarAlumno['Estatus'].'</td>
							<td>'.$mostrarCalificaciones['promedio'].'</td>
							<td>'.$mostrarCalificaciones['valorNumerico'].' ('.$mostrarCalificaciones['nivelDesempeño'].')</td>
							<td>'.$mostrarCalificaciones['observaciones'].'</td>
							<td>'.$mesInicio.'-'.$mesFin.'</td>
					</tr>';
					$a++;
					}
				}
			echo('</table>'.$pie);	
	}else if($opcion==2){
		//FORMATO PARA DESCARGAR INFORMACION DE LOS ALUMNOS AVANZADOS
		echo($header);
		echo'
			<p class="operacion"><td></td> ALUMNOS AVANZADOS </br>
			</p> 
			<table>
				<tr>
				<td class="titulos">No.</td>
				<td class="titulos">NÚM. CONTROL</td>
				<td class="titulos">NOMBRE</td>
				<td class="titulos">EDAD</td>
				<td class="titulos">TELEFONO</td>
				<td class="titulos">CORREO</td>
				<td class="titulos">TIPO DE SANGRE</td>
				<td class="titulos">ALERGIA</td>
				<td class="titulos">ACTIVIDAD MOOCS</td>
				<td class="titulos">NOM. GRUPO</td>
				<td class="titulos">PROMEDIO</td>
				<td class="titulos">NÚM.(EVALUACION DE DESEMPEÑO)</td>
				<td class="titulos">OBSERVACION</td>
				<td class="titulos">PERIODO</td>
				</tr>';
				$sqlAlumnoAvanzado="SELECT evaluacionObservacion,Id_ctrAlumno,edadAvanzado,actividadesfisicas_1,IDgrupoA,p,evaluacionDesempeño,evaluacionNumero,periodoAlumnoAvanzado FROM actividadalumnoavanzado ORDER BY periodoAlumnoAvanzado";
				$queryAlumnoAvanzado=mysqli_query($conex,$sqlAlumnoAvanzado);
				$a=1;
				while($mostarAlumnoAvanzado=mysqli_fetch_assoc($queryAlumnoAvanzado)){
					$ctr=$mostarAlumnoAvanzado['Id_ctrAlumno'];
					$sqlDalumn="SELECT aluapp,aluapm,alunom,aluctr FROM dalumn WHERE aluctr='$ctr'";
					$queryDalumn=mysqli_query($conex, $sqlDalumn);
					$mostrarDalumn=mysqli_fetch_array($queryDalumn);
					if($mostrarDalumn['aluapp']<>''){
						$grupo=$mostarAlumnoAvanzado['IDgrupoA']; $ctr=$mostrarDalumn['aluctr']; $IdPeriodoExtraGrupos=$mostarAlumnoAvanzado['periodoAlumnoAvanzado'];
						$sqlDatosAlumno="SELECT tipoSangre,alergia,telefonoAvanzadoAlumno,correoAvanzadoAlumno FROM datosalumno WHERE id_AlumnoCTR='$ctr'";
						$queryDatosAlumno=mysqli_query($conex,$sqlDatosAlumno);
						$mostrarDatosAlumno=mysqli_fetch_array($queryDatosAlumno);
						
						$sqlGrupo="SELECT nombreGrupo FROM grupos WHERE Id_Grupos='$grupo'";
						$queryGrupo=mysqli_query($conex,$sqlGrupo);
						$mostrarGrupo=mysqli_fetch_array($queryGrupo);
						
						$sqlPeriodo="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$IdPeriodoExtraGrupos' ";
						$queryPeriodo=mysqli_query($conex,$sqlPeriodo);
						$mostrarPeriodo=mysqli_fetch_array($queryPeriodo);
						$anoInicio=strftime("%Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
						$anoFin=strftime("%Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						if($anoInicio==$anoFin){
							$mesInicio=strftime("%B",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
							$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						}else{
							$mesInicio=strftime("%B %Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar'])); 
							$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
						}
						
						echo '<tr>
						<td>'.$a.'</td>
						<td>'.$ctr.'</td>
						<td>'.$mostrarDalumn['aluapp'].' '.$mostrarDalumn['aluapm'].' '.$mostrarDalumn['alunom'].'</td>
						<td>'.$mostarAlumnoAvanzado['edadAvanzado'].'</td>
						<td>'.$mostrarDatosAlumno['telefonoAvanzadoAlumno'].'</td>
						<td>'.$mostrarDatosAlumno['correoAvanzadoAlumno'].'</td>
						<td>'.$mostrarDatosAlumno['tipoSangre'].'</td>
						<td>'.$mostrarDatosAlumno['alergia'].'</td>
						<td>'.$mostarAlumnoAvanzado['actividadesfisicas_1'].'</td>
						<td>'.$mostrarGrupo['nombreGrupo'].'</td>
						<td>'.$mostarAlumnoAvanzado['p'].'</td>
						<td>'.$mostarAlumnoAvanzado['evaluacionNumero'].' ('.$mostarAlumnoAvanzado['evaluacionDesempeño'].')</td>
						<td>'.$mostarAlumnoAvanzado['evaluacionObservacion'].'</td>
						<td>'.$mesInicio.'-'.$mesFin.'</td>
						</tr>';	
						$a++;
					}
			} 
		echo('</table>'.$pie);
	}else if($opcion==3){
		//FORMATO PARA DESCARGAR INFORMACION DE LOS GRUPOS
		echo($header);
		echo'
			<p class="operacion"><td></td> GRUPOS </br>
			</p> 
			<table>
				<tr>
				<td class="titulos">No.</td>
				<td class="titulos">ACTIVIDAD</td>
				<td class="titulos">NÚMERO</td>
				<td class="titulos">NOMBRE DEL GRUPO</td>
				<td class="titulos">DIA</td>
				<td class="titulos">HORA</td>
				<td class="titulos">CAPACIDAD</td>
				<td class="titulos">ESTATUS</td>
				<td class="titulos">PERIODO</td>
				</tr>';
			$sqlGrupos="SELECT id_ActividadE,numeroGrupo,nombreGrupo,diaGrupo,horaGrupo,capacidadGrupo,estatusGrupo,IdPeriodoExtraGrupos FROM grupos ORDER BY IdPeriodoExtraGrupos";
			$queryGrupos=mysqli_query($conex,$sqlGrupos);
			$a=1;
			while($mostarGrupos=mysqli_fetch_assoc($queryGrupos)){
				$id_ActividadE=$mostarGrupos['id_ActividadE']; $IdPeriodoExtraGrupos=$mostarGrupos['IdPeriodoExtraGrupos']; 
				//ACTVIDAD
				$sqlActividad="SELECT IdActE,nombreActividad FROM actividadesextraescolares WHERE IdActE='$id_ActividadE'";
				$queryActividad=mysqli_query($conex,$sqlActividad);
				$mostrarActividad=mysqli_fetch_array($queryActividad);
				//TIPO USUARIO
				$sqlPeriodo="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$IdPeriodoExtraGrupos' ";
				$queryPeriodo=mysqli_query($conex,$sqlPeriodo);
				$mostrarPeriodo=mysqli_fetch_array($queryPeriodo);
				$anoInicio=strftime("%Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
				$anoFin=strftime("%Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
				if($anoInicio==$anoFin){
					$mesInicio=strftime("%B",strtotime($mostrarPeriodo['FechaInicioExtraescolar']));
					$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
				}else{
					$mesInicio=strftime("%B %Y",strtotime($mostrarPeriodo['FechaInicioExtraescolar'])); 
					$mesFin=strftime("%B %Y",strtotime($mostrarPeriodo['FechaFinExtraescolar']));
				}
				
				echo'<tr>
				<td>'.$a.'</td>
				<td>'.$mostrarActividad['nombreActividad'].'</td>
				<td>'.$mostarGrupos['numeroGrupo'].'</td>
				<td>'.$mostarGrupos['nombreGrupo'].'</td>
				<td>'.$mostarGrupos['diaGrupo'].'</td>
				<td>'.$mostarGrupos['horaGrupo'].'</td>
				<td>'.$mostarGrupos['capacidadGrupo'].'</td>
				<td>'.$mostarGrupos['estatusGrupo'].'</td>
				<td>'.$mesInicio.'-'.$mesFin.'</td>
				</tr>';
				$a++;
			} 
		echo('</table>'.$pie);
	}else{
		//FORMATO PARA DESCARGAR INFORMACION DE LOS USUARIOS.
		echo($header);
		echo'
			<p class="operacion"><td></td> USUARIOS </br>
			</p> 
			<table>
				<tr>
				<td class="titulos">No.</td>
				<td class="titulos">NOMBRE</td>
				<td class="titulos">LOGIN</td>
				<td class="titulos">TIPO DE USUARIO</td>
				<td class="titulos">ACTIVIDAD</td>
				</tr>';
			$sqlUsuarios="SELECT nombre,apellidoPUsuario,apellidoMUsuario,login,numTipoUsuario,numProgEdu FROM usuarios ORDER BY numTipoUsuario";
			$queryUsuarios=mysqli_query($conex,$sqlUsuarios);
			$a=1;
			while($mostarUsuarios=mysqli_fetch_assoc($queryUsuarios)){
				$numTipoUsuario=$mostarUsuarios['numTipoUsuario']; $numProgEdu=$mostarUsuarios['numProgEdu']; 
				//TIPO USUARIO
				$sqlTipoUsuario="SELECT IdTipoUsuario,nombreTipoUsuario FROM tipousuario WHERE IdTipoUsuario='$numTipoUsuario' ";
				$queryTipoUsuario=mysqli_query($conex,$sqlTipoUsuario);
				$mostrarTipoUsuario=mysqli_fetch_array($queryTipoUsuario);
				//ACTVIDAD
				$sqlActividad="SELECT IdActE,nombreActividad FROM actividadesextraescolares WHERE IdActE='$numProgEdu'";
				$queryActividad=mysqli_query($conex,$sqlActividad);
				$mostrarActividad=mysqli_fetch_array($queryActividad);
				if($mostrarTipoUsuario['IdTipoUsuario']==1 OR $mostrarTipoUsuario['IdTipoUsuario']==3){ $Actividad=''; }
				else{$Actividad=$mostrarActividad['nombreActividad'];}
				
				echo'<tr>
				<td>'.$a.'</td>
				<td>'.$mostarUsuarios['apellidoPUsuario'].' '.$mostarUsuarios['apellidoMUsuario'].' '.$mostarUsuarios['nombre'].'</td>
				<td>'.$mostarUsuarios['login'].'</td>
				<td>'.$mostrarTipoUsuario['nombreTipoUsuario'].'</td>
				<td>'.$Actividad.'</td>
				</tr>';
				$a++;
			} 
		echo('</table>'.$pie);
	}
}
?>