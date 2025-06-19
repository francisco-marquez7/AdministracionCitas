<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Obtener lista de pacientes para el formulario
$result = $conexion->query("SELECT patient_id, patient_name FROM patients");
$pacientes = $result->fetch_all(MYSQLI_ASSOC);

// Procesar el alta de cita si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'] ?? '';
    $fecha_hora = $_POST['fecha_hora'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    $diagnostico = $_POST['diagnostico'] ?? '';
    $doctor = $_POST['doctor'] ?? '';
    $estado = $_POST['estado'] ?? '';

    if (!empty($patient_id) && !empty($fecha_hora) && !empty($motivo) && !empty($estado)) {
        $stmt = $conexion->prepare("INSERT INTO medical_appointments (appointment_date, appointment_reason, appointment_diagnostic, doctor_assigned, estado_cita, patient_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $fecha_hora, $motivo, $diagnostico, $doctor, $estado, $patient_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Cita registrada con éxito');</script>";
        } else {
            echo "<script>alert('Error al registrar la cita: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Cita</title>
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
                <h3 class="card-title text-center">Registrar Cita Médica</h3>
                <form action="alta_cita.php" method="POST">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Paciente</label>
                        <select id="patient_id" name="patient_id" class="form-control" required>
                            <option value="">Seleccione un paciente</option>
                            <?php foreach ($pacientes as $paciente): ?>
                                <option value="<?= $paciente['patient_id'] ?>"><?= htmlspecialchars($paciente['patient_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <textarea id="motivo" name="motivo" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnostico" class="form-label">Diagnóstico</label>
                        <textarea id="diagnostico" name="diagnostico" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Doctor Asignado</label>
                        <input type="text" id="doctor" name="doctor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado de la Cita</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="">Seleccione el estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Confirmada">Confirmada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Cita</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
