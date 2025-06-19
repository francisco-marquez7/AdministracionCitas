SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `citas_medicas`
--
CREATE DATABASE IF NOT EXISTS `citas_medicas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `citas_medicas`;

----------------------------------------------------------

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(100) NOT NULL,
  `patient_email` varchar(100) NOT NULL,
  `patient_birthdate` date NOT NULL,
  `patient_phone` varchar(15),
  `patient_address` varchar(255),
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `medical_appointments`;
CREATE TABLE IF NOT EXISTS `medical_appointments` (
  `appointment_id` int NOT NULL AUTO_INCREMENT,
  `appointment_date` datetime NOT NULL,
  `appointment_reason` varchar(255) NOT NULL,
  `appointment_diagnostic` text,
  `doctor_assigned` varchar(100),
  `estado_cita` varchar(50),
  `patient_id` int,
  PRIMARY KEY (`appointment_id`),
  KEY `FK_patient` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

----------------------------------------------------------

INSERT INTO `patients` (`patient_id`, `patient_name`, `patient_email`, `patient_birthdate`, `patient_phone`, `patient_address`) VALUES
(1, 'Juan Pérez', 'juan.perez@example.com', '1985-06-15', '123456789', 'Calle 1, Ciudad A'),
(2, 'María López', 'maria.lopez@example.com', '1990-02-20', '987654321', 'Avenida 2, Ciudad B'),
(3, 'Carlos Sánchez', 'carlos.sanchez@example.com', '1978-09-10', '555678123', 'Plaza 3, Ciudad C'),
(4, 'Ana García', 'ana.garcia@example.com', '2000-01-25', '1122334455', 'Calle 4, Ciudad D'),
(5, 'Pedro Fernández', 'pedro.fernandez@example.com', '1982-11-05', '667788990', 'Calle 5, Ciudad E'),
(6, 'Laura Martínez', 'laura.martinez@example.com', '1995-08-15', '778899001', 'Avenida 6, Ciudad F'),
(7, 'Sofía Torres', 'sofia.torres@example.com', '1975-03-30', '889900112', 'Plaza 7, Ciudad G'),
(8, 'Diego Ruiz', 'diego.ruiz@example.com', '1988-12-20', '990011223', 'Calle 8, Ciudad H'),
(9, 'Elena Vidal', 'elena.vidal@example.com', '1993-07-25', '111223344', 'Avenida 9, Ciudad I'),
(10, 'Luis Gómez', 'luis.gomez@example.com', '1980-04-10', '223344556', 'Plaza 10, Ciudad J');

INSERT INTO `medical_appointments` (`appointment_id`, `appointment_date`, `appointment_reason`, `appointment_diagnostic`, `doctor_assigned`, `estado_cita`, `patient_id`) VALUES
(1, '2025-01-20 09:30:00', 'Consulta general.', 'Diagnóstico sin complicaciones.', 'Dr. Martínez', 'Completada', 1),
(2, '2025-01-21 14:00:00', 'Chequeo anual.', 'Paciente en buen estado.', 'Dr. Gómez', 'Pendiente', 2),
(3, '2025-01-22 11:00:00', 'Control de diabetes.', 'Requiere seguimiento.', 'Dra. Fernández', 'Pendiente', 3),
(4, '2025-01-23 10:00:00', 'Consulta respiratoria.', 'Asma bajo control.', 'Dr. Ramírez', 'Completada', 4),
(5, '2025-01-24 09:00:00', 'Dolor abdominal.', 'Posible gastritis.', 'Dr. Salinas', 'Pendiente', 5),
(6, '2025-01-25 16:00:00', 'Dolor de cabeza.', 'Migraña diagnosticada.', 'Dr. Méndez', 'Completada', 6),
(7, '2025-01-26 08:30:00', 'Lesión deportiva.', 'Requiere fisioterapia.', 'Dr. Torres', 'Pendiente', 7),
(8, '2025-01-27 12:00:00', 'Consulta prenatal.', 'Todo en orden.', 'Dra. García', 'Completada', 8),
(9, '2025-01-28 15:30:00', 'Revisión ocular.', 'Necesita lentes.', 'Dr. Ortega', 'Pendiente', 9),
(10, '2025-01-29 10:00:00', 'Dolor de espalda.', 'Contractura muscular.', 'Dr. López', 'Pendiente', 10);

-- --------------------------------------------------------

--
-- Restricciones para tablas volcadas
--

ALTER TABLE `medical_appointments`
  ADD CONSTRAINT `FK_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
