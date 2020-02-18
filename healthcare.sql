-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2020 a las 09:43:06
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analiticas`
--

CREATE TABLE `analiticas` (
  `codigo_analitica` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_personal` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CIU_medico_solicitante` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `pruebas` text COLLATE utf8_spanish_ci NOT NULL,
  `resultados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_resultado` date DEFAULT NULL,
  `observaciones_medico` text COLLATE utf8_spanish_ci NOT NULL,
  `observaciones_personal` text COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros`
--

CREATE TABLE `centros` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `calle` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `telefonos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_medico` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` set('0','1','2') COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `identificador` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `centro` int(11) NOT NULL,
  `facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `denominacion_consulta` varchar(32) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `denominacion` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `identificacion` varchar(8) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultativos`
--

CREATE TABLE `facultativos` (
  `CIU_medico` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `numero_colegiado` int(11) NOT NULL,
  `especialidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int(11) NOT NULL,
  `cita` int(11) NOT NULL,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_medico_referencia` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `grupo_sanguineo` varchar(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_laboratorio`
--

CREATE TABLE `personal_laboratorio` (
  `CIU_personal` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `centro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `dosis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `CIU` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `nacionalidad` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `fijo` varchar(16) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `clave` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `analiticas`
--
ALTER TABLE `analiticas`
  ADD PRIMARY KEY (`codigo_analitica`),
  ADD KEY `analiticas_pacientes` (`CIU_paciente`),
  ADD KEY `analiticas_personal_laboratorio` (`CIU_personal`),
  ADD KEY `analiticas_facultativo` (`CIU_medico_solicitante`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_pacientes` (`CIU_paciente`),
  ADD KEY `citas_facultativos` (`CIU_medico`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`identificador`,`centro`),
  ADD KEY `consultas_centro` (`centro`),
  ADD KEY `consulta_facultativo` (`facultativo`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facultativos`
--
ALTER TABLE `facultativos`
  ADD PRIMARY KEY (`CIU_medico`),
  ADD UNIQUE KEY `numero_colegiado` (`numero_colegiado`),
  ADD KEY `facultativos_especialidades` (`especialidad`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informes_citas` (`cita`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`CIU_paciente`),
  ADD KEY `pacientes_facultativos` (`CIU_medico_referencia`);

--
-- Indices de la tabla `personal_laboratorio`
--
ALTER TABLE `personal_laboratorio`
  ADD KEY `personal_usuario` (`CIU_personal`),
  ADD KEY `personal_centro` (`centro`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tratamientos_pacientes` (`CIU_paciente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CIU`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `analiticas`
--
ALTER TABLE `analiticas`
  MODIFY `codigo_analitica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centros`
--
ALTER TABLE `centros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `analiticas`
--
ALTER TABLE `analiticas`
  ADD CONSTRAINT `analiticas_facultativo` FOREIGN KEY (`CIU_medico_solicitante`) REFERENCES `facultativos` (`CIU_medico`),
  ADD CONSTRAINT `analiticas_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`),
  ADD CONSTRAINT `analiticas_personal_laboratorio` FOREIGN KEY (`CIU_personal`) REFERENCES `personal_laboratorio` (`CIU_personal`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_facultativos` FOREIGN KEY (`CIU_medico`) REFERENCES `facultativos` (`CIU_medico`),
  ADD CONSTRAINT `citas_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`);

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consulta_facultativo` FOREIGN KEY (`facultativo`) REFERENCES `facultativos` (`CIU_medico`),
  ADD CONSTRAINT `consultas_centro` FOREIGN KEY (`centro`) REFERENCES `centros` (`id`);

--
-- Filtros para la tabla `facultativos`
--
ALTER TABLE `facultativos`
  ADD CONSTRAINT `facultativos_especialidades` FOREIGN KEY (`especialidad`) REFERENCES `especialidades` (`id`),
  ADD CONSTRAINT `facultativos_usuarios` FOREIGN KEY (`CIU_medico`) REFERENCES `usuarios` (`CIU`);

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_citas` FOREIGN KEY (`cita`) REFERENCES `citas` (`id`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_facultativos` FOREIGN KEY (`CIU_medico_referencia`) REFERENCES `facultativos` (`CIU_medico`),
  ADD CONSTRAINT `pacientes_usuarios` FOREIGN KEY (`CIU_paciente`) REFERENCES `usuarios` (`CIU`);

--
-- Filtros para la tabla `personal_laboratorio`
--
ALTER TABLE `personal_laboratorio`
  ADD CONSTRAINT `personal_centro` FOREIGN KEY (`centro`) REFERENCES `centros` (`id`),
  ADD CONSTRAINT `personal_usuario` FOREIGN KEY (`CIU_personal`) REFERENCES `usuarios` (`CIU`);

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
