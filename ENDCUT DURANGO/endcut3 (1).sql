-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2023 a las 06:17:23
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `endcut3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `id` int(11) NOT NULL,
  `universidad` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) DEFAULT NULL,
  `disciplina` varchar(255) DEFAULT NULL,
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinadores`
--

CREATE TABLE `coordinadores` (
  `id` int(11) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `nom_asistente` varchar(255) DEFAULT NULL,
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `disciplina` varchar(200) NOT NULL,
  `kardex` longblob DEFAULT NULL,
  `curp` longblob DEFAULT NULL,
  `cedula` longblob DEFAULT NULL,
  `nss` longblob DEFAULT NULL,
  `anexos` longblob DEFAULT NULL,
  `registro` longblob DEFAULT NULL,
  `certificado` longblob DEFAULT NULL,
  `monografia` longblob DEFAULT NULL,
  `cancion` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id` int(11) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) NOT NULL,
  `tel_oficina` int(11) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `disciplina` varchar(255) DEFAULT NULL,
  `rama` varchar(255) DEFAULT NULL,
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) DEFAULT NULL,
  `cedula_prof` int(11) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ape_pat` varchar(255) NOT NULL,
  `ape_mat` varchar(255) NOT NULL,
  `grado` int(11) NOT NULL,
  `carrera` varchar(255) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `disciplina` varchar(255) NOT NULL,
  `rama` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `sexo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidades`
--

CREATE TABLE `universidades` (
  `id` int(11) NOT NULL,
  `estado` varchar(120) NOT NULL,
  `universidad` varchar(200) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `no_camiones` int(11) NOT NULL,
  `no_vans` int(11) NOT NULL,
  `no_carros` int(11) NOT NULL,
  `hotel` varchar(120) NOT NULL,
  `req_guia` varchar(11) NOT NULL,
  `no_guias` varchar(10) NOT NULL,
  `imagen` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `tipo` varchar(60) NOT NULL,
  `disciplina` varchar(200) NOT NULL,
  `universidad` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `pass`, `tipo`, `disciplina`, `universidad`) VALUES
(1, 'root', 'root@gmail.com', '1234', 'admin', 'Atletismo', 'Universidad Tecnológica de Zinacantepec'),
(2, 'user', 'user@gmail.com', '1234', 'usuario', 'Danza', 'Universidad Tecnológica de Rodeo'),
(3, 'superadmin', 'superadmin@gmail.com', '1234', 'superadmin', 'Ajedrez', 'Universidad Tecnológica de Durango');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coordinadores`
--
ALTER TABLE `coordinadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `universidades`
--
ALTER TABLE `universidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coordinadores`
--
ALTER TABLE `coordinadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `universidades`
--
ALTER TABLE `universidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
