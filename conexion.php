<?php
/*
Este archivo debe incluirse en todos los scripts del proyecto.
De esta manera:
 - Podrás usar la configuración de conexión en cualquier parte del proyecto.
 - Solo necesitas actualizar este archivo para reflejar cualquier cambio en toda la aplicación.
*/

/* Configuración de conexión a la base de datos */
$basedatos = array(
    "basedatos" => "citas_medicas",  
    "usuario" => "root",           
    "password" => "test",            
    "servidor" => "db",      
    "puerto" => 3306                
);

/* ERROR REPORTING */
// Indica que solo se mostrarán errores graves
// Valores posibles: E_ERROR | E_WARNING | E_PARSE | E_NOTICE
error_reporting(E_ERROR);

// Reporte de errores para MySQL sin excepciones
mysqli_report(MYSQLI_REPORT_OFF);

/* FUNCIONES COMUNES */

// Función para establecer la conexión a la base de datos
function obtenerConexion()
{
    global $basedatos; // Recuperamos el array con la configuración

    // Conectar a la base de datos
    $conexion = mysqli_connect(
        $basedatos["servidor"],
        $basedatos["usuario"],
        $basedatos["password"],
        $basedatos["basedatos"],
        $basedatos["puerto"]
    );

    // Verificar si hay errores de conexión
    if (!$conexion) {
        responder(null, false, "Error al conectar a la base de datos: " . mysqli_connect_error(), null);
    }

    // Configurar el conjunto de caracteres a UTF-8
    mysqli_set_charset($conexion, "utf8");

    return $conexion;
}

// Función para enviar respuestas en formato JSON
function responder($datos, $ok, $mensaje, $conexion)
{
    // Formatear la respuesta como un array asociativo
    $respuesta = [
        "ok" => $ok,           // Booleano que indica éxito o fallo
        "datos" => $datos,     // Datos devueltos (puede ser null)
        "mensaje" => $mensaje  // Mensaje de la operación
    ];

    // Enviar la respuesta al cliente en formato JSON
    header("Content-Type: application/json");
    echo json_encode($respuesta);

    // Cerrar la conexión a la base de datos si existe
    if ($conexion !== null) {
        mysqli_close($conexion);
    }

    // Finalizar el script con éxito o error
    exit($ok ? 0 : 1);
}
?>

