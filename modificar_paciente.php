<?php
require_once("conexion.php");
$conexion = obtenerConexion();

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de paciente no válido.");
}

$patient_id = $_GET['id'];

// Obtener datos del paciente
$stmt = $conexion->prepare("SELECT patient_name, patient_email, patient_birthdate, patient_phone, patient_address FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$paciente = $result->fetch_assoc();

if (!$paciente) {
    die("Paciente no encontrado.");
}

// Procesar la actualización del paciente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    $stmt = $conexion->prepare("UPDATE patients SET patient_name=?, patient_email=?, patient_birthdate=?, patient_phone=?, patient_address=? WHERE patient_id=?");
    $stmt->bind_param("sssssi", $nombre, $email, $fechaNacimiento, $telefono, $direccion, $patient_id);

    if ($stmt->execute()) {
        echo "<script>alert('Paciente actualizado con éxito'); window.location.href='listado_pacientes.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el paciente: " . $stmt->error . "');</script>";
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Paciente</title>
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
                <h3 class="card-title text-center">Modificar Paciente</h3>
                <form action="modificar_paciente.php?id=<?= $patient_id ?>" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($paciente['patient_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($paciente['patient_email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" value="<?= $paciente['patient_birthdate'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" value="<?= htmlspecialchars($paciente['patient_phone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" value="<?= htmlspecialchars($paciente['patient_address']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
