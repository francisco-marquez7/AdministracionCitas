<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Obtener todas las citas
$result = $conexion->query("SELECT appointment_id, appointment_date, appointment_reason, appointment_diagnostic, doctor_assigned, estado_cita, patient_id FROM medical_appointments");
$citas = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Citas</title>
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
        <div class="card shadow mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h3 class="card-title text-center">Listado de Citas</h3>
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
                            <th>Acciones</th>
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
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="modificar_cita.php?id=<?= $cita['appointment_id'] ?>" class="btn btn-warning btn-sm">Modificar</a>
                                        <a href="borrar_cita.php?id=<?= $cita['appointment_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">Borrar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>