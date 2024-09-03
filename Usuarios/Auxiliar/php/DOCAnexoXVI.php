<?php
include ("../../../Php/conexion.php");
			$idAlumno=$_GET['id'];
			
			$consultaAlumno="SELECT * FROM dalumn,dclist,dcarre,calificacionesalumno,docenteextraescolares,actividadesextraescolares,actividadalumno WHERE dalumn.aluctr=dclist.aluctr AND dclist.carcve=dcarre.Carcve AND Id_NumControlAlumno=Id_NumeroControl AND dalumn.aluctr=Id_NumeroControl AND actividadE=IdActE AND Id_Docente=numControlDocente AND Id_ElegidaActividadAlumno=Id_actividadAlumno AND idCalificaciones='$idAlumno'";
			
			$alumno=mysqli_query($conex,$consultaAlumno);
			$arrayAlumno=mysqli_fetch_array($alumno);
			$Id_NumControlAlumno=$arrayAlumno['Id_NumControlAlumno'];
			$periodoFin=$arrayAlumno['periodoCalificacionesExtraescolar'];
			$Actividad1=$arrayAlumno['nombreActividad'];
			
			$consultaPeriodo="SELECT periodoCalificacionesExtraescolar,nombreActividad FROM  calificacionesalumno,actividadesextraescolares,actividadalumno WHERE Id_ElegidaActividadAlumno=Id_actividadAlumno AND Id_NumeroControl=Id_NumControlAlumno AND actividadE=IdActE AND promedio>=70 AND Id_NumeroControl='$Id_NumControlAlumno' AND periodoCalificacionesExtraescolar<>'$periodoFin'";
			$periodo=mysqli_query($conex,$consultaPeriodo);
			$arrayPeriodo=mysqli_fetch_array($periodo);
			$periodoInicio=$arrayPeriodo['periodoCalificacionesExtraescolar'];
			$Actividad2=$arrayPeriodo['nombreActividad'];
			
			$periodoAct1="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$periodoInicio'";
			$periodoAct=mysqli_query($conex,$periodoAct1);
			$periodoActividad=mysqli_fetch_array($periodoAct);
				setlocale(LC_TIME,"es_MX.UTF8");
				$anoInicioP1=strftime("%Y",strtotime($periodoActividad['FechaInicioExtraescolar']));
				$anoFinP1=strftime("%Y",strtotime($periodoActividad['FechaFinExtraescolar']));
				if($anoInicioP1==$anoFinP1){
					$periodo1=strftime("%B",strtotime($periodoActividad['FechaInicioExtraescolar'])).' - '. strftime("%B %Y",strtotime($periodoActividad['FechaFinExtraescolar']));
				}else{
					$periodo1=strftime("%B %Y",strtotime($periodoActividad['FechaInicioExtraescolar'])).' - '. strftime("%B %Y",strtotime($periodoActividad['FechaFinExtraescolar']));
				}
			
			$periodoAct2="SELECT * FROM periodosescolares WHERE idPeriodosEscolares='$periodoFin'";
			$periodoActi2=mysqli_query($conex,$periodoAct2);
			$periodoActividad2=mysqli_fetch_array($periodoActi2);
				setlocale(LC_TIME,"es_MX.UTF8");
				$anoInicioP2=strftime("%Y",strtotime($periodoActividad2['FechaInicioExtraescolar']));
				$anoFinP2=strftime("%Y",strtotime($periodoActividad2['FechaFinExtraescolar']));
				if($anoInicioP2==$anoFinP2){
					$periodo2=strftime("%B",strtotime($periodoActividad2['FechaInicioExtraescolar'])).' - '. strftime("%B %Y",strtotime($periodoActividad2['FechaFinExtraescolar']));
				}else{
					$periodo2=strftime("%B %Y",strtotime($periodoActividad2['FechaInicioExtraescolar'])).' - '. strftime("%B %Y",strtotime($periodoActividad2['FechaFinExtraescolar']));
				}
				
				if($periodoFin<$periodoInicio){
						$periodocompleto=$periodo2.' ('.$Actividad2.') y '.$periodo1.' ('.$Actividad1.')';
				}
				else{
						$periodocompleto=$periodo1.' ('.$Actividad2.') y '.$periodo2.' ('.$Actividad1.')';
				}
				
				header('Content-type: application/vnd.ms-word');
				header('Content-Disposition: attachment;Filename=AnexoXVI'.$Id_NumControlAlumno.'.doc');
		
		echo '<html>
			<style>
				body{ font-family:Arial; font-size:14.5px; margin: 50px auto;}
				p.titulo{ text-align: center;}
				p.Subtitulo{ text-align: left;}
				p.texto {line-height:1.5em; text-align: justify; margin: 50px auto;}
				td.firmas{text-align: center;text-transform:uppercase;}
				td.mayusculas{text-transform:uppercase;}
				b.mayusculas{text-transform:uppercase;  font-weight:bold;}
			</style>
				<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8"/>
			<body>
				<b>
					<p class="Titulo">ANEXO XVI. CONSTANCIA DE CUMPLIMIENTO DE ACTIVIDAD COMPLEMENTARIA</p>
					<u><p class="Subtitulo">LAE. ELVIRA DELGADO TELONA<br></u>
					</br>Jefa del Departamento de Servicio Escolares</p>
					
					<p class="Subtitulo"> PRESENTE</p>
				</b>
				<table>
					<tr>
						<td colspan="2">
						<p class="texto">
						El que suscribe profesor '.$arrayAlumno['nombre_Docente'].' '.$arrayAlumno['apellidoPDocente'].' '.$arrayAlumno['apellidoMDocente'].', por este medio se permite hacer de su conocimiento que la estudiante
						<b >'.$arrayAlumno['alunom'].' '.$arrayAlumno['aluapp'].' '.$arrayAlumno['aluapm'].'</b>, con número de control  
						<b class="mayusculas">'.$arrayAlumno['Id_NumControlAlumno'].'</b> de la carrera  <b class="mayusculas">'.$arrayAlumno['Carnom'].'</b>, ha cumplido su actividades complementarias con el nivel de 
						desempeño <b class="mayusculas">'.$arrayAlumno['nivelDesempeño'].'</b> y valor numérico de '.$arrayAlumno['valorNumerico'].' durante los períodos escolares: 
						<b class="mayusculas">'.$periodocompleto.'</b> , con un valor curricular de un crédito.
						</p>
						<p class="texto">Se extiende la presente en la Ciudad de San Andrés Tuxtla, Ver., a los '.strftime('%d').' días del mes de '.strftime('%B').' de '.strftime('%Y').'. </p>
						<br></br><br></br><br></br>	
						</td>
					</tr>
					<tr><td class ="firmas"  class="mayusculas" width=300>_______________________________<br></br><b>'.$arrayAlumno['nombre_Docente'].' '.$arrayAlumno['apellidoPDocente'].' '.$arrayAlumno['apellidoMDocente'].'</b> <br></br> PROMOTOR CULTURAL '.$arrayAlumno['nombreActividad'].' <br></br></td>
						<td class ="firmas" width=200>_______________________________<br></br><b>Vo. Bo. ME. MIGUEL MIRANDA TAPIA</b><br></br>JEFE DEL DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES</td>
					</tr>
				</table>
			</body>
		</html>';
?>