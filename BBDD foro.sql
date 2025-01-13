-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-01-2025 a las 18:29:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foro`
--
CREATE DATABASE IF NOT EXISTS `foro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foro`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `contenido` varchar(250) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `contenido`, `fecha_creacion`, `id_usuario`, `id_post`) VALUES
(1, 'Muy interesante, gracias por compartir.', '2024-10-22 10:02:56', 4, 1),
(2, 'Necesito seguir estos consejos.', '2024-10-22 10:02:56', 5, 2),
(3, 'Gran análisis del partido.', '2024-10-22 10:02:56', 6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunidades`
--

CREATE TABLE `comunidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(250) NOT NULL DEFAULT 'logo1.jpg',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comunidades`
--

INSERT INTO `comunidades` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `imagen`, `id_usuario`) VALUES
(1, 'Comunidad de Tecnología', 'Espacio para discutir sobre tecnología y gadgets.', '2024-10-22 10:02:56', 'logo1.jpg', 1),
(2, 'Comunidad de Salud', 'Todo sobre salud y bienestar.', '2024-10-22 10:02:56', 'logo1.jpg', 2),
(3, 'Comunidad de Deportes', 'Discusión sobre deportes y actividad física.', '2024-10-22 10:02:56', 'logo1.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id_membresia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comunidad` int(11) NOT NULL,
  `fecha_unido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id_membresia`, `id_usuario`, `id_comunidad`, `fecha_unido`) VALUES
