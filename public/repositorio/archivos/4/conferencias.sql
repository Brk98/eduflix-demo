-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2020 a las 18:23:17
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eduflix`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencias`
--

CREATE TABLE `conferencias` (
  `id` int(11) NOT NULL,
  `conferencia` varchar(180) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `fecha` date NOT NULL,
  `horario` varchar(6) NOT NULL DEFAULT '00:00',
  `duracion` varchar(3) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fechar` datetime NOT NULL DEFAULT current_timestamp(),
  `fecham` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `conferencias`
--

INSERT INTO `conferencias` (`id`, `conferencia`, `descripcion`, `fecha`, `horario`, `duracion`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES
(1, 'Prueba', '', '2020-07-08', '08:00', '10', 1, '2020-07-04 09:43:05', '0000-00-00 00:00:00', '', 1, 0),
(2, 'Hola', '', '2020-07-31', '08:30', '50', 1, '2020-07-04 09:55:31', '0000-00-00 00:00:00', '', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conferencias`
--
ALTER TABLE `conferencias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conferencias`
--
ALTER TABLE `conferencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
