-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2025 a las 14:51:00
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
-- Base de datos: `uo300627_db`
--
CREATE DATABASE IF NOT EXISTS `uo300627_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `uo300627_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivo`
--

CREATE TABLE `dispositivo` (
  `id_dispositivo` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dispositivo`
--

INSERT INTO `dispositivo` (`id_dispositivo`, `nombre`) VALUES
(1, 'Ordenador'),
(2, 'Tableta'),
(3, 'Telefono');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `nombre`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observacion_facilitador`
--

CREATE TABLE `observacion_facilitador` (
  `id_observacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `comentarios_facilitador` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `observacion_facilitador`
--

INSERT INTO `observacion_facilitador` (`id_observacion`, `id_usuario`, `comentarios_facilitador`) VALUES
(1, 1, 'Posible mejora en las imagenes del html que se carga en circuito para que tengan todas el mismo tamaño.'),
(2, 2, 'Se ha desenvuelto muy bien en la aplicación encontrando rápido los datos requeridos. Principales objeciones acerca del aspecto de algunos apartados, pero que están fuera de lo que se pide en la asignatura, quedaría para posibles desarrollos futuros.'),
(3, 3, 'Se ha desenvuelto muy bien desde el dispositivo móvil a pesar de no tener mucha experiencia informática, encontrando bien todas las respuestas a las preguntas. Respecto a las propuestas de mejora tenerlas en cuenta para diferenciar bien que el glosario no tiene relación con el contenido principal añadiéndolo a un aside.'),
(4, 4, 'Se ha desenvuelto muy bien encontrando rápido las respuestas y accediendo bien a los apartados a pesar de hacerlo desde una tableta. Mirar lo de la foto pixelada y corregir los errores ortográficos.'),
(5, 5, 'Se ha desenvuelto muy bien en la aplicación encontrando rápidamente las respuestas a las preguntas. Mirar si poner un título para indicar que lo de abajo del carrusel son noticias.'),
(6, 6, 'Se ha desenvuelto muy bien encontrando la información rápidamente a pesar de estar desde un dispositivo móvil. Mirar de cambiar el formato del tiempo que tardó el ganador para que quede más claro para el usuario.'),
(7, 7, 'Se ha desenvuelto perfectamente a pesar de la poco habilidad informática, encontrando las respuestas a las preguntas con facilidad.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `id_resultado` int(11) NOT NULL,
  `numero_pregunta` int(11) NOT NULL CHECK (`numero_pregunta` between 1 and 10),
  `valor_respuesta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id_respuesta`, `id_resultado`, `numero_pregunta`, `valor_respuesta`) VALUES