(1, 1, 3, '2024-10-24 08:02:24'),
(2, 2, 3, '2024-10-24 08:02:24'),
(3, 3, 3, '2024-10-24 08:02:24'),
(4, 3, 2, '2024-10-24 08:02:24'),
(5, 2, 2, '2024-10-24 08:02:24'),
(7, 2, 1, '2024-10-24 08:02:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` varchar(450) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(250) DEFAULT NULL,
  `video` varchar(250) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comunidad` int(11) DEFAULT NULL,
  `id_tema` int(11) NOT NULL,
  `tipo_post` enum('normal','comunidad') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `titulo`, `contenido`, `fecha_creacion`, `imagen`, `video`, `id_usuario`, `id_comunidad`, `id_tema`, `tipo_post`) VALUES
(1, 'Nuevo Smartphone', 'Descubre el nuevo smartphone que todos quieren.', '2024-10-22 10:02:56', NULL, '215484_tiny.mp4', 1, 1, 1, 'comunidad'),
(2, 'Consejos de Dieta', 'Mejores consejos para mantener una dieta saludable.', '2024-10-22 10:02:56', 'administrador.png ', NULL, 2, 2, 2, 'normal'),
(3, 'El último partido', 'Resumen del último partido de fútbol.', '2024-10-22 10:02:56', 'administrador2.png ', NULL, 3, 3, 3, 'normal'),
(5, 'nuevo', 'nuevo', '2024-10-24 08:15:54', NULL, NULL, 1, NULL, 3, 'normal'),
(6, 'nuevo', 'qweqweqwe', '2024-10-24 08:16:07', NULL, NULL, 1, NULL, 3, 'normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Innovaciones Tecnológicas', 'Últimas tendencias en tecnología.', '2024-10-22 10:02:56'),
(2, 'Nutrición', 'Importancia de una buena alimentación.', '2024-10-22 10:02:56'),
(3, 'Fútbol', 'Debates sobre fútbol y equipos.', '2024-10-22 10:02:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas-comunidades`
--

CREATE TABLE `temas-comunidades` (
  `id_tema` int(11) NOT NULL,
  `id_comunidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas-comunidades`
--

INSERT INTO `temas-comunidades` (`id_tema`, `id_comunidad`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `contraseña` varchar(250) NOT NULL,
  `imagen_logo_usuario` varchar(250) NOT NULL DEFAULT 'administrador.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `contraseña`, `imagen_logo_usuario`) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@example.com', '1234', 'administrador.png'),
(2, 'María', 'Gómez', 'maria.gomez@example.com', 'abcd', 'administrador.png'),
(3, 'Pedro', 'López', 'pedro.lopez@example.com', '123', 'administrador.png'),
(4, 'Laura', 'Martínez', 'laura.martinez@example.com', '123', 'administrador.png'),
(5, 'Carlos', 'Fernández', 'carlos.fernandez@example.com', 'qwe', 'administrador.png'),
(6, 'Ana', 'Sánchez', 'ana.sanchez@example.com', 'secret', 'administrador.png'),
(7, 'Luis', 'Ramírez', 'luis.ramirez@example.com', 'hello', 'administrador.png'),
(8, 'Lucía', 'Torres', 'lucia.torres@example.com', 'admin', 'administrador.png'),
(9, 'Diego', 'Hernández', 'diego.hernandez@example.com', '123456', 'administrador.png'),
(10, 'Elena', 'Morales', 'elena.morales@example.com', 'welcome', 'administrador.png'),
(11, 'esteban', 'gamboa', 'gamoba@gmail.com', '123', 'administrador.png'),
(16, 'eqweqwe', 'qweqwe', 'estebitangb12@gmail.com', '$2y$10$25.pTtiBhTJB4hn1N1HY4eU6SkqV.JOUgQWQWs7/zu/uBt7cxVy3W', 'administrador2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `fecha_voto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id`, `id_usuario`, `id_post`, `fecha_voto`) VALUES
(1, 7, 1, '2024-10-22 10:02:56'),
(2, 8, 2, '2024-10-22 10:02:56'),
(3, 9, 3, '2024-10-22 10:02:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_post` (`id_post`);

--
-- Indices de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`id_membresia`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_comunidad`),
  ADD KEY `id_comunidad` (`id_comunidad`,`id_usuario`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_comunidad` (`id_comunidad`) USING BTREE,
  ADD KEY `id_tema` (`id_tema`) USING BTREE;

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temas-comunidades`
--
ALTER TABLE `temas-comunidades`
  ADD PRIMARY KEY (`id_comunidad`,`id_tema`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`nombre`,`correo`) USING BTREE;

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD UNIQUE KEY `id_post` (`id_post`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD CONSTRAINT `comunidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD CONSTRAINT `membresias_ibfk_1` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membresias_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `temas-comunidades`
--
ALTER TABLE `temas-comunidades`
  ADD CONSTRAINT `temas-comunidades_ibfk_1` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temas-comunidades_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Base de datos: `foro2`
--
CREATE DATABASE IF NOT EXISTS `foro2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foro2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `contenido` varchar(250) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_comentario_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `contenido`, `fecha_creacion`, `id_usuario`, `id_post`, `id_comentario_padre`) VALUES
(198, 'qweqweqweqwe', '2024-12-13 19:41:59', 11, 564, NULL),
(199, 'esto esta genial eh', '2024-12-13 20:41:06', 11, 567, NULL),
(200, 'esto es good', '2024-12-14 15:17:32', 11, 569, NULL),
(201, 'que dices man', '2024-12-14 15:17:39', 11, 569, 200),
(202, 'yow', '2024-12-14 15:17:51', 11, 569, 200),
(203, 'que guapo vro', '2024-12-14 15:22:16', 11, 570, NULL),
(204, 'asdasdsad', '2024-12-14 15:22:50', 11, 570, 203),
(205, 'esto esta genial!', '2024-12-15 20:55:50', 11, 564, NULL),
(206, 'esto es nuevo', '2024-12-15 20:57:47', 11, 571, NULL),
(207, 'esot e snbuen', '2024-12-15 21:04:35', 11, 566, NULL),
(208, 'asdasd', '2025-01-05 19:19:26', 11, 571, NULL),
(209, '123', '2025-01-05 19:19:29', 11, 571, NULL),
(210, 'sdfgfg', '2025-01-05 19:34:17', 11, 573, NULL),
(211, 'werwerwer', '2025-01-05 19:34:21', 11, 573, 210),
(212, 'sfdf', '2025-01-05 19:39:06', 11, 573, 210),
(213, 'asdasdasd', '2025-01-05 20:34:15', 1, 578, NULL),
(214, 'qweqwe', '2025-01-05 20:34:19', 1, 578, 213),
(215, 'se puede comentar', '2025-01-08 16:55:03', 3, 585, NULL),
(216, 'y se puede responder', '2025-01-08 16:55:16', 3, 585, 215);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunidades`
--

CREATE TABLE `comunidades` (
  `id_comunidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(250) NOT NULL DEFAULT 'logo1.jpg',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comunidades`
--

INSERT INTO `comunidades` (`id_comunidad`, `nombre`, `descripcion`, `fecha_creacion`, `imagen`, `id_usuario`) VALUES
(29, 'pepe', 'qweqweqwe', '2024-12-13 19:39:50', '12.jpg', 7),
(30, 'comunidad 2', 'comunida 2', '2024-12-13 19:42:22', '11.jpg', 11),
(31, 'tgv', 'Tren de alta velocidad 2n2uhf', '2024-12-14 15:20:18', '9.jpg', 11),
(32, 'nueva comunidad', 'esto es nuevo', '2024-12-15 20:56:54', '8.jpg', 11),
(33, 'comunidad nueva 2', 'nuevo', '2024-12-15 21:01:24', '12.jpg', 11),
(34, '123123', 'qwe1231ewqe123qwe', '2025-01-05 19:44:57', '4.jpg', 11),
(35, 'comunidad nuev a', 'esto es una nueva comunidad', '2025-01-08 12:25:40', '12.jpg', 11),
(36, '456', '8513894651', '2025-01-08 12:55:25', '11.jpg', 11),
(37, '89', '8941', '2025-01-08 12:56:22', '10.jpg', 11),
(38, 'comunidad de prueba ', 'Esto es para ver que funciona todo correctamente ', '2025-01-08 17:16:26', '677eb2ea98646.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id_membresia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comunidad` int(11) NOT NULL,
  `fecha_unido` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id_membresia`, `id_usuario`, `id_comunidad`, `fecha_unido`) VALUES
(187, 11, 29, '2024-12-13'),
(188, 11, 30, '2024-12-13'),
(189, 11, 31, '2024-12-14'),
(190, 11, 32, '2024-12-15'),
(191, 11, 33, '2024-12-15'),
(192, 11, 34, '2025-01-05'),
(193, 1, 33, '2025-01-05'),
(194, 1, 29, '2025-01-05'),
(195, 11, 37, '2025-01-08'),
(196, 11, 36, '2025-01-08'),
(197, 11, 35, '2025-01-08'),
(198, 14, 32, '2025-01-08'),
(199, 14, 33, '2025-01-08'),
(200, 14, 31, '2025-01-08'),
(201, 14, 29, '2025-01-08'),
(202, 3, 31, '2025-01-08'),
(203, 3, 30, '2025-01-08'),
(204, 3, 32, '2025-01-08'),
(205, 3, 38, '2025-01-08'),
(206, 12, 32, '2025-01-09'),
(207, 12, 31, '2025-01-09'),
(208, 12, 29, '2025-01-09'),
(209, 12, 33, '2025-01-09'),
(210, 12, 30, '2025-01-12'),
(211, 12, 34, '2025-01-12'),
(212, 12, 37, '2025-01-12'),
(213, 12, 36, '2025-01-12'),
(214, 12, 35, '2025-01-12'),
(215, 12, 38, '2025-01-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` varchar(450) NOT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(250) DEFAULT NULL,
  `video` varchar(250) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comunidad` int(11) DEFAULT NULL,
  `id_tema` int(11) DEFAULT NULL,
  `tipo_post` enum('normal','comunidad') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id_post`, `titulo`, `contenido`, `fecha_creacion`, `imagen`, `video`, `id_usuario`, `id_comunidad`, `id_tema`, `tipo_post`) VALUES
(564, 'nuevo', 'ejemplo nuevo', '2024-12-13', NULL, NULL, 1, 29, 1, 'comunidad'),
(565, 'titulo', 'contenido', '2024-12-13', NULL, NULL, 11, NULL, NULL, 'normal'),
(566, 'titulo', 'contenido', '2024-12-13', NULL, NULL, 11, 29, 59, 'comunidad'),
(567, 'yiylo123', 'contenido 123123', '2024-12-13', '675c9bd2752b0.png', NULL, 11, 29, 40, 'comunidad'),
(569, 'COMERME LA POL', 'contenido nuevo para un ejemplo y que quede genial \r\n', '2024-12-13', '675c9cc92551e.png', NULL, 11, 29, 59, 'comunidad'),
(570, 'COSAS', 'esto es un ejemplo examen\r\n', '2024-12-14', '675da288d33e8.png', NULL, 11, 31, 54, 'comunidad'),
(571, 'link para google', 'http://google.com', '2024-12-15', NULL, NULL, 11, 32, 4, 'comunidad'),
(572, 'COSAS', 'contenido', '2024-12-15', '675f43bd809bf.png', NULL, 11, 33, 4, 'comunidad'),
(573, '123123', '123123124', '2025-01-05', NULL, NULL, 11, 32, 4, 'comunidad'),
(574, 'nuevo ', 'esto es nuevo ', '2025-01-05', '12.jpg', NULL, 11, NULL, NULL, 'normal'),
(575, 'qweqwe', 'qweqwe', '2025-01-05', '11.jpg', NULL, 11, 29, 59, 'comunidad'),
(576, 'qweqwe123123qweqeqwe', '21:22', '2025-01-05', NULL, NULL, 11, 29, 40, 'comunidad'),
(577, 'esto es nuevo brother', 'esot en nuevo 21:22 2025', '2025-01-05', '12.jpg', NULL, 11, NULL, NULL, 'normal'),
(578, 'qwe', 'qwe', '2025-01-05', '8.jpg', NULL, 11, NULL, NULL, 'normal'),
(579, 'qwe', 'qwe nuevo qweqwe', '2025-01-05', '677aeabe425e3.jpg', NULL, 11, NULL, NULL, 'normal'),
(580, '65693', '894165987654321', '2025-01-08', NULL, NULL, 11, 32, 4, 'comunidad'),
(581, 'cosas ', 'probando jeje', '2025-01-08', NULL, NULL, 14, 32, 2, 'comunidad'),
(582, 'movidas nuevas', 'jeje good ', '2025-01-08', NULL, NULL, 14, NULL, NULL, 'normal'),
(583, 'Mira donde he estado', 'En ireland, super mega divertido el viaje.', '2025-01-08', '677ea142ef86e.jpg', NULL, 14, 31, 58, 'comunidad'),
(584, 'nutricion', 'contenido nutricion', '2025-01-08', NULL, NULL, 14, 32, 2, 'comunidad'),
(585, 'nuevo foto', 'imagen nueva ', '2025-01-08', '677eadb808751.jpg', NULL, 3, 32, 2, 'comunidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id_temas` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id_temas`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Innovaciones Tecnológicas', 'Últimas tendencias en tecnología.', '2024-10-22'),
(2, 'Nutrición', 'Importancia de una buena alimentación.', '2024-10-22'),
(3, 'Fútbol', 'Debates sobre fútbol y equipos.', '2024-10-22'),
(4, 'Tecnología', 'Discusión sobre avances tecnológicos, gadgets, software y hardware.', '2024-11-22'),
(5, 'Cine', 'Comentarios y análisis de películas, series y cine independiente.', '2024-11-22'),
(6, 'Deportes', 'Debate sobre fútbol, baloncesto, tenis, y otros deportes.', '2024-11-22'),
(7, 'Música', 'Todo sobre géneros musicales, artistas y conciertos.', '2024-11-22'),
(8, 'Salud y Bienestar', 'Consejos y charlas sobre estilo de vida saludable y bienestar físico y mental.', '2024-11-22'),
(9, 'Viajes', 'Recomendaciones y experiencias de viajes a diferentes destinos del mundo.', '2024-11-22'),
(10, 'Literatura', 'Intercambio de libros, autores y recomendaciones literarias.', '2024-11-22'),
(11, 'Fotografía', 'Foro sobre técnicas, equipos y experiencias fotográficas.', '2024-11-22'),
(12, 'Videojuegos', 'Discusión sobre consolas, juegos y la industria del videojuego.', '2024-11-22'),
(13, 'Arte', 'Debate sobre obras de arte, artistas y tendencias artísticas.', '2024-11-22'),
(14, 'Historia', 'Conversaciones sobre eventos históricos, figuras y épocas clave.', '2024-11-22'),
(15, 'Ciencia', 'Intercambio de descubrimientos científicos, teorías y avances en la ciencia.', '2024-11-22'),
(16, 'Educación', 'Foro sobre métodos de enseñanza, educación online y recursos educativos.', '2024-11-22'),
(17, 'Emprendimiento', 'Consejos sobre cómo empezar un negocio, startups y marketing digital.', '2024-11-22'),
(18, 'Medio Ambiente', 'Debate sobre el cambio climático, ecología y sostenibilidad.', '2024-11-22'),
(19, 'Política', 'Análisis de eventos políticos, gobiernos y elecciones a nivel mundial.', '2024-11-22'),
(20, 'Economía', 'Debate sobre el estado de la economía, mercados financieros y teorías económicas.', '2024-11-22'),
(21, 'Gastronomía', 'Recetas, técnicas de cocina y exploración de la gastronomía global.', '2024-11-22'),
(22, 'Redes Sociales', 'Discusiones sobre las últimas tendencias y plataformas sociales.', '2024-11-22'),
(23, 'Espiritualidad', 'Conversaciones sobre filosofía, religiones y prácticas espirituales.', '2024-11-22'),
(24, 'Filosofía', 'Reflexiones sobre pensamiento filosófico, ética y lógica.', '2024-11-22'),
(25, 'Psicología', 'Charla sobre la mente humana, emociones, comportamientos y salud mental.', '2024-11-22'),
(26, 'Moda', 'Tendencias de la moda, consejos de estilo y últimas colecciones.', '2024-11-22'),
(27, 'Tecnologías Emergentes', 'Debate sobre inteligencia artificial, blockchain, y otras tecnologías del futuro.', '2024-11-22'),
(28, 'Jardinería', 'Consejos sobre cultivo de plantas, paisajismo y cuidado de jardines.', '2024-11-22'),
(29, 'Animales', 'Todo sobre mascotas, fauna salvaje y conservación animal.', '2024-11-22'),
(30, 'Fútbol', 'Foro dedicado a la pasión del fútbol, equipos, partidos y jugadores.', '2024-11-22'),
(31, 'Marketing Digital', 'Estrategias, campañas y mejores prácticas de marketing online.', '2024-11-22'),
(32, 'Estilo de Vida', 'Consejos sobre cómo llevar una vida equilibrada y plena.', '2024-11-22'),
(33, 'Superhéroes', 'Cultura pop, cómics, películas y todo sobre el universo de los superhéroes.', '2024-11-22'),
(34, 'Relaciones Humanas', 'Conversaciones sobre vínculos personales, amistad y amor.', '2024-11-22'),
(35, 'Educación Financiera', 'Consejos para mejorar la gestión de dinero, inversiones y finanzas personales.', '2024-11-22'),
(36, 'Cultura Pop', 'Todo lo relacionado con películas, series, música y más en el mundo del entretenimiento.', '2024-11-22'),
(37, 'Sostenibilidad', 'Proyectos e iniciativas que buscan un mundo más sostenible y ecológico.', '2024-11-22'),
(38, 'Ropa Vintage', 'Foro sobre ropa retro, segunda mano y estilo vintage.', '2024-11-22'),
(39, 'Tendencias en Tecnología', 'Nuevas tendencias en el mundo tecnológico, desde IA hasta wearables.', '2024-11-22'),
(40, 'Bienestar Mental', 'Estrategias y técnicas para cuidar la salud mental y emocional.', '2024-11-22'),
(41, 'Ciberseguridad', 'Debate sobre la protección de datos, hacking ético y seguridad digital.', '2024-11-22'),
(42, 'Astronomía', 'Exploración del espacio, planetas, estrellas y fenómenos astronómicos.', '2024-11-22'),
(43, 'Cómics', 'Intercambio sobre cómics, autores, géneros y adaptaciones cinematográficas.', '2024-11-22'),
(44, 'Cultura Geek', 'Todo sobre la cultura geek: gadgets, cómics, tecnología y videojuegos.', '2024-11-22'),
(45, 'Terror', 'Discusión sobre películas, libros y relatos de terror y misterio.', '2024-11-22'),
(46, 'Criptomonedas', 'Análisis sobre el mercado de criptomonedas, blockchain y NFTs.', '2024-11-22'),
(47, 'Sociología', 'Estudios sobre el comportamiento humano en la sociedad, cultura y grupos sociales.', '2024-11-22'),
(48, 'Trabajo Remoto', 'Consejos sobre cómo trabajar desde casa, herramientas y productividad.', '2024-11-22'),
(49, 'Cuidado Personal', 'Consejos sobre higiene, cuidados de la piel, cabello y bienestar general.', '2024-11-22'),
(50, 'Automóviles', 'Todo sobre coches, mantenimiento, novedades y el mundo del motor.', '2024-11-22'),
(51, 'Diseño Gráfico', 'Foro sobre tendencias, herramientas y consejos en el mundo del diseño visual.', '2024-11-22'),
(52, 'Cuentos Cortos', 'Intercambio de relatos, cuentos y narrativas breves de diferentes géneros.', '2024-11-22'),
(53, 'Bailes', 'Discusión sobre estilos de baile, desde salsa hasta hip hop y danza moderna.', '2024-11-22'),
(54, 'Aventura al Aire Libre', 'Experiencias y consejos sobre senderismo, camping y actividades al aire libre.', '2024-11-22'),
(55, 'Cultura Asiática', 'Todo sobre la cultura, cine, música y tradiciones de Asia oriental.', '2024-11-22'),
(56, 'Feng Shui', 'Consejos para aplicar el Feng Shui en el hogar y mejorar la energía de los espacios.', '2024-11-22'),
(57, 'Esports', 'Competencias, noticias y estrategias sobre el mundo de los deportes electrónicos.', '2024-11-22'),
(58, 'Autoayuda', 'Temas de desarrollo personal, motivación y cómo superar obstáculos en la vida.', '2024-11-22'),
(59, 'Arquitectura', 'Todo sobre diseño arquitectónico, tendencias y construcción sostenible.', '2024-11-22'),
(60, 'Maternidad y Paternidad', 'Consejos y experiencias sobre la crianza de hijos y educación familiar.', '2024-11-22'),
(61, 'Aficiones Creativas', 'Intercambio sobre pasatiempos creativos como DIY, scrapbooking, y manualidades.', '2024-11-22'),
(62, 'Lenguas Extranjeras', 'Foro para aprender y practicar idiomas extranjeros, cultura y tradiciones.', '2024-11-22'),
(63, 'Cómics Manga', 'Discusión sobre mangas, anime y todo lo relacionado con la cultura japonesa.', '2024-11-22'),
(64, 'Relatos de Viaje', 'Intercambio de experiencias y anécdotas sobre viajes por el mundo.', '2024-11-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas-comunidades`
--

CREATE TABLE `temas-comunidades` (
  `id_tema` int(11) NOT NULL,
  `id_comunidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas-comunidades`
--

INSERT INTO `temas-comunidades` (`id_tema`, `id_comunidad`) VALUES
(40, 29),
(59, 29),
(61, 29),
(4, 30),
(54, 31),
(58, 31),
(62, 31),
(2, 32),
(4, 32),
(2, 33),
(3, 33),
(4, 33),
(5, 33),
(1, 34),
(3, 35),
(4, 35),
(9, 35),
(2, 36),
(4, 37),
(2, 38),
(3, 38),
(4, 38),
(5, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `contraseña` varchar(250) NOT NULL,
  `imagen_logo_usuario` varchar(250) NOT NULL DEFAULT 'administrador.png',
  `fecha_unido` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `correo`, `contraseña`, `imagen_logo_usuario`, `fecha_unido`) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@example.com', '1234', 'administrador1.png', '2024-11-29'),
(2, 'María', 'Gómez', 'maria.gomez@example.com', 'abcd', 'administrador2.png', '2024-11-29'),
(3, 'Pedro', 'López', 'pedro.lopez@example.com', '123', 'administrador3.png', '2024-11-29'),
(4, 'Laura', 'Martínez', 'laura.martinez@example.com', '123', 'administrador4.png', '2024-11-29'),
(5, 'Carlos', 'Fernández', 'carlos.fernandez@example.com', 'qwe', 'administrador4.png', '2024-11-29'),
(6, 'Ana', 'Sánchez', 'ana.sanchez@example.com', 'secret', 'administrador1.png', '2024-11-29'),
(7, 'Luis', 'Ramírez', 'luis.ramirez@example.com', 'hello', 'administrador2.png', '2024-11-29'),
(8, 'Lucía', 'Torres', 'lucia.torres@example.com', 'admin', 'administrador3.png', '2024-11-29'),
(9, 'Diego', 'Hernández', 'diego.hernandez@example.com', '123456', 'administrador2.png', '2024-11-29'),
(10, 'Elena', 'Morales', 'elena.morales@example.com', 'welcome', 'administrador1.png', '2024-11-29'),
(11, 'esteban', 'gamboa', 'gamoba@gmail.com', '123', 'administrador1.png', '2024-11-29'),
(12, 'esteban', 'gamboa', 'esteban@gmail.com', '$2y$10$VxNT78FSUDprjKbp6kmIHu0WQkh495yT3uxwoUYc7APYDb7j54wJ.', '677e8f92667e5.jpg', '2025-01-08'),
(13, 'esteban1', 'gamboa', 'esteban@gmailc.omn', '$2y$10$jnf4Aca5VrT0B68/WvYv4uiEmpr.4fWZtz3a7WBrTk9JrPiVJ6vrC', '677e8fb8b2211.jpg', '2025-01-08'),
(14, 'esteban12', 'gamboa', 'esteban@mgai.com', '$2y$10$erC6WvLssV3lq61gSHzYbeQ27OMUMs.dHjxz/66CSJ.ieyCVphi6S', '677e8ffc7109d.jpg', '2025-01-08'),
(15, 'pedro', 'fernandez', 'pedro@gmai.com', '$2y$10$9xfrli8Jd81/RCm6YLCbq.BkQlcCy1P5vA6uRyYPSOMrOcF3Rjvdy', '677eab158c9d2.jpg', '2025-01-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `id_voto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `fecha_voto` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id_voto`, `id_usuario`, `id_post`, `fecha_voto`) VALUES
(563, 11, 564, '2024-12-13'),
(564, 11, 567, '2024-12-13'),
(565, 11, 566, '2024-12-13'),
(566, 11, 565, '2024-12-14'),
(567, 11, 569, '2024-12-14'),
(568, 11, 570, '2024-12-14'),
(569, 11, 571, '2025-01-05'),
(570, 11, 572, '2025-01-05'),
(571, 11, 573, '2025-01-05'),
(572, 11, 578, '2025-01-05'),
(573, 1, 578, '2025-01-05'),
(574, 11, 576, '2025-01-08'),
(575, 14, 580, '2025-01-08'),
(576, 14, 576, '2025-01-08'),
(577, 14, 583, '2025-01-08'),
(578, 3, 581, '2025-01-08'),
(579, 3, 585, '2025-01-08'),
(580, 12, 585, '2025-01-09'),
(581, 12, 584, '2025-01-12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `comentarios_ibfk_3` (`id_comentario_padre`);

--
-- Indices de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD PRIMARY KEY (`id_comunidad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`id_membresia`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_comunidad`),
  ADD KEY `id_comunidad` (`id_comunidad`,`id_usuario`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_comunidad` (`id_comunidad`) USING BTREE,
  ADD KEY `id_tema` (`id_tema`) USING BTREE;

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id_temas`);

--
-- Indices de la tabla `temas-comunidades`
--
ALTER TABLE `temas-comunidades`
  ADD PRIMARY KEY (`id_comunidad`,`id_tema`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `unique` (`nombre`,`correo`) USING BTREE;

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id_voto`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE,
  ADD KEY `id_post` (`id_post`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  MODIFY `id_comunidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id_temas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `id_voto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=582;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_3` FOREIGN KEY (`id_comentario_padre`) REFERENCES `comentarios` (`id_comentario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD CONSTRAINT `comunidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD CONSTRAINT `membresias_ibfk_1` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id_comunidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membresias_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id_comunidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_temas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `temas-comunidades`
--
ALTER TABLE `temas-comunidades`
  ADD CONSTRAINT `temas-comunidades_ibfk_1` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidades` (`id_comunidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temas-comunidades_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_temas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Base de datos: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- Volcado de datos para la tabla `pma__export_templates`
--

INSERT INTO `pma__export_templates` (`id`, `username`, `export_type`, `template_name`, `template_data`) VALUES
(1, 'root', 'database', 'foro', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"structure_or_data_forced\":\"0\",\"table_select[]\":[\"comentarios\",\"comunidades\",\"membresias\",\"post\",\"temas\",\"temas-comunidades\",\"usuarios\",\"votos\"],\"table_structure[]\":[\"comentarios\",\"comunidades\",\"membresias\",\"post\",\"temas\",\"temas-comunidades\",\"usuarios\",\"votos\"],\"table_data[]\":[\"comentarios\",\"comunidades\",\"membresias\",\"post\",\"temas\",\"temas-comunidades\",\"usuarios\",\"votos\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@DATABASE@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Estructura de la tabla @TABLE@\",\"latex_structure_continued_caption\":\"Estructura de la tabla @TABLE@ (continúa)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Contenido de la tabla @TABLE@\",\"latex_data_continued_caption\":\"Contenido de la tabla @TABLE@ (continúa)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"structure_and_data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"structure_and_data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_procedure_function\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_create_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Volcado de datos para la tabla `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"foro2\",\"table\":\"usuarios\"},{\"db\":\"foro2\",\"table\":\"comunidades\"},{\"db\":\"foro2\",\"table\":\"post\"},{\"db\":\"foro2\",\"table\":\"comentarios\"},{\"db\":\"foro2\",\"table\":\"temas\"},{\"db\":\"foro2\",\"table\":\"temas-comunidades\"},{\"db\":\"foro2\",\"table\":\"membresias\"},{\"db\":\"foro2\",\"table\":\"votos\"},{\"db\":\"foro\",\"table\":\"usuarios\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__table_info`
--

INSERT INTO `pma__table_info` (`db_name`, `table_name`, `display_field`) VALUES
('foro2', 'comentarios', 'contenido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-01-12 17:29:00', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de datos: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
