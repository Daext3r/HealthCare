-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2020 a las 16:23:11
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
CREATE DATABASE IF NOT EXISTS `healthcare` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `healthcare`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativos`
--

CREATE TABLE `administrativos` (
  `CIU_administrativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `id_centro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `administrativos`:
--   `id_centro`
--       `centros` -> `id`
--   `CIU_administrativo`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `CIU_usuario` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `admins`:
--   `CIU_usuario`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analiticas`
--

CREATE TABLE `analiticas` (
  `codigo_analitica` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_personal` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CIU_facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `pruebas` text COLLATE utf8_spanish_ci NOT NULL,
  `resultados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_resultado` date DEFAULT NULL,
  `observaciones_personal` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `analiticas`:
--   `CIU_facultativo`
--       `facultativos` -> `CIU_facultativo`
--   `CIU_paciente`
--       `pacientes` -> `CIU_paciente`
--   `CIU_personal`
--       `laboratorio` -> `CIU_personal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros`
--

CREATE TABLE `centros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `telefonos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `CIU_gerente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `hora_apertura` int(11) NOT NULL,
  `hora_cierre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `centros`:
--   `CIU_gerente`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` set('P','NA','A') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `citas`:
--   `CIU_facultativo`
--       `facultativos` -> `CIU_facultativo`
--   `CIU_paciente`
--       `pacientes` -> `CIU_paciente`
--

--
-- Disparadores `citas`
--
DELIMITER $$
CREATE TRIGGER `cita_biorrada` AFTER DELETE ON `citas` FOR EACH ROW INSERT INTO notificaciones (id, CIU_usuario, resumen, informacion) VALUES (NULL, old.CIU_paciente, "Cita anulada", CONCAT("La cita prevista para el ", old.fecha, " con ", (SELECT nombre_completo FROM vista_usuarios_facultativos WHERE  CIU = old.CIU_facultativo), " ha sido cancelada."))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios`
--

CREATE TABLE `episodios` (
  `id` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `especialidad` int(11) DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `ult_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `cerrado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `episodios`:
--   `especialidad`
--       `especialidades` -> `id`
--   `CIU_paciente`
--       `pacientes` -> `CIU_paciente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `denominacion` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `especialidades`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultativos`
--

CREATE TABLE `facultativos` (
  `CIU_facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `numero_colegiado` int(11) NOT NULL,
  `especialidad` int(11) NOT NULL,
  `sala` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `centro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `facultativos`:
--   `centro`
--       `centros` -> `id`
--   `CIU_facultativo`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int(11) NOT NULL,
  `CIU_facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL,
  `episodio` int(11) DEFAULT NULL,
  `privado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `informes`:
--   `episodio`
--       `episodios` -> `id`
--   `CIU_facultativo`
--       `facultativos` -> `CIU_facultativo`
--   `CIU_paciente`
--       `pacientes` -> `CIU_paciente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `CIU_personal` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `centro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `laboratorio`:
--   `centro`
--       `centros` -> `id`
--   `CIU_personal`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `CIU_usuario` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `resumen` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `informacion` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `notificaciones`:
--   `CIU_usuario`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_medico_referencia` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo_sanguineo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CIU_enfermero_referencia` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `enfermedades` longtext COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `pacientes`:
--   `CIU_enfermero_referencia`
--       `facultativos` -> `CIU_facultativo`
--   `CIU_medico_referencia`
--       `facultativos` -> `CIU_facultativo`
--   `CIU_paciente`
--       `usuarios` -> `CIU`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `id` int(11) NOT NULL,
  `centro_destino` int(11) NOT NULL,
  `CIU_facultativo` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `traslados`:
--   `CIU_facultativo`
--       `usuarios` -> `CIU`
--

--
-- Disparadores `traslados`
--
DELIMITER $$
CREATE TRIGGER `notificacion_traslado` BEFORE INSERT ON `traslados` FOR EACH ROW INSERT INTO notificaciones(CIU_usuario, resumen, informacion) VALUES((SELECT CIU_gerente FROM centros WHERE centros.id = (SELECT centro FROM facultativos WHERE CIU_facultativo = new.CIU_facultativo)), "Nuevo traslado", "Has recibido una solicitud de traslado. Revísala lo antes posible")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` int(11) NOT NULL,
  `nregistro` int(11) NOT NULL,
  `CIU_paciente` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tomas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `episodio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `tratamientos`:
--   `episodio`
--       `episodios` -> `id`
--   `CIU_paciente`
--       `pacientes` -> `CIU_paciente`
--

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
-- RELACIONES PARA LA TABLA `usuarios`:
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_administrativos_centros`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_administrativos_centros` (
`CIU_administrativo` varchar(64)
,`nombre_completo` varchar(97)
,`id_centro` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_citas_pacientes_facultativos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_citas_pacientes_facultativos` (
`nombre_paciente` varchar(97)
,`nombre_medico` varchar(97)
,`CIU_facultativo` varchar(64)
,`fecha` date
,`hora` time
,`id` int(11)
,`CIU_paciente` varchar(64)
,`estado` set('P','NA','A')
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pacientes_facultativos_referencia`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_pacientes_facultativos_referencia` (
`ciu_medico` varchar(64)
,`ciu_enfermero` varchar(64)
,`CIU_paciente` varchar(64)
,`nombre_medico` varchar(97)
,`nombre_enfermero` varchar(97)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resumen_informes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resumen_informes` (
`id` int(11)
,`privado` tinyint(1)
,`episodio` int(11)
,`CIU_medico` varchar(64)
,`CIU_paciente` varchar(64)
,`fecha` date
,`hora` time
,`contenido` text
,`nombre_completo_medico` varchar(97)
,`especialidad` varchar(64)
,`nombre_completo_paciente` varchar(97)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_traslados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_traslados` (
`nombre_centro_destino` varchar(64)
,`nombre_facultativo` varchar(97)
,`centro_destino` int(11)
,`CIU_facultativo` varchar(64)
,`CIU_gerente_destino` varchar(64)
,`nombre_gerente_destino` varchar(97)
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_facultativos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios_facultativos` (
`CIU` varchar(64)
,`nombre_completo` varchar(97)
,`especialidad` varchar(64)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_nombre`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios_nombre` (
`CIU` varchar(64)
,`nombre_completo` varchar(97)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_pacientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios_pacientes` (
`CIU` varchar(64)
,`nombre_completo` varchar(97)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_administrativos_centros`
--
DROP TABLE IF EXISTS `vista_administrativos_centros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_administrativos_centros`  AS  select `administrativos`.`CIU_administrativo` AS `CIU_administrativo`,(select `vista_usuarios_nombre`.`nombre_completo` from `vista_usuarios_nombre` where (`vista_usuarios_nombre`.`CIU` = `administrativos`.`CIU_administrativo`)) AS `nombre_completo`,`administrativos`.`id_centro` AS `id_centro` from `administrativos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_citas_pacientes_facultativos`
--
DROP TABLE IF EXISTS `vista_citas_pacientes_facultativos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_citas_pacientes_facultativos`  AS  select (select `vista_usuarios_pacientes`.`nombre_completo` from `vista_usuarios_pacientes` where (`vista_usuarios_pacientes`.`CIU` = `citas`.`CIU_paciente`)) AS `nombre_paciente`,(select `vista_usuarios_facultativos`.`nombre_completo` from `vista_usuarios_facultativos` where (`vista_usuarios_facultativos`.`CIU` = `citas`.`CIU_facultativo`)) AS `nombre_medico`,(select `vista_usuarios_facultativos`.`CIU` from `vista_usuarios_facultativos` where (`vista_usuarios_facultativos`.`CIU` = `citas`.`CIU_facultativo`)) AS `CIU_facultativo`,`citas`.`fecha` AS `fecha`,`citas`.`hora` AS `hora`,`citas`.`id` AS `id`,`citas`.`CIU_paciente` AS `CIU_paciente`,`citas`.`estado` AS `estado` from `citas` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pacientes_facultativos_referencia`
--
DROP TABLE IF EXISTS `vista_pacientes_facultativos_referencia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_pacientes_facultativos_referencia`  AS  (select `pacientes`.`CIU_medico_referencia` AS `ciu_medico`,`pacientes`.`CIU_enfermero_referencia` AS `ciu_enfermero`,`pacientes`.`CIU_paciente` AS `CIU_paciente`,(select `vista_usuarios_nombre`.`nombre_completo` from `vista_usuarios_nombre` where (`vista_usuarios_nombre`.`CIU` = `pacientes`.`CIU_medico_referencia`)) AS `nombre_medico`,(select `vista_usuarios_nombre`.`nombre_completo` from `vista_usuarios_nombre` where (`vista_usuarios_nombre`.`CIU` = `pacientes`.`CIU_enfermero_referencia`)) AS `nombre_enfermero` from `pacientes`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_informes`
--
DROP TABLE IF EXISTS `vista_resumen_informes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_resumen_informes`  AS  (select `informes`.`id` AS `id`,`informes`.`privado` AS `privado`,`informes`.`episodio` AS `episodio`,`informes`.`CIU_facultativo` AS `CIU_medico`,`informes`.`CIU_paciente` AS `CIU_paciente`,`informes`.`fecha` AS `fecha`,`informes`.`hora` AS `hora`,`informes`.`contenido` AS `contenido`,`vista_usuarios_facultativos`.`nombre_completo` AS `nombre_completo_medico`,`vista_usuarios_facultativos`.`especialidad` AS `especialidad`,`vista_usuarios_nombre`.`nombre_completo` AS `nombre_completo_paciente` from ((`informes` join `vista_usuarios_facultativos` on((`informes`.`CIU_facultativo` = `vista_usuarios_facultativos`.`CIU`))) join `vista_usuarios_nombre` on((`vista_usuarios_nombre`.`CIU` = `informes`.`CIU_paciente`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_traslados`
--
DROP TABLE IF EXISTS `vista_traslados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_traslados`  AS  (select (select `centros`.`nombre` from `centros` where (`centros`.`id` = `traslados`.`centro_destino`)) AS `nombre_centro_destino`,(select `vista_usuarios_facultativos`.`nombre_completo` from `vista_usuarios_facultativos` where (`vista_usuarios_facultativos`.`CIU` = `traslados`.`CIU_facultativo`)) AS `nombre_facultativo`,`traslados`.`centro_destino` AS `centro_destino`,`traslados`.`CIU_facultativo` AS `CIU_facultativo`,(select `centros`.`CIU_gerente` from `centros` where (`centros`.`id` = `traslados`.`centro_destino`)) AS `CIU_gerente_destino`,(select `vista_usuarios_nombre`.`nombre_completo` from `vista_usuarios_nombre` where (`vista_usuarios_nombre`.`CIU` = (select `centros`.`CIU_gerente` from `centros` where (`centros`.`id` = `traslados`.`centro_destino`)))) AS `nombre_gerente_destino`,`traslados`.`id` AS `id` from `traslados`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_facultativos`
--
DROP TABLE IF EXISTS `vista_usuarios_facultativos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_facultativos`  AS  select `usuarios`.`CIU` AS `CIU`,concat(`usuarios`.`nombre`,' ',`usuarios`.`apellidos`) AS `nombre_completo`,(select `especialidades`.`denominacion` AS `especialidad` from `especialidades` where (`especialidades`.`id` = `facultativos`.`especialidad`)) AS `especialidad` from (`usuarios` join `facultativos` on((`usuarios`.`CIU` = `facultativos`.`CIU_facultativo`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_nombre`
--
DROP TABLE IF EXISTS `vista_usuarios_nombre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_nombre`  AS  select `usuarios`.`CIU` AS `CIU`,concat(`usuarios`.`nombre`,' ',`usuarios`.`apellidos`) AS `nombre_completo` from `usuarios` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_pacientes`
--
DROP TABLE IF EXISTS `vista_usuarios_pacientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_pacientes`  AS  select `usuarios`.`CIU` AS `CIU`,concat(`usuarios`.`nombre`,' ',`usuarios`.`apellidos`) AS `nombre_completo` from (`usuarios` join `pacientes` on((`usuarios`.`CIU` = `pacientes`.`CIU_paciente`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD PRIMARY KEY (`CIU_administrativo`),
  ADD KEY `administrativos_centros` (`id_centro`);

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`CIU_usuario`);

--
-- Indices de la tabla `analiticas`
--
ALTER TABLE `analiticas`
  ADD PRIMARY KEY (`codigo_analitica`),
  ADD KEY `analiticas_pacientes` (`CIU_paciente`),
  ADD KEY `analiticas_personal_laboratorio` (`CIU_personal`),
  ADD KEY `analiticas_facultativo` (`CIU_facultativo`);

--
-- Indices de la tabla `centros`
--
ALTER TABLE `centros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CIU_gerente` (`CIU_gerente`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_pacientes` (`CIU_paciente`),
  ADD KEY `citas_facultativos` (`CIU_facultativo`);

--
-- Indices de la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episodios_paciente` (`CIU_paciente`),
  ADD KEY `episodios_especialidad` (`especialidad`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facultativos`
--
ALTER TABLE `facultativos`
  ADD PRIMARY KEY (`CIU_facultativo`),
  ADD UNIQUE KEY `numero_colegiado` (`numero_colegiado`),
  ADD KEY `facultativos_especialidades` (`especialidad`),
  ADD KEY `facultativos_centro` (`centro`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informes_paciente` (`CIU_paciente`),
  ADD KEY `informes_facultativos` (`CIU_facultativo`),
  ADD KEY `informes_episodio` (`episodio`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD KEY `personal_usuario` (`CIU_personal`),
  ADD KEY `personal_centro` (`centro`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notificaciones-usuarios` (`CIU_usuario`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`CIU_paciente`),
  ADD KEY `pacientes_facultativos` (`CIU_medico_referencia`),
  ADD KEY `pacientes_enfermero` (`CIU_enfermero_referencia`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `traslados_usuarios` (`CIU_facultativo`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tratamientos_pacientes` (`CIU_paciente`),
  ADD KEY `tratamientos_episodios` (`episodio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CIU`),
  ADD UNIQUE KEY `correo` (`correo`);

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
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
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
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
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
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_centros` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `administrativos_usuarios` FOREIGN KEY (`CIU_administrativo`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_usuario` FOREIGN KEY (`CIU_usuario`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `analiticas`
--
ALTER TABLE `analiticas`
  ADD CONSTRAINT `analiticas_facultativo` FOREIGN KEY (`CIU_facultativo`) REFERENCES `facultativos` (`CIU_facultativo`),
  ADD CONSTRAINT `analiticas_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`),
  ADD CONSTRAINT `analiticas_personal_laboratorio` FOREIGN KEY (`CIU_personal`) REFERENCES `laboratorio` (`CIU_personal`);

--
-- Filtros para la tabla `centros`
--
ALTER TABLE `centros`
  ADD CONSTRAINT `centros_usuarios` FOREIGN KEY (`CIU_gerente`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_facultativos` FOREIGN KEY (`CIU_facultativo`) REFERENCES `facultativos` (`CIU_facultativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD CONSTRAINT `episodios_especialidad` FOREIGN KEY (`especialidad`) REFERENCES `especialidades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `episodios_paciente` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facultativos`
--
ALTER TABLE `facultativos`
  ADD CONSTRAINT `facultativos_centro` FOREIGN KEY (`centro`) REFERENCES `centros` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `facultativos_usuario` FOREIGN KEY (`CIU_facultativo`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_episodio` FOREIGN KEY (`episodio`) REFERENCES `episodios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `informes_facultativos` FOREIGN KEY (`CIU_facultativo`) REFERENCES `facultativos` (`CIU_facultativo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `informes_paciente` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD CONSTRAINT `personal_centro` FOREIGN KEY (`centro`) REFERENCES `centros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_usuario` FOREIGN KEY (`CIU_personal`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones-usuarios` FOREIGN KEY (`CIU_usuario`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_enfermero` FOREIGN KEY (`CIU_enfermero_referencia`) REFERENCES `facultativos` (`CIU_facultativo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pacientes_facultativos` FOREIGN KEY (`CIU_medico_referencia`) REFERENCES `facultativos` (`CIU_facultativo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pacientes_usuario` FOREIGN KEY (`CIU_paciente`) REFERENCES `usuarios` (`CIU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD CONSTRAINT `traslados_usuarios` FOREIGN KEY (`CIU_facultativo`) REFERENCES `usuarios` (`CIU`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_episodios` FOREIGN KEY (`episodio`) REFERENCES `episodios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tratamientos_pacientes` FOREIGN KEY (`CIU_paciente`) REFERENCES `pacientes` (`CIU_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
