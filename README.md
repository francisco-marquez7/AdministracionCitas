# Proyecto Citas Médicas

Este proyecto es una aplicación web diseñada para gestionar citas médicas y pacientes de manera eficiente. Permite realizar altas, bajas, modificaciones y consultas de pacientes y citas.

---

## 📂 Enlace a GitHub

El código fuente del proyecto está disponible en el siguiente repositorio:
[GitHub - Citas Médicas](https://github.com/franciscoMarquez7/HLC_RecuperaFrancisco_Marquez.git)

---

## 🌐 Enlace al Alojamiento Web

Puedes acceder a la aplicación en el siguiente enlace:
[Alojamiento Web](http://localhost/PhpRecupera_Francisco_Marquez/WebApp.html)

---

## 🛠 Configuración de la Base de Datos

### Conexión
El archivo `conexion.php` contiene la configuración necesaria para conectar con la base de datos. Asegúrate de configurar los valores correctamente en tu entorno:

```php
$basedatos = array(
    "basedatos" => "citas_medicas",  // Nombre de la base de datos
    "usuario" => "root",            // Usuario de la base de datos
    "password" => "test",           // Contraseña del usuario
    "servidor" => "db",             // Host del servidor
    "puerto" => 3306                // Puerto de la base de datos
);
