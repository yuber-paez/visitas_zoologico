-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2025 a las 09:37:19
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
-- Base de datos: `zoologico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_pago`
--

CREATE TABLE `medio_pago` (
  `id_medio_pago` int(10) NOT NULL,
  `pago` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medio_pago`
--

INSERT INTO `medio_pago` (`id_medio_pago`, `pago`) VALUES
(1, 'EFECTIVO'),
(2, 'TARJETA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(10) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`) VALUES
(1, 'ADMIN'),
(2, 'USER'),
(3, 'EMPLEADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tip_entrada`
--

CREATE TABLE `tip_entrada` (
  `id_tip_entrada` int(10) NOT NULL,
  `entrada` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tip_entrada`
--

INSERT INTO `tip_entrada` (`id_tip_entrada`, `entrada`) VALUES
(1, 'ADULTO'),
(2, 'NINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `doc` int(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `img` varchar(500) NOT NULL,
  `user` varchar(30) NOT NULL,
  `id_rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `doc`, `name`, `email`, `tel`, `password`, `img`, `user`, `id_rol`) VALUES
(7, 1070730214, 'Yuber Paez', 'santiagopc333@gmail.com', '3202534042', '$2y$10$BtVj2mge5h5/oF1l5YuecO3dRjVOe8wiT0quvZ6g2fAqj.2wo8mY.', 'uploads/68c79f04ab46d_atras.jpg', 'Yubergas333', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id_visi` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `documento` int(20) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `fecha_entrada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_salida` datetime DEFAULT NULL,
  `tip_entrada` int(10) NOT NULL,
  `id_med_pago` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visitas`
--

INSERT INTO `visitas` (`id_visi`, `nombre`, `documento`, `tel`, `fecha_entrada`, `fecha_salida`, `tip_entrada`, `id_med_pago`) VALUES
(1, 'Yuber Paez', 1070730214, '305 847 9261', '2025-09-15 06:53:56', '2025-09-30 01:53:35', 1, 1),
(2, 'Yuber Paez', 1070730214, '305 847 9261', '2025-09-15 06:54:05', '2025-09-30 01:53:35', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  ADD PRIMARY KEY (`id_medio_pago`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tip_entrada`
--
ALTER TABLE `tip_entrada`
  ADD PRIMARY KEY (`id_tip_entrada`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id_visi`),
  ADD KEY `tip_entrada` (`tip_entrada`),
  ADD KEY `id_med_pago` (`id_med_pago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  MODIFY `id_medio_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tip_entrada`
--
ALTER TABLE `tip_entrada`
  MODIFY `id_tip_entrada` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id_visi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`tip_entrada`) REFERENCES `tip_entrada` (`id_tip_entrada`),
  ADD CONSTRAINT `visitas_ibfk_2` FOREIGN KEY (`id_med_pago`) REFERENCES `medio_pago` (`id_medio_pago`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
