-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-07-2020 a las 17:10:44
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(180) NOT NULL,
  `padre` int(11) NOT NULL DEFAULT '0',
  `activo` int(11) NOT NULL,
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencias`
--

DROP TABLE IF EXISTS `conferencias`;
CREATE TABLE IF NOT EXISTS `conferencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conferencia` varchar(180) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `fecha` date NOT NULL,
  `horario` varchar(6) NOT NULL DEFAULT '00:00',
  `duracion` varchar(3) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) NOT NULL,
  `curso` varchar(180) NOT NULL,
  `imagen` varchar(160) NOT NULL DEFAULT 'repositorio/cursos/default.jpg',
  `id_categoria` int(2) NOT NULL,
  `descripcion` text NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros`
--

DROP TABLE IF EXISTS `foros`;
CREATE TABLE IF NOT EXISTS `foros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(140) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `archivo` varchar(180) NOT NULL,
  `id_tipo_foro` int(11) NOT NULL DEFAULT '1',
  `id_usuario` int(11) NOT NULL,
  `padre` int(11) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros_tipos`
--

DROP TABLE IF EXISTS `foros_tipos`;
CREATE TABLE IF NOT EXISTS `foros_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(90) NOT NULL,
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `foros_tipos`
--

INSERT INTO `foros_tipos` (`id`, `tipo`, `fechar`, `fecham`, `id_usuario`) VALUES
(1, 'Todos pueden ver este tema', '2020-07-01 18:13:19', NULL, 0),
(2, 'Solo usuarios especificos pueden ver este tema', '2020-07-01 18:13:19', NULL, 0),
(3, 'Este tema es privado', '2020-07-01 18:13:46', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL,
  `grupo` varchar(180) NOT NULL,
  `descripcion` text NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'First post', 'This is a really interesting post.', '2020-06-23 03:39:15'),
(2, 'Second post', 'This is a fascinating post!', '2020-06-23 03:39:15'),
(3, 'Third post', 'This is a very informative post.', '2020-06-23 03:39:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(80) NOT NULL,
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role`, `fechar`, `id_usuario`) VALUES
(1, 'ADMINISTRADOR', '2020-07-02 12:07:24', 1),
(2, 'PROFESOR', '2020-07-02 12:07:24', 1),
(3, 'ESTUDIANTE', '2020-07-02 12:07:36', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `apaterno` varchar(80) NOT NULL,
  `amaterno` varchar(80) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(90) NOT NULL,
  `id_rol` int(1) NOT NULL DEFAULT '1',
  `foto` varchar(180) NOT NULL DEFAULT 'repositorio/usuarios/default.jpg',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `usuario`, `password`, `id_rol`, `foto`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES
(1, 'Carlos', 'Ruiz', 'García', 'carlos.ruiz@gesdes.com', '5562270812', 'carlos.ruiz', '98020442', 1, 'repositorio/usuarios/default.jpg', 1, '2020-07-02 12:10:19', NULL, '', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