(1, 1, 1, 'Maverick Viñales'),
(2, 1, 2, 'Red Bull KTM Tech3'),
(3, 1, 3, '190'),
(4, 1, 4, '3'),
(5, 1, 5, '3'),
(6, 1, 6, 'Petronas Sepang International Circuit'),
(7, 1, 7, '2025-10-26'),
(8, 1, 8, 'Álex Márquez'),
(9, 1, 9, 'Marc Márquez'),
(10, 1, 10, '5'),
(11, 2, 1, 'Maverick Viñales'),
(12, 2, 2, 'Red Bull KTM Tech3'),
(13, 2, 3, '190'),
(14, 2, 4, '4'),
(15, 2, 5, '3'),
(16, 2, 6, 'Petronas Sepang International Circuit'),
(17, 2, 7, '2025-10-26'),
(18, 2, 8, 'Alex Márquez'),
(19, 2, 9, 'Marc Márquez'),
(20, 2, 10, '5'),
(21, 3, 1, 'Maverick Viñales'),
(22, 3, 2, 'Red Bull KTM Tech3'),
(23, 3, 3, '190'),
(24, 3, 4, '5'),
(25, 3, 5, '3'),
(26, 3, 6, 'Circuito de Petronas Sepang International Circuit'),
(27, 3, 7, '2025-10-26'),
(28, 3, 8, 'Álex Márquez'),
(29, 3, 9, 'Marc Márquez'),
(30, 3, 10, '5'),
(31, 4, 1, 'Maverick Viñales'),
(32, 4, 2, 'Red Bull KTM Tech3'),
(33, 4, 3, '190'),
(34, 4, 4, '5'),
(35, 4, 5, '3'),
(36, 4, 6, 'circuito Petronas Sepang International Circuit'),
(37, 4, 7, '2025-10-26'),
(38, 4, 8, 'Álex Márquez'),
(39, 4, 9, 'Marc Márquez'),
(40, 4, 10, '5'),
(41, 5, 1, 'Maverick Viñales'),
(42, 5, 2, 'Red Bull KTM Tech3'),
(43, 5, 3, '190'),
(44, 5, 4, '5'),
(45, 5, 5, '3'),
(46, 5, 6, 'Circuito de Petronas Sepang International Circuit'),
(47, 5, 7, '26/10/2025'),
(48, 5, 8, 'Álex Márquez'),
(49, 5, 9, 'Marc Márquez'),
(50, 5, 10, '5'),
(51, 6, 1, 'Maverick Viñales'),
(52, 6, 2, 'Red Bull KTM Tech3'),
(53, 6, 3, '190'),
(54, 6, 4, '5'),
(55, 6, 5, '3'),
(56, 6, 6, 'Circuito Petronas Sepang International Circuit'),
(57, 6, 7, '26-10-2025'),
(58, 6, 8, 'Álex Márquez'),
(59, 6, 9, 'Marc Márquez'),
(60, 6, 10, '5'),
(61, 7, 1, 'Maverick Viñales'),
(62, 7, 2, 'Red Bull KTM Tech3'),
(63, 7, 3, '190'),
(64, 7, 4, '5'),
(65, 7, 5, '3'),
(66, 7, 6, 'Petronas Sepang International Circuit'),
(67, 7, 7, '26/10/2025'),
(68, 7, 8, 'Álex Márquez'),
(69, 7, 9, 'Marc Márquez'),
(70, 7, 10, '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

CREATE TABLE `resultado` (
  `id_resultado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dispositivo` int(11) NOT NULL,
  `tiempo_empleado` decimal(10,2) DEFAULT NULL,
  `completado` tinyint(1) NOT NULL,
  `comentarios_usuario` text DEFAULT NULL,
  `propuestas_mejora` text DEFAULT NULL,
  `valoracion` int(11) DEFAULT NULL CHECK (`valoracion` between 0 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultado`
--

INSERT INTO `resultado` (`id_resultado`, `id_usuario`, `id_dispositivo`, `tiempo_empleado`, `completado`, `comentarios_usuario`, `propuestas_mejora`, `valoracion`) VALUES
(1, 1, 2, 245.79, 1, 'Ninguno', 'La pregunta de la meteorología es un poco dudosa', 9),
(2, 2, 1, 270.99, 1, 'No tengo ningún otro comentario', 'Las fotos que aparecen en la pantalla de inicio las pondría centradas. Poner por ejemplo la biografía del piloto a la derecha de la foto y en general todo mejor distribuido para que no quede tanto espacio vacío a la derecha.', 7),
(3, 3, 3, 321.49, 1, 'Está todo muy bien y está claro.', 'La lista de conceptos relacionados con moto GP que está en el apartado de piloto quedaría mejor en un apartado aparte llamado por ejemplo glosario, ya que no tiene mucho que ver con el piloto.', 10),
(4, 4, 2, 307.64, 1, 'El resto está muy bien, no tengo ningún otro comentario.', 'La foto que aparece del piloto se ve muy pixelada, la cambiaría por otra que se vea mejor. En meteorología pone al principio \"Coordenadas de las ciudad:\", que no tiene mucho sentido, por lo que lo corregiría para que se entendiera mejor.', 8),
(5, 5, 1, 266.81, 1, 'Nada más, está perfecto, muestra la información de manera clara', 'Si tuviera que mejorar algo especificaría que la información que aparece en la página de inicio después de las fotos son noticias poniendo un título o algo similar', 7),
(6, 6, 3, 295.85, 1, 'Por el resto todo muy claro y fácil de encontrar la información.', 'Cambiaría la forma en la que se muestra el tiempo que tardó el ganador en acabar la carrera ya que no se entiende del todo bien cuanto es.', 9),
(7, 7, 2, 333.56, 1, 'No tengo ningún comentario.', 'No se me ocurre ninguna, está todo perfecto.', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `edad` int(11) NOT NULL CHECK (`edad` between 0 and 120),
  `profesion` varchar(40) NOT NULL,
  `id_genero` int(11) NOT NULL,
  `pericia` int(11) NOT NULL CHECK (`pericia` between 0 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `edad`, `profesion`, `id_genero`, `pericia`) VALUES
(1, 23, 'Estudiante', 1, 10),
(2, 47, 'Administradora', 2, 7),
(3, 51, 'Vendedor por cuenta ajena', 1, 4),
(4, 45, 'Profesora', 2, 5),
(5, 19, 'Estudiante', 2, 7),
(6, 20, 'Estudiante', 2, 6),
(7, 48, 'Obrero', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD PRIMARY KEY (`id_dispositivo`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `observacion_facilitador`
--
ALTER TABLE `observacion_facilitador`
  ADD PRIMARY KEY (`id_observacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD UNIQUE KEY `respuesta_unica` (`id_resultado`,`numero_pregunta`);

--
-- Indices de la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD PRIMARY KEY (`id_resultado`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_dispositivo` (`id_dispositivo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_genero` (`id_genero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `observacion_facilitador`
--
ALTER TABLE `observacion_facilitador`
  MODIFY `id_observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `resultado`
--
ALTER TABLE `resultado`
  MODIFY `id_resultado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `observacion_facilitador`
--
ALTER TABLE `observacion_facilitador`
  ADD CONSTRAINT `observacion_facilitador_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`id_resultado`) REFERENCES `resultado` (`id_resultado`);

--
-- Filtros para la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD CONSTRAINT `resultado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `resultado_ibfk_2` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivo` (`id_dispositivo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id_genero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
