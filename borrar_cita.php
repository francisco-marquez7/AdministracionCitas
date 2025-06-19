<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de cita no válido.");
}

$appointment_id = $_GET['id'];

// Eliminar la cita de la base de datos
$stmt = $conexion->prepare("DELETE FROM medical_appointments WHERE appointment_id = ?");
$stmt->bind_param("i", $appointment_id);

if ($stmt->execute()) {
    echo "<script>alert('Cita eliminada correctamente'); window.location.href='listado_citas.php';</script>";
} else {
    echo "<script>alert('Error al eliminar la cita: " . $stmt->error . "');</script>";
}

$stmt->close();
?>
