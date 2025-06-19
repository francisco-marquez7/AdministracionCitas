<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de paciente no válido.");
}

$patient_id = $_GET['id'];

// Eliminar el paciente de la base de datos
$stmt = $conexion->prepare("DELETE FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);

if ($stmt->execute()) {
    echo "<script>alert('Paciente eliminado correctamente');</script>";
} else {
    echo "<script>alert('Error al eliminar el paciente: " . $stmt->error . "');</script>";
}

$stmt->close();
?>
