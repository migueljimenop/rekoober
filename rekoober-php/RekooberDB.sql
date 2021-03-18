-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-06-2020 a las 15:12:01
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `RekooberDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id_aut` int(11) NOT NULL,
  `nom_aut` varchar(50) NOT NULL,
  `ape_aut` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_aut`, `nom_aut`, `ape_aut`) VALUES
(1, 'Pablo', 'Picasso'),
(2, 'Gabriela', 'Mistral'),
(3, 'Pedro', 'Perez'),
(4, 'Julianito', 'Perez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_cat` int(11) NOT NULL,
  `nom_cat` varchar(50) NOT NULL,
  `est_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_cat`, `nom_cat`, `est_cat`) VALUES
(1, 'Terror', 1),
(2, 'Suspenso', 1),
(3, 'Comedia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id_acc` int(11) NOT NULL,
  `rut_acc` char(12) NOT NULL,
  `nom_acc` varchar(50) NOT NULL,
  `ema_acc` varchar(50) NOT NULL,
  `pss_acc` varchar(12) NOT NULL,
  `tel_acc` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id_acc`, `rut_acc`, `nom_acc`, `ema_acc`, `pss_acc`, `tel_acc`) VALUES
(1, '18.721.813-6', 'Miguel Jimeno', 'migueljimeno.p@gmail.com', 'miguelito', 945255688),
(2, '18.979.769-9', 'Pia Acuña', 'pia.acunac@umayor.cl', 'piacata', 974952951),
(3, '12.345.678-9', 'Test N1', 'test@test.com', '123456789', 123456789),
(4, '98.765.432-1', 'Test N2', 'test2@test.com', '987654321', 987654321),
(5, '22.222.222-2', 'Testing Rekoober', 'tes@test.cl', 'testing2020', 222222222),
(6, '33.333.333-3', 'Tres tres', 'tres@tres.cl', '123456789', 988127371),
(7, '12.312.312-3', 'Navegabilidad Testing', 'test@testing.cl', '123123', 987654321),
(8, '65.656.565-6', 'Navegabilidad Testing', 'test@testing.cl', 'testing', 987654321),
(9, '90.909.090-9', 'Navegabilidad Testing', 'nave@gmail.com', 'testing', 123456789),
(10, '55.555.555-5', 'Testing Navegabilidad', 'testing@test.cl', 'testing', 987654321);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamos `
--

CREATE TABLE `detalle_prestamos ` (
  `id_det` int(11) NOT NULL,
  `lib_det` int(11) NOT NULL,
  `pre_det` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `id_edi` int(11) NOT NULL,
  `nom_edi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id_edi`, `nom_edi`) VALUES
(1, 'Santillana'),
(2, 'Planeta'),
(3, 'S&M&J');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes `
--

CREATE TABLE `imagenes ` (
  `id_img` int(11) NOT NULL,
  `lib_img` int(11) NOT NULL,
  `rou_img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_lib` int(11) NOT NULL,
  `isbn_lib` int(13) NOT NULL,
  `tit_lib` varchar(100) NOT NULL,
  `sin_lib` varchar(500) NOT NULL,
  `idi_lib` varchar(30) NOT NULL,
  `ano_lib` int(4) NOT NULL,
  `pag_lib` int(4) NOT NULL,
  `edi_lib` int(11) NOT NULL,
  `aut_lib` int(11) NOT NULL,
  `cat_lib` int(11) NOT NULL,
  `cue_lib` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_lib`, `isbn_lib`, `tit_lib`, `sin_lib`, `idi_lib`, `ano_lib`, `pag_lib`, `edi_lib`, `aut_lib`, `cat_lib`, `cue_lib`) VALUES
