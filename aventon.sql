-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-06-2018 a las 20:01:27
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aventon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `provincia` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `localidad` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `calle` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `numero` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `piso` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `depto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_vehiculo`
--

CREATE TABLE `fotos_vehiculo` (
  `id_foto` int(11) NOT NULL,
  `patente` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `foto` text COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `fotos_vehiculo`
--

INSERT INTO `fotos_vehiculo` (`id_foto`, `patente`, `foto`) VALUES
(1, 'ABC780', 'ABC123-1.jpg'),
(2, '159ASD159', '159ASD159-1.jpg'),
(3, '159ASD159', '159ASD159-2.jpg'),
(4, '159ASD159', '159ASD159-3.jpg'),
(7, 'ASD430', 'ASD430-1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `texto` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `respuesta` text COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntua_conductor`
--

CREATE TABLE `puntua_conductor` (
  `id_puntua_conductor` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `comentario` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `calificacion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntua_pasajero`
--

CREATE TABLE `puntua_pasajero` (
  `id_puntua_pasajero` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `calificacion` int(11) NOT NULL,
  `comentario` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `numero_tarjeta` bigint(20) NOT NULL,
  `estado` int(1) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id_usuario` int(11) NOT NULL,
  `numero` bigint(20) UNSIGNED NOT NULL,
  `codigo_seguridad` int(10) UNSIGNED NOT NULL,
  `vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`id_usuario`, `numero`, `codigo_seguridad`, `vencimiento`) VALUES
(1, 11231231231, 123, '2018-10-18'),
(5, 1231231231234123, 123, '2018-09-01'),
(5, 7897897897897894, 123, '2018-06-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(2048) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(2048) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_de_nacimiento` date NOT NULL,
  `mail` varchar(2048) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `promedio_puntuacion_conductor` double NOT NULL,
  `promedio_puntuacion_pasajero` double NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `contrasenia` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `foto_perfil` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `gasto` double NOT NULL DEFAULT '0',
  `ahorro` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `fecha_de_nacimiento`, `mail`, `promedio_puntuacion_conductor`, `promedio_puntuacion_pasajero`, `id_direccion`, `contrasenia`, `foto_perfil`, `gasto`, `ahorro`) VALUES
(1, 'Manuel', 'Gimenez', '1998-07-06', 'manugime@gmail.com', 0, 0, 2, 'banana', 'user1.jpg', 0, 0),
(5, 'JoaquÃ­n', 'de Antueno', '2000-01-01', 'joaquindea@hotmail.es', 10, 0, 0, 'chauchas', 'user5.jpg', 0, 0),
(6, 'Pesca', 'de Antueno', '2000-01-01', 'joaquinpescadeantueno@gmail.com', 10, 0, 0, 'a', 'user6.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `patente` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `marca` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `modelo` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `asientos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`patente`, `id_usuario`, `marca`, `modelo`, `asientos`) VALUES
('159ASD159', 1, 'Honda', 'Uno', 1),
('ABC780', 3, 'Ford', 'Fiesta', 5),
('ASD430', 5, 'Fiat', 'Vivace', 4),
('qwe789', 1, 'Fiat', 'Uno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE `viajes` (
  `id_viaje` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `patente` varchar(10) NOT NULL,
  `origen` text NOT NULL,
  `destino` text NOT NULL,
  `duracion` decimal(10,5) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` text NOT NULL,
  `costo` decimal(10,5) NOT NULL,
  `tarjeta` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id_viaje`, `id_usuario`, `patente`, `origen`, `destino`, `duracion`, `fecha_hora`, `descripcion`, `tipo`, `costo`, `tarjeta`) VALUES
(13, 5, 'ASD430', 'a', 'a', '1.00000', '2018-07-01 12:00:00', 'Nada', 'Ocasional', '50.00000', 1231231231234123);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `puntua_conductor`
--
ALTER TABLE `puntua_conductor`
  ADD PRIMARY KEY (`id_puntua_conductor`);

--
-- Indices de la tabla `puntua_pasajero`
--
ALTER TABLE `puntua_pasajero`
  ADD PRIMARY KEY (`id_puntua_pasajero`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`numero`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `INDEX1` (`nombre`(191)),
  ADD KEY `INDEX2` (`apellido`(191)),
  ADD KEY `INDEX3` (`fecha_de_nacimiento`),
  ADD KEY `INDEX4` (`mail`(191)),
  ADD KEY `INDEX5` (`promedio_puntuacion_conductor`),
  ADD KEY `INDEX6` (`promedio_puntuacion_pasajero`),
  ADD KEY `INDEX7` (`contrasenia`(191));

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`patente`),
  ADD UNIQUE KEY `patente` (`patente`);

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id_viaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntua_conductor`
--
ALTER TABLE `puntua_conductor`
  MODIFY `id_puntua_conductor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntua_pasajero`
--
ALTER TABLE `puntua_pasajero`
  MODIFY `id_puntua_pasajero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
