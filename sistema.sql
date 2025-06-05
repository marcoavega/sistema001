-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 08:45:07
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
(15, 'administrador1', 'administrador1@gmail.com', '$2y$10$HqeAjVjU2IdwaCGQfV3T.OvgOXuWF.IpPJPKT57FqDO3FtBby5dom', 2, '2025-03-28 23:33:42', '2025-04-20 15:44:22', ''),
(27, 'administrador', 'administrador@gmail.com', '$2y$10$5DSbp6nSLKLs1MfK.c8PUeq.RbXo94s7dF42u8maVwIGGOQInhIPS', 1, '2025-04-18 05:44:07', '2025-05-07 20:07:41', 'assets/images/users/administrador.png'),
(34, 'administrador3', 'administrador3@gmail.com', '$2y$10$oX3TFhuG8TISWvSvnYZ35eMBtZxhP5HnIviTvUaa9bC9QTxpRvQSe', 1, '2025-05-05 23:16:29', '2025-05-05 23:16:48', ''),
(39, 'administrador4', 'administrador4@gamail.com', '$2y$10$oANVcX0Cwy9rJ/WkEp/N9.E4c2.Eloe4xKVGb7ztMogSJtZrrWzii', 1, '2025-05-08 21:49:15', '2025-05-08 21:49:15', ''),
(43, 'administrador5', 'administrador5@gmail.com', '$2y$10$IcH46sHEntZZDtMW52LKHuxalaBb.iC1UzEueMuB6.qOnICUpvfmi', 1, '2025-05-12 18:22:58', '2025-05-12 18:22:58', '');

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `levels_users`
--
ALTER TABLE `levels_users`
  MODIFY `id_level_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users-levels` FOREIGN KEY (`level_user`) REFERENCES `levels_users` (`id_level_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
