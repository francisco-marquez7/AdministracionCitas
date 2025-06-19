<?php
require_once("conexion.php");
$conexion = obtenerConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';

    if (!empty($nombre)) {
        $stmt = $conexion->prepare("SELECT patient_name, patient_email, patient_birthdate, patient_phone, patient_address FROM patients WHERE patient_name LIKE ?");
        $param = "%$nombre%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        $pacientes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $pacientes = [];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Paciente</title>
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
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h3 class="card-title text-center">Buscar Paciente</h3>
                <form action="buscar_paciente.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Paciente</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($pacientes) && count($pacientes) > 0): ?>
    <div class="main-content mt-5"></div>
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h4 class="card-title text-center">Resultados</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
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
