<?php
session_start();
	include ("../../../Php/conexion.php");	
	session_id();
	
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=3){
		header("location:../../../index.php");
		exit;
		}
	}

	if(isset($_POST['Imprimir'])){
		$idGrupos=$_POST['idGrupos'];
		$operacion=$_POST['operacion'];
		
		//INFORMACION DEL GRUPO
		$sql="SELECT * FROM grupos WHERE Id_Grupos='$idGrupos'";
		$resultado1=mysqli_query($conex,$sql);
		$mostrar=mysqli_fetch_array($resultado1);
		$IdPeriodoExtraGrupos=$mostrar['IdPeriodoExtraGrupos'];
		$numControlDocenteExtraescolar=$mostrar['numControlDocenteExtraescolar'];
		$id_ActividadE=$mostrar['id_ActividadE'];
		$nombre=$mostrar['nombreGrupo'];
		
		$actividad="SELECT * FROM actividadesextraescolares WHERE IdActE='$id_ActividadE'";
		$resultado=mysqli_query($conex,$actividad);
		$array=mysqli_fetch_array($resultado);
		
		$docenteConsulta="SELECT * FROM docenteextraescolares WHERE id_Actividad='$id_ActividadE'";
		$docente=mysqli_query($conex,$docenteConsulta);
		$arrayDocente=mysqli_fetch_array($docente);
		
		
		$periodoConsulta="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$IdPeriodoExtraGrupos' ORDER BY idPeriodosEscolares DESC "; //Consulta
		$periodo=mysqli_query($conex,$periodoConsulta); //Llamado de la conexion con la consulta
		$arrayPeriodo=mysqli_fetch_array($periodo); //Inicio del While para mostrar datos en la tabla
		setlocale(LC_TIME,"es_ES.UTF-8");
		$anoInicio=strftime("%Y",strtotime($arrayPeriodo['FechaInicioExtraescolar']));
		$anoFin=strftime("%Y",strtotime($arrayPeriodo['FechaFinExtraescolar']));
		if($anoInicio==$anoFin){
			$mesInicio=strftime("%B",strtotime($arrayPeriodo['FechaInicioExtraescolar']));
			$mesFin=strftime("%B %Y",strtotime($arrayPeriodo['FechaFinExtraescolar']));
		}else{
			$mesInicio=strftime("%B %Y",strtotime($arrayPeriodo['FechaInicioExtraescolar'])); 
			$mesFin=strftime("%B %Y",strtotime($arrayPeriodo['FechaFinExtraescolar']));
		}
		
	if($nombre!="TALLER" AND $nombre!="taller" AND $nombre!="Taller"){
			if($operacion==1){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=Listas'.$array['nombreActividad'].'_'.$idGrupos.'.doc');

				$sql="SELECT * FROM dalumn,actividadalumno,actividadesextraescolares WHERE Id_NumControlAlumno=aluctr AND IdActE='$id_ActividadE' AND IdGrupo='$idGrupos' AND actividadE='$id_ActividadE' AND Estatus='Aceptado' ";
				$query=mysqli_query($conex,$sql);
				
				echo '<html>
					<style>
						table{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
						body{ font-family:arial; font-size:13px; }
					</style>
						<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
					<body>
					<center>
						<label>INSTITUTO TECNOLÓGICO SUPERIOR DE SAN ANDRÉS TUXTLA</label><br></br>
						<label>Departamento de Actividades Extraescolares</label><br></br><br></br>
						<label>Docente: '.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'</label><br></br>
						<label>Actividad: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp Grupo: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp Hora: '.$mostrar['horaGrupo'].' </label><br></br>
						<table border="1" width=600>
							<thead>
								<tr>
									<th>No.</th>
									<th>Núm. Control</th>
									<th>Nombre</th>
									<th colspan="15">Asistencias</th>
								</tr>
							</thead>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
										echo'<tr>
										<td>'.$x.'</td>
										<td>'.$mostrar['aluctr'].'</td>
										<td>'.$mostrar['aluapp'].' '.$mostrar['aluapm'].' '.$mostrar['alunom'].'</td>';
										for($a=1;$a<=15;$a++){echo '<td width=18></td>';}
										echo'</tr>';
										$x++;
									}
						echo '</table> <br></br>
						</center>
					</body>
				</html>';
			}else if($operacion==2){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=Calificaciones'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT * FROM dalumn,actividadalumno,actividadesextraescolares,calificacionesalumno WHERE  Id_NumControlAlumno=aluctr AND Id_NumeroControl=aluctr AND IdActE='$id_ActividadE' AND IdGrupo='$idGrupos' AND actividadE='$id_ActividadE' AND periodoCalificacionesExtraescolar='$IdPeriodoExtraGrupos' AND Id_Docente='$numControlDocenteExtraescolar'";
				$query=mysqli_query($conex,$sql);
				
				echo '
				<!DOCTYPE html>
				<html>
					<style>
						table{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
						body{ font-family:arial; font-size:13px;}
						td.negro{ font-weight:bold;}
					</style>
						<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
				<body>
				<center>
					<label>INSTITUTO TECNOLÓGICO SUPERIOR DE SAN ANDRÉS TUXTLA</label><br></br>
					<label>Departamento de Actividades Extraescolares</label><br></br><br></br>
					<label>Docente:'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'</label><br></br>
					<label>Actividad: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Grupo: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Hora: '.$mostrar['horaGrupo'].' <br></br>
					<table border="1" width=600>
						<thead>
							<tr>
								<th rowspan="2">No.</th>
								<th rowspan="2">Núm. Control</th>
								<th rowspan="2">Nombre</th>
								<th  colspan="4">Calificaciones</th>
							</tr>
							<tr>
								<td class="negro">CAL-1</td>
								<td class="negro">CAL-2</td>
								<td class="negro">CAL-3</td>
								<td class="negro">CAL-F</td>
							</tr>
						</thead>';	
								$x=1;
								while($mostrar=mysqli_fetch_assoc($query)){
									echo'<tr>
									<td>'.$x.'</td>
									<td>'.$mostrar['aluctr'].'</td>
									<td>'.$mostrar['aluapp'].' '.$mostrar['aluapm'].' '.$mostrar['alunom'].'</td>
									<td>'.$mostrar['calificacionUno'].'</td>
									<td>'.$mostrar['calificacionDos'].'</td>
									<td>'.$mostrar['calificacionTres'].'</td>
									<td>'.$mostrar['promedio'].'</td>
									</tr>';
									$x++;
								}
							echo '</table>	<br></br>
							</center>
						</body>
					</html>';
			}else if($operacion==3){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=CedulaInscripcion'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT Id_NumControlAlumno,edadA FROM actividadalumno
				WHERE IdGrupo='$idGrupos' AND actividadE='$id_ActividadE'
				AND  PeriodoExtraescolarId='$IdPeriodoExtraGrupos' AND Estatus='Aceptado'";
				$query=mysqli_query($conex,$sql);
				echo '<html>
						<style>
							table.lineas{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
							body{ font-family:Arial; font-size:14.5px;}
							p.titulo{ text-align: center; font-weight:bold;}
							td.negritas{font-weight:bold;}
							td.firmas{text-align:center; text-transform:uppercase;}
						</style>
							<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
						<body>
						<center>
							<p class="Titulo">Cédula de Inscripción a Actividades Culturales, Deportivas y Recreativas <br></br>
											DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br><br></br>
											INSCRIPCIÓN - PERIODO: '.$mesInicio.' - '.$mesFin.'<br></br><br></br>
											ACTIVIDAD: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp GRUPO: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp HORA: '.$mostrar['horaGrupo'].'
							</p>
							
							<br></br>
							
							<table border="1" class="lineas" width=900> 
								<tr>
									<thead>
										<th>No. </th>
										<th>ESTUDIANTES</th>
										<th>No.  DE CONTROL </th>
										<th>CARRERA  </th>
										<th>SEM </th>
										<th>EDAD </th>
										<th>SEXO </th>
										<th>OBSERVACIONES </th>
									</thead>
								</tr>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
										$ctr=$mostrar['Id_NumControlAlumno'];
										$sqlcarreraA="SELECT alusex,aluapp,aluapm,alunom,Carnco,clinpe FROM dalumn
											 INNER JOIN dclist ON dalumn.aluctr=dclist.aluctr 
											 INNER JOIN dcarre ON dcarre.Carcve=dclist.Carcve 
											 WHERE dalumn.aluctr='$ctr'";
											 $queryCarreraA=mysqli_query($conex,$sqlcarreraA);
											 $informacion=mysqli_fetch_array($queryCarreraA);
											if($informacion['alusex']==1){
												$sexo='M';
											}else{
												$sexo='F';
											}
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$informacion['aluapp'].' '.$informacion['aluapm'].' '.$informacion['alunom'].'</td>
											<td>'.$mostrar['Id_NumControlAlumno'].'</td>
											<td>'.$informacion['Carnco'].'</td>
											<td>'.$informacion['clinpe'].'°</td>
											<td>'.$mostrar['edadA'].'</td>
											<td>'.$sexo.'</td>
											<td></td>
										</tr>';
										$x++;
									}
							echo '</table>
							<br></br><br></br>
							<table width=900> 
								<tr>
									<td class ="firmas" width=100>'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'<br></br>___________________________________________<br></br><b>Promotor Responsable de la Disciplina<br></br></td>
									<td></td>
									<td class ="firmas" width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
								</tr>
							</table> 
							</center>							
						</body>
					</html>';
			}else{
				
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=CedulaResultados'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT Id_NumControlAlumno,promedio FROM actividadalumno
				INNER JOIN calificacionesalumno ON Id_NumControlAlumno=Id_NumeroControl
				WHERE IdGrupo='$idGrupos' AND actividadE='$id_ActividadE'
				AND  PeriodoExtraescolarId='$IdPeriodoExtraGrupos' AND periodoCalificacionesExtraescolar='$IdPeriodoExtraGrupos' 
				AND Estatus='Aceptado' ";
				$query=mysqli_query($conex,$sql);
					echo '<html>
						<style>
							table.lineas{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase; font-size:12px;}
							body{ font-family:Arial; font-size:14.5px;}
							p.titulo{ text-align: center; font-weight:bold;}
							td.negritas{font-weight:bold;}
							td.firmas{text-align: center;}
						</style>
							<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
						<body>
						<center>
							<p class="titulo">Cédula de Resultados a Actividades Culturales, Deportivas y Recreativas<br></br>
											DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br>
											ACTIVIDAD: '.$mostrar['nombreGrupo'].'<br></br>
											PERIODO: '.$mesInicio.' - '.$mesFin.'
							</p>
							
							<br></br>
							
							<table border="1" class="lineas" width=650> 
								<tr>
									<thead>
										<th>No. </th>
										<th>Estudiantes</th>
										<th>No.  De CONTROL </th>
										<th>ESPECIALIDAD   </th>
										<th>SEMESTRE  </th>
										<th>RESULTADO   </th>
									</thead>
								</tr>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
											$ctr=$mostrar['Id_NumControlAlumno'];
										$sqlcarreraA="SELECT alusex,aluapp,aluapm,alunom,Carnco,clinpe FROM dalumn
											 INNER JOIN dclist ON dalumn.aluctr=dclist.aluctr 
											 INNER JOIN dcarre ON dcarre.Carcve=dclist.Carcve 
											 WHERE dalumn.aluctr='$ctr'";
											 $queryCarreraA=mysqli_query($conex,$sqlcarreraA);
											 $informacion=mysqli_fetch_array($queryCarreraA); 
										if($mostrar['promedio']>69){
											$valor='ACREDITADO';
										}else{
											$valor='NO ACREDITADO';
										}
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$informacion['aluapp'].' '.$informacion['aluapm'].' '.$informacion['alunom'].'</td>
											<td>'.$mostrar['Id_NumControlAlumno'].'</td>
											<td>'.$informacion['Carnco'].'</td>
											<td>'.$informacion['clinpe'].'°</td>
											<td>'.$valor.'</td>
										</tr>';
										$x++;
									}
							echo '</table>
							<br></br><br></br>
							<table width=680> 
								<tr>
									<td class ="firmas" width=100>'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'<br></br>___________________________________________<br></br><b>Promotor Responsable de la Disciplina<br></br></td>
									<td></td>
									<td class ="firmas" width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
								</tr>
							</table> 
						</center>
						</body>
					</html>';
			}
	}else{
			if($operacion==1){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=Listas'.$array['nombreActividad'].'_'.$idGrupos.'.doc');

				$sql="SELECT * FROM dalumn,actividadalumnoavanzado,actividadesextraescolares WHERE Id_ctrAlumno=aluctr AND IdActE='$id_ActividadE' AND IDgrupoA='$idGrupos' AND actividadAvanzado='$id_ActividadE' AND 	estatusAvanzado='Aceptado' ";
				$query=mysqli_query($conex,$sql);
				
				echo '<html>
					<style>
						table{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
						body{ font-family:arial; font-size:13px; }
					</style>
						<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
					<body>
					<center>
						<label>INSTITUTO TECNOLÓGICO SUPERIOR DE SAN ANDRÉS TUXTLA</label><br></br>
						<label>Departamento de Actividades Extraescolares</label><br></br><br></br>
						<label>Docente: '.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'</label><br></br>
						<label>Actividad: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp Grupo: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp Hora: '.$mostrar['horaGrupo'].' </label><br></br>
						<table border="1" width=600>
							<thead>
								<tr>
									<th>No.</th>
									<th>Núm. Control</th>
									<th>Nombre</th>
									<th colspan="15">Asistencias</th>
								</tr>
							</thead>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
										echo'<tr>
										<td>'.$x.'</td>
										<td>'.$mostrar['aluctr'].'</td>
										<td>'.$mostrar['aluapp'].' '.$mostrar['aluapm'].' '.$mostrar['alunom'].'</td>';
										for($a=1;$a<=15;$a++){echo '<td width=18></td>';}
										echo'</tr>';
										$x++;
									}
						echo '</table> <br></br>
						</center>
					</body>
				</html>';
			}else if($operacion==2){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=Calificaciones'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT * FROM dalumn,actividadalumnoavanzado,actividadesextraescolares WHERE Id_ctrAlumno=aluctr AND IdActE='$id_ActividadE' AND IDgrupoA='$idGrupos' AND actividadAvanzado='$id_ActividadE' AND 	estatusAvanzado='Aceptado' ";
				$query=mysqli_query($conex,$sql);
				
				echo '
				<!DOCTYPE html>
				<html>
					<style>
						table{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
						body{ font-family:arial; font-size:13px;}
						td.negro{ font-weight:bold;}
					</style>
						<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
				<body>
				<center>
					<label>INSTITUTO TECNOLÓGICO SUPERIOR DE SAN ANDRÉS TUXTLA</label><br></br>
					<label>Departamento de Actividades Extraescolares</label><br></br><br></br>
					<label>Docente:'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'</label><br></br>
					<label>Actividad: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Grupo: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Hora: '.$mostrar['horaGrupo'].' <br></br>
					<table border="1" width=600>
						<thead>
							<tr>
								<th rowspan="2">No.</th>
								<th rowspan="2">Núm. Control</th>
								<th rowspan="2">Nombre</th>
								<th  colspan="4">Calificaciones</th>
							</tr>
							<tr>
								<td class="negro">CAL-1</td>
								<td class="negro">CAL-2</td>
								<td class="negro">CAL-3</td>
								<td class="negro">CAL-F</td>
							</tr>
						</thead>';	
								$x=1;
								while($mostrar=mysqli_fetch_assoc($query)){
									echo'<tr>
									<td>'.$x.'</td>
									<td>'.$mostrar['aluctr'].'</td>
									<td>'.$mostrar['aluapp'].' '.$mostrar['aluapm'].' '.$mostrar['alunom'].'</td>
									<td>'.$mostrar['c1'].'</td>
									<td>'.$mostrar['c2'].'</td>
									<td>'.$mostrar['c3'].'</td>
									<td>'.$mostrar['p'].'</td>
									</tr>';
									$x++;
								}
							echo '</table>	<br></br>
							</center>
						</body>
					</html>';
			}else if($operacion==3){
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=CedulaInscripcion'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT Id_ctrAlumno,edadAvanzado FROM actividadalumnoavanzado
				WHERE IDgrupoA='$idGrupos' AND actividadAvanzado='$id_ActividadE'
				AND periodoAlumnoAvanzado='$IdPeriodoExtraGrupos' AND estatusAvanzado='Aceptado'";
				$query=mysqli_query($conex,$sql);
				echo '<html>
						<style>
							table.lineas{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase;}
							body{ font-family:Arial; font-size:14.5px;}
							p.titulo{ text-align: center; font-weight:bold;}
							td.negritas{font-weight:bold;}
							td.firmas{text-align:center; text-transform:uppercase;}
						</style>
							<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
						<body>
						<center>
							<p class="Titulo">Cédula de Inscripción a Actividades Culturales, Deportivas y Recreativas <br></br>
											DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br><br></br>
											INSCRIPCIÓN - PERIODO: '.$mesInicio.' - '.$mesFin.'<br></br><br></br>
											ACTIVIDAD: '.$array['nombreActividad'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp GRUPO: '.$mostrar['nombreGrupo'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp HORA: '.$mostrar['horaGrupo'].'
							</p>
							
							<br></br>
							
							<table border="1" class="lineas" width=900> 
								<tr>
									<thead>
										<th>No. </th>
										<th>ESTUDIANTES</th>
										<th>No.  DE CONTROL </th>
										<th>CARRERA  </th>
										<th>SEM </th>
										<th>EDAD </th>
										<th>SEXO </th>
										<th>OBSERVACIONES </th>
									</thead>
								</tr>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
										$ctr=$mostrar['Id_ctrAlumno'];
										$sqlcarreraA="SELECT alusex,aluapp,aluapm,alunom,Carnco,clinpe FROM dalumn
											 INNER JOIN dclist ON dalumn.aluctr=dclist.aluctr 
											 INNER JOIN dcarre ON dcarre.Carcve=dclist.Carcve 
											 WHERE dalumn.aluctr='$ctr'";
											 $queryCarreraA=mysqli_query($conex,$sqlcarreraA);
											 $informacion=mysqli_fetch_array($queryCarreraA);
											if($informacion['alusex']==1){
												$sexo='M';
											}else{
												$sexo='F';
											}
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$informacion['aluapp'].' '.$informacion['aluapm'].' '.$informacion['alunom'].'</td>
											<td>'.$mostrar['Id_ctrAlumno'].'</td>
											<td>'.$informacion['Carnco'].'</td>
											<td>'.$informacion['clinpe'].'°</td>
											<td>'.$mostrar['edadAvanzado'].'</td>
											<td>'.$sexo.'</td>
											<td></td>
										</tr>';
										$x++;
									}
							echo '</table>
							<br></br><br></br>
							<table width=900> 
								<tr>
									<td class ="firmas" width=100>'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'<br></br>___________________________________________<br></br><b>Promotor Responsable de la Disciplina<br></br></td>
									<td></td>
									<td class ="firmas" width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
								</tr>
							</table> 
							</center>							
						</body>
					</html>';
			}else{
				
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=CedulaResultados'.$array['nombreActividad'].'_'.$idGrupos.'.doc');
				
				$sql="SELECT Id_ctrAlumno,edadAvanzado,p FROM actividadalumnoavanzado
				WHERE IDgrupoA='$idGrupos' AND actividadAvanzado='$id_ActividadE'
				AND periodoAlumnoAvanzado='$IdPeriodoExtraGrupos' AND estatusAvanzado='Aceptado'";
				$query=mysqli_query($conex,$sql);
					echo '<html>
						<style>
							table.lineas{ border-collapse: collapse; border: black 1px solid; text-transform:uppercase; font-size:12px;}
							body{ font-family:Arial; font-size:14.5px;}
							p.titulo{ text-align: center; font-weight:bold;}
							td.negritas{font-weight:bold;}
							td.firmas{text-align: center;}
						</style>
							<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
						<body>
						<center>
							<p class="titulo">Cédula de Resultados a Actividades Culturales, Deportivas y Recreativas<br></br>
											DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br>
											ACTIVIDAD: '.$mostrar['nombreGrupo'].'<br></br>
											PERIODO: '.$mesInicio.' - '.$mesFin.'
							</p>
							
							<br></br>
							
							<table border="1" class="lineas" width=650> 
								<tr>
									<thead>
										<th>No. </th>
										<th>Estudiantes</th>
										<th>No.  De CONTROL </th>
										<th>ESPECIALIDAD   </th>
										<th>SEMESTRE  </th>
										<th>RESULTADO   </th>
									</thead>
								</tr>';
									$x=1;
									while($mostrar=mysqli_fetch_assoc($query)){
										$ctr=$mostrar['Id_ctrAlumno'];
										$sqlcarreraA="SELECT alusex,aluapp,aluapm,alunom,Carnco,clinpe FROM dalumn
											 INNER JOIN dclist ON dalumn.aluctr=dclist.aluctr 
											 INNER JOIN dcarre ON dcarre.Carcve=dclist.Carcve 
											 WHERE dalumn.aluctr='$ctr'";
											 $queryCarreraA=mysqli_query($conex,$sqlcarreraA);
											 $informacion=mysqli_fetch_array($queryCarreraA);
										if($mostrar['p']>69){
											$valor='ACREDITADO';
										}else{
											$valor='NO ACREDITADO';
										}
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$informacion['aluapp'].' '.$informacion['aluapm'].' '.$informacion['alunom'].'</td>
											<td>'.$mostrar['Id_ctrAlumno'].'</td>
											<td>'.$informacion['Carnco'].'</td>
											<td>'.$informacion['clinpe'].'°</td>
											<td>'.$valor.'</td>
										</tr>';
										$x++;
									}
							echo '</table>
							<br></br><br></br>
							<table width=680> 
								<tr>
									<td class ="firmas" width=100>'.$arrayDocente['nombre_Docente'].' '.$arrayDocente['apellidoPDocente'].' '.$arrayDocente['apellidoMDocente'].'<br></br>___________________________________________<br></br><b>Promotor Responsable de la Disciplina<br></br></td>
									<td></td>
									<td class ="firmas" width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
								</tr>
							</table> 
						</center>
						</body>
					</html>';
			}
	}
}
?>