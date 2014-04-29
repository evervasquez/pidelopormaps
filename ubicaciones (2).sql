-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-04-2014 a las 00:17:51
-- Versión del servidor: 5.5.36-MariaDB
-- Versión de PHP: 5.5.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ubicaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `id_ubicaciones` int(6) NOT NULL AUTO_INCREMENT,
  `latitud` varchar(40) DEFAULT NULL,
  `longitud` varchar(40) DEFAULT NULL,
  `idusuario` int(6) DEFAULT NULL,
  `cantidad` int(3) DEFAULT NULL,
  `contacto` varchar(40) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `observacion` varchar(400) DEFAULT NULL,
  `estado` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id_ubicaciones`),
  KEY `fk_usuario_ubicaciones` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuario` int(6) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(40) DEFAULT NULL,
  `email` varchar(40) NOT NULL DEFAULT '',
  `imagen` varchar(200) DEFAULT NULL,
  `estado` smallint(1) DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `index_usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD CONSTRAINT `fk_usuario_ubicaciones` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
