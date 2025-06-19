<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Ejecutar la consulta y manejar errores
$sql = "SELECT patient_id, patient_name, patient_email, patient_birthdate, patient_phone, patient_address FROM patients";
$result = $conexion->query($sql);

// Verificar si la consulta falló
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}

// Obtener los pacientes si hay resultados
$pacientes = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>

<body style="background-color:rgb(239, 242, 244);">
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
            <h3 class="card-title text-center">Listado de Pacientes</h3>

            <?php if (count($pacientes) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td><?= htmlspecialchars($paciente['patient_name']) ?></td>
                                <td><?= htmlspecialchars($paciente['patient_email']) ?></td>
                                <td><?= htmlspecialchars($paciente['patient_birthdate']) ?></td>
                                <td><?= htmlspecialchars($paciente['patient_phone']) ?></td>
                                <td><?= htmlspecialchars($paciente['patient_address']) ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="modificar_paciente.php?id=<?= $paciente['patient_id'] ?>"
                                            class="btn btn-warning btn-sm">Modificar</a>
                                        <a href="borrar_paciente.php?id=<?= $paciente['patient_id'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este paciente?');">Borrar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No hay pacientes registrados.</p>
            <?php endif; ?>
        </div>
    </div>
    </div>

</body>
</html>