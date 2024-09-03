<?php
session_start();
include('../../../Php/conexion.php');
$periodo = $_SESSION['periodoEscolar'];
$actividadDocente = $_SESSION['id_Actividad'];
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;
$numeroControl = isset($_GET['numeroControl']) ? strtoupper($_GET['numeroControl']) : null;
$carrera = isset($_GET['carrera']) ? intval($_GET['carrera']) : null;
$grupo = isset($_GET['grupo']) ? intval($_GET['grupo']) : null;
$idDocente = $_SESSION['login'];
$evaluacionActiva = array(false, false,false);

$columnaCalificar="";

// Establecer la zona horaria a México City
date_default_timezone_set('America/Mexico_City');
// Obtener la fecha actual en formato deseado
$fechaActual = date('Y-m-d 00:00:00');

// Cierra cualquier declaración previa si existe
if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}

// Consulta SQL base
$sql = "SELECT 
    da.aluctr AS numControl, 
    da.alunom AS nombre, 
    da.aluapp AS apePaterno, 
    da.aluapm AS apeMaterno,
    dca.Carnom AS carrera,
    gp.nombreGrupo AS grupo,
    gp.horaGrupo AS hora,
    aa.Estatus AS estatus,
    ca.calificacionUno as c1,
    ca.calificacionDos as c2,
    ca.calificacionTres as c3
    FROM dalumn AS da
    INNER JOIN dclist AS dc ON dc.aluctr=da.aluctr
    INNER JOIN dcarre AS dca ON dca.Carcve=dc.carcve
    INNER JOIN datosalumno AS dal ON dal.id_AlumnoCTR=da.aluctr
    INNER JOIN actividadalumno AS aa ON aa.Id_NumControlAlumno=da.aluctr
    INNER JOIN grupos AS gp ON gp.Id_Grupos=aa.IdGrupo
    INNER JOIN calificacionesalumno AS ca ON ca.Id_NumeroControl=da.aluctr
    WHERE gp.id_ActividadE=? AND gp.IdPeriodoExtraGrupos=? AND aa.Estatus='Aceptado' AND ca.Id_docente=? ";

$baseLimit = " LIMIT ? OFFSET ? ";
$baseWhere = "";

if ($numeroControl == null && $carrera == null && $grupo == null) {
    // Preparar la consulta SQL sin filtros adicionales
    $sql = $sql . $baseLimit;
    $stmt = $conex->prepare($sql);
} else {
    if ($numeroControl != null) {
        $baseWhere .= " AND da.aluctr='$numeroControl' ";
    }
    
    if ($carrera != null) {
        $baseWhere .= " AND dc.carcve=$carrera ";
    }
    
    if ($grupo != null) {
        $baseWhere .= " AND gp.Id_Grupos=$grupo ";
    }
    // Consulta arreglada para cuando hay parámetros adicionales
    $baseQuery = $sql . $baseWhere . $baseLimit;
    $stmt = $conex->prepare($baseQuery);
}

if ($stmt === false) {
    die('Error en prepare: ' . htmlspecialchars($conex->error));
}

$bind = $stmt->bind_param("iiiii", $actividadDocente, $periodo, $idDocente, $pageSize, $offset);
if ($bind === false) {
    die('Error en bind_param: ' . htmlspecialchars($stmt->error));
}

// Ejecutar la consulta
$execute = $stmt->execute();
if ($execute === false) {
    die('Error en execute: ' . htmlspecialchars($stmt->error));
}

// Obtener los resultados
$result = $stmt->get_result();
if ($result === false) {
    die('Error en get_result: ' . htmlspecialchars($stmt->error));
}

// Cierra la declaración anterior antes de hacer una nueva consulta
$stmt->close();

// Nueva consulta
$fechas = "SELECT * FROM fechacalificacion WHERE idFechaCal=?";
$idFecha = 1;

$fechaStmt = $conex->prepare($fechas);
if ($fechaStmt === false) {
    die('Error en prepare: ' . htmlspecialchars($conex->error));
}

$bindFecha = $fechaStmt->bind_param("i", $idFecha);
if ($bindFecha === false) {
    die('Error en bind_param: ' . htmlspecialchars($fechaStmt->error));
}

$executeFecha = $fechaStmt->execute();
if ($executeFecha === false) {
    die('Error en execute: ' . htmlspecialchars($fechaStmt->error));
}

$resultFechas = $fechaStmt->get_result();
if ($resultFechas === false) {
    die('Error en get_result: ' . htmlspecialchars($fechaStmt->error));
}

while ($row = $resultFechas->fetch_assoc()) {
    if($fechaActual == $row['fechaC1']){
        $evaluacionActiva[0]=true;
        $columnaCalificar="calificacionUno";
    }else if($fechaActual==$row['fechaC2']){
        $evaluacionActiva[1]=true;
        $columnaCalificar="calificacionDos";
    }else if($fechaActual==$row['fechaC3']){
        $evaluacionActiva[2]=true;
        $columnaCalificar="calificacionTres";
    }
}

// Procesar resultados de la primera consulta
if ($result->num_rows > 0) {
    echo "<table class='tabla-catalogo'>
            <tr>
                <th>Num. Control</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Hora</th>
                <th>Estatus</th>
                <th>Primera Evaluación</th>
                <th>Segunda Evaluación</th>
                <th>Tercera Evaluación</th>
                <th>Calificar</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $disableButton = !empty($row['c1']) && !empty($row['c2']) && !empty($row['c3']);
        echo "<tr>
                <td>" . $row["numControl"] . "</td>
                <td>" . $row["nombre"] . " " . $row["apePaterno"] . " " . $row["apeMaterno"] . "</td>
                <td>" . $row["carrera"] . "</td>
                <td>" . $row["grupo"] . "</td>
                <td>" . $row["hora"] . "</td>
                <td>" . $row["estatus"] . "</td>
                <td>" . ($evaluacionActiva[0] ? (empty($row["c1"])) ? "<input type='text' name='calificacion' />" : $row["c1"] : (empty($row["c1"]) ? "Evaluación Cerrada" : $row["c1"])) . "</td>
                <td>" . ($evaluacionActiva[1] ? (empty($row["c2"])) ? "<input type='text' name='calificacion' />" : $row["c2"] : (empty($row["c2"]) ? "Evaluación Cerrada" : $row["c2"])) . "</td>
                <td>" . ($evaluacionActiva[2] ? (empty($row["c3"])) ? "<input type='text' name='calificacion' />" : $row["c3"] : (empty($row["c3"]) ? "Evaluación Cerrada" : $row["c3"])) . "</td>

            <td>
                <button id='botonModalInfoAlumno' type='button' class='btn btn-primary btn-info-alumno' 
                        data-numControl='" . $row["numControl"] . "' 
                        data-columnaCalificar='" . $columnaCalificar . "'"
                        . ($disableButton ? 'disabled' : '') . ">
                    Agregar Calificación
                </button>
            </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

// Cierra la declaración de la segunda consulta
$fechaStmt->close();
?>
