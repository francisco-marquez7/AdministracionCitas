<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Inicializar variable de cita
$cita = null;

// Procesar la búsqueda si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'] ?? '';
    
    if (!empty($appointment_id) && is_numeric($appointment_id)) {
        $stmt = $conexion->prepare("SELECT appointment_id, appointment_date, appointment_reason, appointment_diagnostic, doctor_assigned, estado_cita, patient_id FROM medical_appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cita = $result->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Cita</title>
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
                <h3 class="card-title text-center">Buscar Cita por ID</h3>
                <form action="buscar_cita.php" method="POST">
                    <div class="mb-3">
                        <label for="appointment_id" class="form-label">ID de la Cita</label>
                        <input type="number" id="appointment_id" name="appointment_id" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <?php if ($cita): ?>
    <div class="main-content mt-5">
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h4 class="card-title text-center">Detalles de la Cita</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID Cita</th><td><?= htmlspecialchars($cita['appointment_id']) ?></td></tr>
                        <tr><th>Fecha</th><td><?= htmlspecialchars($cita['appointment_date']) ?></td></tr>
                        <tr><th>Motivo</th><td><?= htmlspecialchars($cita['appointment_reason']) ?></td></tr>
                        <tr><th>Diagnóstico</th><td><?= htmlspecialchars($cita['appointment_diagnostic']) ?></td></tr>
                        <tr><th>Doctor Asignado</th><td><?= htmlspecialchars($cita['doctor_assigned']) ?></td></tr>
                        <tr><th>Estado</th><td><?= htmlspecialchars($cita['estado_cita']) ?></td></tr>
                        <tr><th>ID Paciente</th><td><?= htmlspecialchars($cita['patient_id']) ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>
