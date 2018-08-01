-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-08-2018 a las 18:20:59
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
  `pago_pasajero` int(11) NOT NULL DEFAULT '0',
  `semanas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id_viaje`, `id_usuario`, `patente`, `origen`, `destino`, `duracion`, `fecha_hora`, `descripcion`, `tipo`, `costo`, `tarjeta`, `pago_conductor`, `pago_pasajero`, `semanas`) VALUES
(5, 2, 'FGH159', 'City Bell', 'Buenos Aires', '0.25000', '2018-08-14 12:00:00', '', 0, '50.00000', 7891789178917891, 0, 0, 0),
(8, 2, 'FGH159', 'a', 'a', '1.00000', '2018-08-02 13:00:00', '', 1, '1.00000', 7891789178917891, 0, 0, 2),
(9, 1, 'MLK282', 'q', 'q', '1.00000', '2018-08-10 16:00:00', '', 0, '1.00000', 1234567891234511, 0, 0, 0),
(11, 2, 'FGH159', 'd', 'd', '1.01667', '2018-07-30 22:02:00', '', 0, '1.00000', 7891789178917891, 1, 1, 0),
(12, 2, 'FGH159', 'w', 'w', '0.50000', '2018-08-01 12:00:00', '', 1, '5.00000', 7891789178917891, 0, 0, 4),
(13, 1, 'MLK282', 'Un Lugar', 'Otro Lugar', '2.00000', '2018-08-05 19:00:00', '', 1, '1.00000', 1234567891234511, 0, 0, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id_viaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
