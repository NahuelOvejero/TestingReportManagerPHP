-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2017 a las 03:30:01
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `testingplataform`
--
CREATE DATABASE IF NOT EXISTS `testingplataform` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `testingplataform`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

DROP TABLE IF EXISTS `asignacion`;
CREATE TABLE `asignacion` (
  `IdProyecto` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
CREATE TABLE `auditoria` (
  `estado` varchar(10) NOT NULL,
  `IdReq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `defecto`
--

DROP TABLE IF EXISTS `defecto`;
CREATE TABLE `defecto` (
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `archivo` blob,
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE `proyecto` (
  `IdProyecto` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `entrega` date NOT NULL,
  `inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

DROP TABLE IF EXISTS `prueba`;
CREATE TABLE `prueba` (
  `nombre` varchar(200) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `entrada` varchar(200) NOT NULL,
  `esperado` varchar(200) NOT NULL,
  `tipo` varchar(200) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `ultimotest` date DEFAULT NULL,
  `estado` varchar(200) NOT NULL DEFAULT 'Incompleto',
  `IdReq` int(11) NOT NULL,
  `precondicion` varchar(200) NOT NULL,
  `postcondicion` varchar(200) NOT NULL,
  `fin` date NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `prueba`
--
DROP TRIGGER IF EXISTS `update_proyect_ins`;
DELIMITER $$
CREATE TRIGGER `update_proyect_ins` AFTER INSERT ON `prueba` FOR EACH ROW BEGIN
SET @total = (select COUNT(*)
              from prueba
            WHERE IdReq = new.IdReq
                );

SET @ready = (select COUNT(*)
            from prueba
            WHERE IdReq = new.IdReq
            AND estado = 'Exitoso'
            );

IF (@total = @ready) THEN
   UPDATE requerimientos SET estado = 'Exitoso' WHERE IdReq = new.IdReq;

ELSE
   UPDATE requerimientos SET estado = 'Fallido' WHERE IdReq = NEW.IdReq;
	   INSERT INTO auditoria VALUE('fallo', new.IdReq);
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_proyect_upd`;
DELIMITER $$
CREATE TRIGGER `update_proyect_upd` AFTER UPDATE ON `prueba` FOR EACH ROW BEGIN
SET @total = (select COUNT(*)
              from prueba
            WHERE IdReq = new.IdReq
                );

SET @ready = (select COUNT(*)
            from prueba
            WHERE IdReq = new.IdReq
            AND estado = 'Exitoso'
            );

IF (@total = @ready) THEN
   UPDATE requerimientos SET estado = 'Exitoso' WHERE IdReq = new.IdReq;
ELSE
   UPDATE requerimientos SET estado = 'Fallido' WHERE IdReq = NEW.IdReq;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reqanalista`
--

DROP TABLE IF EXISTS `reqanalista`;
CREATE TABLE `reqanalista` (
  `IdUser` int(11) NOT NULL,
  `requerimiento` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientos`
--

DROP TABLE IF EXISTS `requerimientos`;
CREATE TABLE `requerimientos` (
  `IdReq` int(11) NOT NULL,
  `IdProyecto` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `modulo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `actor` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `precondicion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `postcondicion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `disparador` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `fin` date NOT NULL,
  `prioridad` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `version` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `IdRol` int(2) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `info` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IdRol`, `nombre`, `info`) VALUES
(1, 'Lider QA', 'Lider del proyecto.'),
(2, 'Requerimiento', NULL),
(3, 'Tester Analista', NULL),
(4, 'Tester Developer', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `IdUser` int(3) NOT NULL,
  `mail` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `IdRol` int(1) NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `version`
--

DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `IdProyecto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `version` int(4) NOT NULL,
  `subversion` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`IdProyecto`,`IdUser`,`fecha`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`IdProyecto`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `reqanalista`
--
ALTER TABLE `reqanalista`
  ADD PRIMARY KEY (`IdUser`,`requerimiento`);

--
-- Indices de la tabla `requerimientos`
--
ALTER TABLE `requerimientos`
  ADD PRIMARY KEY (`IdReq`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUser`);

--
-- Indices de la tabla `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`fecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `IdProyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `requerimientos`
--
ALTER TABLE `requerimientos`
  MODIFY `IdReq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUser` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
