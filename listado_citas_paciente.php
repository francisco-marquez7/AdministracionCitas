<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Inicializar variable de citas
$citas = [];

// Procesar el filtrado si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_inicio = $_POST['id_inicio'] ?? '';
    $id_fin = $_POST['id_fin'] ?? '';
    
    if (!empty($id_inicio) && !empty($id_fin) && is_numeric($id_inicio) && is_numeric($id_fin)) {
        $stmt = $conexion->prepare("SELECT appointment_id, appointment_date, appointment_reason, appointment_diagnostic, doctor_assigned, estado_cita, patient_id FROM medical_appointments WHERE patient_id BETWEEN ? AND ?");
        $stmt->bind_param("ii", $id_inicio, $id_fin);
        $stmt->execute();
        $result = $stmt->get_result();
        $citas = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Citas por Paciente</title>
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
                <h3 class="card-title text-center">Filtrar Citas por ID de Paciente</h3>
                <form action="listado_citas_paciente.php" method="POST">
                    <div class="mb-3">
                        <label for="id_inicio" class="form-label">ID Paciente Inicio</label>
                        <input type="number" id="id_inicio" name="id_inicio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_fin" class="form-label">ID Paciente Fin</label>
                        <input type="number" id="id_fin" name="id_fin" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </form>
            </div>
        </div>
    </div>
    <?php if (!empty($citas)): ?>
        <div class="main-content mt-5">
        <div class="card shadow mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h4 class="card-title text-center">Resultados</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Cita</th>
                            <th>Fecha</th>
                            <th>Motivo</th>
                            <th>Diagnóstico</th>
                            <th>Doctor Asignado</th>
                            <th>Estado</th>
                            <th>ID Paciente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?= htmlspecialchars($cita['appointment_id']) ?></td>
                                <td><?= htmlspecialchars($cita['appointment_date']) ?></td>
                                <td><?= htmlspecialchars($cita['appointment_reason']) ?></td>
                                <td><?= htmlspecialchars($cita['appointment_diagnostic']) ?></td>
                                <td><?= htmlspecialchars($cita['doctor_assigned']) ?></td>
                                <td><?= htmlspecialchars($cita['estado_cita']) ?></td>
                                <td><?= htmlspecialchars($cita['patient_id']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    <?php endif; ?>
</body>
</html>
