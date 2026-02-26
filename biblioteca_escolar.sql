-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2026 a las 02:47:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

-- Crea la base de datos
CREATE DATABASE biblioteca_escolar DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- --------------------------------------------------------

USE biblioteca_escolar;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca_escolar`
--

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grado_grupo` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nombre`, `grado_grupo`, `email`) VALUES
(1, 'Juan Pérez', '3-A', 'juan.perez@escuela.edu'),
(2, 'María García', '1-B', 'm.garcia@escuela.edu'),
(3, 'Carlos López', '2-C', 'carlos.l_99@escuela.edu'),
(4, 'Sofía Ramírez', '3-A', 'sofia.rami@escuela.edu'),
(5, 'Diego Hernández', '2-B', 'diego.h@escuela.edu'),
(6, 'Lucía Méndez', '1-A', 'lucia.m@escuela.edu'),
(7, 'Ricardo Sosa', '3-B', 'rsosa@escuela.edu'),
(8, 'Beatriz Luna', '2-C', 'b.luna@escuela.edu'),
(9, 'Mariana Islas', '2-A', 'mariana.islas@escuela.edu'),
(10, 'Kevin Duarte', '3-C', 'kevin.duarte@escuela.edu'),
(12, 'test', '3-A', 'test@test.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecario`
--

CREATE TABLE `bibliotecario` (
  `id_bibliotecario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bibliotecario`
--

INSERT INTO `bibliotecario` (`id_bibliotecario`, `nombre`, `turno`, `password`) VALUES
(1, 'Ana Martínez', 'Matutino', 'admin.ana77'),
(2, 'Roberto Gómez', 'Vespertino', 'roberto_pass'),
(3, 'Elena Torres', 'Vespertino', 'elena.biblio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `estado` enum('disponible','prestado') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id_libro`, `titulo`, `autor`, `isbn`, `estado`) VALUES
(1, 'Don Quijote de la Mancha', 'Miguel de Cervantes', '978-8420412146', 'disponible'),
(2, 'Cien años de soledad', 'Gabriel García Márquez', '978-0307474728', 'prestado'),
(3, 'El Principito', 'Antoine de Saint-Exupéry', '978-0156013987', 'disponible'),
(4, '1984', 'George Orwell', '978-0451524935', 'prestado'),
(5, 'Crónica de una muerte anunciada', 'Gabriel García Márquez', '978-1400034956', 'disponible'),
(6, 'Rayuela', 'Julio Cortázar', '978-0307474735', 'disponible'),
(7, 'La tregua', 'Mario Benedetti', '978-8420473130', 'prestado'),
(8, 'Harry Potter y la piedra filosofal', 'J.K. Rowling', '978-8478884451', 'disponible'),
(9, 'El Hobbit', 'J.R.R. Tolkien', '978-0547928227', 'disponible'),
(10, 'Pedro Páramo', 'Juan Rulfo', '978-8437604183', 'disponible'),
(11, 'test', 'test', 'test', 'prestado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_bibliotecario` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_entrega_esperada` date NOT NULL,
  `fecha_devolucion_real` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id_prestamo`, `id_alumno`, `id_libro`, `id_bibliotecario`, `fecha_salida`, `fecha_entrega_esperada`, `fecha_devolucion_real`) VALUES
(1, 1, 2, 1, '2026-02-02', '2026-02-08', '2024-02-07'),
(2, 2, 4, 1, '2026-02-05', '2026-02-12', '2026-02-20'),
(4, 4, 1, 3, '2026-02-06', '2026-02-25', NULL),
(5, 5, 5, 2, '2026-02-02', '2026-02-09', '2024-02-09'),
(6, 6, 3, 1, '2026-02-10', '2026-02-17', NULL),
(7, 7, 8, 2, '2026-02-11', '2026-02-25', NULL),
(8, 8, 9, 3, '2026-02-12', '2026-02-19', NULL),
(9, 1, 10, 1, '2026-02-13', '2026-02-20', NULL),
(10, 2, 6, 2, '2026-02-14', '2026-02-21', '2026-02-26'),
(11, 12, 11, 1, '2026-02-26', '2026-03-05', '2026-02-26'),
(12, 12, 11, 2, '2026-02-26', '2026-03-04', '2026-02-26'),
(13, 12, 11, 3, '2026-02-26', '2026-03-03', '2026-02-26'),
(14, 12, 11, 1, '2026-02-25', '2026-02-26', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `bibliotecario`
--
ALTER TABLE `bibliotecario`
  ADD PRIMARY KEY (`id_bibliotecario`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `idx_libro_titulo` (`titulo`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_bibliotecario` (`id_bibliotecario`),
  ADD KEY `idx_fecha_entrega` (`fecha_entrega_esperada`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `bibliotecario`
--
ALTER TABLE `bibliotecario`
  MODIFY `id_bibliotecario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  ADD CONSTRAINT `prestamo_ibfk_3` FOREIGN KEY (`id_bibliotecario`) REFERENCES `bibliotecario` (`id_bibliotecario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