(1, 100, 'Primer libro', 'Buen libro', 'Ingles', 2020, 123, 1, 1, 1, 1),
(2, 200, 'Segundo libro', 'Buen libro', 'Español', 2019, 190, 2, 2, 2, 2),
(3, 300, 'Tercer libro', 'Buen libro también', 'Ingles', 1998, 298, 2, 3, 3, 3),
(4, 400, 'Cuarto libro', 'Excelenteeeee', 'Portugues', 1889, 128, 2, 1, 2, 4),
(6, 100, 'Primero', 'Buen', 'Español', 2020, 1280, 3, 3, 1, 1),
(10, 987, 'Ultimo', 'Hola hola', 'Ingles', 1231, 1231, 1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id_pre` int(11) NOT NULL,
  `lib_pre` int(11) NOT NULL,
  `cue_pre` int(11) NOT NULL,
  `fep_pre` datetime NOT NULL,
  `fer_pre` datetime DEFAULT NULL,
  `est_pre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id_pre`, `lib_pre`, `cue_pre`, `fep_pre`, `fer_pre`, `est_pre`) VALUES
(23, 3, 1, '2020-06-15 03:48:10', '2020-06-15 11:48:24', 2),
(24, 2, 1, '2020-06-15 06:09:47', '2020-06-15 12:38:48', 2),
(25, 4, 1, '2020-06-15 06:10:01', '2020-06-15 11:27:50', 2),
(26, 6, 8, '2020-06-15 12:13:37', '2020-06-15 12:13:43', 2),
(27, 4, 10, '2020-06-15 12:32:19', '2020-06-15 12:34:00', 2),
(28, 10, 6, '2020-06-15 12:36:20', NULL, 1),
(29, 2, 1, '2020-06-15 12:38:52', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_aut`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id_acc`);

--
-- Indices de la tabla `detalle_prestamos `
--
ALTER TABLE `detalle_prestamos `
  ADD PRIMARY KEY (`id_det`),
  ADD KEY `fk_dli` (`lib_det`),
  ADD KEY `fk_pre` (`pre_det`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`id_edi`);

--
-- Indices de la tabla `imagenes `
--
ALTER TABLE `imagenes `
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `fk_img` (`lib_img`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_lib`),
  ADD KEY `fk_edi` (`edi_lib`),
  ADD KEY `fk_aut` (`aut_lib`),
  ADD KEY `fk_cat` (`cat_lib`),
  ADD KEY `fk_cue` (`cue_lib`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_pre`),
  ADD KEY `fk_acc` (`cue_pre`),
  ADD KEY `fk_lib` (`lib_pre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_aut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id_acc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_prestamos `
--
ALTER TABLE `detalle_prestamos `
  MODIFY `id_det` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id_edi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `imagenes `
--
ALTER TABLE `imagenes `
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_lib` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_pre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_prestamos `
--
ALTER TABLE `detalle_prestamos `
  ADD CONSTRAINT `fk_dli` FOREIGN KEY (`lib_det`) REFERENCES `libros` (`id_lib`),
  ADD CONSTRAINT `fk_pre` FOREIGN KEY (`pre_det`) REFERENCES `prestamos` (`id_pre`);

--
-- Filtros para la tabla `imagenes `
--
ALTER TABLE `imagenes `
  ADD CONSTRAINT `fk_img` FOREIGN KEY (`lib_img`) REFERENCES `libros` (`id_lib`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_aut` FOREIGN KEY (`aut_lib`) REFERENCES `autores` (`id_aut`),
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`cat_lib`) REFERENCES `categorias` (`id_cat`),
  ADD CONSTRAINT `fk_cue` FOREIGN KEY (`cue_lib`) REFERENCES `cuentas` (`id_acc`),
  ADD CONSTRAINT `fk_edi` FOREIGN KEY (`edi_lib`) REFERENCES `editoriales` (`id_edi`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_acc` FOREIGN KEY (`cue_pre`) REFERENCES `cuentas` (`id_acc`),
  ADD CONSTRAINT `fk_lib` FOREIGN KEY (`lib_pre`) REFERENCES `libros` (`id_lib`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
