<?php
//header('Content-type: application/vnd.ms-word');
//header('Content-Disposition: attachment;Filename=CedulaResultados.doc');
include ("../../../Php/conexion.php");

?>
<html>
	<style>
		table.lineas{ border-collapse: collapse; border: black 1px solid;}
		body{ font-family:Arial; font-size:14.5px;}
		p.titulo{ text-align: center; font-weight:bold;}
		td.negritas{font-weight:bold;}
		td.firmas{text-align: center;}
		td.centro{text-align: center;}
	</style>
		<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
	<body>
		<p class="Titulo"><td></td>INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRES TUXTLA<br></br>
						DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS <br></br><br></br>
						INSCRIPCIÓN - PERIODO: ________________ <br></br><br></br>
		</p>
		
		<br></br>
		
		<table border="1" class="lineas" width=900> 
			<tr>
				<thead>
					<th rowspan="2">No. </th>
					<th rowspan="2">Extraescolar</th>
					<?php 	
					$operacion = 1;
							$sql="SELECT * FROM carrera";
							$resultado=mysqli_query($conex,$sql);
							$countCarrera = mysqli_num_rows($resultado);
							while($mostar=mysqli_fetch_assoc($resultado)){ 
								echo '<th colspan="2" width=40>'.$mostar['claveCarrera'].'</th>';
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
							$x=1; $suma = 0;
							while($mostrar=mysqli_fetch_assoc($resultado1)){
								$id_Actividad = $mostrar['IdActE'];
								$idInicio=$id_Actividad;
								
								echo '<tr>
									<td>'.$x.'</td>
									<td>'.$mostrar['nombreActividad'].' </td>';
									
									$sql="SELECT * FROM carrera";
									$resultado=mysqli_query($conex,$sql);
									while($mostrar=mysqli_fetch_assoc($resultado)){
										$id_Carrera = $mostrar['Id_Carrera'];
										/*if($operacion == 1){
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND  promedio=0";	
											$consultaM="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND  promedio=0";
											$countTotal ="SELECT count(sexoAlumno) FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='3' AND actividadE='3' AND carreraAlumno = '3'";
										}else if($operacion == 2){
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND  promedio<=69 AND promedio>0";
											$consultaM="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND  promedio<=69 AND promedio>0";
											$countTotal ="SELECT count(sexoAlumno) FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='3' AND actividadE='3' AND carreraAlumno = '3'";
										}else{
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND  promedio>70";
											$consultaM="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND  promedio>70";
											$countTotal ="SELECT count(sexoAlumno) FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='3' AND actividadE='3' AND carreraAlumno = '3'";
										}*/
										
										$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera'";	
										$consultaM="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE='$id_Actividad' AND actividadE='$id_Actividad' AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera'";
										
										$queryH=mysqli_query($conex,$consultaH);
										$countH = mysqli_num_rows($queryH);
										
										$queryM=mysqli_query($conex,$consultaM);
										$countM = mysqli_num_rows($queryM);
										
										if($countM==0 OR $countH == 0){
											echo '<td class = "centro" > </td><td class = "centro"></td>';
										}else{
											echo '<td class = "centro" >'.$countH.'</td><td class = "centro">'.$countM.'</td>';
										}
										
										$suma =  $suma + $countM + $countH;
									}
									
								if($suma == 0){
									echo '<td class = "centro"></td>';	
								}else{
									echo '<td class = "centro">'.$suma.'</td>';	
								}
								echo '</tr>';
								$ejemplo = $x;
								$x++;
								if($ejemplo != $x){
									$suma=0;
								}
							}
							
							
						
						echo 
						'<tr>
							<td colspan="2">Sub Total</td>';
							$sql="SELECT * FROM carrera";
							$resultado=mysqli_query($conex,$sql);
							while($mostrar=mysqli_fetch_assoc($resultado)){	
								$id_Carrera = $mostrar['Id_Carrera'];
									/*if($operacion == 1){
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND promedio=0";
											$consultaF="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND promedio=0";
										}else if($operacion == 2){
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND promedio>0 AND promedio<70";
											$consultaF="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND promedio>0 AND promedio<70";
										}else{
											$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera' AND promedio>=70";
											$consultaF="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera' AND promedio>=70";
										}*/
								
								$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='F' AND carreraAlumno = '$id_Carrera'";
								$consultaF="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE  AND sexoAlumno='H' AND carreraAlumno = '$id_Carrera'";
										
								
								$queryH=mysqli_query($conex,$consultaH);
								$countH = mysqli_num_rows($queryH);
								
								$queryF=mysqli_query($conex,$consultaF);
								$countF = mysqli_num_rows($queryF);
								
								if($countH==0 OR $countF == 0){
									echo '<td class = "centro" > </td><td class = "centro"></td>';
								}else{
									echo '<td class = "centro" >'.$countF.'</td><td class = "centro">'.$countH.'</td>';
								}
								
							}
						echo '</tr>';
						
						echo 
						'<tr>
							<td colspan="2">Total</td>';
							$sql="SELECT * FROM carrera";
							$resultado=mysqli_query($conex,$sql);
							while($mostrar=mysqli_fetch_assoc($resultado)){	
								$id_Carrera = $mostrar['Id_Carrera'];
								
									/*if($operacion == 1){
										$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE AND carreraAlumno = '$id_Carrera' AND promedio = 0";
									}else if($operacion == 2){
										$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE AND carreraAlumno = '$id_Carrera' AND promedio>0 AND promedio<70";
									}else{
										$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE AND carreraAlumno = '$id_Carrera' AND promedio>=70";
									}*/
								
								
								
								$consultaH="SELECT sexoAlumno FROM calificacionesalumno,alumno,actividadesextraescolares,actividadalumno WHERE numControlAlumno=Id_NumControlAlumno AND Id_NumControlAlumno=Id_NumeroControl AND IdActE=actividadE AND carreraAlumno = '$id_Carrera'";
									
								$queryH=mysqli_query($conex,$consultaH);
								$countH = mysqli_num_rows($queryH);
								
								if($countH==0){
									echo '<td class = "centro" > </td><td class = "centro"></td>';
								}else{
									echo '<td colspan="2" class = "centro">'.$countH.'</td>';
								}
								
							}
						echo '</tr>';
			?>
		</table>
		<br></br><br></br>
		<table width=900> 
			<tr>
				<td></td>
				<td class ='firmas' width=100>ME. MIGUEL MIRANDA TAPIA<br></br>___________________________________________<br></br><b>Jefe del Departamento de Actividades Culturales, Deportivas y Recreativas</b></td>
				<td></td>
			</tr>
		</table> 
		
	</body>
</html>