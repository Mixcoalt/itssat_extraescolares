<?php
include ("../../../Php/conexion.php");
			$Id_ctrAlumno=$_GET['id'];  //NUM CONTROL DEL ALUMNO ACREDITADO
			$count=$_GET['count']; //COUNT DE ALUMNOS EN UNA ACTIVIDAD NORMAL
			$countA2=$_GET['countA2']; //COUNT CON ACTIVIDAD MOOCS
			date_default_timezone_set("America/Mexico_City");
		
			$consultaAlumno="SELECT * FROM dalumn,dclist,dcarre,docenteextraescolares,actividadesextraescolares,actividadalumnoavanzado WHERE dalumn.aluctr=dclist.aluctr AND dclist.carcve=dcarre.Carcve AND dalumn.aluctr=Id_ctrAlumno AND actividadAvanzado=IdActE AND id_Actividad=IdActE AND id_actividadAlumnoAvanzado='$Id_ctrAlumno'";
			$alumno=mysqli_query($conex,$consultaAlumno);
			$arrayAlumno=mysqli_fetch_array($alumno);
			$periodoFin=$arrayAlumno['periodoAlumnoAvanzado'];
			$Actividad1=$arrayAlumno['nombreActividad'];
			$Id_ctrAlumno=$arrayAlumno['Id_ctrAlumno'];
			
			if($countA2==2){
				$consultaPeriodo="SELECT * FROM actividadesextraescolares,actividadalumnoavanzado WHERE Id_ctrAlumno='$Id_ctrAlumno' AND actividadAvanzado=IdActE AND p>69 AND periodoAlumnoAvanzado!='$periodoFin'";
				$periodo=mysqli_query($conex,$consultaPeriodo);
				$arrayPeriodo=mysqli_fetch_array($periodo);
				$periodoInicio=$arrayPeriodo['periodoAlumnoAvanzado'];
				$Actividad2=$arrayPeriodo['nombreActividad'];

			}else{
				$consultaPeriodo="SELECT * FROM actividadesextraescolares,calificacionesalumno,actividadalumno WHERE Id_ElegidaActividadAlumno=Id_actividadAlumno AND Id_NumeroControl='$Id_ctrAlumno' AND actividadE=IdActE AND promedio>69 AND periodoCalificacionesExtraescolar!='$periodoFin'";
				$periodo=mysqli_query($conex,$consultaPeriodo);
				$arrayPeriodo=mysqli_fetch_array($periodo);
				$periodoInicio=$arrayPeriodo['periodoCalificacionesExtraescolar'];
				$Actividad2=$arrayPeriodo['nombreActividad'];
				
			}
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
						$periodocompleto=$periodo2.' ('.$Actividad1.') y '.$periodo1.' ('.$Actividad2.')';
				}
				else{
						$periodocompleto=$periodo1.' ('.$Actividad2.') y '.$periodo2.' ('.$Actividad1.')';
				}
			
				
				//header('Content-type: application/vnd.ms-word');
				//header('Content-Disposition: attachment;Filename=AnexoXVI'.$arrayAlumno['Id_ctrAlumno'].'.doc');
		
		echo '<html>
			<style>
				body{ font-family:Arial; font-size:14.5px; margin:50px auto;}
				p.titulo{ text-align:center;}
				p.Subtitulo{ text-align: left;}
				p.texto {line-height:1.5em; text-align: justify; margin: 50px auto;}
				td.firmas{text-align:center;text-transform:uppercase;}
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
						<b class="mayusculas">'.$arrayAlumno['Id_ctrAlumno'].'</b> de la carrera  <b class="mayusculas">'.$arrayAlumno['Carnom'].'</b>, ha cumplido su actividades complementarias con el nivel de 
						desempeño <b class="mayusculas">'.$arrayAlumno['evaluacionDesempeño'].'</b> y valor numérico de '.$arrayAlumno['evaluacionNumero'].' durante los períodos escolares: 
						<b class="mayusculas">'.$periodocompleto.'</b> , con un valor curricular de un crédito.
						</p>
						<p class="texto">Se extiende la presente en la Ciudad de San Andrés Tuxtla, Ver., a los '.strftime('%d').' días del mes de '.strftime('%B').' de '.strftime('%Y').'. </p>
						<br></br><br></br><br></br>	
						</td>
					</tr>
					<tr>
						<td class ="firmas"  class="mayusculas" width=300>_______________________________<br></br><b>'.$arrayAlumno['nombre_Docente'].' '.$arrayAlumno['apellidoPDocente'].' '.$arrayAlumno['apellidoMDocente'].'</b> <br></br> PROMOTOR CULTURAL '.$arrayAlumno['nombreActividad'].' <br></br></td>
						<td class ="firmas" width=200>_______________________________<br></br><b>Vo. Bo. ME. MIGUEL MIRANDA TAPIA</b><br></br>JEFE DEL DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES</td>
					</tr>
				</table>
			</body>
		</html>';
?>