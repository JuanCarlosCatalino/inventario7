-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 05:44:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `invetario7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes_institucion`
--

CREATE TABLE `ambientes_institucion` (
  `id` bigint(20) NOT NULL,
  `id_ies` int(11) NOT NULL,
  `encargado` varchar(100) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `detalle` varchar(300) NOT NULL,
  `otros_detalle` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ambientes_institucion`
--

INSERT INTO `ambientes_institucion` (`id`, `id_ies`, `encargado`, `codigo`, `detalle`, `otros_detalle`) VALUES
(1, 1, 'ys', '102B', 'AULA DPW 1', 'LABORATORIO'),
(2, 1, 'rrsss', '122', '121', '122'),
(3, 2, '', '213', '123', '123'),
(4, 1, 'prueba', 's', 's', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienes`
--

CREATE TABLE `bienes` (
  `id` bigint(20) NOT NULL,
  `id_ingreso_bienes` int(11) NOT NULL,
  `id_ambiente` bigint(20) NOT NULL,
  `cod_patrimonial` varchar(20) NOT NULL,
  `denominacion` varchar(300) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `dimensiones` varchar(50) NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `situacion` varchar(5) NOT NULL,
  `estado_conservacion` varchar(20) NOT NULL,
  `observaciones` varchar(400) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_registro` int(11) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `bienes`
--

INSERT INTO `bienes` (`id`, `id_ingreso_bienes`, `id_ambiente`, `cod_patrimonial`, `denominacion`, `marca`, `modelo`, `tipo`, `color`, `serie`, `dimensiones`, `valor`, `situacion`, `estado_conservacion`, `observaciones`, `fecha_registro`, `usuario_registro`, `estado`) VALUES
(1, 1, 2, '', 'PRUEBARRasdasd', 'PP', 'RR', 'UU', 'EE', 'BB', 'AA', 12.20, 'UUU', 'REGULARR', 'BIEN DE PRUENARRRsadasdasdsdasdasdasdasdasdsad', '2025-04-05 12:28:04', 1, 0),
(2, 1, 2, '1234567', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 123.00, 'S', 'S', 'S', '2025-04-05 12:28:53', 1, 0),
(3, 6, 2, '123456', 'Bien de prueba', 'prueba', 'prueba', 'prueba', 'prueba', 'prueba', 'prueba', 0.00, 'prueb', 'prueba', 'prueba', '2025-04-17 22:32:06', 1, 1),
(4, 6, 1, '11212', 'aasd', 'asdas', 'dasd', 'asdas', 'asdasd', 'asdas', 'dasdasd', 0.00, 'asdas', 'dasd', 'asd', '2025-04-17 22:34:24', 1, 1),
(5, 7, 1, '12312', '312', '312', '312', '123', '123', '213123', '123', 123.00, '123', '123123', '123', '2025-04-17 22:41:16', 1, 1),
(6, 8, 1, 'as', 'wqeasd', 'asd', 'asd', 'asdasd', 'asdas', 'asdasd', 'dsad', 0.00, 'dasd', 'asd', 'asd', '2025-04-17 22:42:29', 1, 1),
(7, 9, 1, 'sad', 'asd', 'asd', 'asd', 'asd', 'asdasd', 'asdasd', 'asdas', 0.00, 'asdas', 'asd', 'asd', '2025-04-17 22:42:45', 1, 1),
(8, 10, 1, '', 'jk', 'hk', 'hjk', 'hkj', 'hk', 'jh', 'kjh', 0.00, 'hkj', 'hkj', 'fd', '2025-04-17 22:46:41', 1, 1),
(9, 11, 1, 'hjasbdkj', 'lj', 'k', 'b', 'b', 'jb', 'kjb', 'jh', 0.00, 'hjklj', 'kl', 'j', '2025-04-22 15:18:04', 1, 1),
(10, 11, 1, '', 'jk', 'kj', 'jk', 'dfdf', 'kjj', 'jk', 'klj', 0.00, 'hjk', 'h', 'kjh', '2025-04-22 15:18:04', 1, 1),
(11, 12, 1, '', 'klñ', 'ñ', 'j', 'k', 'jkl', 'j', 'lkj', 0.00, 'jlk', 'j', 'lkj', '2025-04-22 15:50:52', 1, 1),
(12, 12, 1, '', 'kjkj', 'njk', 'nk', 'j', 'kjh', 'kj', 'hjk', 0.00, 'kh', 'jkh', 'ui', '2025-04-22 15:50:52', 1, 1),
(13, 12, 1, '', 'kjhk', 'hkj', 'hj', 'h', 'jkh', 'j', 'h', 0.00, 'k', 'hjk', 'sdf', '2025-04-22 15:50:52', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_movimiento`
--

CREATE TABLE `detalle_movimiento` (
  `id` bigint(20) NOT NULL,
  `id_movimiento` bigint(20) NOT NULL,
  `id_bien` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_movimiento`
--

INSERT INTO `detalle_movimiento` (`id`, `id_movimiento`, `id_bien`) VALUES
(1, 2, 3),
(2, 2, 4),
(3, 3, 3),
(4, 3, 4),
(5, 4, 7),
(6, 4, 3),
(7, 4, 4),
(8, 5, 3),
(9, 5, 4),
(10, 5, 1),
(11, 5, 8),
(12, 5, 7),
(13, 6, 1),
(14, 6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_bienes`
--

CREATE TABLE `ingreso_bienes` (
  `id` int(11) NOT NULL,
  `detalle` varchar(1000) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ingreso_bienes`
--

INSERT INTO `ingreso_bienes` (`id`, `detalle`, `id_usuario`, `fecha_registro`) VALUES
(1, 'primer ingreso', 1, '2025-04-17 13:31:07'),
(2, 'Ingreso de Bienes', 1, '2025-04-17 22:23:06'),
(3, 'Ingreso de Bienes', 1, '2025-04-17 22:32:06'),
(4, 'Ingreso de Bienes', 1, '2025-04-17 22:32:59'),
(5, 'Ingreso de Bienes', 1, '2025-04-17 22:34:05'),
(6, '234234', 1, '2025-04-17 22:34:24'),
(7, 'sdsd', 1, '2025-04-17 22:41:16'),
(8, 'asdasd', 1, '2025-04-17 22:42:29'),
(9, 'sadasd', 1, '2025-04-17 22:42:45'),
(10, 'sfaasf', 1, '2025-04-17 22:46:41'),
(11, 'transferencia del gore', 1, '2025-04-22 15:18:04'),
(12, 'ingreso de bienes de prueba', 1, '2025-04-22 15:50:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `id` int(11) NOT NULL,
  `beneficiario` int(11) NOT NULL,
  `cod_modular` varchar(10) NOT NULL,
  `ruc` varchar(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `institucion`
--

INSERT INTO `institucion` (`id`, `beneficiario`, `cod_modular`, `ruc`, `nombre`) VALUES
(1, 1, '0671107', '20608381385', 'huanta'),
(2, 3, '1231', '2144214', 'ayacucho'),
(3, 1, '235468', '3246842.031', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint(20) NOT NULL,
  `id_ambiente_origen` bigint(20) NOT NULL,
  `id_ambiente_destino` bigint(20) NOT NULL,
  `id_usuario_registro` int(11) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp(),
  `descripcion` varchar(2000) NOT NULL,
  `id_ies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `id_ambiente_origen`, `id_ambiente_destino`, `id_usuario_registro`, `fecha_registro`, `descripcion`, `id_ies`) VALUES
(1, 1, 4, 1, '2025-04-18', 'movimiento de prueba', 1),
(2, 1, 4, 1, '2025-04-18', 'movimiento de prueba', 1),
(3, 4, 1, 1, '2025-04-18', 'sas', 1),
(4, 1, 2, 1, '2025-04-21', 'ff', 1),
(5, 2, 1, 1, '2025-04-21', 'rt', 1),
(6, 1, 2, 1, '2025-04-22', 'jdsfsdkjf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `token` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id`, `id_usuario`, `fecha_hora_inicio`, `fecha_hora_fin`, `token`) VALUES
(1, 1, '2025-04-04 16:29:36', '2025-04-04 16:31:36', 'Nwk7ysUyIz)Itj7XM16MM4&xp#1xwQ'),
(2, 1, '2025-04-04 16:30:08', '2025-04-04 16:32:08', ']MOJmj[bnm[F0lbTw]czK&RE0(b]OO'),
(3, 1, '2025-04-04 16:32:01', '2025-04-04 22:16:08', 'xSme*)4BwdsR(w)lv&z{vN56w7Jduk'),
(4, 1, '2025-04-04 22:16:07', '2025-04-04 22:18:07', 'Fdz3]2fNNm/Dd96J89AtGn])87YG{b'),
(5, 1, '2025-04-04 22:16:17', '2025-04-04 22:18:05', 'U6ZveFDq8L)w*2(K}3qv3jsLNJM2Ge'),
(6, 1, '2025-04-04 22:17:10', '2025-04-04 22:23:40', 'anROe$qEm$@9G3oXw32N)L@s6((KJ]'),
(7, 1, '2025-04-04 22:22:50', '2025-04-04 22:29:21', 'z9j3[13PC8$u7yfG(5AwbW4eCIp(Ss'),
(8, 1, '2025-04-04 22:28:30', '2025-04-04 22:30:30', 'xfBz{8[PsKhIcI4x[SiF(Tn8l&5*[7'),
(9, 1, '2025-04-04 22:28:31', '2025-04-04 22:30:31', 'jjX)Y%G}e$dyASQKE@NtqWH2abV&sD'),
(10, 1, '2025-04-04 22:28:32', '2025-04-04 22:30:32', 'u%EB)bxP1wj/5onQ@{aLIWcsyh*%xn'),
(11, 1, '2025-04-04 22:28:55', '2025-04-04 22:30:55', 'ODKDpGdn%)BZI*R)TZC$ToslqFTzit'),
(12, 1, '2025-04-04 22:29:47', '2025-04-04 22:31:47', '9a&gCiI{@E6I9HbzEqUG7lm$e7ySFt'),
(13, 1, '2025-04-04 22:30:35', '2025-04-04 22:33:14', 'Xaj6%d7hmI0YcrPTj7nxkOGY]6)WC5'),
(14, 1, '2025-04-04 22:32:35', '2025-04-04 23:39:42', 'rGU%cjZm%OP(0RZ1jIQJ}0Ns}zm8O@'),
(15, 1, '2025-04-05 11:37:22', '2025-04-05 13:59:19', '$ywNpMwR/HlcLf71cb5HaYJV]5ids('),
(16, 1, '2025-04-07 20:59:24', '2025-04-07 22:59:50', 'D0md%s7R0FTK]{21trnSJkmDvsBkSz'),
(17, 1, '2025-04-08 09:19:33', '2025-04-08 09:25:56', '[ZcY#UnB$S#cBSoyf@cSpF)TCaefw@'),
(18, 1, '2025-04-08 21:41:02', '2025-04-08 21:43:02', 'Kw}}E0A12CXsIoInE(1V28)1UWWxX['),
(19, 1, '2025-04-08 21:41:11', '2025-04-08 23:39:07', 'jUpdfvsD3VDp17A7Uhs6xSwryPZWt&'),
(20, 1, '2025-04-15 15:17:22', '2025-04-15 18:34:28', 'mx[7aYCLlvsbfyvZLJ[k%ea#ZN&LQU'),
(21, 1, '2025-04-16 10:32:27', '2025-04-16 10:47:02', '}$K]bKqGQ@BXEfDj(DVvBzNygOwkPd'),
(22, 1, '2025-04-16 21:14:53', '2025-04-16 21:37:47', ']p]#9us03N8mtqTRQT8Y#1g7QY*q)9'),
(23, 1, '2025-04-17 13:31:57', '2025-04-17 23:04:48', ']JHHCm%6OCeZGpIkK%v}{YX)GC1u/A'),
(24, 1, '2025-04-18 10:50:05', '2025-04-18 12:49:12', '#Vxl3OP6A7H$OncAf{VCpldCjH)O6T'),
(25, 1, '2025-04-21 20:21:24', '2025-04-21 23:35:27', 'Z5HZY{Rq1pruf6kvNg]V3yRvWmbLSE'),
(26, 1, '2025-04-22 15:16:21', '2025-04-22 15:55:05', 'UcD@)T%3)0@Kb$NPAYWt[Hcxg&N$*p'),
(27, 1, '2025-04-25 23:00:03', '2025-04-25 23:05:24', 'LBD4)}(SXASrzkuK&hj%aOKz((]xvv'),
(28, 1, '2025-05-13 11:09:58', '2025-05-13 11:13:15', 'f&q2n[lRwuP%lTYm#fI9yOX@NN5D@#'),
(29, 1, '2025-05-30 11:43:27', '2025-05-30 11:44:29', 'gDS1an(eqF1ns&62/0bWWFt$EsVH@s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` varchar(11) NOT NULL,
  `nombres_apellidos` varchar(140) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `password` varchar(1000) NOT NULL,
  `reset_password` int(1) NOT NULL DEFAULT 0,
  `token_password` varchar(30) NOT NULL DEFAULT '',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `nombres_apellidos`, `correo`, `telefono`, `estado`, `password`, `reset_password`, `token_password`, `fecha_registro`) VALUES
(1, '11112222', 'admin', 'admin@gmail.comm', '987654321', 1, '$2y$10$IeNRkcso2I60YiFEo8gKmeQEyWhTVq9TETpTgSenx380IaeWOSbv6', 0, '', '2025-04-04 16:20:51'),
(2, '70198965', 'yucra curo ', 'yucrac@gmail.com', '12345611', 1, '$2y$10$eYm6sJB.gf6SWDfad1CDT.ZHcpTBI/3XfL/fA5KT4KXdv3ZgPSW6C', 0, '', '2025-04-04 16:54:14'),
(3, 'ss', 'ss', 'ss', 'ss', 1, '$2y$10$o4roS5UGJWwdbRqzLD7QYexqmtnZli9blSKQGfdAFXL6K7h0Ef1Bq', 0, '', '2025-04-04 21:20:33'),
(4, '87654321', 'catalino juan', 'jajaj@gmail.com', '987654321', 1, 'admin', 0, '', '2025-05-13 11:11:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambientes_institucion`
--
ALTER TABLE `ambientes_institucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ies` (`id_ies`);

--
-- Indices de la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ambiente` (`id_ambiente`),
  ADD KEY `usuario_registro` (`usuario_registro`),
  ADD KEY `id_ingreso_bienes` (`id_ingreso_bienes`);

--
-- Indices de la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bien` (`id_bien`),
  ADD KEY `id_movimiento` (`id_movimiento`);

--
-- Indices de la tabla `ingreso_bienes`
--
ALTER TABLE `ingreso_bienes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiario` (`beneficiario`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ambiente_origen` (`id_ambiente_origen`),
  ADD KEY `id_ambiente_destino` (`id_ambiente_destino`),
  ADD KEY `id_usuario_registro` (`id_usuario_registro`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambientes_institucion`
--
ALTER TABLE `ambientes_institucion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bienes`
--
ALTER TABLE `bienes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ingreso_bienes`
--
ALTER TABLE `ingreso_bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ambientes_institucion`
--
ALTER TABLE `ambientes_institucion`
  ADD CONSTRAINT `ambientes_institucion_ibfk_1` FOREIGN KEY (`id_ies`) REFERENCES `institucion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD CONSTRAINT `bienes_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes_institucion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bienes_ibfk_2` FOREIGN KEY (`usuario_registro`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bienes_ibfk_3` FOREIGN KEY (`id_ingreso_bienes`) REFERENCES `ingreso_bienes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD CONSTRAINT `detalle_movimiento_ibfk_1` FOREIGN KEY (`id_bien`) REFERENCES `bienes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_movimiento_ibfk_2` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingreso_bienes`
--
ALTER TABLE `ingreso_bienes`
  ADD CONSTRAINT `ingreso_bienes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD CONSTRAINT `institucion_ibfk_1` FOREIGN KEY (`beneficiario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_ambiente_origen`) REFERENCES `ambientes_institucion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_ambiente_destino`) REFERENCES `ambientes_institucion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`id_usuario_registro`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
