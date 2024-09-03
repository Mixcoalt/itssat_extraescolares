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

	if(isset($_POST['Visualizar'])){
		
		$numPeriodo=$_POST['numPeriodo'];
		$operacion=$_POST['operacion'];	
		
		$periodoConsulta="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$numPeriodo' ORDER BY idPeriodosEscolares DESC "; //Consulta
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
				<head>
				<link rel="stylesheet" type="text/css" href="../../../Css/style.css" />
				<link rel="stylesheet" type="text/css" href="../../../Css/tablas.css" />
				</head>
			<body>
			<center> <br></br>
				<p class="Titulo"><td></td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRES TUXTLA<br></br>
								DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br>
								INSCRIPCIÓN - PERIODO: '.$mesInicio.' - '.$mesFin.'<br></br>
				</p>
				
				<table width=500> 
					<tr>
							<thead> 
							<th rowspan="2">No. </th>
							<th rowspan="2">Extraescolar</th>'; 	
									$sql="SELECT * FROM dcarre";
									$resultado=mysqli_query($conex,$sql);
									$countCarrera=mysqli_num_rows($resultado);
									while($mostar=mysqli_fetch_assoc($resultado)){ 
										echo '<th colspan="2" width=40>'.$mostar['Carnco'].'</th>';
									}
									echo '<th rowspan="2">Total </th>';
									echo '</tr>';
									echo ' <tr>';
											for($a=1;$a<=$countCarrera;$a++){
												echo '<td class="negritas">H</td><td class="negritas">M</td>';
											}
									echo '</tr></thead>';
								
									$sql1="SELECT * FROM actividadesextraescolares";
									$resultado1=mysqli_query($conex,$sql1);
									$x=1; $suma=0; 
									while($mostrar=mysqli_fetch_assoc($resultado1)){
										$id_Actividad=$mostrar['IdActE'];
										$idInicio=$id_Actividad;
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$mostrar['nombreActividad'].' </td>';
											
											$sql="SELECT * FROM dcarre";
											$resultado=mysqli_query($conex,$sql);
											$NumeroCarreras=0;
											while($mostrar=mysqli_fetch_assoc($resultado)){
												$countHN=0;$countHA=0;$countMN=0;$countMA=0;
												$id_Carrera=$mostrar['Carcve'];
												$sqlAlumno="SELECT Id_NumControlAlumno,actividadE,Estatus,PeriodoExtraescolarId FROM actividadalumno INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno WHERE dclist.carcve='$id_Carrera' AND Estatus='Aceptado' AND PeriodoExtraescolarId='$numPeriodo' AND actividadE='$id_Actividad'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$ctrAlumno=$mostrarAlumno['Id_NumControlAlumno'];
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														$AlumCTR=$mostrarDalum['aluctr'];
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_NumControlAlumno']){
															$sqlCalificacion="SELECT promedio FROM calificacionesalumno WHERE Id_NumeroControl='$AlumCTR' AND periodoCalificacionesExtraescolar='$numPeriodo'";
															$queryCalificacion=mysqli_query($conex,$sqlCalificacion);
															$calificacionAlumno=mysqli_fetch_array($queryCalificacion);
															if($operacion==1 AND $calificacionAlumno['promedio']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $calificacionAlumno['promedio']>0 AND $calificacionAlumno['promedio']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $calificacionAlumno['promedio']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
																
															}
														}
														
													}

												}
												
												$sqlAlumno="SELECT 	Id_ctrAlumno,estatusAvanzado,actividadAvanzado,periodoAlumnoAvanzado,p FROM actividadalumnoavanzado INNER JOIN dclist ON dclist.aluctr=Id_ctrAlumno WHERE dclist.carcve='$id_Carrera' AND estatusAvanzado='Aceptado' AND periodoAlumnoAvanzado='$numPeriodo' AND actividadAvanzado='$id_Actividad'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_ctrAlumno']){
															if($operacion==1 AND $mostrarAlumno['p']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $mostrarAlumno['p']>0 AND $mostrarAlumno['p']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $mostrarAlumno['p']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHA++;
																}else{
																	$countMA++;
																}
																
															}
														}
														
													}

												}
												
												$countH=$countHN+$countHA;
												$countM=$countMN+$countMA;
												
												echo '<td class="centro">';if ($countH==0){echo '';}else{echo ($countH);}echo '</td><td class="centro">';
												if ($countM==0){echo '';}else{echo ($countM);}echo '</td>';
														
												$suma=$suma+$countM+$countH;
												$NumeroCarreras++;
											}
										echo '<td class="centro">';if ($suma==0){echo '';}else{echo ($suma);}echo '</td>';	
										echo '</tr>';
										$ejemplo=$x;
										$x++;
										if($ejemplo!=$x){
											$suma=0;
										}
									}
									
								
								echo 
								'<tr>
									<td colspan="2">Sub Total</td>';
									
									$SumaTotal=0;$a=0;
									$sql="SELECT * FROM dcarre";
									$resultado=mysqli_query($conex,$sql);
									while($mostrar=mysqli_fetch_assoc($resultado)){
										$countHN=0;$countHA=0;$countMN=0;$countMA=0;
										$id_Carrera=$mostrar['Carcve'];
										$sqlAlumno="SELECT Id_NumControlAlumno,actividadE,Estatus,PeriodoExtraescolarId FROM actividadalumno INNER JOIN actividadesextraescolares ON IdActE=actividadE INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno WHERE dclist.carcve='$id_Carrera' AND Estatus='Aceptado' AND PeriodoExtraescolarId='$numPeriodo'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$ctrAlumno=$mostrarAlumno['Id_NumControlAlumno'];
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														$AlumCTR=$mostrarDalum['aluctr'];
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_NumControlAlumno']){
															
															$sqlCalificacion="SELECT promedio FROM calificacionesalumno WHERE Id_NumeroControl='$AlumCTR' AND periodoCalificacionesExtraescolar='$numPeriodo'";
															$queryCalificacion=mysqli_query($conex,$sqlCalificacion);
															$calificacionAlumno=mysqli_fetch_array($queryCalificacion);
														if($operacion==1 AND $calificacionAlumno['promedio']==0){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==2 AND $calificacionAlumno['promedio']>0 AND $calificacionAlumno['promedio']<70){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==3 AND $calificacionAlumno['promedio']>69){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==4){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
															
														}
														}
														
													}

												}
												$sqlAlumno="SELECT 	Id_ctrAlumno,estatusAvanzado,actividadAvanzado,periodoAlumnoAvanzado,p FROM actividadalumnoavanzado INNER JOIN actividadesextraescolares ON IdActE=actividadAvanzado INNER JOIN dclist ON dclist.aluctr=Id_ctrAlumno WHERE dclist.carcve='$id_Carrera' AND estatusAvanzado='Aceptado' AND periodoAlumnoAvanzado='$numPeriodo'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_ctrAlumno']){
														if($operacion==1 AND $mostrarAlumno['p']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $mostrarAlumno['p']>0 AND $mostrarAlumno['p']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $mostrarAlumno['p']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHA++;
																}else{
																	$countMA++;
																}
																
															}
														}
														
													}

												}
												$countH=$countHN+$countHA;
												$countF=$countMN+$countMA;
										
										if($countH==0){echo '<td class="centro"></td>';}else{echo '<td class="centro">'.$countH.'</td>';}	
										if($countF==0){echo '<td class="centro"></td>';}else{echo '<td class="centro">'.$countF.'</td>';}
										$SumaTotal=$SumaTotal+$countH+$countF;
										$total=$countH+$countF;
										$array[$a]=$total;
										$a++;
									}
										if($SumaTotal==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$SumaTotal.'</td>';}
								echo '</tr>';
								
								echo 
								'<tr>
									<td colspan="2">Total</td>';
									
									for($a=0;$a<$NumeroCarreras;$a++){	
										if($array[$a]==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$array[$a].'</td>';}				
										
									}
									
									if($SumaTotal==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$SumaTotal.'</td>';}
								echo '</tr>';

				echo '</table>
				<br></br><br></br>
					<form action="../estadisticas.php";>	
						<button class="boton">Regresar</button>
					<form>
				<center> <br></br>
			</body>
		</html>';
		
	}
	
	
	if(isset($_POST['Imprimir'])){
		
		$numPeriodo=$_POST['numPeriodo'];
		$operacion=$_POST['operacion'];	
		
		header('Content-type: application/vnd.ms-word');
		header('Content-Disposition: attachment;Filename=Estadisticas'.$operacion.'.doc');
		
		
		$periodoConsulta="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$numPeriodo' ORDER BY idPeriodosEscolares DESC "; //Consulta
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
				body{ font-family:Arial; font-size:11px;}
				p.titulo{ text-align: center; font-weight:bold;}
				td.negritas{font-weight:bold;}
				td.firmas{text-align: center;}
				td.centro{text-align: center;}
			</style>
				<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
			<body>
				<p class="Titulo"><td></td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRES TUXTLA<br></br>
								DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br><br></br>
								INSCRIPCIÓN - PERIODO: '.$mesInicio.' - '.$mesFin.'<br></br>
				</p>
				
				<table border="1" class="lineas" width=900> 
					<tr>
						<thead>
							<th rowspan="2">No. </th>
							<th rowspan="2">Extraescolar</th>'; 	
									$sql="SELECT * FROM dcarre";
									$resultado=mysqli_query($conex,$sql);
									$countCarrera=mysqli_num_rows($resultado);
									while($mostar=mysqli_fetch_assoc($resultado)){ 
										echo '<th colspan="2" width=40 style="font-size:9px;";>'.$mostar['Carnco'].'</th>';
									}
									echo '<th rowspan="2">Total </th>';
									echo '<thead></tr>';
									echo ' <tr>';
											for($a=1;$a<=$countCarrera;$a++){
												echo '<td class="negritas">H</td><td class="negritas">M</td>';
											}
									echo '</tr>';
								
									$sql1="SELECT * FROM actividadesextraescolares";
									$resultado1=mysqli_query($conex,$sql1);
									$x=1; $suma=0;
									while($mostrar=mysqli_fetch_assoc($resultado1)){
										$id_Actividad=$mostrar['IdActE'];
										$idInicio=$id_Actividad;
										
										echo '<tr>
											<td>'.$x.'</td>
											<td>'.$mostrar['nombreActividad'].' </td>';
											
										$sql="SELECT * FROM dcarre";
											$resultado=mysqli_query($conex,$sql);
											$NumeroCarreras=0;
											while($mostrar=mysqli_fetch_assoc($resultado)){
												$countHN=0;$countHA=0;$countMN=0;$countMA=0;
												$id_Carrera=$mostrar['Carcve'];
												$sqlAlumno="SELECT Id_NumControlAlumno,actividadE,Estatus,PeriodoExtraescolarId FROM actividadalumno INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno WHERE dclist.carcve='$id_Carrera' AND Estatus='Aceptado' AND PeriodoExtraescolarId='$numPeriodo' AND actividadE='$id_Actividad'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$ctrAlumno=$mostrarAlumno['Id_NumControlAlumno'];
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														$AlumCTR=$mostrarDalum['aluctr'];
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_NumControlAlumno']){
															$sqlCalificacion="SELECT promedio FROM calificacionesalumno WHERE Id_NumeroControl='$AlumCTR' AND periodoCalificacionesExtraescolar='$numPeriodo'";
															$queryCalificacion=mysqli_query($conex,$sqlCalificacion);
															$calificacionAlumno=mysqli_fetch_array($queryCalificacion);
															if($operacion==1 AND $calificacionAlumno['promedio']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $calificacionAlumno['promedio']>0 AND $calificacionAlumno['promedio']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $calificacionAlumno['promedio']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
																
															}
														}
														
													}

												}
												
												$sqlAlumno="SELECT 	Id_ctrAlumno,estatusAvanzado,actividadAvanzado,periodoAlumnoAvanzado,p FROM actividadalumnoavanzado INNER JOIN dclist ON dclist.aluctr=Id_ctrAlumno WHERE dclist.carcve='$id_Carrera' AND estatusAvanzado='Aceptado' AND periodoAlumnoAvanzado='$numPeriodo' AND actividadAvanzado='$id_Actividad'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_ctrAlumno']){
															if($operacion==1 AND $mostrarAlumno['p']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $mostrarAlumno['p']>0 AND $mostrarAlumno['p']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $mostrarAlumno['p']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHA++;
																}else{
																	$countMA++;
																}
																
															}
														}
														
													}

												}
												
												$countH=$countHN+$countHA;
												$countM=$countMN+$countMA;
												
												echo '<td class="centro">';if ($countH==0){echo '';}else{echo ($countH);}echo '</td><td class="centro">';
												if ($countM==0){echo '';}else{echo ($countM);}echo '</td>';
														
												$suma=$suma+$countM+$countH;
												$NumeroCarreras++;
											}
										echo '<td class="centro">';if ($suma==0){echo '';}else{echo ($suma);}echo '</td>';	
										echo '</tr>';
										$ejemplo=$x;
										$x++;
										if($ejemplo!=$x){
											$suma=0;
										}
									}
									
								
								echo 
								'<tr>
									<td colspan="2">Sub Total</td>';
									
									$SumaTotal=0;$a=0;
									$sql="SELECT * FROM dcarre";
									$resultado=mysqli_query($conex,$sql);
									while($mostrar=mysqli_fetch_assoc($resultado)){
										$countHN=0;$countHA=0;$countMN=0;$countMA=0;
										$id_Carrera=$mostrar['Carcve'];
										$sqlAlumno="SELECT Id_NumControlAlumno,actividadE,Estatus,PeriodoExtraescolarId FROM actividadalumno INNER JOIN actividadesextraescolares ON IdActE=actividadE INNER JOIN dclist ON dclist.aluctr=Id_NumControlAlumno WHERE dclist.carcve='$id_Carrera' AND Estatus='Aceptado' AND PeriodoExtraescolarId='$numPeriodo'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$ctrAlumno=$mostrarAlumno['Id_NumControlAlumno'];
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														$AlumCTR=$mostrarDalum['aluctr'];
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_NumControlAlumno']){
															
															$sqlCalificacion="SELECT promedio FROM calificacionesalumno WHERE Id_NumeroControl='$AlumCTR' AND periodoCalificacionesExtraescolar='$numPeriodo'";
															$queryCalificacion=mysqli_query($conex,$sqlCalificacion);
															$calificacionAlumno=mysqli_fetch_array($queryCalificacion);
														if($operacion==1 AND $calificacionAlumno['promedio']==0){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==2 AND $calificacionAlumno['promedio']>0 AND $calificacionAlumno['promedio']<70){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==3 AND $calificacionAlumno['promedio']>69){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
														}else if($operacion==4){
															if($mostrarDalum['alusex']==1){
																$countHN++;
															}else{
																$countMN++;
															}
															
														}
														}
														
													}

												}
												$sqlAlumno="SELECT 	Id_ctrAlumno,estatusAvanzado,actividadAvanzado,periodoAlumnoAvanzado,p FROM actividadalumnoavanzado INNER JOIN actividadesextraescolares ON IdActE=actividadAvanzado INNER JOIN dclist ON dclist.aluctr=Id_ctrAlumno WHERE dclist.carcve='$id_Carrera' AND estatusAvanzado='Aceptado' AND periodoAlumnoAvanzado='$numPeriodo'";
												$resultadoAlumno=mysqli_query($conex,$sqlAlumno);
												
												while($mostrarAlumno=mysqli_fetch_assoc($resultadoAlumno)){
													$sqlDalum="SELECT alusex,aluctr FROM dalumn";
													$resultadoDalum=mysqli_query($conex,$sqlDalum);
													while($mostrarDalum=mysqli_fetch_assoc($resultadoDalum)){
														if($mostrarDalum['aluctr']==$mostrarAlumno['Id_ctrAlumno']){
														if($operacion==1 AND $mostrarAlumno['p']==0){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==2 AND $mostrarAlumno['p']>0 AND $mostrarAlumno['p']<70){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==3 AND $mostrarAlumno['p']>69){
																if($mostrarDalum['alusex']==1){
																	$countHN++;
																}else{
																	$countMN++;
																}
															}else if($operacion==4){
																if($mostrarDalum['alusex']==1){
																	$countHA++;
																}else{
																	$countMA++;
																}
																
															}
														}
														
													}

												}
												$countH=$countHN+$countHA;
												$countF=$countMN+$countMA;
										
										if($countH==0){echo '<td class="centro"></td>';}else{echo '<td class="centro">'.$countH.'</td>';}	
										if($countF==0){echo '<td class="centro"></td>';}else{echo '<td class="centro">'.$countF.'</td>';}
										$SumaTotal=$SumaTotal+$countH+$countF;
										$total=$countH+$countF;
										$array[$a]=$total;
										$a++;
									}
										if($SumaTotal==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$SumaTotal.'</td>';}
								echo '</tr>';
								
								echo 
								'<tr>
									<td colspan="2">Total</td>';
									
									for($a=0;$a<$NumeroCarreras;$a++){	
										if($array[$a]==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$array[$a].'</td>';}				
										
									}
									
									if($SumaTotal==0){echo '<td class="centro" colspan="2"></td>';}else{echo '<td class="centro" colspan="2">'.$SumaTotal.'</td>';}
								echo '</tr>';

				echo '</table>
				<br></br><br></br>
				<table width=900> 
					<tr>
						<td></td>
						<td class ="firmas" width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
						<td></td>
					</tr>
				</table> 
				
			</body>
		</html>';
	}
?>
