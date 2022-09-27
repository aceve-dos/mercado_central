-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2022 a las 22:01:32
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mercado_central`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `embalaje`
--

CREATE TABLE `embalaje` (
  `tipo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_producto`
--

CREATE TABLE `historial_producto` (
  `id_producto` int(10) NOT NULL,
  `producto_nombre` varchar(10) DEFAULT NULL,
  `fecha_emision` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(10) NOT NULL,
  `producto_nombre` varchar(20) DEFAULT NULL,
  `sub_producto` varchar(20) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `peso` decimal(65,0) DEFAULT NULL,
  `precio_max` float DEFAULT NULL,
  `precio_min` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `producto_nombre`, `sub_producto`, `cantidad`, `tipo`, `peso`, `precio_max`, `precio_min`) VALUES
(14, 'Zanahorias', '2', 90, 'Cajones', '65', 100, 1),
(15, 'Zanahorias', '2', 90, 'Cajones', '65', 100, 1),
(16, 'Zanahorias', '2', 90, 'Cajones', '65', 100, 1),
(17, 'Zanahorias', '2', 90, 'Cajones', '65', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestero`
--

CREATE TABLE `puestero` (
  `id_puestero` int(10) NOT NULL,
  `nombre_puestero` varchar(20) DEFAULT NULL,
  `nro_puestero` varchar(10) DEFAULT NULL,
  `id_producto` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id_usuario` int(11) NOT NULL,
  `id_puestero` int(10) DEFAULT NULL,
  `id_producto` int(10) DEFAULT NULL,
  `fecha_nac` varchar(8) DEFAULT NULL,
  `informe_toneladas_diario` varchar(10) DEFAULT NULL,
  `informe_tonelada_mensual` varchar(10) DEFAULT NULL,
  `informe_tonelada_anual` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(10) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `nivel` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `email`, `contraseña`, `nivel`) VALUES
(1, NULL, NULL, '144', '144', NULL),
(2, NULL, NULL, 'asa', 'asaa', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_producto`
--
ALTER TABLE `historial_producto`
  ADD UNIQUE KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `puestero`
--
ALTER TABLE `puestero`
  ADD PRIMARY KEY (`id_puestero`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD UNIQUE KEY `id_puestero` (`id_puestero`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_producto`
--
ALTER TABLE `historial_producto`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `puestero`
--
ALTER TABLE `puestero`
  MODIFY `id_puestero` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_producto`
--
ALTER TABLE `historial_producto`
  ADD CONSTRAINT `historial_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `registro_ibfk_5` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `registro_ibfk_6` FOREIGN KEY (`id_puestero`) REFERENCES `puestero` (`id_puestero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
