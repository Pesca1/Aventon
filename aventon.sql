-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-07-2018 a las 19:19:39
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
(1, 'HJK789', 'HJK789-1.jpg'),
(2, 'FGH159', 'FGH159-1.jpeg'),
(3, 'FGH159', 'FGH159-2.jpeg'),
(4, 'MLK282', 'MLK282-1.jpg');

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

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `id_pasajero`, `id_viaje`, `numero_tarjeta`, `estado`, `comentario`) VALUES
(2, 1, 2, 1234567891234511, 0, 'Hola, me gustarÃ­a viajar con vos, puedo llevar \r\nmorfi! Saludos!'),
(3, 2, 1, 7891789178917891, 1, ''),
(4, 1, 3, 1234567891234511, 2, ''),
(5, 2, 10, 7891789178917891, 0, ''),
(6, 3, 1, 1234561234561234, 1, ''),
(7, 1, 13, 1234567891234511, 1, '');

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
(1, 1234123412341234, 123, '2018-07-31'),
(1, 1234567891234511, 123, '2030-01-31'),
(1, 4567456745674567, 123, '2020-09-30'),
(2, 7891789178917891, 123, '2023-06-30'),
(3, 9874987498749874, 123, '2035-01-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `id_transaccion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `monto` decimal(10,5) NOT NULL,
  `tipo` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`id_transaccion`, `id_usuario`, `id_viaje`, `monto`, `tipo`, `fecha_hora`) VALUES
(2, 2, 1, '100.00000', 1, '2018-07-17 15:53:16'),
(3, 3, 1, '100.00000', 1, '2018-07-17 15:53:21'),
(4, 1, 13, '50.00000', 1, '2018-07-17 15:00:00');

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
(1, 'JoaquiÅ„', 'de Antueno', '1998-01-08', 'joaquindea@hotmail.es', 50, 0, 0, '1', 'user1.jpg', 0, 0),
(2, 'Roby', 'Goren', '1993-06-13', 'joaquinpescadeantueno@gmail.com', 70, 0, 0, '1', 'user2.jpeg', 0, 0),
(3, 'Sebastian', 'Zecenarro', '1996-07-17', 'sebazece@gmail.com', 0, 0, 0, '1', 'user3.png', 0, 0);

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
('ABC123', 3, 'Honda Fit', 'Fir', 5),
('FGH159', 2, 'Citroen', 'C3', 6),
('HJK789', 1, 'Renault', 'Sandero', 4),
('MLK282', 1, 'Fiat', 'Vivace', 4);

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
  `tipo` int(11) NOT NULL,
  `costo` decimal(10,5) NOT NULL,
  `tarjeta` bigint(20) NOT NULL,
  `pago_conductor` int(11) NOT NULL DEFAULT '0',
  `pago_pasajero` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id_viaje`, `id_usuario`, `patente`, `origen`, `destino`, `duracion`, `fecha_hora`, `descripcion`, `tipo`, `costo`, `tarjeta`, `pago_conductor`, `pago_pasajero`) VALUES
(1, 1, 'HJK789', 'La Plata', 'Buenos Aires', '1.00000', '2018-07-15 16:00:00', '', 0, '100.00000', 4567456745674567, 0, 1),
(2, 2, 'FGH159', 'Punta Indio', 'Mar del Plata', '2.50000', '2018-07-05 12:00:00', '', 0, '50.00000', 7891789178917891, 0, 0),
(3, 3, 'ABC123', 'Ensenada', 'Berisso', '0.25000', '2018-07-20 12:00:00', '', 0, '50.00000', 9874987498749874, 0, 0),
(10, 1, 'MLK282', 'a', 'a', '1.00000', '2018-07-17 12:00:00', '', 1, '50.00000', 4567456745674567, 0, 0),
(11, 1, 'HJK789', 'Temperley', 'LoberÃ­a', '2.00000', '2018-07-13 09:00:00', '', 1, '50.00000', 1234567891234511, 0, 0),
(12, 2, 'FGH159', 'City Bell', 'Informatica', '1.00000', '2018-07-18 12:00:00', '', 0, '50.00000', 7891789178917891, 0, 0),
(13, 2, 'FGH159', 'bb', 'b', '1.00000', '2018-07-18 17:00:00', '', 1, '50.00000', 7891789178917891, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje_semanal`
--

CREATE TABLE `viaje_semanal` (
  `id_viaje_semanal` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `pago_conductor` int(11) NOT NULL DEFAULT '0',
  `pago_pasajero` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje_semanal`
--

INSERT INTO `viaje_semanal` (`id_viaje_semanal`, `id_viaje`, `fecha_hora`, `pago_conductor`, `pago_pasajero`) VALUES
(6, 10, '2018-07-17 12:00:00', 0, 0),
(7, 11, '2018-07-13 09:00:00', 0, 0),
(8, 11, '2018-07-14 09:00:00', 0, 0),
(9, 11, '2018-07-16 09:00:00', 0, 0),
(10, 11, '2018-07-18 09:00:00', 0, 0),
(11, 11, '2018-07-20 09:00:00', 0, 0),
(12, 11, '2018-07-21 09:00:00', 0, 0),
(13, 11, '2018-07-23 09:00:00', 0, 0),
(14, 11, '2018-07-25 09:00:00', 0, 0),
(15, 11, '2018-07-27 09:00:00', 0, 0),
(16, 11, '2018-07-28 09:00:00', 0, 0),
(17, 11, '2018-07-30 09:00:00', 0, 0),
(18, 11, '2018-08-01 09:00:00', 0, 0),
(19, 11, '2018-08-03 09:00:00', 0, 0),
(20, 11, '2018-08-04 09:00:00', 0, 0),
(21, 13, '2018-07-17 12:00:00', 0, 1);

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
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`id_transaccion`);

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
-- Indices de la tabla `viaje_semanal`
--
ALTER TABLE `viaje_semanal`
  ADD PRIMARY KEY (`id_viaje_semanal`);

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
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntua_conductor`
--
ALTER TABLE `puntua_conductor`
  MODIFY `id_puntua_conductor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `puntua_pasajero`
--
ALTER TABLE `puntua_pasajero`
  MODIFY `id_puntua_pasajero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `viaje_semanal`
--
ALTER TABLE `viaje_semanal`
  MODIFY `id_viaje_semanal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
