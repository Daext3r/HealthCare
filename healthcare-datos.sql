-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2020 a las 16:04:02
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `healthcare`
--

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `denominacion`) VALUES
(2, 'Alergología'),
(3, 'Anatomía Patológica'),
(4, 'Anestesiología y Reanimación'),
(5, 'Angiología y Cirugía Vascular'),
(6, 'Aparato Digestivo'),
(7, 'Cardiología'),
(8, 'Cirugía Cardiovascular'),
(9, 'Cirugía General y del Aparato Digestivo'),
(10, 'Cirugía Oral y Maxilofacial'),
(11, 'Cirugía Ortopédica y Traumatología'),
(12, 'Cirugía Pediátrica'),
(13, 'Cirugía Plástica, Estética y Reparadora'),
(14, 'Cirugía Torácica'),
(15, 'Dermatología Médico-Quirúrgica y Venereología'),
(16, 'Endocrinología y Nutrición'),
(17, 'Farmacología Clínica'),
(18, 'Geriatría'),
(19, 'Hematología y Hemoterapia'),
(20, 'InmunologíaMedicina del Trabajo'),
(21, 'Medicina Familiar y Comunitaria'),
(22, 'Medicina Física y Rehabilitación'),
(23, 'Medicina Intensiva'),
(24, 'Medicina Interna'),
(25, 'Medicina Nuclear'),
(26, 'Medicina Preventiva y Salud Pública'),
(27, 'Nefrología'),
(28, 'Neumología'),
(29, 'Neurocirugía'),
(30, 'Neurofisiología Clínica'),
(31, 'Neurología'),
(32, 'Obstetricia y Ginecología'),
(33, 'Oftalmología'),
(34, 'Oncología Médica'),
(35, 'Oncología Radioterápica'),
(36, 'Otorrinolaringología'),
(37, 'Pediatría y sus Áreas Específicas'),
(38, 'Psiquiatría'),
(39, 'Radiodiagnóstico'),
(40, 'Reumatología'),
(41, 'Urología'),
(42, 'Enfermería de Salud Mental'),
(43, 'Enfermería de Cuidados Médico-Quirúrgicos'),
(44, 'Enfermería del Trabajo'),
(45, 'Enfermería Familiar y Comunitaria'),
(46, 'Enfermería Geriátrica'),
(47, 'Enfermería Obstétrico-Ginecológica'),
(48, 'Enfermería Pediátrica ');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`CIU`, `nombre`, `apellidos`, `dni`, `sexo`, `nacionalidad`, `direccion`, `telefono`, `fijo`, `fecha_nacimiento`, `clave`, `correo`) VALUES
('root', 'Administrador', 'General', '00000000T', 'H', 'Española', 'localhost', '000000000', '000000000', '0000-00-00', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'root@localhost.com');
COMMIT;


--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`CIU_usuario`) VALUES
('root');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
