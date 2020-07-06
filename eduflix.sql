-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-07-2020 a las 21:07:35
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
-- Estructura de tabla para la tabla `archivos`
--

DROP TABLE IF EXISTS `archivos`;
CREATE TABLE IF NOT EXISTS `archivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(180) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `archivo` varchar(160) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `privado` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(60) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(180) NOT NULL,
  `descripcion` text NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `grupo`, `descripcion`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES
(1, 'grupo', 'descripcion del grupo', 1, '2020-07-02 16:44:41', NULL, '10.23.13.1', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `clase` varchar(180) NOT NULL,
  `metodo` varchar(180) NOT NULL,
  `argumentos` varchar(180) DEFAULT NULL,
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `id_usuario`, `clase`, `metodo`, `argumentos`, `fechar`, `ip`) VALUES
(79, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:03:24', 'unknown'),
(78, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:03:03', 'unknown'),
(77, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:02:58', 'unknown'),
(76, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-06 10:02:58', 'unknown'),
(75, 1, 'App\\Controllers\\Login', 'cerrarSesionAction', 'Login,cerrarSesion:CLOSE', '2020-07-06 10:00:20', 'unknown'),
(74, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:00:15', 'unknown'),
(73, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:00:05', 'unknown'),
(72, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-06 10:00:04', 'unknown'),
(71, 1, 'App\\Controllers\\Login', 'cerrarSesionAction', 'Login,cerrarSesion:CLOSE', '2020-07-05 00:14:24', 'unknown'),
(70, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:14:19', 'unknown'),
(69, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-05 00:14:19', 'unknown'),
(68, 1, 'App\\Controllers\\Login', 'cerrarSesionAction', 'Login,cerrarSesion:CLOSE', '2020-07-05 00:14:12', 'unknown'),
(67, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:14:03', 'unknown'),
(66, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-05 00:14:03', 'unknown'),
(65, 1, 'App\\Controllers\\Login', 'cerrarSesionAction', 'Login,cerrarSesion:CLOSE', '2020-07-05 00:13:12', 'unknown'),
(64, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:12:51', 'unknown'),
(63, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:12:45', 'unknown'),
(62, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:03:30', 'unknown'),
(61, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-05 00:00:38', 'unknown'),
(60, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-05 00:00:38', 'unknown'),
(59, 1, 'App\\Controllers\\Login', 'cerrarSesionAction', 'Login,cerrarSesion:CLOSE', '2020-07-05 00:00:12', 'unknown'),
(58, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-04 23:59:58', 'unknown'),
(57, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-04 23:59:55', 'unknown'),
(80, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 10:26:13', 'unknown'),
(81, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 10:26:49', 'unknown'),
(82, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:26:55', 'unknown'),
(83, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:27:16', 'unknown'),
(84, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:37:50', 'unknown'),
(85, 1, 'App\\Controllers\\Admin\\Grupos', 'nuevoAction', 'Admin,grupos,nuevo:', '2020-07-06 10:39:52', 'unknown'),
(86, 1, 'App\\Controllers\\Admin\\Grupos', 'nuevoAction', 'Admin,grupos,nuevo:', '2020-07-06 10:40:12', 'unknown'),
(87, 1, 'App\\Controllers\\Admin\\Categorias', 'nuevoAction', 'Admin,categorias,nuevo:', '2020-07-06 10:40:20', 'unknown'),
(88, 1, 'App\\Controllers\\Admin\\Categorias', 'nuevoAction', 'Admin,categorias,nuevo:', '2020-07-06 10:40:30', 'unknown'),
(89, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 10:46:12', 'unknown'),
(90, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:46:15', 'unknown'),
(91, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:47:41', 'unknown'),
(92, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 10:47:54', 'unknown'),
(93, 1, 'App\\Controllers\\Admin\\Categorias', 'tablaAction', 'Admin,categorias,tabla:', '2020-07-06 11:01:10', 'unknown'),
(94, 1, 'App\\Controllers\\Admin\\Categorias', 'nuevoAction', 'Admin,categorias,nuevo:', '2020-07-06 11:01:20', 'unknown'),
(95, 1, 'App\\Controllers\\Admin\\Categorias', 'nuevoAction', 'Admin,categorias,nuevo:', '2020-07-06 11:01:33', 'unknown'),
(96, 1, 'App\\Controllers\\Admin\\Categorias', 'tablaAction', 'Admin,categorias,tabla:', '2020-07-06 11:02:10', 'unknown'),
(97, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 11:02:31', 'unknown'),
(98, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 11:02:33', 'unknown'),
(99, 1, 'App\\Controllers\\Login', 'indexAction', 'index,Login:', '2020-07-06 13:09:48', 'unknown'),
(100, 1, 'App\\Controllers\\Login', 'validateAction', 'Login,validate:ACCESS', '2020-07-06 13:09:58', 'unknown'),
(101, 1, 'App\\Controllers\\Home', 'indexAction', 'index,Home:', '2020-07-06 13:09:59', 'unknown'),
(102, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:13:01', 'unknown'),
(103, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:17:09', 'unknown'),
(104, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:18:34', 'unknown'),
(105, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:20:02', 'unknown'),
(106, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:20:22', 'unknown'),
(107, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:20:41', 'unknown'),
(108, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:20:58', 'unknown'),
(109, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:21:22', 'unknown'),
(110, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:21:30', 'unknown'),
(111, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:22:06', 'unknown'),
(112, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:23:35', 'unknown'),
(113, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:23:55', 'unknown'),
(114, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:24:10', 'unknown'),
(115, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:24:24', 'unknown'),
(116, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:25:29', 'unknown'),
(117, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:26:05', 'unknown'),
(118, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:26:15', 'unknown'),
(119, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:26:28', 'unknown'),
(120, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:27:16', 'unknown'),
(121, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:28:36', 'unknown'),
(122, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:29:49', 'unknown'),
(123, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:31:55', 'unknown'),
(124, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:32:59', 'unknown'),
(125, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:33:20', 'unknown'),
(126, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:34:06', 'unknown'),
(127, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:36:44', 'unknown'),
(128, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:37:29', 'unknown'),
(129, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:39:57', 'unknown'),
(130, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:40:58', 'unknown'),
(131, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:43:55', 'unknown'),
(132, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:44:32', 'unknown'),
(133, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:46:47', 'unknown'),
(134, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:48:30', 'unknown'),
(135, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:49:25', 'unknown'),
(136, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:51:15', 'unknown'),
(137, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:52:37', 'unknown'),
(138, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 13:53:33', 'unknown'),
(139, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 14:05:36', 'unknown'),
(140, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 14:35:34', 'unknown'),
(141, 1, 'App\\Controllers\\Admin\\Cursos', 'tablaAction', 'Admin,cursos,tabla:', '2020-07-06 14:35:43', 'unknown'),
(142, 1, 'App\\Controllers\\Admin\\Cursos', 'tablaAction', 'Admin,cursos,tabla:', '2020-07-06 14:35:47', 'unknown'),
(143, 1, 'App\\Controllers\\Admin\\Cursos', 'nuevoAction', 'Admin,cursos,nuevo:', '2020-07-06 14:35:49', 'unknown'),
(144, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 14:36:33', 'unknown'),
(145, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 14:37:10', 'unknown'),
(146, 1, 'App\\Controllers\\Admin\\Usuarios', 'agregarAction', 'Admin,usuarios,agregar:', '2020-07-06 14:37:24', 'unknown'),
(147, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 14:37:24', 'unknown'),
(148, 1, 'App\\Controllers\\Admin\\Usuarios', 'editarAction', 'Admin,usuarios,3,editar:', '2020-07-06 14:37:44', 'unknown'),
(149, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 14:37:54', 'unknown'),
(150, 1, 'App\\Controllers\\Admin\\Usuarios', 'editarAction', 'Admin,usuarios,3,editar:', '2020-07-06 14:38:23', 'unknown'),
(151, 1, 'App\\Controllers\\Admin\\Usuarios', 'actualizarAction', 'Admin,usuarios,actualizar:', '2020-07-06 14:38:44', 'unknown'),
(152, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 14:38:45', 'unknown'),
(153, 1, 'App\\Controllers\\Admin\\Usuarios', 'nuevoAction', 'Admin,usuarios,nuevo:', '2020-07-06 14:41:08', 'unknown'),
(154, 1, 'App\\Controllers\\Admin\\Usuarios', 'tablaAction', 'Admin,usuarios,tabla:', '2020-07-06 14:41:16', 'unknown'),
(155, 1, 'App\\Controllers\\Admin\\Cursos', 'tablaAction', 'Admin,cursos,tabla:', '2020-07-06 14:41:21', 'unknown'),
(156, 1, 'App\\Controllers\\Admin\\Cursos', 'nuevoAction', 'Admin,cursos,nuevo:', '2020-07-06 14:41:24', 'unknown'),
(157, 1, 'App\\Controllers\\Admin\\Cursos', 'tablaAction', 'Admin,cursos,tabla:', '2020-07-06 14:48:06', 'unknown'),
(158, 1, 'App\\Controllers\\Admin\\Cursos', 'tablaAction', 'Admin,cursos,tabla:', '2020-07-06 15:38:47', 'unknown'),
(159, 1, 'App\\Controllers\\Admin\\Dashboard', 'indexAction', 'index,Admin,dashboard:', '2020-07-06 15:40:25', 'unknown');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(180) NOT NULL,
  `descripcion` text NOT NULL,
  `archivo` varchar(180) DEFAULT NULL,
  `id_usuario_envia` int(11) NOT NULL,
  `id_usuario_recibe` int(11) NOT NULL,
  `padre` int(11) NOT NULL DEFAULT '0',
  `fechar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecham` int(11) DEFAULT NULL,
  `ip` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
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
  `ip` varchar(20) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `usuario`, `password`, `id_rol`, `foto`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES
(1, 'Carlos', 'Ruiz', 'García', 'carlos.ruiz@gesdes.com', '5562270812', 'carlos.ruiz', '98020442', 1, 'repositorio/usuarios/default.jpg', 1, '2020-07-02 12:10:19', NULL, '', 1, 0),
(2, 'Edgar Alejandro', 'Sanchez', 'Trejo', 'jose.ruiz@redanahuac.mx', '5562270813', 'admin', '98020442', 1, '', 1, '2020-07-06 14:36:52', NULL, 'unknown', 1, 0),
(3, 'Edgar Alejandro', 'Sanchez', 'Trejo', 'jose.ruiz@redanahuac.mx', '5562270813', 'admin', '98020442', 1, 'repositorio/usuarios/3.jpg', 1, '2020-07-06 14:37:23', NULL, 'unknown', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
