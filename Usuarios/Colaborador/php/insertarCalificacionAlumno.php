<?php
include('../../../Php/conexion.php');
$numControl = $_GET['numControl'];
$columnaCalificar = $_GET['columnaCalificar'];
$calificacion=$_GET['calificacion'];

$sql = "UPDATE calificacionesalumno SET $columnaCalificar = ? WHERE Id_NumeroControl = ?";

echo "Consulta SQL: " . $sql . "\n";
$stmt=$conex->prepare($sql);
$stmt->bind_param("ss",$calificacion,$numControl);

if ($stmt->execute()) {
    echo "<script>alert(".$sql.");</script>";
} else {
    echo "<script>alert('Error al actualizar la calificación: " . $conex->error . "');</script>";
}

$stmt->close();
?>