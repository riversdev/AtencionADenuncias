-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2020 a las 07:07:25
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
  `tipoDenuncia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numExpediente` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fechaPresentacion` date NOT NULL,
  `imagenDenuncia` longblob NOT NULL,
  `anonimatoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombreDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domicilioDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefonoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edadDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `servidorPublicoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `puestoDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `especificarDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gradoEstudiosDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discapacidadDenunciante` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombreDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entidadDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefonoDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correoDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexoDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edadDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `servidorPublicoDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `especificarDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relacionDenunciado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lugarDenuncia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fechaDenuncia` date NOT NULL,
  `horaDenuncia` time NOT NULL,
  `narracionDenuncia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombreTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domicilioTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefonoTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correoTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relacionTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trabajaTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entidadTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cargoTestigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `statusDenuncia` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `contrasenia`) VALUES
(1, 'Rivers', '$2y$10$i5khTjkAwe2oQ7lfVxcLzOjhMH0GDoM/83f2AYjGGh/sx40aSq09.');

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
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
