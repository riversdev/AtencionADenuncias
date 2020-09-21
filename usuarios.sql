-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2020 a las 08:20:27
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `denuncias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apm` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `tipoUsuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `contrasenia`, `app`, `apm`, `email`, `tel`, `tipoUsuario`, `status`) VALUES
(1, 'Rivers', '$2y$10$i5khTjkAwe2oQ7lfVxcLzOjhMH0GDoM/83f2AYjGGh/sx40aSq09.', 'app', 'apm', 'rivers@gmail', '7712684392', 'Administrador', 1),
(2, 'Paty', '$2a$07$asxx54ahjppf45sd87a5auqkYjnnv/gp/sHlYLhGcbnfG/CQRAHba', 'Espinoza', 'Espinoza', 'alert@gmail.com', '7712684392', 'Administrador', 1),
(4, 'Zully', '$2a$07$asxx54ahjppf45sd87a5au80CATPrEHRol1RCvBLq/cV7MQBnf1Ge', 'Ortega', 'Téllez', 'zully@gmail.com', '7712684392', 'Usuario Consulta', 0),
(8, 'Comité ', '$2a$07$asxx54ahjppf45sd87a5auqkYjnnv/gp/sHlYLhGcbnfG/CQRAHba', 'de', 'Ética', 'pattyespinoza24298@gmail.com', '7712684392', 'Usuario Consulta', 0),
(10, 'dbgfgdg', '$2a$07$asxx54ahjppf45sd87a5au3MQPZnWd/etyXK.U/NLyLKeZhLTIabu', 'gggsgdg', 'ggsgdgsgg', 'pattyespinoza24298@gmail.com', '7712684392', 'Usuario Consulta', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
