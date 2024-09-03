<?php
session_start();
include("../../../Php/conexion.php");


$periodo = $_SESSION['periodoEscolar'];
$actividadDocente=$_SESSION['id_Actividad'];
// Recibir parámetros de paginación
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
$offset = ($page - 1) * $pageSize;
$numeroControl = isset($_GET['numeroControl']) ? strtoupper($_GET['numeroControl']) : null;
$carrera = isset($_GET['carrera']) ? intval($_GET['carrera']) : null;
$grupo = isset($_GET['grupo']) ? intval($_GET['grupo']):null; 

// Consulta SQL con paginación
$sql = "SELECT 
    da.aluctr AS numControl, 
    da.alunom AS nombre, 
    da.aluapp AS apePaterno, 
    da.aluapm AS apeMaterno,
    dca.Carnom AS carrera,
    dc.clinpe AS semestre, 
    dal.telefonoAvanzadoAlumno AS telefono,
    dal.correoAvanzadoAlumno AS correo,
    aa.horarioAcademico AS horario, 
    gp.nombreGrupo AS grupo,
    gp.horaGrupo AS hora,
    dal.alergia AS alerta,
    aa.Estatus AS estatus,
    aa.nombreCertificado AS documento
    FROM dalumn AS da
    INNER JOIN dclist AS dc ON dc.aluctr=da.aluctr
    INNER JOIN dcarre AS dca ON dca.Carcve=dc.carcve
    INNER JOIN datosalumno AS dal ON dal.id_AlumnoCTR=da.aluctr
    INNER JOIN actividadalumno AS aa ON aa.Id_NumControlAlumno=da.aluctr
    INNER JOIN grupos AS gp ON gp.Id_Grupos=aa.IdGrupo
    WHERE gp.id_ActividadE=? AND gp.IdPeriodoExtraGrupos=? ";

$baseLimit = " LIMIT ? OFFSET ? ";
$baseWhere="";

if($numeroControl==null && $carrera==null && $grupo==null){
        // Preparar la consulta SQL
        $sql = $sql . $baseLimit;
        $stmt = $conex->prepare($sql);
}else{
    $bindParams = array();

    if ($numeroControl != null) {
        $baseWhere .= " AND da.aluctr='$numeroControl' ";
    }
    
    if ($carrera != null) {
        $baseWhere .= " AND dc.carcve=$carrera ";
    }
    
    if ($grupo != null) {
        $baseWhere .= " AND gp.Id_Grupos=$grupo ";
    }
    //Consulta arreglada para cuando hay parámetros
    $baseQuery = $sql . $baseWhere . $baseLimit;
    $stmt = $conex->prepare($baseQuery);
}




$stmt->bind_param("iiii", $actividadDocente,$periodo, $pageSize, $offset);
// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Generar el HTML
if ($result->num_rows > 0) {
    echo "<table class='tabla-catalogo'>
            <tr>
                <th>Num Control</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Grupo</th>
                <th>Hora</th>
                <th>Estatus</th>
                <th>Detalles de Alumno</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["numControl"] . "</td>
                <td>" . $row["nombre"] . " " . $row["apePaterno"] . " " . $row["apeMaterno"] . "</td>
                <td>" . $row["carrera"] . "</td>
                <td>" . $row["semestre"] . "</td>
                <td>" . $row["grupo"] . "</td>
                <td>" . $row["hora"] . "</td>
                <td>" . $row["estatus"] . "</td>
                <td>
                 <button id='botonModalInfoAlumno' type='button' class='btn btn-primary btn-info-alumno'
                        data-toggle='modal'
                        data-target='#infoModal'
                        data-nombre='" . $row["nombre"] . " " . $row["apePaterno"] . " " . $row["apeMaterno"] . "'
                        data-control='" . $row["numControl"] . "'
                        data-telefono='" . $row["telefono"] . "'
                        data-correo='" . $row["correo"] . "'
                        data-horario='" . $row["horario"] . "'
                        data-alergia='" . $row["alerta"] . "'
                        data-status='" . $row["estatus"] . "'
                        data-documentos='" . $row["documento"] . "'>
                    Ver Detalles
                </button>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}
?>
