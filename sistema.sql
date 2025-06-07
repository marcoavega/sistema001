-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2025 a las 23:51:34
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
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companys`
--

CREATE TABLE `companys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rfc` varchar(55) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `companys`
--

INSERT INTO `companys` (`id`, `name`, `rfc`, `address`, `phone`, `email`) VALUES
(1, 'company1', 'xxxxxxxxxxxx', 'direcion-de-empresa', '5525458796', 'email@empresa.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levels_users`
--

CREATE TABLE `levels_users` (
  `id_level_user` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `description_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `levels_users`
--

INSERT INTO `levels_users` (`id_level_user`, `level`, `description_level`) VALUES
(1, 1, 'Administrador'),
(2, 2, 'Director'),
(3, 3, 'Gerente'),
(4, 4, 'Supervisor'),
(5, 5, 'Auxiliar'),
(6, 6, 'Externo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `level_user`, `created_at`, `updated_at`, `img_url`) VALUES
(2, 'administrador2', 'administrador2@gmail.com', '$2y$10$GgtTWrlYykHcv6hednsnKOEJEKyOG5JQmrMnHjX736nL4p6gK2bAW', 1, '2025-03-18 20:15:59', '2025-05-05 20:12:37', ''),
(15, 'administrador1', 'administrador1@gmail.com', '$2y$10$HqeAjVjU2IdwaCGQfV3T.OvgOXuWF.IpPJPKT57FqDO3FtBby5dom', 1, '2025-03-28 23:33:42', '2025-05-22 17:49:07', ''),
(27, 'administrador', 'administrador@gmail.com', '$2y$10$j.n/yl2twdiwX7qdoYV1t.tT2dYVMYmKB3NCodQ9nyasBqHlOA45C', 1, '2025-04-18 05:44:07', '2025-05-25 01:38:46', 'assets/images/users/administrador.png'),
(34, 'administrador3', 'administrador3@gmail.com', '$2y$10$oX3TFhuG8TISWvSvnYZ35eMBtZxhP5HnIviTvUaa9bC9QTxpRvQSe', 1, '2025-05-05 23:16:29', '2025-05-05 23:16:48', ''),
(46, 'administrador4', 'administrador4@gmail.com', '$2y$10$j25.pyBSiZUGXT5J0H5kRO1Gyw3tLqjx/HEBLdnpfra09SnEz9Xuq', 1, '2025-05-23 01:42:43', '2025-05-23 01:42:43', ''),
(47, 'administrador5', 'administrador5@gmail.com', '$2y$10$DIUdFkeiI2ls3sBLh0CAW.uoZuiMy.tB2.j6cBiDo89A2alhOa3cS', 1, '2025-05-23 01:43:30', '2025-05-23 01:43:30', ''),
(49, 'administrador6', 'administrador6@gmail.com', '$2y$10$VPbzrZL5IVBp.T8RiHd1Q.AzBEfKi0jOVmKa/9ca3jJ7Td5tRIiG6', 1, '2025-05-23 02:35:28', '2025-05-23 02:35:28', ''),
(50, 'administrador8', 'administrador8@gmail.com', '$2y$10$VX60KoRrbUg7d3s6V4tKROrtzh8skkYKXxAq4PS9QiNUZzrTORk9C', 1, '2025-05-23 02:38:41', '2025-05-24 21:12:21', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` enum('login','logout') NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `action`, `timestamp`) VALUES
(1, 27, 'logout', '2025-06-07 13:24:49'),
(2, 27, 'login', '2025-06-07 13:25:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `levels_users`
--
ALTER TABLE `levels_users`
  ADD PRIMARY KEY (`id_level_user`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `users-levels` (`level_user`);

--
-- Indices de la tabla `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `levels_users`
--
ALTER TABLE `levels_users`
  MODIFY `id_level_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users-levels` FOREIGN KEY (`level_user`) REFERENCES `levels_users` (`id_level_user`);

--
-- Filtros para la tabla `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
