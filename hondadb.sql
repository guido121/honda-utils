-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2023 a las 19:54:52
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hondadb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--
CREATE DATABASE hondadb;

CREATE TABLE `alumnos` (
  `matricula` varchar(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`matricula`, `nombre`, `apellido`) VALUES
('124', 'hola', 'hola'),
('125', 'Guidoo', 'Palacinn'),
('126', 'Jorge', 'Benavides'),
('127', 'Jose', 'Peña'),
('128', 'Paolo', 'Palacin'),
('129', 'Jhoseline', 'Palacin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `razon_social`, `codigo`, `activo`) VALUES
(2, 'Transportes San Valentin', 'TSVSAC', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinatarios`
--

CREATE TABLE `destinatarios` (
  `destinatario_id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `activo` char(1) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `destinatarios`
--

INSERT INTO `destinatarios` (`destinatario_id`, `nombres`, `apellidos`, `correo`, `activo`, `cliente_id`) VALUES
(1, 'Guido', 'Palacin', 'luis.palacinr@gmail.com', '1', 2),
(2, 'Guido', 'Palacin', 'luis.palacinr@gmail.com', '1', 2),
(3, 'Paolo', 'palacin', 'jordan.palacinr@gmail.com', '1', 2),
(4, 'Paolo', 'palacin', 'jordan.palacinr@gmail.com', '1', 2),
(5, 'Paolo', 'palacin', 'jordan.palacinr@gmail.com', '1', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `destinatarios`
--
ALTER TABLE `destinatarios`
  ADD PRIMARY KEY (`destinatario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `destinatarios`
--
ALTER TABLE `destinatarios`
  MODIFY `destinatario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
