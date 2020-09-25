-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2020 a las 05:18:59
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

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
-- Estructura de tabla para la tabla `denuncias`
--

CREATE TABLE `denuncias` (
  `idDenuncia` int(11) NOT NULL,
  `tipoDenuncia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numExpediente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaPresentacion` datetime DEFAULT NULL,
  `imagenDenuncia` longblob,
  `pdfDenuncia` longblob,
  `anonimatoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombreDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilioDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefonoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edadDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `servidorPublicoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `puestoDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `especificarDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gradoEstudiosDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discapacidadDenunciante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombreDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entidadDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefonoDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correoDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexoDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edadDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `servidorPublicoDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `especificarDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relacionDenunciado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lugarDenuncia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaDenuncia` date DEFAULT NULL,
  `horaDenuncia` time DEFAULT NULL,
  `narracionDenuncia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombreTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilioTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefonoTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correoTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relacionTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trabajaTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entidadTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargoTestigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statusDenuncia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'J. Alejandro', '$2a$07$asxx54ahjppf45sd87a5auyKfcechGPcpVDKwZ2I/c7mxsts2o7aa', 'Ríos', 'Téllez', 'jesus.alejandro.rios.tellez@gmail.com', '7713523938', 'Administrador', 1),
(2, 'Paty', '$2a$07$asxx54ahjppf45sd87a5auqkYjnnv/gp/sHlYLhGcbnfG/CQRAHba', 'Espinoza', 'Espinoza', 'alert@gmail.com', '7712684392', 'Administrador', 1),
(4, 'Zully', '$2a$07$asxx54ahjppf45sd87a5au80CATPrEHRol1RCvBLq/cV7MQBnf1Ge', 'Ortega', 'Téllez', 'zully@gmail.com', '7712684392', 'Usuario Consulta', 0),
(8, 'ComitU', '$2a$07$asxx54ahjppf45sd87a5auqkYjnnv/gp/sHlYLhGcbnfG/CQRAHba', 'de', 'Ética', 'pattyespinoza24298@gmail.com', '7712684392', 'Usuario Consulta', 0),
(10, 'dbgfgdg', '$2a$07$asxx54ahjppf45sd87a5au3MQPZnWd/etyXK.U/NLyLKeZhLTIabu', 'gggsgdg', 'ggsgdgsgg', 'pattyespinoza24298@gmail.com', '7712684392', 'Usuario Consulta', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `denuncias`
--
ALTER TABLE `denuncias`
  ADD PRIMARY KEY (`idDenuncia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `denuncias`
--
ALTER TABLE `denuncias`
  MODIFY `idDenuncia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
