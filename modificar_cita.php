<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de cita no válido.");
}

$appointment_id = $_GET['id'];

// Obtener datos de la cita
$stmt = $conexion->prepare("SELECT appointment_date, appointment_reason, appointment_diagnostic, doctor_assigned, estado_cita, patient_id FROM medical_appointments WHERE appointment_id = ?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$cita = $result->fetch_assoc();

if (!$cita) {
    die("Cita no encontrada.");
}

// Procesar la actualización de la cita
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    $diagnostico = $_POST['diagnostico'] ?? '';
    $doctor = $_POST['doctor'] ?? '';
    $estado = $_POST['estado'] ?? '';

    $stmt = $conexion->prepare("UPDATE medical_appointments SET appointment_date=?, appointment_reason=?, appointment_diagnostic=?, doctor_assigned=?, estado_cita=? WHERE appointment_id=?");
    $stmt->bind_param("sssssi", $fecha, $motivo, $diagnostico, $doctor, $estado, $appointment_id);

    if ($stmt->execute()) {
        echo "<script>alert('Cita actualizada con éxito'); window.location.href='listado_citas.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la cita: " . $stmt->error . "');</script>";
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body style="background-color: rgb(239, 242, 244);">
    <nav class="navbar navbar-expand-md bg-primary navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="favicon.png" alt="Logo Médico" style="width: 32px; height: 32px;"> Citas Médicas
            </a>
        </div>
    </nav>
    <div class="main-content mt-5">
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h3 class="card-title text-center">Modificar Cita</h3>
                <form action="modificar_cita.php?id=<?= $appointment_id ?>" method="POST">
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" id="fecha" name="fecha" class="form-control" value="<?= htmlspecialchars($cita['appointment_date']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <textarea id="motivo" name="motivo" class="form-control" required><?= htmlspecialchars($cita['appointment_reason']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnostico" class="form-label">Diagnóstico</label>
                        <textarea id="diagnostico" name="diagnostico" class="form-control"><?= htmlspecialchars($cita['appointment_diagnostic']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Doctor Asignado</label>
                        <input type="text" id="doctor" name="doctor" class="form-control" value="<?= htmlspecialchars($cita['doctor_assigned']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado de la Cita</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="Pendiente" <?= $cita['estado_cita'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="Confirmada" <?= $cita['estado_cita'] == 'Confirmada' ? 'selected' : '' ?>>Confirmada</option>
                            <option value="Cancelada" <?= $cita['estado_cita'] == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
