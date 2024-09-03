<?php
session_start();
	session_id();
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=4){
		header("location:../../../index.php");
		exit;
		}
	}
			include("../../../Php/conexion.php"); //Llamado a la conexion
			if(isset($_POST['enviar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$periodo=$_SESSION['perioso']; //Periodo extraescolar actual
				$idCalificación=$_GET['id'];
				$nivelDesempeño=$_POST['nivelDesempeño'];	
				$observaciones=$_POST['observaciones'];
				
				if($nivelDesempeño=='Insuficiente'){$valorNumerico=0;} 
				else if($nivelDesempeño=='Suficiente'){$valorNumerico=1;}
				else if($nivelDesempeño=='Bueno'){$valorNumerico=2;}
				else if($nivelDesempeño=='Notable'){$valorNumerico=3;}
				else{$valorNumerico=4;}
				
				
				$sql="UPDATE calificacionesalumno SET observaciones='$observaciones',valorNumerico='$valorNumerico',nivelDesempeño='$nivelDesempeño' WHERE idCalificaciones = '$idCalificación'";
				echo($sql);
				$resultado=mysqli_query($conex,$sql);
				header("location:../reportecolab.php");
			}
			
			
			
			if(isset($_POST['imprimir'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				$idCalificación=$_GET['id'];
				
				$sql="SELECT * FROM calificacionesalumno,dalumn,periodosescolares,actividadesextraescolares,actividadalumno WHERE Id_NumeroControl=Id_NumControlAlumno AND Id_NumeroControl=aluctr AND idPeriodosEscolares=periodoCalificacionesExtraescolar AND Id_ElegidaActividadAlumno=Id_actividadAlumno AND IdActE=actividadE AND idCalificaciones = '$idCalificación'";
				$query=mysqli_query($conex,$sql);
				$mostrar=mysqli_fetch_array($query);
				$IdPeriodoExtraGrupos=$mostrar['periodoCalificacionesExtraescolar'];
			
			
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=AnexoXVII'.$mostrar['Id_NumeroControl'].'.doc');

				
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
				
				echo '<html>
							<style>
								table.lineas{ border-collapse: collapse; border: black 1px solid;}
								body{ font-family:Neo Sans Pro; font-size:14.5px;}
								p.titulo{ text-align: center; font-weight:bold; font-size:15px;}
								td.negritas{font-weight:bold;}
								td.centro{text-align: center;}
							</style>
								<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
							<body>
								<p class="Titulo">ANEXO XVII. FORMATO DE EVALUACIÓN AL DESEMPEÑO DE LA ACTIVIDAD COMPLEMENTARIA</p>
								<table> 
									<tr>
										<td class="negritas">Nombre del estudiante: </td>
										<td>'.$mostrar['alunom'].' '.$mostrar['aluapp'].' '.$mostrar['aluapm'].'</td>
									</tr>
									<tr>
										<td class="negritas">Actividad complementaria: </td>
										<td>'.$mostrar['nombreActividad'].'</td>
									</tr>
									<tr>
										<td class="negritas">Periodo de realización: </td>
										<td>'.$mesInicio.' - '.$mesFin.'</td>
									</tr>
								</table>
								
								<br></br>
								
								<table border="1" class="lineas"> 
										<thead>
										<tr>
											<th rowspan="2">No. </th>
											<th rowspan="2">Criterios a evaluar:</th>
											<th colspan="5">Nivel de desempeño del criterio(4): </th>
										</tr>
											<tr>
												<td class="negritas">Insuficiente</td>
												<td class="negritas">Suficiente</td>
												<td class="negritas">Bueno</td>
												<td class="negritas">Notable</td>
												<td class="negritas">Excelente</td>
											</tr>
										<thead>
									<tr c>
										<td>1</td>
										<td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>';
											if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
											else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
											else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
											else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
											else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>2</td>
										<td>Trabaja en equipo y se adapta a nuevas situaciones.</td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>3</td>
										<td>Muestra liderazgo en las actividades encomendadas.</td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>4</td>
										<td>Organiza su tiempo y trabaja de manera proactiva.</td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>5</td>
										<td>Interpreta la realidad y se Sensibiliza aportando soluciones a la problemática con la actividad. </td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>6</td>
										<td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>7</td>
										<td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>';
										if($mostrar['nivelDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['nivelDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else if($mostrar['nivelDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td colspan="7" class="negritas">
											Observaciones: '.$mostrar['observaciones'].'<br></br>
											Valor numérico de la actividad complementaria: '.$mostrar['valorNumerico'].'<br></br>
											Nivel de desempeño alcanzado de la actividad complementaria: '.$mostrar['nivelDesempeño'].'<br></br>
										</td>
									</tr>
								</table>
							</body>
					</html>';
			}
			
			
			
			if(isset($_POST['regresar'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				header("location:../reportecolab.php");
			}
			
			//OPERACIONES PARA ALUMNOS MOOCS
			
			if(isset($_POST['regresarIrre'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				header("location:../reportecolabMOOCS.php");
			}
			
			if(isset($_POST['imprimirIrre'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				$idCalificación=$_GET['id'];
				
				$sql="SELECT * FROM actividadalumnoavanzado,dalumn,periodosescolares,actividadesextraescolares WHERE 	Id_ctrAlumno=dalumn.aluctr AND IdActE=actividadAvanzado AND id_actividadAlumnoAvanzado='$idCalificación'";
				$query=mysqli_query($conex,$sql);
				$mostrar=mysqli_fetch_array($query);
				$IdPeriodoExtraGrupos=$mostrar['periodoAlumnoAvanzado'];
			
			
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=AnexoXVII'.$mostrar['Id_ctrAlumno'].'.doc');

				
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
				
				echo '<html>
							<style>
								table.lineas{ border-collapse: collapse; border: black 1px solid;}
								body{ font-family:Neo Sans Pro; font-size:14.5px;}
								p.titulo{ text-align: center; font-weight:bold; font-size:15px;}
								td.negritas{font-weight:bold;}
								td.centro{text-align: center;}
							</style>
								<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
							<body>
								<p class="Titulo">ANEXO XVII. FORMATO DE EVALUACIÓN AL DESEMPEÑO DE LA ACTIVIDAD COMPLEMENTARIA</p>
								<table> 
									<tr>
										<td class="negritas">Nombre del estudiante: </td>
										<td>'.$mostrar['alunom'].' '.$mostrar['aluapp'].' '.$mostrar['aluapm'].'</td>
									</tr>
									<tr>
										<td class="negritas">Actividad complementaria: </td>
										<td>'.$mostrar['nombreActividad'].'</td>
									</tr>
									<tr>
										<td class="negritas">Periodo de realización: </td>
										<td>'.$mesInicio.' - '.$mesFin.'</td>
									</tr>
								</table>
								
								<br></br>
								
								<table border="1" class="lineas"> 
										<thead>
										<tr>
											<th rowspan="2">No. </th>
											<th rowspan="2">Criterios a evaluar:</th>
											<th colspan="5">Nivel de desempeño del criterio(4): </th>
										</tr>
											<tr>
												<td class="negritas">Insuficiente</td>
												<td class="negritas">Suficiente</td>
												<td class="negritas">Bueno</td>
												<td class="negritas">Notable</td>
												<td class="negritas">Excelente</td>
											</tr>
										<thead>
									<tr c>
										<td>1</td>
										<td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>';
											if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
											else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
											else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
											else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
											else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>2</td>
										<td>Trabaja en equipo y se adapta a nuevas situaciones.</td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>3</td>
										<td>Muestra liderazgo en las actividades encomendadas.</td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>4</td>
										<td>Organiza su tiempo y trabaja de manera proactiva.</td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>5</td>
										<td>Interpreta la realidad y se Sensibiliza aportando soluciones a la problemática con la actividad. </td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>6</td>
										<td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td>7</td>
										<td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>';
										if($mostrar['evaluacionDesempeño']=='Insuficiente'){echo '<td>X</td><td></td><td></td><td></td><td></td>';} 
										else if($mostrar['evaluacionDesempeño']=='Suficiente'){echo '<td></td><td>X</td><td></td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Bueno'){echo '<td></td><td></td><td>X</td><td></td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else if($mostrar['evaluacionDesempeño']=='Notable'){echo '<td></td><td></td><td></td><td>X</td><td></td>';}
										else{echo '<td></td><td></td><td></td><td></td><td>X</td>';}
									echo '</tr>
									<tr>
										<td colspan="7" class="negritas">
											Observaciones: '.$mostrar['evaluacionObservacion'].'<br></br>
											Valor numérico de la actividad complementaria: '.$mostrar['evaluacionNumero'].'<br></br>
											Nivel de desempeño alcanzado de la actividad complementaria: '.$mostrar['evaluacionDesempeño'].'<br></br>
										</td>
									</tr>
								</table>
							</body>
					</html>';
			}
			
			if(isset($_POST['enviarIrrE'])){ //Acepta el valor del boton Ingresar (Formulario) del archivo registrousuarios.php
				//Llenado de datos correspondientes del formulario a la BD
				$periodo=$_SESSION['perioso']; //Periodo extraescolar actual
				$idCalificación=$_GET['id'];
				$nivelDesempeño=$_POST['evaluacionDesempeño'];	
				$observaciones=$_POST['observaciones'];
				
				if($nivelDesempeño=='Insuficiente'){$valorNumerico=0 ;} 
				else if($nivelDesempeño=='Suficiente'){$valorNumerico=1; }
				else if($nivelDesempeño=='Bueno'){$valorNumerico=2; }
				else if($nivelDesempeño=='Notable'){$valorNumerico=3; }
				else{$valorNumerico=4; }
				
				
				$sql="UPDATE actividadalumnoavanzado SET evaluacionObservacion='$observaciones',evaluacionNumero='$valorNumerico',evaluacionDesempeño='$nivelDesempeño' WHERE 	id_actividadAlumnoAvanzado = '$idCalificación'";
				echo($sql);
				$resultado=mysqli_query($conex,$sql);
				header("location:../reportecolabMOOCS.php");
			}
			
?>