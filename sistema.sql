-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-06-2025 a las 20:50:26
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
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Herramientas generales'),
(2, 'Insumos consumibles'),
(3, 'Herramientas maquinados'),
(4, 'Papelería'),
(5, 'Tlapalería'),
(6, 'Materia prima maquinado'),
(9, 'Piezas para kit de articulador'),
(11, 'Producto terminado');

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
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `currency_id` int(11) NOT NULL,
  `currency_name` varchar(10) NOT NULL,
  `exchange_rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_name`, `exchange_rate`) VALUES
(1, 'MXN', 20.00),
(2, 'USD', 20.00);

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
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(1000) NOT NULL,
  `product_description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `subcategory_id` int(11) NOT NULL,
  `desired_stock` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `sale_price` decimal(10,4) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `height` decimal(10,4) DEFAULT NULL,
  `length` decimal(10,4) DEFAULT NULL,
  `width` decimal(10,4) DEFAULT NULL,
  `diameter` decimal(10,4) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `product_description`, `location`, `price`, `stock`, `registration_date`, `category_id`, `supplier_id`, `unit_id`, `currency_id`, `image_url`, `subcategory_id`, `desired_stock`, `status`, `sale_price`, `weight`, `height`, `length`, `width`, `diameter`, `updated_at`) VALUES
(1, 'H-0001', 'Avellanador 1/4\" 1/4\"', NULL, 'HM3-7', 150.00, 6, '2024-01-08 00:00:00', 3, 2, 1, 1, 'avellanador1_4.jpg', 5, 2, 0, 150.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-27 21:27:11'),
(44, 'H-0002', 'Avellanador 1/2\" 3FLT 82', NULL, 'HM3-7', 1.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '652459c468854_IMG_20231009_134859_398[1].jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(45, 'H-0003', 'Boquilla ER-32', NULL, 'HM3-8', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245e5e4adc8_IMG_20231009_135742_685[1].jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(47, 'H-0004', 'Cortador 211-270 3/4 4FL SQ EM', NULL, 'HM2-11', 980.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245f668b348_IMG_20231009_140439_159.jpg', 5, 2, 0, 980.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(48, 'H-0005', 'Cortador De Carburo Solido Diametro 3/8, 3 Filos, AADE0375J3D KENNAMETAL', NULL, 'HM2-11', 800.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245fd9ed077_IMG_20231009_135542_237.jpg', 5, 4, 1, 800.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(49, 'H-0006', 'Cortador SA-1FM 1/4 CYL', NULL, '', 650.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'CORTADOR.jpg', 5, 2, 1, 650.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(50, 'H-0007', 'Cuchilla E100 P7ACERO Y ALUMINIO', NULL, 'HM2-14', 1.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '652460811aecd_IMG_20231009_140404_883.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(51, 'H-0008', 'Fresa de carburo de tungsteno clave 125 12,7 x 22,2 x 6,4 mm(1/2x7/8x1/4\")', NULL, 'HM2-14', 784.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, 'FRESA.jpg', 5, 2, 0, 784.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(53, 'H-0009', 'FRESA DE DOBLE CORTE DE CARBURO SH-5', NULL, 'HM2-14', 784.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '652461bd30ddf_IMG_20231009_140548_946.jpg', 5, 2, 0, 784.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(54, 'H-0010', 'Fresa de doble corte para dremel SC-42 Double cut burr', NULL, 'HM2-14', 200.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524621ebb627_IMG_20231009_140321_551.jpg', 5, 2, 0, 200.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(55, 'H-0011', 'Tarraja 1\" M6X1', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246c8bd5430_IMG_20231009_140019_434.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(56, 'H-0012', 'Tarraja 1\" M5X.8', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246df03f3d9_IMG_20231009_140039_500.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(57, 'H-0013', 'Tarraja 1\" M4X7', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246e42c629b_IMG_20231009_140058_020.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(58, 'H-0014', 'Tarraja 1\" M3X.5', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246e9854526_IMG_20231009_140118_450.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(60, 'H-0016', 'Machuelo OSG ROYCO 5303F 1/8 - 40 2B 3FL SEMICONICO', NULL, 'HM3-6', 1.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '652475de427e8_IMG_20231009_153018_560.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(61, 'H-0017', 'Machuelo OSG ROYCO 5303F 3/16-24 2B 4FL SEMICONICO', NULL, 'HM3-6', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247686b6266_IMG_20231009_152858_760.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(63, 'H-0018', 'Machuelo OSG ROYCO 142 M3X0.5 D3 2S/P PLUG', NULL, 'HM2-20', 1.00, 11, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524776535649_IMG_20231009_152807_827.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(64, 'H-0019', 'Machuelo OSG ROYCO 5305N 10-24 2B 4FL SEMICONICO', NULL, 'HM3-6', 1.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '652478ecd5372_IMG_20231009_152338_555.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(65, 'H-0020', 'Machuelo OSG ROYCO 5301N 10-24 2B 2S/P SEMICONICO', NULL, 'HM2-20', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247a0aa1a16_IMG_20231009_152338_555.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(67, 'H-0021', 'Machuelo OSG ROYCO 5303F 1/4-20 2B 4FL SEMICONICO', NULL, 'HM2-20', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247a86be014_IMG_20231009_152858_760.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(70, 'H-0022', 'Machuelo OSG ROYCO 5303F 3/8-16 2B 4FL SEMICONICO', NULL, 'HM3-6', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247b763dce8_IMG_20231009_152442_711.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(71, 'H-0023', 'Juego de Machuelo OSG ROYCO M5 X 0.8 6H', NULL, 'HM3-6', 486.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247bc62733f_IMG_20231009_152701_683.jpg', 5, 3, 1, 486.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(72, 'H-0024', 'Juego de Machuelo OSG ROYCO M6 X1 6H', NULL, 'HM3-6', 513.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247c3f9dfa5_IMG_20231009_152645_816.jpg', 5, 3, 1, 513.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(74, 'H-0025', 'Juego de Machuelo OSG ROYCO M4 X 0.7 6H', NULL, 'HM3-6', 486.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247cc3dc7f0_IMG_20231009_152544_434.jpg', 5, 3, 1, 486.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(75, 'H-0026', 'Cortador R1.5X6X4X50L', NULL, 'HM3-9', 290.50, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247f7a95089_IMG-20231009-WA0001.jpg', 5, 2, 0, 290.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(76, 'H-0027', 'Cortador R1.0X4X4X50L', NULL, 'HM3-9', 290.50, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247f8f4de19_IMG-20231009-WA0001.jpg', 5, 2, 0, 290.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(77, 'H-0028', 'Cortador R0.75X3X4X50L', NULL, 'HM3-9', 290.50, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247fa445d75_IMG-20231009-WA0001.jpg', 5, 2, 0, 290.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(80, 'H-0029', 'Cortador R2.0X8X4X50L', NULL, 'HM3-9', 1290.50, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247fda7de63_IMG-20231009-WA0001.jpg', 5, 2, 0, 1290.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(81, 'H-0030', 'Cortador R0.5X2X4X50L', NULL, 'HM3-9', 290.50, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524800c28db9_IMG-20231009-WA0001.jpg', 5, 2, 0, 290.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(82, 'H-0031', 'Inserto DFT05T308HP / KC7140 / 1804829', NULL, 'HM2-17', 500.00, 20, '2024-01-08 00:00:00', 3, 2, 1, 1, '652480ee9141e_IMG_20231009_161518_511.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(83, 'H-0032', 'Inserto KC410M / 2984054', NULL, 'HM2-17', 500.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '652481525eae6_IMG_20231009_161612_513.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(84, 'H-0033', 'Inserto NT2R / KCU10 / 4175911', NULL, 'HM2-18', 500.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652481907eff1_IMG_20231009_161713_523.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(86, 'H-0034', 'Inserto NT3RK / KC5025 / 1795787', NULL, 'HM2-18', 30.50, 10, '2024-01-08 00:00:00', 3, 2, 1, 2, '652481dc39e07_IMG_20231009_161307_339.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(88, 'H-0036', 'Inserto CNMG090308MP / CNMG322MP / KC5010', NULL, 'HM2-16', 15.60, 30, '2024-01-08 00:00:00', 3, 2, 1, 2, '6524835def208_IMG_20231009_161822_013.jpg', 5, 10, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(89, 'H-0037', 'Inserto A4G0205M02U02GMN / KC5025', NULL, 'HM2-16', 500.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '652483a716952_IMG_20231009_161742_020.jpg', 5, 2, 1, 500.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(91, 'H-0038', 'Inserto NT3R / KC5010', NULL, 'HM2-18', 500.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652484445d5e1_IMG_20231009_165123_369.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(92, 'H-0039', 'Broca para metal 10.00 MM', NULL, 'HM2-6', 85.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525779ebfad1_IMG_20231010_100001_599.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0039, '2025-06-22 11:11:48'),
(93, 'H-0040', 'Broca para metal 17/64', NULL, 'HM2-7', 40.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525785db67f9_IMG_20231010_100116_298.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0067, '2025-06-22 11:11:48'),
(94, 'H-0041', 'Broca para metal 1/4', NULL, 'HM2-5', 100.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652578cf4aa14_IMG_20231010_100201_147.jpg', 5, 5, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0063, '2025-06-22 11:11:48'),
(95, 'H-0042', 'Broca para metal 6.35 MM', NULL, '', 80.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525791b1534f_IMG_20231010_100354_485.jpg', 5, 2, 1, 80.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(96, 'H-0043', 'Broca para metal 1/2\"', NULL, 'HM3-1', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '652579aa0c56d_IMG_20231010_100433_527.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(97, 'H-0044', 'Broca para metal 3/8&quot; HSS', NULL, 'HM2-7', 90.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '652579edc8504_IMG_20231010_100541_401.jpg', 5, 2, 0, 90.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(98, 'H-0045', 'Broca para concreto 3/8\" (10)', NULL, 'HM3-1', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257a28469e7_IMG_20231010_100557_681.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(99, 'H-0046', 'Broca para metal 9/16\"', NULL, 'HM3-4', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257bf5b93cc_IMG_20231010_102027_731.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(100, 'H-0047', 'Broca para metal 31/64\"', NULL, 'HM3-3', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257c3e19dfe_IMG_20231010_102050_437.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(101, 'H-0048', 'Broca para metal 7/16\"', NULL, 'HM3-3', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257cbf1b672_IMG_20231010_102116_322.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(102, 'H-0049', 'Broca para metal CLEVELAND 1/8', NULL, 'HM2-5', 30.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257d245682b_IMG_20231010_102147_476.jpg', 5, 10, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0031, '2025-06-22 11:11:48'),
(103, 'H-0050', 'Broca para metal 2.50 MM 0.0984', NULL, 'HM2-7', 45.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257d6c28af3_IMG_20231010_102225_747.jpg', 5, 5, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0025, '2025-06-22 11:11:48'),
(104, 'H-0051', 'Broca para metal 15/64', NULL, 'HM2-7', 80.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257db2b948b_IMG_20231010_102246_630.jpg', 5, 5, 1, 80.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(105, 'H-0052', 'Broca para metal 7/64', NULL, 'HM2-8', 55.00, 14, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257e53c347f_IMG_20231010_102607_366.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(106, 'H-0053', 'Broca para metal 3/32', NULL, 'HM2-7', 35.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257e9c98e90_IMG_20231010_102330_517.jpg', 5, 5, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0023, '2025-06-22 11:11:48'),
(107, 'H-0054', 'Broca para metal 3/16', NULL, 'HM2-7', 90.00, 13, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257ed86fba6_IMG_20231010_102408_714.jpg', 5, 5, 1, 90.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(109, 'H-0055', 'Broca para metal 4.00 MM', NULL, 'HM2-8', 35.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257f7bdf85b_IMG_20231010_102424_168.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0040, '2025-06-22 11:11:48'),
(110, 'H-0056', 'Broca para metal 11/64', NULL, 'HM2-6', 30.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257fbd8eebc_IMG_20231010_102534_809.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(111, 'H-0057', 'Broca para metal 9/64', NULL, 'HM2-9', 38.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258003de85c_IMG_20231010_102552_755.jpg', 5, 10, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0035, '2025-06-22 11:11:48'),
(112, 'H-0058', 'Broca para metal 1/8', NULL, 'HM2-5', 35.00, 8, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258044d9a12_IMG_20231010_102623_674.jpg', 5, 10, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0032, '2025-06-22 11:11:48'),
(114, 'H-0059', 'Broca para metal 5/32', NULL, 'HM2-8', 40.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '652580db7f955_IMG_20231010_102641_410.jpg', 5, 5, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 39.0000, '2025-06-22 11:11:48'),
(115, 'H-0060', 'Broca para metal 5/64\" 0.0781\"', NULL, 'HM2-8', 75.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '652581b01de30_IMG_20231010_102650_179.jpg', 5, 2, 0, 75.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(116, 'H-0061', 'Broca para metal 27  0.1440', NULL, 'HM2-7', 40.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652581ffc15c7_IMG_20231010_102659_658.jpg', 5, 2, 0, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 27.0000, '2025-06-22 11:11:48'),
(117, 'H-0062', 'Broca para concreto 5/8\"', NULL, 'HM3-1', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258353be987_IMG_20231010_105534_251.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(118, 'H-0063', 'Broca para metal 5/16', NULL, 'HM2-8', 78.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '652583a12c1bc_IMG_20231010_105604_565.jpg', 5, 5, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 79.0000, '2025-06-22 11:11:48'),
(119, 'H-0064', 'Broca para metal 13/64', NULL, 'HM2-6', 55.00, 11, '2024-01-08 00:00:00', 3, 2, 1, 1, '652583e7491b3_IMG_20231010_105626_665.jpg', 5, 10, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0051, '2025-06-22 11:11:48'),
(120, 'H-0065', 'Broca para metal 7/8\"', NULL, 'HM3-4', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525842fa53a5_IMG_20231010_105659_302.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(121, 'H-0066', 'Broca para metal 3/4\"', NULL, 'HM3-2', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '652584603c277_IMG_20231010_105722_077.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(122, 'H-0067', 'Broca para metal 12.50 MM', NULL, 'HM3-2', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '652584a152913_IMG_20231010_105753_757.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(123, 'H-0068', 'Tornillos para torno 5/16', NULL, 'HM3-6', 100.00, 14, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525889da04c5_IMG_20231010_111900_825.jpg', 5, 8, 1, 1.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(124, 'H-0069', 'Rima CLEVELAND 3/8\"', NULL, 'HM3-7', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258909e297e_IMG_20231010_111931_604.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(125, 'H-0070', 'Rima Fenes 3/8\"', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258952c5e06_IMG_20231010_112035_863.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(126, 'H-0071', 'Rima Fenes 1/2\"', NULL, 'HM3-7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258999e1c99_IMG_20231010_112058_508.jpg', 5, 2, 0, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(127, 'H-0072', 'Pistola de silicón Grande', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258d9f1b792_IMG_20231010_113034_246.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(128, 'I-0001', 'Barras de silicón 1/2\"', NULL, 'LOCKER FILA 3', 1.00, 34, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258df2a32fc_IMG_20231010_113138_143.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(129, 'I-0002', 'Lentes  de seguridad FOY Ambar', NULL, 'LOCKER FILA 4', 1.00, 16, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258e42dfb13_IMG_20231010_113233_881.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(130, 'I-0003', 'Lentes de seguridad PRETUL Transparentes', NULL, 'LOCKER FILA 4', 1.00, 7, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258e9d97d1d_IMG_20231010_113315_252.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(131, 'I-0004', 'Lentes de seguridad FOY Transparentes', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258faddecd5_IMG_20231010_113429_054.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(132, 'I-0005', 'Plasti acero 25 ml o Epoxico', NULL, 'LOCKER FILA 2', 110.00, 5, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525913f69a16_IMG_20231010_113453_281.jpg', 5, 2, 1, 110.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(133, 'I-0006', 'Cinta sella roscas 1/2\" X 7 m', NULL, 'LOCKER FILA 4', 1.00, 10, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525920b640f5_IMG_20231010_113514_174.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(134, 'I-0007', 'Disco de lija Grano 120 fino 5\"', NULL, 'LOCKER FILA 4', 1.00, 13, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525933e1bb8b_IMG_20231010_113546_500.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(136, 'I-0008', 'Disco de lija Grano 80 medio 5\"', NULL, 'LOCKER FILA 4', 1.00, 11, '2024-01-08 00:00:00', 2, 2, 1, 1, '652593d8eea6c_IMG_20231010_113617_638.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(137, 'I-0009', 'Cinta de montaje doble cara 19 mm X 5 m', NULL, 'LOCKER FILA 1', 1.00, 5, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525944472efc_IMG_20231010_113631_678.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(138, 'I-0010', 'Cinta masking 18 mm X 50 m', NULL, 'FILA 1', 30.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525948a58bdf_IMG_20231010_113650_761.jpg', 5, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(139, 'I-0011', 'Pistola de silicón Chica', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '652594c2942b8_IMG_20231010_113711_071.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(140, 'I-0012', 'Tapones auditivos con triple barrera 25 db', NULL, 'LOCKER FILA 4', 10.78, 10, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525951016b48_IMG_20231010_113734_333.jpg', 5, 2, 1, 10.7800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(141, 'I-0013', 'Guantes de nitrilo Grandes', NULL, 'LOCKER FILA 4', 28.45, 6, '2024-01-08 00:00:00', 2, 2, 1, 1, '652595508a04e_IMG_20231010_113750_383.jpg', 5, 2, 1, 28.4500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(143, 'I-0014', 'Guantes de carnaza Unitalla (trabajo ligero)', NULL, 'LOCKER FILA 4', 53.45, 3, '2024-01-08 00:00:00', 5, 2, 1, 1, '652595ca65d46_IMG_20231010_113804_572.jpg', 5, 2, 1, 53.4500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(144, 'I-0015', 'Portalámpara para tubo flourescente FA8', NULL, '', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '65259615af253_IMG_20231010_113819_730.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(145, 'I-0016', 'Manguera para aire tipo resorte 7.6 m', NULL, '', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '652596833170a_IMG_20231010_115933_963.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(146, 'I-0017', 'Fumigador doméstico 1 LT.', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '652596c7cc55c_IMG_20231010_120000_943.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(147, 'H-0073', 'Martillo de hojalatero 11 OZ.', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259736a23ab_IMG_20231010_120022_666.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(148, 'H-0074', 'Mango para martillo Mango', NULL, '', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525980f04ad2_IMG_20231010_120039_303.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(149, 'H-0075', 'Maceta de goma 606', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259960a900f_IMG_20231010_120105_237.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(150, 'H-0076', 'Maceta de goma 808', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259995d501c_IMG_20231010_120116_822.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(151, 'H-0077', 'Extensión eléctrica de uso rudo 16 AWG X 6 MTS', NULL, '', 1.00, 6, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259a2423a75_IMG_20231010_120145_934.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(152, 'H-0078', 'Cautín Weller 221-NM-146', NULL, 'LOCKER FILA 3', 1300.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259c45890f4_IMG_20231010_120456_039.jpg', 5, 2, 1, 1300.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(153, 'H-0079', 'Puntas para multimetro Fluke', NULL, 'LOCKER FILA 2', 300.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '65259ddad49cb_IMG_20231010_120509_094.jpg', 5, 2, 1, 300.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(154, 'H-0080', 'Punta para cautín CT5A7MX', NULL, 'LOCKER FILA 3', 120.00, 5, '2024-01-08 00:00:00', 2, 2, 1, 1, '65259ee66b32b_IMG_20231010_120636_659.jpg', 5, 2, 1, 120.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(155, 'H-0081', 'Punta para cautín PTA7MX', NULL, 'LOCKER FILA 3', 120.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '65259f71740bd_IMG_20231010_120624_780.jpg', 5, 2, 1, 120.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(156, 'H-0082', 'Resistencia HEW60PMX', NULL, 'LOCKER FILA 3', 450.00, 2, '2024-01-08 00:00:00', 2, 2, 1, 1, '65259fcaca494_IMG_20231010_120721_513.jpg', 5, 2, 1, 450.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(158, 'I-0018', 'Disco 40 grano, 115mm, 22mm', NULL, 'LOCKER FILA 4', 1.00, 2, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525a7a179664_IMG_20231010_120346_523.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(162, 'I-0019', 'Esponja para cautín Esponja', NULL, 'LOCKER FILA 3', 30.00, 3, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525af2672d9e_IMG_20231010_120529_238.jpg', 5, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(163, 'I-0020', 'Rollo de lija N. 100 1 1/2\" X 148 Ft.', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525b0191cc09_IMG_20231010_122251_179.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(164, 'I-0021', 'Rollo de lija grano 120 38 mm X 45 m', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525b06eba83a_IMG_20231010_122323_456.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(165, 'I-0022', 'Mini cepillo de alambre Surtido', NULL, 'LOCKER FILA 3', 1.00, 12, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b0fa58367_IMG_20231010_122411_264.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(166, 'H-0083', 'Navaja retráctil 18 mm', NULL, 'LOCKER FILA 3', 40.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b1918b595_IMG_20231010_122514_553.jpg', 5, 2, 1, 40.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(167, 'H-0084', 'Navaja retráctil Pequeña', NULL, 'LOCKER FILA 3', 25.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b2121263e_IMG_20231010_122537_660.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(168, 'I-0023', 'Repuesto para navajas Repuesto', NULL, 'LOCKER FILA 3', 30.00, 8, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b2c625380_IMG_20231010_122544_491.jpg', 5, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(170, 'H-0085', 'Cuchilla para linóleo 7\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b34f832e0_IMG_20231010_122619_684.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(171, 'I-0024', 'Pila alcalina A76/LR44', NULL, 'LOCKER FILA 2', 55.00, 2, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525b3ea55aef_IMG_20231010_135502_790.jpg', 5, 2, 1, 55.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(175, 'H-0086', 'Lima redonda bastarda 10\"', NULL, 'LOCKER FILA 4', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b8f888bd8_IMG_20231010_140631_205.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(178, 'H-0087', 'Maneral tipo garrote 3/32&quot; A 3/8&quot;', NULL, 'LOCKER FILA 3', 70.96, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525bbfaa970d_IMG_20231010_140616_249.jpg', 5, 2, 1, 70.9600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(179, 'H-0088', 'Lima bastarda de media caña escofina 4\"', NULL, '', 70.00, 0, '2024-01-08 00:00:00', 1, 4, 1, 1, '6525bf2c397c0_IMG_20231010_140059_679.jpg', 5, 2, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(180, 'H-0089', 'Lima triangular de uso regular 5\"', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 1, 1, 1, '6525bfc39a576_IMG_20231010_140110_037.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(181, 'H-0090', 'Lima plana 5\"', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c0e41ba0b_IMG_20231010_140231_563.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(182, 'H-0091', 'Bomba desoldadora Extractor', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c13eddb97_IMG_20231010_140308_697.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(183, 'H-0092', 'Maneral ajustable 1/16\" X 1/4\"', NULL, '', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c1d3111fa_IMG_20231010_140321_313.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(184, 'H-0093', 'Lima bastarda de media caña 5\"', NULL, 'LOCKER FILA 4', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c259c5ab7_IMG_20231010_140403_929.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(185, 'H-0094', 'Broca para concreto 1/4\" X 12', NULL, '', 85.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c2e3e549b_IMG_20231010_140424_912.jpg', 5, 2, 1, 85.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(186, 'H-0095', 'Segueta Diente fino', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c36f1b8b4_IMG_20231010_140447_425.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(187, 'H-0096', 'Broca para concreto Longitud 12\"', NULL, 'LOCKER FILA 4', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c3eab5029_IMG_20231010_140603_518.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(188, 'H-0097', 'Maneral tipo garrote 5/32\" X 3/4\"', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c46a46249_IMG_20231010_140616_249.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(189, 'H-0098', 'Tijera 8\"', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c520ab147_IMG_20231010_152301_159.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(190, 'I-0025', 'Rueda flap con vástago grano 80 Ø 2&quot;', NULL, 'locker fila 4', 85.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c5fd16336_IMG_20231010_152326_826.jpg', 5, 2, 1, 85.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(191, 'I-0026', 'Rueda flap con vástago grano 120 Ø 2\"', NULL, '', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c65f73832_IMG_20231010_152326_826.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(192, 'I-0027', 'Cuchillas de repuesto para cortador de tubo 18 mm', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c82ab8050_IMG_20231010_152338_762.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(193, 'H-0099', 'Destornillador de caja 3/8\" X 3\"', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c945b5da9_IMG_20231010_152358_564.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(194, 'H-0100', 'Desarmador Comfort Grip 75 mm x 3\"', NULL, 'LOCKER FILA 3', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525ca43c0e7c_IMG_20231010_152435_828.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(195, 'H-0101', 'Desarmador Screwdriver 7\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cbc6b03b5_IMG_20231010_152502_653.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(196, 'H-0102', 'Desarmador Phillips PH0 x 4\"', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cc468391d_IMG_20231010_152543_607.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(197, 'H-0103', 'Desarmador de cruz 1/4\" x 4', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525ccd6a8bec_IMG_20231010_152631_435.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(198, 'H-0104', 'Dado corto 9/16\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cd5485220_IMG_20231010_152650_260.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(199, 'H-0105', 'Desarmador Plano', NULL, 'LOCKER FILA 3', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cda71bafc_IMG_20231010_152722_888.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(200, 'H-0106', 'Punzón para barrenar 3/8\"', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cf9cb1b93_IMG_20231010_152809_144.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(201, 'H-0107', 'Punzón 5/16\" X 1/8\"', NULL, 'LOCKER FILA 3', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cfd0b2658_IMG_20231010_152923_737.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(202, 'H-0108', 'Destornillador de caja 7 mm', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525d0405cc72_IMG_20231010_152942_826.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(203, 'H-0109', 'llave ajustable 6\" marca: FOY', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652874bb6fa72_IMG_20231010_154434_712.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(204, 'H-0110', 'Llave de presión 10\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528751b2fbb0_IMG_20231010_154521_868.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(205, 'H-0111', 'pinzas para abrir anillos de retención. desde 65mm hasta 12mm', NULL, 'LOCKER FILA 3', 190.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528758810807_IMG_20231010_154539_966.jpg', 5, 2, 1, 190.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(206, 'H-0112', 'Pinzas de presión Tipo prensa', NULL, 'LOCKER FILA 4', 245.69, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65287606afac3_IMG_20231010_154605_145.jpg', 5, 2, 1, 245.6900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(208, 'H-0113', 'pinzas de punta medianas', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652876a891028_IMG_20231010_154616_619.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(209, 'H-0114', 'Pinzas para anillo de retención de 90grados', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652876fc979d2_IMG_20231010_154629_828.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(210, 'H-0115', 'Matraca 3/8\"', NULL, '', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528775b9ea45_IMG_20231010_154639_333.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(211, 'H-0116', 'juego de llaves Allen tipo navaja estándar', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528781895bd7_IMG_20231010_154720_527.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(212, 'H-0117', 'llave combinada. 3/8\" X 16cm', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6529acbf18aa1_IMG_20231010_154821_267.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(213, 'H-0118', 'Llave combinada 9/16\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6529b93ac3c8c_IMG_20231010_155051_770.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(214, 'H-0119', 'Dado Corto 9/16\" 9/16\" marca SURTEK', NULL, 'LOCKER FILA 3', 30.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6532f3afa9ab7_IMG_20231020_153551_656_hdr.jpg', 5, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(216, 'I-0028', 'Brocha 1\" 1\" Marca Comex', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6532f541a667b_IMG_20231020_153607_481_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(218, 'H-0120', 'Llave Mixta 1/2\" 1/2\" Marca Urrea', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ea0dc3f5e_IMG_20231010_155121_905.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(219, 'H-0121', 'Llave Mixta 3/8\" 3/8\" Marca Urrea', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ea8d57ef4_IMG_20231010_155144_754.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(220, 'H-0122', 'Llave Allen 3/16\" Llave Allen 3/16\"', NULL, 'LOCKER FILA 3', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536eba15e073_IMG_20231010_155208_965.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(221, 'H-0123', 'Llave Allen 3.0mm Llave Allen 3.0mm', NULL, 'B14', 1.00, 6, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ec2182e0e_IMG_20231010_155230_884.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(222, 'H-0124', 'Llave Allen 5/32\" Llave Allen 5/32\"', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ec7417827_IMG_20231010_155305_259.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(223, 'H-0125', 'Llave Allen 5/64\" Llave Allen 5/64\"', NULL, 'LOCKER FILA 3', 1.00, 13, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ecbd71cce_IMG_20231010_155322_039.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(224, 'H-0126', 'Llave Allen 1/8\" Llave Allen 1/8\"', NULL, 'LOCKER FILA 3', 1.00, 9, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ed14c3b40_IMG_20231010_155448_355.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(225, 'H-0127', 'Llave Allen tipo T 3/32\" Llave Allen tipo T 3/32\"', NULL, 'LOCKER FILA 3', 1.00, 4, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ed6bb7880_IMG_20231010_155505_574.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(226, 'H-0128', 'Llave Allen Tipo T 1/8\" Llave Allen Tipo T 1/8\" ', NULL, 'LOCKER FILA 3', 1.00, 4, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536eea290400_IMG_20231010_155516_199.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(227, 'H-0129', 'Maneral ajustable tipo T 1/2\" Maneral ajustable tipo T 1/2\" marca truper', NULL, 'LOCKER FILA 3', 120.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536efa239bbb_IMG_20231010_155708_862.jpg', 5, 2, 1, 120.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(228, 'H-0130', 'Maneral Tipo T ajustable capacidad 3/16\"', NULL, 'LOCKER FILA 3', 63.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536effe5e1b3_IMG_20231010_155730_317.jpg', 5, 2, 1, 63.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(229, 'H-0131', 'Manera Tipo T ajustable 1/4\" Manera Tipo T ajustable 1/4\" marca truper', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f05aef38d_IMG_20231010_155813_643.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(230, 'H-0132', 'Broquero 1/2\" Broquero 1/2\" marca truper', NULL, 'LOCKER FILA 3', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f0b0bc6f6_IMG_20231010_155800_670.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(232, 'I-0029', 'Cople Rápido Macho Cople Rápido Macho', NULL, '', 1.00, 4, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f2171b4fa_IMG_20231010_155836_005.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(233, 'I-0030', 'Cople rápido hembra Cople rápido hembra surtek', NULL, 'LOCKER FILA 4', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f287a1b0f_IMG_20231010_155848_071.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(234, 'I-0031', 'Cople rápido hembra Cople rápido hembra marca truper', NULL, 'LOCKER FILA 4', 50.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f2bec2c4d_IMG_20231010_155903_289.jpg', 5, 2, 1, 50.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(235, 'H-0133', 'Flexometro 5m x 16\" Flexometro 5m x 16\" truper', NULL, 'LOCKER FILA 3', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f34d60237_IMG_20231010_155922_495.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(236, 'I-0032', 'Pila 2016 de 3V Pila 2016 de 3V marca steren', NULL, 'LOCKER FILA 2', 1.00, 9, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f46a4b3ac_IMG_20231010_160102_979.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(238, 'I-0033', 'Pila AA 1.5V Pila AA 1.5V marca RadioShack O ENERGIZER', NULL, 'LOCKER FILA 2', 10.00, 13, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f64d64536_IMG_20231010_160316_111.jpg', 5, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(239, 'I-0034', 'Pila AAA Pila AAA marca duracel', NULL, 'LOCKER FILA 2', 25.00, 6, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f6af551d7_IMG_20231010_160547_272.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(240, 'I-0035', 'Pila 9V Pila 9V marca Duracell O VOLTECK', NULL, 'LOCKER FILA 2', 38.80, 4, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f736d0c06_IMG_20231010_160446_493.jpg', 5, 2, 1, 38.8000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(241, 'I-0036', 'Gas butano Gas butano Pretul', NULL, 'LOCKER FILA 1', 1.00, 3, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f76a9dc4b_IMG_20231010_160737_064.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(242, 'I-0037', 'WD40', NULL, 'FILA 1', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f79498c77_IMG_20231010_160757_880.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(245, 'DELT-5B', 'TORNILLO PARA MESA INCISAL Y DE TRANSFERENCIA', NULL, 'GABETA-G2', 20.00, 399, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ad8eb74bfc_IMG_20231010_16081.jpg', 2, 2, 1, 20.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(246, 'I-0038', 'Bolsas para basura. Bolsas para basura, para desperdicio de maquinado.', NULL, '', 50.00, 10, '2024-01-08 00:00:00', 2, 4, 1, 1, '653ad8eb74bfc_IMG_20231010_160813_434.jpg', 5, 2, 1, 50.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(247, 'DELT-5Ñ', 'CONDILO PARA MCD', NULL, 'MESA', 20.00, 168, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ada08abb5c_condilo.jpg', 3, 2, 1, 20.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(248, 'DELT-4J', 'PERNO PARA LIGA DE CONTRACCION', NULL, 'GABETA-G5', 20.00, 232, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ade70bc6c0_dhjasdkjadljAFKADADKADLKahjkdahdkahd12651.png', 3, 2, 1, 20.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(253, 'H-0134', 'Boquilla ER25 1/2\" ER25 1/2\"', NULL, 'HM3-8', 532.50, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162509.jpg', 5, 2, 0, 532.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(254, 'H-0135', 'Cortador 5/8\" HSS 5/8\" HSS', NULL, '', 1032.40, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162528.jpg', 5, 2, 0, 1032.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(255, 'H-0136', 'Broca 28', NULL, 'HM2-1', 50.75, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162546.jpg', 5, 5, 1, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(256, 'H-0137', 'Broca 29 Broca 29', NULL, 'HM2-1', 50.75, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162601.jpg', 5, 2, 0, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(257, 'H-0138', 'Broca 30 Broca 30', NULL, '', 50.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162608.jpg', 5, 2, 0, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(258, 'H-0139', 'Broca para metal 7/32', NULL, 'HM2-8', 80.75, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG_20231030_132125_501_hdr.jpg', 5, 5, 1, 80.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(259, 'DELT-5X', 'PORTA PLATINA', NULL, '', 40.00, 821, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085206_665_hdr.jpg', 3, 2, 1, 40.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(260, 'DELT-5Q', 'TORNILLO DE FIJACION DE VARILLA DE NIVEL DE CPI M6', NULL, 's/u', 8.00, 107, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085129_359_hdr.jpg', 2, 2, 1, 8.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(261, 'DELT-6D', 'TORNILLO SUJECION 3', NULL, 'GABETA-G3', 8.00, 445, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085117_602_hdr.jpg', 2, 2, 1, 8.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(262, 'DELT-4Ñ', 'VARILLA DE SOPORTE', NULL, '', 40.00, 120, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085158_182_hdr.jpg', 3, 2, 1, 40.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(264, 'DELT-5C', 'PERNO DE POSICION (3/16 x 1/2), PERNO SOLIDO RECTIFICADO INOXIDABLE, (3/16 x .500)', NULL, 'A5', 3.86, 2518, '2024-01-08 00:00:00', 9, 13, 1, 1, 'pernos.jpg', 1, 600, 1, 3.8600, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(265, 'P-0039', 'Kola loka Pegamento', NULL, 'cajon', 20.00, 28, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG_20231101_080204_317_hdr.jpg', 5, 10, 1, 20.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(266, 'I-0040', 'Disco para esmeriladora angular para corte de metal 4 1/2\" Disco para esmeriladora angular para corte de metal 4 1/2\"  marca maxtool', NULL, 'LOCKER FILA 4', 50.00, 3, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG_20231101_120033_192_hdr.jpg', 5, 2, 1, 50.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(267, 'P-0001', 'Hojas Blancas paquete 500 hojas Hojas Blancas paquete 500 hojas', NULL, '', 1.00, 3, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_124600_652_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(268, 'P-0002', 'Etiquetas redondas dorada paquete Etiquetas redondas dorada paquete', NULL, '', 1.00, 4, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_124920_580_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(269, 'P-0003', 'Grapas caja de 5000 pzas. Grapas caja de 5000 pzas.', NULL, '', 1.00, 2, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125114_229_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(270, 'P-0004', 'Libreta profesional cuadro grande Libreta profesional cuadro grande', NULL, '', 20.00, 5, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125216_282_hdr.jpg', 5, 2, 1, 20.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(271, 'P-0005', 'Hojas de colores combinadas Hojas de colores combinadas por hojas', NULL, '', 1.00, 150, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125341_661_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(272, 'P-0006', 'Hojas blancas 500 pzas.', NULL, '', 180.00, 11, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_124600_652_hdr_654c02cef14dc.jpg', 5, 2, 1, 180.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(273, 'P-0007', 'Cuaderno profesional cuadro grande', NULL, '', 22.00, 1, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125216_282_hdr_654c0317801c3.jpg', 5, 2, 1, 22.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(274, 'P-0008', 'Tinta color azul Tinta color roja', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125834_988_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(275, 'P-0009', 'Tinta color negro Tinta color negro', NULL, '', 1.00, 1, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125841_629_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(276, 'P-0010', 'Cinta chica transparente scotch 550 Cinta chica transparente scotch 550', NULL, '', 1.00, 7, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_130008_700_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(277, 'P-0011', 'Marcador sharpie delgado punto fino color rojo. Marcador sharpie delgado punto fino color rojo.', NULL, '', 10.30, 12, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_130629_590_hdr.jpg', 5, 2, 1, 10.3000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(278, 'P-0012', 'Marcador Sharpie delgado punto fino color negro Marcador Sharpie delgado punto fino color negro', NULL, '', 17.10, 8, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_130751_772_hdr.jpg', 5, 2, 1, 17.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(279, 'P-0013', 'Marcador BIC delgado punto fino color negro Marcador BIC delgado punto fino color negro', NULL, '', 17.40, 6, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_130847_249_hdr.jpg', 5, 2, 1, 17.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(280, 'P-0014', 'Marcador Baco delgado punto fino color azul Marcador Baco delgado punto fino color azul', NULL, '', 18.00, 8, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_130937_485_hdr.jpg', 5, 2, 1, 18.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(281, 'p-0015', 'Bolígrafo Azor punto fino color negro Bolígrafo Azor punto fino color negro', NULL, '', 1.00, 8, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131122_472_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(282, 'P-0016', 'Bolígrafo azor punto fino color rojo Bolígrafo azor punto fino color rojo', NULL, '', 1.00, 6, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131146_164_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(283, 'P-0017', 'Bolígrafo Azor punto fino color azul Bolígrafo Azor punto fino color azul', NULL, '', 1.00, 6, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131236_084_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(284, 'P-0018', 'Marcador Esterbrook negro Marcador Esterbrook negro', NULL, '', 28.12, 8, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131330_455_hdr.jpg', 5, 2, 1, 28.1200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(285, 'P-0019', 'Marcador Esterbrook color azul Marcador Esterbrook color azul', NULL, '', 28.12, 3, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131521_459_hdr.jpg', 5, 2, 1, 28.1200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(286, 'P-0020', 'Marcador Esterbrook color rojo Marcador Esterbrook color rojo', NULL, '', 28.12, 2, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132237_713_hdr.jpg', 5, 2, 1, 28.1200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(287, 'P-0021', 'Boligrafo BIC color negro punto fino Boligrafo BIC color negro punto fino', NULL, '', 1.00, 4, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131634_257_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(288, 'P-0022', 'Bolígrafo BIC color negro punto mediano Bolígrafo BIC color negro punto mediano', NULL, '', 1.00, 5, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131711_565_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(289, 'P-0023', 'Lapiz Paper Mate HB 2.5 Lapiz Paper Mate HB 2.5', NULL, '', 1.00, 12, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132053_648_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(290, 'P-0024', 'Marcador Azor grueso color rojo Marcador Azor grueso color rojo', NULL, '', 15.24, 2, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132209_726_hdr.jpg', 5, 2, 1, 15.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(291, 'P-0025', 'Marcador sharpie punto ultra fino color negro Marcador sharpie punto ultra fino color negro', NULL, '', 17.10, 10, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132331_183_hdr.jpg', 5, 2, 1, 17.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(292, 'P-0026', 'Marcador colores surtido Marcador colores surtido', NULL, '', 11.20, 4, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132107_774_hdr.jpg', 5, 2, 1, 11.2000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(293, 'P-0027', 'Marcador Magistral color negro Marcador Magistral color negro', NULL, '', 18.62, 4, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132439_110_hdr.jpg', 5, 2, 1, 18.6200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(294, 'P-0028', 'Lapiz adhesivo Dixon Lapiz adhesivo Dixon', NULL, '', 1.00, 6, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_132710_926_hdr.jpg', 5, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(295, 'P-0029', 'Masking Tape Janel 24mm', NULL, 'FILA 1', 23.66, 7, '2024-01-08 00:00:00', 2, 5, 1, 1, 'IMG_20231108_132844_337_hdr.jpg', 5, 2, 1, 23.6600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(296, 'I-0270', 'Disco para esmeril, corte de metal, delgado de 4-1/2\" marca Astromex O TRUPER', NULL, 'LOCKER FILA 4', 18.10, 11, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG20231110103057.jpg', 5, 2, 1, 18.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(297, 'H-0141', 'Boquilla ER40 1/4\" (7-6mm) Boquilla ER40 1/4\" (7-6mm)', NULL, 'HM3-8', 580.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133250.jpg', 5, 2, 0, 580.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48');
INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `product_description`, `location`, `price`, `stock`, `registration_date`, `category_id`, `supplier_id`, `unit_id`, `currency_id`, `image_url`, `subcategory_id`, `desired_stock`, `status`, `sale_price`, `weight`, `height`, `length`, `width`, `diameter`, `updated_at`) VALUES
(298, 'H-0142', 'Boquilla ER32 3/32\" (3-2mm) Boquilla ER32 3/32\" (3-2mm)', NULL, 'HM3-8', 539.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133258.jpg', 5, 2, 0, 539.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(299, 'H-0143', 'Rima recta 3/16', NULL, 'HM3-7', 882.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133317.jpg', 5, 1, 1, 882.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(300, 'H-0144', 'Broca HSS 4F 3/32', NULL, 'HM2-2', 28.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133421.jpg', 5, 10, 1, 28.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(301, 'H-0145', 'Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox', NULL, 'HM4-1', 960.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133636.jpg', 5, 2, 0, 960.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(302, 'H-0146', 'Broca HSS #7 Cleveland Broca HSS #7 Cleveland', NULL, 'HM2-2', 50.75, 6, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133415.jpg', 5, 6, 1, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(303, 'H-0147', 'Broca HSS #20 Cleveland Broca HSS #20 Cleveland', NULL, 'HM2-2', 50.75, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133410.jpg', 5, 5, 1, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(304, 'H-0148', 'Cortador vertical de HSS 4F 1/8\" CLEV Cortador vertical de HSS 4F 1/8\" CLEV', NULL, '', 340.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133343.jpg', 5, 2, 0, 340.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(305, 'I-0041', 'Plasti Loka Plasti Loka', NULL, 'LOCKER FILA 2', 25.00, 2, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG20231114083449.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(306, 'DELT-6M', 'TORNILLO SUJECION 2, (TORNILLO PARA PORTA PLATINA Y BASE DE CALIBRACION).', NULL, '', 10.00, 415, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231003_085415_568_hdr.jpg', 2, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(307, 'DELT-6G', 'SOPORTE DE PANTALLA CENTRAL', NULL, '', 25.00, 124, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231027_075910_962_hdr.jpg', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(308, 'DELT-5J', 'PANTALLA DE REGISTRO DERECHA', NULL, '', 15.00, 109, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231010_075948_466.jpg', 3, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(309, 'DELT-5H', 'PANTALLA DE REGISTRO IZQUIERDA', NULL, '', 15.00, 108, '2024-01-08 00:00:00', 9, 3, 1, 1, NULL, 3, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 19:13:34'),
(310, 'DELT-5A', 'MESA INCISAL', NULL, '', 25.00, 455, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20230913_083850_991_hdr.jpg', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(311, 'DELT-5T', 'Varilla para Sujeción Central', NULL, 'GABETA-G3', 25.00, 122, '2024-01-08 00:00:00', 9, 3, 1, 1, 'varillacentral.jpg', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(315, 'H-0149', 'Boquilla ER40 1/8\"(4-3) Boquilla ER40 1/8\"(4-3)', NULL, 'HM3-8', 580.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115247.jpg', 5, 2, 0, 580.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(316, 'H-0150', 'Broca numerica #19 Cleveland Broca numerica #19 Cleveland', NULL, 'HM2-5', 50.75, 14, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115311.jpg', 5, 5, 1, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(317, 'H-0151', 'Llave allen bola 3/32\" en L Llave allen bola 3/32\" en L', NULL, 'LOCKER FILA 3', 38.00, 10, '2024-01-08 00:00:00', 1, 2, 1, 1, 'IMG20231122115332.jpg', 5, 2, 1, 38.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(318, 'H-0152', 'Broca HSS 1/8\" larga Broca HSS 1/8\" larga', NULL, '', 50.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115411.jpg', 5, 2, 0, 50.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(319, 'I-0044', 'PELICULA ESTIRABLE DE 5\" C80, Playo para empaque rollo chico', NULL, 'ALMACEN GENERAL', 37.00, 37, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG20231114130404.jpg', 5, 2, 1, 37.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(321, 'DELT-4K', 'VARILLA PARA NIVEL (articulador)', NULL, 'GABETA G7', 25.00, 100, '2024-01-08 00:00:00', 9, 3, 1, 1, NULL, 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 19:14:15'),
(322, 'DELT-5R', 'Pin de Marca Central', NULL, 'GABETA-G2', 10.00, 100, '2024-01-08 00:00:00', 9, 3, 1, 1, NULL, 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 19:14:03'),
(323, 'I-0045', 'Cuchillas, Navajas de repuesto de 18mm Cuchillas, Navajas de repuesto de 18mm', NULL, 'LOCKER FILA 3', 3.14, 17, '2024-01-08 00:00:00', 1, 4, 1, 1, '.trashed-1703363215-IMG20231123142433.jpg', 5, 2, 1, 3.1400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(324, 'H-0153', 'Lima Plana Muza de 8\" con mango Lima Plana Muza de 8\" con mango', NULL, 'LOCKER FILA 4', 65.52, 2, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143139.jpg', 5, 2, 1, 65.5200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(325, 'H-0154', 'Juego de 11 Brocas para Metal y concreto Juego de 11 Brocas para Metal y concreto', NULL, '', 176.00, 0, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142325.jpg', 5, 2, 1, 176.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(326, 'I-0046', 'Guantes de nylon recubiertos de poliuretano MEDIANOS Guantes de nylon recubiertos de poliuretano MEDIANOS', NULL, '', 42.00, 10, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142300.jpg', 5, 2, 1, 42.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(327, 'I-0047', 'Guantes de nylon recubiertos de poliuretano GRANDES', NULL, 'LOCKER', 42.24, 15, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG20231123142307.jpg', 5, 2, 1, 42.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(328, 'H-0155', 'Escuadra Para Carpintero de 8\" Escuadra Para Carpintero de 8\"', NULL, 'LOCKER FILA 4', 99.00, 2, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142858.jpg', 5, 2, 1, 99.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(329, 'I-0048', 'Segueta bimetálica de 18DPP largo de 12\" Segueta bimetálica de 18DPP largo de 12\"', NULL, 'LOCKER FILA 4', 20.25, 23, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143300.jpg', 5, 2, 1, 20.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(330, 'I-0049', 'Segueta Bimetálica de 24DPP, 12\" de largo Segueta Bimetálica de 24DPP, 12\" de largo', NULL, 'LOCKER FILA 4', 20.25, 8, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143322.jpg', 5, 2, 1, 20.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(331, 'H-0156', 'Llave combinada de 1/2\" X 170mm. de largo Llave combinada de 1/2\" X 170mm. de largo', NULL, 'LOCKER FILA 3', 25.00, 1, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143227.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(332, 'H-0157', 'Llave combinada 9/16\" X 180mm de largo Llave combinada 9/16\" X 180mm de largo', NULL, 'LOCKER FILA 3', 30.17, 1, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143215.jpg', 5, 2, 1, 30.1700, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(338, 'H-0159', 'Broca de cobalto C/ Alcrona 1/8\" X 70mm Corte 13mm largo total DORMER', NULL, 'HM2-1', 756.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231206152658.jpg', 5, 2, 0, 756.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(339, 'H-0160', 'Broca HSS Alfabética Letra', NULL, 'HM2-2', 65.25, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231206152430.jpg', 5, 5, 1, 65.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(341, 'H-0161', 'Inserto de carburo A4R125I03P00GMN KCU10 KENNAMETAL', NULL, 'HM3-5', 546.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133744.jpg', 5, 10, 1, 546.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(342, 'H-0162', 'PortaHerramientas Derecho A4SMR1616K0314 KENNAMETAL', NULL, '', 3208.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133754.jpg', 5, 2, 1, 3208.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(343, 'H-0163', 'Broca HSS Alfabetica Letra \"D\" Clev', NULL, 'HM2-3', 65.25, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134457.jpg', 5, 2, 1, 65.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(344, 'H-0164', 'BROCA HSS NUMERICA \"#30\" CLEV', NULL, 'HM2-4', 43.50, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133730.jpg', 5, 2, 0, 43.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(345, 'H-0165', 'Broca HSS Alfabetica Letra N', NULL, 'HM2-3', 85.55, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134427.jpg', 5, 5, 1, 85.5500, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(346, 'H-0166', 'Broca HSS Numerica 15', NULL, 'HM2-4', 50.75, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133812.jpg', 5, 5, 1, 50.7500, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(347, 'H-0167', 'RIMA HSS 3/16', NULL, 'HM3-7', 913.50, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134304.jpg', 5, 1, 1, 913.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(350, 'DELT-6F', 'PERNO PARA PANTALLA CENTRAL, PERNO SOLIDO RECTIFICADO DE 1/4 X 1-1/2', NULL, 'A14', 10.00, 372, '2024-01-08 00:00:00', 9, 3, 1, 1, 'PERNO_PARA_PANTALLA_46.jpg', 4, 100, 1, 10.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(352, 'DELT-5W', 'PERNO 2, PARA PANTALLAS, PERNO SOLIDO RECTIFICADO INOXIDABLE DE 5/16 X 1', NULL, 'A10', 8.21, 382, '2024-01-08 00:00:00', 9, 4, 1, 1, 'PERNO_2_PARA_PANTALLA_DERECHA_O_IZQUIERDA_DE_1_pulgada_x_5-16_pulgadas_89.jpg', 4, 100, 1, 8.2100, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(353, 'DELT-4X', 'IMAN DE NEODIMIO CUADRADO DE 15X15X3MM', NULL, 'A3', 14.09, 499, '2024-01-08 00:00:00', 9, 12, 1, 1, 'IMAN_DE_NEODIMIO_DE_15X15X3MM_96.jpg', 4, 2, 1, 14.0900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(354, 'DELT-5D', 'BASE INFERIOR', NULL, '', 116.17, 318, '2024-01-08 00:00:00', 9, 3, 1, 1, 'BASE_INFERIOR_32.png', 3, 2, 1, 116.1700, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(355, 'DELT-6H', 'PANTALLA CENTRAL', NULL, '', 113.18, 228, '2024-01-08 00:00:00', 9, 3, 1, 1, 'PANTALLA_CENTRAL_28.png', 3, 2, 1, 113.1800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(356, 'DELT-5F', 'BASTIDOR MARCO MCD', NULL, 'MESA ABAJO', 325.38, 173, '2024-01-08 00:00:00', 9, 3, 1, 1, 'BASTIDOR_MARCO_CPI_19.png', 3, 2, 1, 325.3800, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(358, 'DELT-5M', 'IMAN DE NEODIMIO REDONDO 3/4 x 0.100', NULL, 'A6', 26.68, 970, '2024-01-14 00:00:00', 9, 25, 1, 1, 'IMG20231122153955.jpg', 4, 2, 1, 26.6800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(359, 'DELT-5Z', 'PERNO 1 PARA PANTALLAS, PERNO SOLIDO RECTIFICADO ACERO INOXIDABLE DE  1/4 X 1', NULL, 'A11', 10.00, 389, '2024-01-15 00:00:00', 9, 4, 1, 1, 'perno1pantalla.png', 4, 100, 1, 10.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(360, 'DELT-7M', 'SOPORTE NASAL', NULL, '', 10.00, 101, '2024-01-16 00:00:00', 9, 3, 1, 1, 'SOPORTE_NASAL_77.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(361, 'DELT-7W', 'CONECTOR 2 HORQUILLA', NULL, '', 10.00, 284, '2024-01-16 00:00:00', 9, 3, 1, 1, 'CONECTOR_2_HORQUILLA_28.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(362, 'DELT-7K', 'CONECTOR 1 HORQUILLA', NULL, '', 10.00, 283, '2024-01-16 00:00:00', 9, 3, 1, 1, 'CONECTOR_1_HORQUILLA_12.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(363, 'DELT-7T', 'OLIVA', NULL, '', 10.00, 140, '2024-01-16 00:00:00', 9, 3, 1, 1, 'OLIVA_39.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(364, 'DELT-7Y', 'TRAVESAÑO PARA PERNO', NULL, '', 20.00, 431, '2024-01-16 00:00:00', 9, 3, 1, 1, 'TRAVESAÑO_PARA_PERNO_39.png', 3, 2, 1, 20.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(366, 'H-0168', 'BOQUILLA ER32 3/16\" (5-4)', NULL, 'HM3-8', 539.00, 0, '2024-01-16 00:00:00', 3, 2, 1, 1, 'BOQUILLA_ER32_17.jpg', 5, 2, 0, 539.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(367, 'H-0169', 'MACHUELO HELICOIDAL M4 x 0.7 ROYCO', NULL, 'HM2-19', 769.50, 5, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M4_x_0.7_ROYCO_28.jpg', 5, 7, 1, 769.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(368, 'H-0170', 'MACHUELO HELICOIDAL M5 x 0.8 ROYCO', NULL, 'HM2-19', 769.50, 6, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M5_x_0.8_ROYCO_21.jpg', 5, 5, 1, 769.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(369, 'H-0171', 'MACHUELO HELICOIDAL M6 x 1 ROYCO', NULL, 'HM2-19', 769.50, 6, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M6_x_1_ROYCO_68.jpg', 5, 5, 1, 769.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(370, 'H-0172', 'MACHUELO GUN 2F  3/16\" - 24 ROYCO 2B 2S/P', NULL, 'HM2-19', 152.25, 4, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_GUN_2F__3_16_-_24_ROYCO_33.jpg', 5, 2, 0, 152.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(371, 'H-0173', 'CORTADOR VERTICAL RECTO 1/2\" 4FL ALTIN', NULL, 'HM2-13', 1222.00, 2, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_VERTICAL_RECTO_1_2_4FL_ALTIN_27.jpg', 5, 2, 0, 1222.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(372, 'H-0174', 'CORTADOR DE CARBURO LARGO 1/8\" x 4\" 4FL BRILLANTE', NULL, 'HM2-11', 504.00, 4, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_LARGO_1_8_x_4_4FL_BRILLANTE_75.jpg', 5, 3, 0, 504.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(373, 'H-0175', 'BROCA DE CENTRO #1 CLEV', NULL, 'HM2-1', 72.50, 6, '2024-01-16 00:00:00', 3, 2, 1, 1, 'BROCA_DE_CENTRO_1_CLEV_0.jpg', 5, 2, 0, 72.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(374, 'H-0176', 'CORTADOR  VERTICAL A.V. 4F 3mm GREENFIELD', NULL, 'HM2-13', 145.00, 1, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_VERTOCAL_A.V._4F_3mm_GREEBFIELD_59.jpg', 5, 1, 1, 145.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(375, 'H-0177', 'MACHUELO HELICOIDAL N10-24 ROYCO', NULL, 'HM2-19', 540.00, 5, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_N10-24_ROYCO_95.jpg', 5, 3, 1, 540.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(376, 'DELT-5K', 'VARILLA DE NIVEL (INOX CPI)', NULL, 'GABETA-G4', 4.63, 117, '2024-01-18 00:00:00', 9, 3, 1, 1, 'VARILLA_DE_NIVEL_18.png', 3, 2, 1, 4.6300, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(377, 'DELT-5Y', 'BASE COLUMNA DE CALIBRACION', NULL, '', 158.50, 104, '2024-01-18 00:00:00', 9, 3, 1, 1, 'BASE_COLUMNA_DE_CALIBRACION_97.png', 3, 2, 1, 158.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(378, 'DELT-5G', 'BASE SUPERIOR CPI', NULL, '', 258.06, 182, '2024-01-23 00:00:00', 9, 3, 1, 1, 'BASE_SUPERIOR_CPI_10.png', 3, 2, 1, 258.0600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(379, 'DELT-4A', 'MARCO PARA ANALOGO', NULL, '', 10.00, 147, '2024-01-24 00:00:00', 9, 3, 1, 1, 'PERNO_DE_POSICION_79.jpg', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(380, 'H-0178', 'SET DE BOQUILLAS ER 32 ORION', NULL, '', 233.50, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'SET_DE_BOQUILLAS_ER_32_ORION_60.jpg', 5, 2, 0, 233.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(381, 'H-0179', 'CONO CAT 40 A ER16, PROYECCIÓN DE 101.6mm, MCA. SANDVIK', NULL, '', 149.90, 3, '2024-01-24 00:00:00', 3, 11, 1, 2, 'CONO_CAT_40_A_ER16,_PROYECCIÓN_DE_101.6mm,_MCA._SANDVIK_77.jpg', 5, 2, 0, 149.9000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(382, 'H-0180', 'LLAVE PARA TUERCA CONO CAT 40 A ER16, MCA. Sandvik', NULL, '', 27.40, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'LLAVE_PARA_TUERCA_CONO_CAT_40_A_ER16,_MCA._Sandvik_4.png', 5, 2, 0, 27.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(383, 'H-0181', 'CONO CAT 40 A ER20, PROYECCIÓN DE 152.4mm, MCA. SANDVIK.', NULL, '', 149.90, 4, '2024-01-24 00:00:00', 3, 11, 1, 2, 'CONO_CAT_40_A_ER20,_PROYECCIÓN_DE_152.4mm,_MCA._SANDVIK._98.jpg', 5, 2, 0, 149.9000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(384, 'H-0182', 'LLAVE PARA TUERCA CONO CAT 40 A ER20, MCA. Sandvik.', NULL, '', 27.40, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'LLAVE_PARA_TUERCA_CONO_CAT_40_A_ER20,_MCA._Sandvik._71.jpg', 5, 2, 0, 27.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(385, 'H-0183', 'TORNILLO DE RETENCIÓN, PULL STUD, ROSCA M16, MCA. Sandvik.', NULL, '', 40.15, 2, '2024-01-24 00:00:00', 3, 11, 1, 2, 'TORNILLO_DE_RETENCIÓN,_PULL_STUD,_ROSCA_M16,_MCA._Sandvik._13.jpg', 5, 2, 0, 40.1500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(386, 'H-0184', 'PORTA PINZAS (BOQUILLA) ER20, RANGO DE 2mm A 13mm, MCA. ORION, TECNOLOGÍA ALEMANA', NULL, '', 150.00, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'PORTA_PINZAS_(BOQUILLA)_ER20,_RANGO_DE_2mm_A_13mm,_MCA._ORION,_TECNOLOGÍA_ALEMANA_10.jpg', 5, 2, 0, 150.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(387, 'H-0185', 'PORTA PINZAS (BOQUILLA) ER16, RANGO DE 0.5mm A 10mm, MCA. ORION, TECNOLOGÍA ALEMANA', NULL, '', 180.00, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'PORTA_PINZAS_(BOQUILLA)_ER16,_RANGO_DE_0.5mm_A_10mm,_MCA._ORION,_TECNOLOGÍA_ALEMANA_2.png', 5, 2, 0, 180.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(388, 'H-0186', 'INSERTO DE CARBURO DGN 2202JT IC 808ISCAR', NULL, 'HM2-16', 32.50, 0, '2024-01-24 00:00:00', 3, 2, 1, 2, 'INSERTO_DE_CARBURO_DGN_2202JT_IC_808ISCAR_85.jpg', 5, 10, 1, 32.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(389, 'H-0187', 'Fresa 4 filos, diámetro 1/8 con longitud de corte 1-1/8 y longitud total 3, con mango cilindrico 1/8, carburo en acabado brillante, DORMER', NULL, 'HM2-10', 20.71, 10, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL, 5, 4, 1, 20.7100, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(390, 'H-0188', 'Fresa 4 filos, diámetro 1/4\" con longitud de corte 1-1/8\" y longitud total 3\", con\r\nmango cilíndrico 1/4\", carburo en, acabado brillante Marca Dormer', NULL, '', 26.10, 6, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL, 5, 2, 0, 26.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(391, 'H-0189', 'Fresa 4 filos, diámetro 3/8\" con longitud de corte 1-1/8\" y longitud total 3\", con\r\nmango cilíndrico 3/8\", carburo en, acabado brillante Marca Dormer', NULL, '', 36.30, 6, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL, 5, 2, 0, 36.3000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(392, 'H-0190', 'CORTADOR DE 1/2 DE DIAMETRO 4 FILOS DECORTE X 1 DE LARGO DE CORTE X 3 DE LARGOTOTAL MCA. DORMER', NULL, 'HM2-10', 43.29, 6, '2024-02-06 14:35:35', 3, 11, 1, 2, NULL, 5, 3, 1, 43.2900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(393, 'H-0191', 'CORTADOR DE 3/4 DE DIAMETRO 4 FILOS DECORTE X 1 1/2 DE LARGO DE CORTE X 4 DELARGO TOTAL MCA. DORMER', NULL, 'HM3-8', 122.62, 4, '2024-02-06 14:40:35', 3, 11, 1, 2, NULL, 5, 2, 1, 122.6200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(396, 'DELT-6A', 'ARANDELA PLANA DIAMETRO 12.7MM, SPECIAL FLAT WASHER .750 X .193 X .040 W-07514', NULL, 'A12', 0.12, 2068, '2024-02-07 10:10:09', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.750_X_.193_X_.040_82.jpg', 4, 2, 1, 0.1200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(397, 'DELT-5E', 'ARANDELA PLANA MESA, SPECIAL FLAT WASHER .500 X .225 X .0810  W-04960', NULL, 'A7', 0.17, 1973, '2024-02-07 10:12:24', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.500_X_.265_X_.031_2.jpg', 4, 2, 1, 0.0600, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(398, 'DELT-7D', 'ARANDELA PLANA 1.6MM, SPECIAL FLAT WASHER .750 X .257 X .062 W-07530', NULL, 'D3', 0.08, 1015, '2024-02-07 10:17:52', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.750_X_.257_X_.062_59.jpg', 4, 2, 1, 0.0800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(399, 'H-0192', 'INSERTO DE CARBURO NG2031RK KC5025 KENNAMETAL', NULL, 'HM2-16', 469.00, 10, '2024-02-07 12:23:14', 3, 2, 1, 1, 'INSERTO_DE_CARBURO_NG2031RK_KC5025_KENNAMETAL_82.jpg', 5, 10, 1, 469.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(400, 'H-0193', 'CORTADOR DE CARBURO, D 3/16 x 1-1/2 C x 4 LT 4 4FL BRILLANTE', NULL, 'HM2-12', 672.00, 1, '2024-02-08 10:35:15', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_3_16_x_1_Y_MEDIO_CORTE_x_4_LT_4_4FL_BRILLANTE_64.jpg', 5, 3, 1, 672.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(401, 'H-0194', 'MACHUELO HELICOIDAL M3 x 0.5', NULL, 'HM2-19', 686.00, 2, '2024-02-08 10:36:55', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M3_x_0.5_55.jpg', 5, 2, 0, 686.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(402, 'H-0195', 'FRESA DE DOBLE CORTE DE CARBURO SL-4', NULL, 'HM2-14', 784.00, 2, '2024-02-08 10:46:59', 3, 2, 1, 1, 'LIMA_ROTATIVA_CONICA_DE_CARBURO_SL-4_99.jpg', 5, 2, 0, 784.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(404, 'H-0197', 'CORTADOR DE CARBURO 3/16\" x 2\" 4FL', NULL, 'HM2-11', 414.45, 1, '2024-02-16 14:10:11', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_3_16_PULGADAS_x_2_PULGADAS_4FL_10.jpg', 5, 2, 0, 414.4500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(405, 'H-0197', 'BROCA LARGA 1/8\" x 5-1/8\"  CLEV', NULL, 'HM2-4', 91.50, 2, '2024-02-16 14:12:31', 3, 2, 1, 1, 'BROCA_LARGA_1_8_x_5_1_8__CLEV_83.jpg', 5, 2, 0, 91.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(406, 'H-0198', 'BROCA EXTRA LARGA 1/8\"  x 8\" CLEV', NULL, 'HM3-1', 301.00, 2, '2024-02-16 14:15:06', 3, 2, 1, 1, 'BROCA_EXTRA_LARGA_1_8__x_8_CLEV_53.jpg', 5, 2, 0, 301.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(407, 'H-0199', 'LLAVE TORX  T9x6\" URREA', NULL, 'LOCKER FILA 3', 183.40, 1, '2024-02-16 14:18:34', 1, 2, 1, 1, 'LLAVE_TORX__T9x6_URREA_56.jpg', 5, 2, 1, 183.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(408, 'H-0200', 'LLAVE TORX T10x6\" URREA', NULL, 'LOCKER FILA 3', 183.40, 0, '2024-02-16 14:19:53', 1, 2, 1, 1, 'LLAVE_TORX_T10x6_URREA_11.jpg', 5, 2, 1, 183.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(409, 'H-0201', 'PORTA PINZAS BOQUILLA ER20 RANGO DE 2mm A 13mm', NULL, '', 180.00, 0, '2024-02-19 10:29:53', 3, 11, 1, 2, 'PORTA_PINZAS_BOQUILLA_ER20_RANGO_DE_2mm_A_13mm_90.jpg', 5, 2, 0, 180.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(410, 'H-0202', 'Broca serie extra larga con zanco cilíndrico, D 1/8 o 0.1252, L 160 mm. MCA, DOMMER', NULL, 'HM3-5', 23.25, 4, '2024-02-22 10:24:02', 3, 11, 1, 2, 'Broca_serie_extra_larga__22.jpg', 5, 4, 1, 23.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(411, 'I-0051', 'CUBETA 19 LT REFRIGERANTE PARA CNC BLASER UNIVERSAL 2000', NULL, '', 362.50, 1, '2024-03-11 15:41:01', 2, 2, 1, 2, 'CUBETA_19_LT_REFRIGERANTE_PARA_CNC_BLASER_UNIVERSAL_2000_44.jpg', 5, 2, 1, 362.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(412, 'I-0052', 'ACEITE 3 EN UNO 90ML', NULL, 'LOCKER FILA 2', 56.00, 5, '2024-03-11 15:43:04', 2, 2, 1, 1, 'ACEITE_3_EN_UNO_90ML_44.jpg', 5, 2, 1, 56.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(413, 'H-0203', 'BROCA RECTA A.V. 43/64\" CLEV', NULL, 'HM3-5', 658.00, 1, '2024-03-11 15:50:54', 3, 2, 1, 1, 'BROCA_RECTA_A_V_43_64_CLEV_31.jpg', 5, 2, 0, 658.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(414, 'H-0204', 'BROCA RECTA A.V. 21/32\" CLEV', NULL, 'HM3-5', 644.00, 1, '2024-03-11 16:01:43', 3, 2, 1, 1, 'BROCA_RECTA_A_V_21_32_CLEV_18.jpg', 5, 2, 0, 644.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(415, 'H-0205', 'MACHUELO HELICOIDAL 5/16-18 GH2 3FX MB S/O', NULL, 'HM3-6', 900.00, 8, '2024-03-14 15:20:07', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_5_16_18_GH2_3FX_MB_S_O_91.jpg', 5, 2, 0, 900.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(416, 'H-0206', 'fresa para redondear esquinas, corner rounding end mill 3/16 x 1/2', NULL, 'HM2-15', 980.00, 1, '2024-03-15 11:45:57', 3, 2, 1, 1, 'fresa_para_redondear_esquinas,_corner_rounding_end_mill_3_16_x_1_2_5.jpg', 5, 2, 0, 980.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(417, 'H-0207', 'BROCA #16', NULL, 'HM2-1', 70.00, 5, '2024-03-19 13:33:23', 3, 2, 1, 1, 'BROCA_16_1.jpg', 5, 10, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(418, 'H-0208', 'SIERRA CINTA LONGITUD DE 2,362mm (93', NULL, 'HM4-1', 44.96, 6, '2024-03-19 13:42:24', 3, 11, 1, 2, 'SIERRA_CINTA_LONGITUD_DE_2,362mm_(93,_FABRICACION_ESPECIAL),_DIENTE_M42,_COMBINADO,_MCA._GARANT,,_TECNOLOGIA_ALEMANA_90.jpg', 5, 4, 1, 44.9600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(419, 'H-0209', 'BROCA DE CENTROS 1.6mm, EXTRA LARGA, ACERO AL COBALTO (HSS+E), MCA. GARANT. TECNOLOGIA ALEMANA', NULL, 'HM2-10', 26.80, 2, '2024-03-19 13:46:50', 3, 11, 1, 2, 'BROCA_DE_CENTROS_1.6mm,_EXTRA_LARGA,_ACERO_AL_COBALTO_(HSS+E),_MCA._GARANT._TECNOLOGIA_ALEMANA_31.jpg', 5, 2, 1, 26.8000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(420, 'H-0210', 'BROCA DE CENTROS 3mm, EXTRA LARGA, ACERO AL COBALTO (HSS+E), MCA. GARANT. TECNOLOGIA ALEMANA.', NULL, 'HM2-10', 20.50, 0, '2024-03-19 13:48:03', 3, 11, 1, 2, 'BROCA_DE_CENTROS_3mm,_EXTRA_LARGA,_ACERO_AL_COBALTO_(HSS+E),_MCA._GARANT._TECNOLOGIA_ALEMANA._41.jpg', 5, 2, 1, 20.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(421, 'DELT-6J', 'TORNILLO PARA PANTALLA CENTRAL, TORNILLO SOCKET CILINDRO M5 x 8mm', NULL, 'A15', 0.74, 365, '2024-03-21 14:49:06', 9, 13, 1, 1, 'TORNILLO_PARA_PANTALLA_CENTRAL_3_16_93.jpg', 1, 2, 1, 0.7400, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(422, 'DELT-8E', 'OPRESOR 1/4\", ANILLO DE RETENCION 1/4\" , SEGURO TRUAC EXTERIOR 1/4\"', NULL, 'B11', 1.88, 1250, '2024-03-21 14:54:37', 9, 13, 1, 1, 'OPRESOR_14_41.jpg', 1, 2, 1, 1.8800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(423, 'DELT-8C', 'ORING PARA TRAVESAÑO, PERNOS, H70005- NBR 70 568-005 CS: 0.070 X ID:0.101 ORING D.I. 0.101, D.E. 7/32 W 1/16', NULL, 'B9', 0.34, 3600, '2024-03-21 15:28:26', 9, 13, 1, 1, 'ORING_PARA_TRAVESAÑO,_PERNOS_5.jpg', 4, 2, 1, 0.3400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(424, 'DELT-8X', 'MOCHILA PARA KIT', NULL, 'RACK', 340.00, 188, '2024-03-22 14:52:12', 9, 4, 1, 1, 'MOCHILA_PARA_ARTICULADOR_93.jpg', 4, 2, 1, 340.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(426, 'H-0211', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 4.76mm (3/16&quot;) longitud total 87mm, longitud de cuchilla de 44mm, Para escariar agujeros tolerancia H7, HSS DOMER', NULL, 'HM3-7', 45.00, 2, '2024-04-01 12:27:17', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_4_76mm_3_16_longitud_total_87mm_longitud_de_cuchilla_de_44mm_Para_escariar_agujeros_tolerancia_H7_HSS_DOMER_11.jpg', 5, 2, 0, 45.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(427, 'H-0212', 'PRENSA ESQUINERA DE ALUMINIO 3\"', NULL, '', 233.80, 2, '2024-04-01 16:25:27', 1, 2, 1, 1, 'PRENSA_ESQUINERA_DE_ALUMINIO_3__60.jpg', 5, 2, 1, 233.8000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(428, 'H-0213', 'LLAVE TORX T9 BANDERA', NULL, 'LOCKER FILA 3', 105.00, 2, '2024-04-01 16:27:28', 1, 2, 1, 1, 'LLAVE_TORX_T9_BANDERA_39.jpg', 5, 2, 1, 105.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(429, 'H-0214', 'LLAVE TORX T10 BANDERA', NULL, 'LOCKER FILA 3', 105.00, 2, '2024-04-01 16:29:27', 1, 2, 1, 1, 'LLAVE_TORX_T10_BANDERA_79.jpg', 5, 2, 1, 105.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(430, 'H-0215', 'CORTADOR VERTICAL 1/4', NULL, 'HM2-10', 520.00, 2, '2024-04-01 16:32:02', 3, 2, 1, 1, 'CORTADOR_VERTICAL_1_4_FILO_3_4_LT_DE_2_1_2__32.jpg', 5, 3, 1, 520.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(431, 'H-0216', 'BROCA RECTA NUMERICA #9 CLEV', NULL, 'HM2-9', 56.00, 6, '2024-04-01 16:33:14', 3, 2, 1, 1, 'BROCA_RECTA_NUMERICA_9_CLEV_100.jpg', 5, 10, 1, 56.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(432, 'H-0217', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 6.35mm (1/4&quot;) longitud total de 100mm, longitud de cuchilla de 50mm, Para escariar agujeros tolerancia H7, HSS con acabado vaporizado-brillante para mecanizado de acero, fundición gris, aluminio forjado, aluminio fundido, cobre o aleaciones de cobre, MCA. DORMER.', NULL, 'HM3-7', 48.00, 2, '2024-04-02 16:02:04', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_6_35mm_1_4_longitud_total_de_100mm_longitud_de_cuchilla_de_50mm_DORMER_98.jpg', 5, 2, 0, 48.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(433, 'H-0218', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 7.94mm (5/16&quot;) longitud total de 115mm, longitud de cuchilla de 58mm, DORMER', NULL, 'HM3-7', 52.00, 2, '2024-04-02 16:03:50', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_7_94mm_5_16_longitud_total_de_115mm_longitud_de_cuchilla_de_58mm_DORMER_6.jpg', 5, 2, 0, 52.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(434, 'H-0219', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 9.52mm (3/8\") longitud total de 124mm, longitud de cuchilla de 62mm, DORMER', NULL, '', 55.00, 1, '2024-04-02 16:05:04', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_9_52mm_3_8_longitud_total_de_124mm_longitud_de_cuchilla_de_62mm_DORMER_7.jpg', 5, 2, 0, 55.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(435, 'H-0220', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 9.52mm\r\n(3/8\") longitud total de 124mm, longitud de cuchilla de 62mm, Para escariar\r\nagujeros tolerancia H7, HSS MCA. DORMER.', NULL, '', 55.00, 1, '2024-04-09 09:25:34', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_9_52mm_3_8_longitud_total_de_124mm_longitud_de_cuchilla_de_62mm_Para_escariar_agujeros_tolerancia_H7_HSS_MCA_DORMER__5.jpg', 5, 2, 0, 55.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(436, 'I-0054', 'Retazo de trapo blanco', NULL, '', 95.00, 40, '2024-04-09 09:48:44', 2, 16, 2, 1, 'Retazo_de_trapo_blanco_94.jpg', 5, 2, 1, 95.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(437, 'I-0055', 'Gasolina blanca', NULL, '', 90.00, 20, '2024-04-09 09:49:57', 2, 16, 7, 1, 'Gasolina_blanca_38.jpg', 5, 2, 1, 90.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(438, 'I-0056', 'Alcohol Isopropilico', NULL, '', 90.00, 40, '2024-04-09 09:51:15', 2, 13, 7, 1, 'Alcohol_Isopropilico_70.jpg', 5, 2, 1, 90.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(439, 'I-0057', 'Thinner estandar', NULL, '', 70.00, 20, '2024-04-09 09:52:29', 2, 16, 7, 1, 'Thinner_estandar_41.jpg', 5, 2, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(440, 'H-0221', 'CoroTurn® 107, herramienta con mango para torneado, zanco 3/4\" x 3/4\", a\r\nderecha, MCA. Sandvik', NULL, '', 186.50, 1, '2024-04-09 14:29:29', 3, 11, 1, 2, 'CoroTurn_107_herramienta_con_mango_para_torneado_zanco_3_4_x_3_4_a_derecha_MCA_Sandvik_55.jpg', 5, 2, 0, 186.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(441, 'H-0222', 'Plaquita CoroTurn® 107 para torneado, acabado radio de punta 0.2mm, 2 filos,material Aluminio, Marca Sandvik', NULL, 'HM2-15', 15.60, 10, '2024-04-09 14:33:37', 3, 11, 1, 2, 'Plaquita_CoroTurn_107_para_torneado_acabado_radio_de_punta_0_2mm_2_filos_material_Aluminio_Marca_Sandvik_35.jpg', 5, 10, 1, 15.6000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(442, 'H-0223', 'Plaquita CoroTurn® 107 para torneado, acabado radio de punta 0.4mm, 2 filos,\r\nmaterial Inoxidable, Marca Sandvik', NULL, '', 19.98, 10, '2024-04-09 14:34:25', 3, 11, 1, 2, 'Plaquita_CoroTurn_107_para_torneado_acabado_radio_de_punta_0_4mm_2_filos_material_Inoxidable_Marca_Sandvik_12.jpg', 5, 2, 1, 19.9800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(443, 'H-0224', 'CORTADOR RECTO DE CARBURO 1/8', NULL, 'HM2-13', 280.00, 3, '2024-04-11 13:42:16', 3, 2, 1, 1, 'CORTADOR_RECTO_DE_CARBURO_1_8_4_FL_ESTANDAR_37.jpg', 5, 1, 1, 280.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(444, 'H-0225', 'Boquilla ER32 1/8', NULL, 'HM3-8', 539.00, 2, '2024-04-11 13:52:48', 3, 2, 1, 1, 'Boquilla_ER32_1_8__17.jpg', 5, 1, 0, 539.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(445, 'H-0226', 'Boquilla ER40 1/8', NULL, 'HM3-8', 580.00, 1, '2024-04-11 14:02:19', 3, 2, 1, 1, 'Boquilla_ER40_1_8__6.jpg', 5, 1, 0, 580.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(446, 'IC-0001', 'GU-352 Guante p/pintar talla mediano', NULL, 'LOCKER FILA 4', 42.24, 1, '2024-04-11 16:09:50', 2, 17, 8, 1, 'GU_352_Guante_p_pintar_talla_mediano_9.jpg', 5, 2, 1, 42.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(447, 'IC-0002', 'GU-352 Guante p/pintar talla Grande', NULL, 'LOCKER FILA 4', 42.24, 5, '2024-04-11 16:11:41', 2, 17, 8, 1, 'GU_352_Guante_p_pintar_talla_mediano_42.jpg', 5, 2, 1, 42.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(448, 'IC-0003', 'GU-121P Guante de nylon recubierto de nitrilo medianos', NULL, 'LOCKER FILA 4', 28.45, 6, '2024-04-11 16:14:24', 2, 17, 8, 1, 'GU_121P_Guante_de_nylon_recubierto_de_nitrilo_medianos_57.jpg', 5, 2, 1, 28.4500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(449, 'I-0004', 'GU-122P Guante de nylon recubierto de nitrilo chicos', NULL, 'LOCKER FILA 4', 28.45, 1, '2024-04-11 16:15:38', 2, 17, 8, 1, 'GU_122P_Guante_de_nylon_recubierto_de_nitrilo_chicos_68.jpg', 5, 2, 1, 28.4500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(450, 'I-0005', 'GU-113P Guante de nylon recubierto de poliuretano medianos', NULL, 'LOCKER FILA 4', 25.00, 11, '2024-04-11 16:18:34', 2, 17, 8, 1, 'GU_113P_Guante_de_nylon_recubierto_de_poliuretano_medianos_57.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(451, 'I-0006', 'GU-112P Guante de nylon recubierto de poliuretano grandes', NULL, 'LOCKER FILA 4', 25.00, 5, '2024-04-11 16:22:39', 2, 17, 8, 1, 'GU_112P_Guante_de_nylon_recubierto_de_poliuretano_grandes_86.jpg', 5, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(452, 'IC-0007', 'M-33X Cinta de aislar 19 mm x 18 m', NULL, 'LOCKER FILA 1', 18.97, 4, '2024-04-12 14:52:57', 2, 17, 1, 1, 'M_33X_Cinta_de_aislar_19_mm_x_18_m_6.jpg', 5, 2, 1, 18.9700, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(453, 'H-0227', 'DR-1/4X6TP Desarmador Plano mango transparente 1/4\" X 6\"', NULL, 'LOCKER FILA 3', 29.31, 1, '2024-04-12 15:00:03', 1, 17, 1, 1, 'DR_1_4X6TP_Desarmador_Plano_mango_transparente_1_4_X_6__12.jpg', 5, 2, 1, 29.3100, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(454, 'H-0228', 'DR-5/16X6TP Desarmador plano mango transparente 5/16\" x 6\" ', NULL, 'LOCKER FILA 3', 42.24, 1, '2024-04-12 15:02:16', 1, 17, 1, 1, 'DR_5_16X6TP_Desarmador_plano_mango_transparente_5_16_x_6__39.jpg', 5, 2, 1, 42.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(455, 'H-0229', 'DP-1/8X6 Desarmador phillips de 1/8\" x 6\"', NULL, 'LOCKER FILA 3', 33.62, 1, '2024-04-12 15:03:40', 1, 17, 1, 1, 'DP_1_8X6_Desarmador_phillips_de_1_8_x_6__0.jpg', 5, 2, 1, 33.6200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(456, 'H-0230', 'DP-3/16X6 Desarmador phillips de 3/16\" x 6\"', NULL, 'LOCKER FILA 3', 42.24, 1, '2024-04-12 15:05:06', 1, 17, 1, 1, 'DP_3_16X6_Desarmador_phillips_de_3_16_x_6__54.jpg', 5, 2, 1, 42.2400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(457, 'H-0231', 'DP-1/4X6 Desarmador phillips de 1/4&quot; X 6&quot;', NULL, 'LOCKER FILA 3', 50.86, 1, '2024-04-12 15:06:48', 1, 17, 1, 1, 'DP_1_4X6_Desarmador_phillips_de_1_4_X_6__63.jpg', 5, 2, 1, 50.8600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(458, 'H-0232', 'E-8X12 Escuadra cantero profesional 8\" x 12\" ', NULL, '', 59.49, 1, '2024-04-12 15:08:45', 1, 17, 1, 1, 'E_8X12_Escuadra_cantero_profesional_8_x_12__3.jpg', 5, 2, 1, 59.4900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(459, 'IC-0008', 'CTR-150 Cinta transparente de 48 mm x 15M', NULL, '', 50.86, 8, '2024-04-15 10:15:12', 2, 17, 1, 1, 'CTR_150_Cinta_transparente_de_48_mm_x_15M_17.jpg', 5, 2, 1, 50.8600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(460, 'IC-0009', 'CIN-1810N Cinchos negros de plástico de 100mm x 2.5mm paquete de 100 cinchos', NULL, '', 14.65, 4, '2024-04-15 10:21:33', 2, 17, 1, 1, 'CIN_1810N_Cinchos_negros_de_pl_stico_de_100mm_x_2_5mm_paquete_de_100_cinchos_97.jpg', 5, 2, 1, 14.6500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(461, 'IC-0010', 'LIME-120 Lija de esmeril grano 120', NULL, '', 11.21, 10, '2024-04-15 10:25:29', 2, 17, 1, 1, 'LIME_120_Lija_de_esmeril_grano_120_12.jpg', 5, 2, 1, 11.2100, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(462, 'IC-0011', 'LIME-80 Lija de esmeril grano 80', NULL, '', 12.50, 4, '2024-04-15 10:28:02', 2, 17, 1, 1, 'LIME_80_Lija_de_esmeril_grano_80_46.jpg', 5, 2, 1, 12.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(463, 'IC-0012', 'LIMER-120 Lija de esmeril grano 120 roja', NULL, '', 13.36, 33, '2024-04-15 10:30:05', 2, 17, 1, 1, 'LIMER_120_Lija_de_esmeril_grano_120_roja_1.jpg', 5, 2, 1, 13.3600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(464, 'IC-0013', 'LIMER-100 Lija de esmeril grano 100', NULL, '', 13.36, 5, '2024-04-15 10:33:48', 2, 17, 1, 1, 'LIMER_100_Lija_de_esmeril_grano_100_36.jpg', 5, 2, 1, 13.3600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(465, 'IC-0014', 'LIAG-600 Lija de agua grano 600', NULL, '', 7.33, 7, '2024-04-15 10:35:17', 2, 17, 1, 1, 'LIAG_600_Lija_de_agua_grano_600_4.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(466, 'IC-0015', 'LIAG-240 Lija de agua grano 240', NULL, '', 7.33, 8, '2024-04-15 10:37:38', 2, 17, 1, 1, 'LIAG_240_Lija_de_agua_grano_240_36.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(467, 'IC-0016', 'LIAG-180 Lija de agua grano 180', NULL, '', 7.33, 8, '2024-04-15 10:39:19', 2, 17, 1, 1, 'LIAG_180_Lija_de_agua_grano_180_29.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(468, 'IC-0017', 'LIJA DE AGUA 120', NULL, '', 7.33, 7, '2024-04-15 10:42:04', 2, 17, 1, 1, 'LIJA_DE_AGUA_120_80.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(469, 'IC-0018', 'LIJA DE AGUA 800', NULL, '', 7.33, 5, '2024-04-15 10:43:00', 2, 17, 1, 1, 'LIJA_DE_AGUA_800_51.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(470, 'IC-0019', 'LIJA DE AGUA 1200', NULL, '', 7.33, 10, '2024-04-15 10:45:14', 2, 17, 1, 1, 'LIJA_DE_AGUA_1200_73.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(471, 'IC-0020', 'LIJA DE AGUA 1500', NULL, '', 7.33, 9, '2024-04-15 10:46:47', 2, 17, 1, 1, 'LIJA_DE_AGUA_1500_26.jpg', 5, 2, 1, 7.3300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(472, 'DELT-6N', 'PERNO PARA CLIP, PERNO SOLIDO RECTIFICADO ACERO ALEADO 3/8\" X 1-1/4\"', NULL, 'B1', 12.17, 330, '2024-04-15 15:45:02', 9, 13, 1, 1, 'PERNO_PARA_CLIP_PERNO_SOLIDO_RECTIFICADO_3_8_X_1_1_4__55.jpg', 1, 2, 1, 12.1700, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(473, 'DELT-4M', 'PERNO CENTRADOR PARA CLIP, PERNO SOLIDO RECTIFICADO INOXIDABLE 1/8', NULL, 'A1', 2.82, 400, '2024-04-15 16:21:38', 9, 13, 1, 1, 'PERNO_CENTRADOR_PARA_CLIP_PERNO_SOLIDO_RECTIFICADO_1_8_X_1__72.jpg', 4, 100, 1, 2.8200, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(474, 'DELT-7Ñ', 'TORNILLO PARA CONECTOR, TORNILLO ALLEN SOCKET CILINDRO INOXIDABLE A2 M4x20MM', NULL, 'B5', 0.94, 809, '2024-04-15 16:25:37', 9, 13, 1, 1, 'TORNILLO_PARA_CONECTOR_TORNILLO_ALLEN_SOCKET_CILINDRO_INOXIDABLE_A2_M4x20M_90.jpg', 1, 2, 1, 0.9400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(475, 'DELT-5S', 'INSERTO, OPRESOR ALLEN INOXIDABLE A2 MILIMETRICO M5 X 6MM', NULL, 'A9', 0.53, 2750, '2024-04-15 16:36:20', 9, 13, 1, 1, 'INSERTO_OPRESOR_ALLEN_INOXIDABLE_A2_MILIMETRICO_M5_X_6M_8.jpg', 1, 2, 1, 0.5300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(476, 'DELT-6B', 'TORNILLO 1 (M3), TORNILLO ALLEN SOCKET CILINDRO INOXIDABLE A2 M3 x 6MM', NULL, 'A13', 0.48, 2100, '2024-04-16 09:20:16', 9, 13, 1, 1, 'TORNILLO_1_M3_TORNILLO_ALLEN_SOCKET_CILINDRO_INOXIDABLE_A2_M3_x_6MM_41.jpg', 1, 2, 1, 0.4800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(478, 'DELT-8Y', 'LLAVE HEXAGONAL ALLEN TIPO \"L\" METRICA M2.5 (2.5MM)', NULL, 'B12', 2.54, 310, '2024-04-16 09:41:37', 9, 13, 1, 1, 'LLAVE_EXAGONAL_ALLEN_TIPO_L_METRICA__43.jpg', 1, 2, 1, 2.5400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(479, 'IC-0021', 'ADHESIVO EPOXICO EN JERINGA 25 ML (0.84 OZ) TRANSPARENTE 5 MINUTOS', NULL, '', 115.56, 2, '2024-04-16 09:47:27', 2, 13, 1, 1, 'ADHESIVO_EPOXICO_EN_JERINGA_25_ML_0_84_OZ_TRANSPARENTE_5_MINUTOS_43.jpg', 5, 2, 1, 115.5600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(480, 'H-0233', 'MANERAL PARA MACHUELO AJUSTABLE 1/16\" A 3/8\"', NULL, 'LOCKER FILA 3', 62.02, 1, '2024-04-16 09:51:08', 1, 13, 1, 1, 'MANERAL_PARA_MACHUELO_AJUSTABLE_1_16_A_3_8__20.jpg', 5, 2, 1, 62.0200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(481, 'H-0234', 'MANERAL PARA MACHUELO AJUSTABLE CAPACIDAD DE 1/4\"', NULL, 'LOCKER FILA 3', 81.40, 2, '2024-04-16 09:52:07', 1, 13, 1, 1, 'MANERAL_PARA_MACHUELO_AJUSTABLE_3_32_A_3_8__31.jpg', 5, 2, 1, 81.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(482, 'H-0235', 'CALIBRADOR VERNIER DIGITAL 152MM/0-6\" DE ACERO INOXIDABLE', NULL, '', 640.22, 1, '2024-04-16 09:53:29', 1, 13, 1, 1, 'CALIBRADOR_VERNIER_DIGITAL_152MM_0_6_DE_ACERO_INOXIDABLE_50.png', 5, 2, 1, 640.2200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(483, 'DELT-4T', 'SOPORTE ANALOGO', NULL, 'S/U', 498.00, 228, '2024-04-16 11:12:49', 9, 19, 1, 1, 'SOPORTE_ANALOGO__29.png', 4, 2, 1, 498.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(484, 'DELT-8D', 'APUNTADOR ORBITAL', NULL, 'B10', 95.00, 139, '2024-04-16 11:15:50', 9, 19, 1, 1, 'APUNTADOR_ORBITAL_72.png', 4, 2, 1, 95.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(485, 'DELT-7E', 'HORQUILLA DOBLADA', NULL, 'B4', 90.00, 80, '2024-04-16 11:17:47', 9, 19, 1, 1, 'HORQUILLA_DOBLADA_13.png', 4, 2, 1, 90.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(486, 'DELT-7R', 'HORQUILLA PLANA', NULL, 'B8', 70.00, 90, '2024-04-16 11:22:59', 9, 19, 1, 1, 'HORQUILLA_PLANA_64.png', 4, 2, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(487, 'DELT-7B', 'TIJERA DERECHA', NULL, '', 215.00, 139, '2024-04-16 11:36:02', 9, 19, 1, 1, 'TIJERA_DERECHA_74.png', 4, 2, 1, 215.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(488, 'DELT-7C', 'TIJERA IZQUIERDA', NULL, '', 215.00, 139, '2024-04-16 11:38:27', 9, 19, 1, 1, 'TIJERA_IZQUIERDA_61.png', 4, 2, 1, 215.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(489, 'DELT-4Q', 'SEGURO  DE CENTRICA', NULL, 'A2', 20.00, 167, '2024-04-16 11:39:52', 9, 19, 1, 1, 'SEGURO_CON_DOBLES_Y_ACABADO__10.png', 4, 2, 1, 20.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(490, 'DELT-4Z', 'LIGAS DE ENLACE (LIGA DE NITRILO 3/32 MEDIDA ESPECIAL)', NULL, 'C2', 11.80, 1763, '2024-04-16 11:55:35', 9, 23, 1, 1, 'LIGA_LIGA_DE_NITRILO_3_32_MEDIDA_ESPECIAL__1.jpg', 4, 2, 1, 11.8000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(492, 'DELT-4B', 'BASE SUPERIOR PARA ARTICULADOR', NULL, 'MESA ABAJO', 20.00, 195, '2024-04-17 14:51:51', 9, 3, 1, 1, 'BASE_SUPERIOR_PARA_ANALOGO_0.png', 3, 2, 1, 20.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(493, 'DELT-4C', 'NIVEL DE ALTURA', NULL, '', 15.00, 167, '2024-04-17 14:56:38', 9, 3, 1, 1, 'NIVEL_DE_ALTURA_78.png', 3, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(494, 'DELT-4D', 'PERNO 1 PARA SOPORTE', NULL, '', 10.00, 172, '2024-04-17 14:59:38', 9, 3, 1, 1, 'PERNO_1_PARA_SOPORTE_56.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(495, 'DELT-4E', 'ANALOGO DERECHO', NULL, 'S/U', 5.00, 0, '2024-04-17 15:02:56', 9, 3, 1, 1, 'ANALOGO_DERECHO_34.png', 4, 2, 1, 5.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(496, 'DELT-4F', 'PERNO 2 PARA SOPORTE', NULL, '', 10.00, 172, '2024-04-17 15:06:16', 9, 3, 1, 1, 'PERNO_2_PARA_SOPORTE_95.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(497, 'DELT-4G', 'CONDILO PARA ANALOGO', NULL, '', 6.00, 241, '2024-04-17 15:08:25', 9, 3, 1, 1, 'CONDILO_PARA_ANALOGO_25.png', 3, 2, 1, 6.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(498, 'DELT-4H', 'ANALOGO IZQUIERDO', NULL, 'S/U', 5.00, 0, '2024-04-17 15:15:17', 9, 3, 1, 1, 'ANALOGO_IZQUIERDO_97.png', 4, 2, 1, 5.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(499, 'DELT-4N', 'CLIP', NULL, 'C1', 7.50, 328, '2024-04-17 15:23:46', 9, 26, 1, 1, 'CLIP_100.png', 4, 2, 1, 7.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(500, 'DELT-4P', 'POSICIONADOR DENTAL', NULL, '', 10.00, 61, '2024-04-17 15:37:34', 9, 3, 1, 1, 'POSICIONADOR_DENTAL_22.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(501, 'DELT-4R', 'ETIQUETA LADO IZQUIERDO', NULL, 'S/U', 2.28, 1075, '2024-04-17 15:42:06', 9, 4, 1, 1, 'ETIQUETA_LADO_IZQUIERDO_100.png', 4, 2, 1, 2.2800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(502, 'DELT-4S', 'ETIQUETA LADO DERECHO', NULL, 'S/U', 2.28, 1075, '2024-04-17 15:47:21', 9, 4, 1, 1, 'ETIQUETA_LADO_DERECHO_72.png', 4, 2, 1, 2.2800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(503, 'DELT-4Y', 'RESORTE', NULL, 'A4', 10.00, 546, '2024-04-17 15:54:58', 9, 4, 1, 1, '', 4, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(504, 'DELT-5N', 'PORTA IMAN', NULL, 'GABETA-G1', 5.00, 522, '2024-04-17 16:22:57', 9, 3, 1, 1, 'PORTA_IMAN_7.png', 3, 2, 1, 5.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(505, 'DELT-5P', 'PIN DE MARCA PARA CONDILO', NULL, 'A8', 1.00, 327, '2024-04-17 16:26:50', 9, 3, 1, 1, 'PIN_DE_MARCA_PARA_CONDILO_61.png', 3, 2, 1, 1.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(506, 'DELT-6C', 'TORNILLO PARA NIVEL DE ALTURA', NULL, 'GABETA G8', 10.00, 115, '2024-04-17 16:37:24', 9, 3, 1, 1, 'TORNILLO_PARA_NIVEL_DE_ALTURA_28.png', 2, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(507, 'DELT-6K', 'TORNILLO PARA BASE INFERIOR (TORNILLO SOCKET PLANA INOXIDABLE ESTANDAR - 10-24 X 3/8\")', NULL, 'A16', 1.10, 1195, '2024-04-17 16:49:45', 9, 13, 1, 1, 'TORNILLO_PARA_BASE_INFERIOR_TORNILLO_SOCKET_PLANA_INOXIDABLE_ESTANDAR_10_24_X_3_8__37.png', 1, 2, 1, 1.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(508, 'H-0236', 'Fresa de punta esférica (cortador), 2 canales, diámetro corte 1/16, longitud decorte 1/4, Longitud total 1-1/2, radio completo 1/32, zanco cilíndrico1/8, metal duro en acabado brillante,', NULL, 'HM2-13', 19.50, 5, '2024-04-19 12:23:19', 3, 11, 1, 2, 'Fresa_de_punta_esf_rica_2_canales_di_metro_corte_1_16_longitud_decorte_1_4_Longitud_total_1_1_2_radio_completo_1_32_zanco_cil_ndrico1_8_metal_duro_en_acabado_brillante__47.jpg', 5, 1, 1, 19.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(509, 'H-0237', 'BROCA DE CENTROS N1, 9437925KL25SW7', NULL, 'HM2-1', 6.42, 5, '2024-04-19 13:01:23', 3, 11, 1, 2, 'BROCA_DE_CENTROS_N1_9437925KL25SW7_85.jpg', 5, 0, 1, 6.4200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(510, 'H-0238', 'MACHUELO HELICOIDAL 1/8-40, 3KL792579SRHG4', NULL, 'HM2-19', 50.82, 5, '2024-04-19 13:37:19', 3, 11, 1, 2, 'MACHUELO_HELICOIDAL_1_8_40_3KL792579SRHG4__55.jpg', 5, 1, 1, 50.8200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(511, 'H-0239', 'BROCA HSS NUMERICA 37, ASRHG434343KLB', NULL, 'HM2-4', 2.19, 18, '2024-04-19 13:54:33', 3, 11, 1, 2, 'BROCA_HSS_NUMERICA_37_ASRHG434343KLB__5.jpg', 5, 10, 1, 2.1900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(512, 'H-0240', 'BROCA HSS NUMERICA 38, R79792579SRMMS', NULL, 'HM2-5', 2.19, 18, '2024-04-19 13:57:26', 3, 11, 1, 2, 'BROCA_HSS_NUMERICA_38_R79792579SRMMS__59.jpg', 5, 10, 1, 2.1900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(513, 'H-0241', 'Extensión reforzada aterrizada 8 m 3x14 AWG, Volteck', NULL, '', 219.82, 1, '2024-04-19 14:19:24', 5, 17, 1, 1, 'Extensi_n_reforzada_aterrizada_8_m_3x14_AWG_Volteck_48.jpg', 5, 2, 1, 219.8200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(514, 'H-0242', 'Extensión reforzada aterrizada 4 m 3x14 AWG, Volteck', NULL, '', 107.75, 1, '2024-04-19 15:06:11', 5, 17, 1, 1, 'Extensi_n_reforzada_aterrizada_4_m_3x14_AWG_Volteck_98.jpg', 5, 2, 1, 107.7500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(515, 'H-0243', 'Pinza de presión 9\", punta larga, Truper', NULL, 'LOCKER FILA 3', 139.65, 1, '2024-04-19 15:20:55', 1, 17, 1, 1, 'Pinza_de_presi_n_9_punta_larga_Truper_30.jpg', 5, 2, 1, 139.6500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(516, 'H-0244', 'Lima redonda muza 8\", Truper', NULL, 'LOCKER FILA 4', 38.79, 2, '2024-04-19 15:26:14', 1, 17, 1, 1, 'Lima_redonda_muza_8_Truper_49.jpg', 5, 2, 1, 38.7900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(517, 'H-0245', 'Lima redonda muza 10\", Truper', NULL, 'LOCKER FILA 4', 53.44, 1, '2024-04-19 15:27:37', 1, 17, 1, 1, 'Lima_redonda_muza_10_Truper_12.jpg', 5, 2, 1, 53.4400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(518, 'H-0246', 'Lima media caña muzas 8\", Truper', NULL, '', 62.06, 1, '2024-04-19 15:29:15', 1, 17, 1, 1, 'Lima_media_ca_a_muzas_8_Truper_39.jpg', 5, 2, 1, 62.0600, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(519, 'H-0247', 'Lima media caña muzas 10\", Truper', NULL, 'LOCKER FILA 4', 111.20, 1, '2024-04-19 15:38:48', 1, 17, 1, 1, 'Lima_media_ca_a_muzas_10_Truper_42.jpg', 5, 2, 1, 111.2000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48');
INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `product_description`, `location`, `price`, `stock`, `registration_date`, `category_id`, `supplier_id`, `unit_id`, `currency_id`, `image_url`, `subcategory_id`, `desired_stock`, `status`, `sale_price`, `weight`, `height`, `length`, `width`, `diameter`, `updated_at`) VALUES
(520, 'H-0248', 'Cinta de empaque 48 mm x 150 m transparente, Pretul', NULL, '', 37.93, 10, '2024-04-19 15:40:03', 2, 17, 1, 1, 'Cinta_de_empaque_48_mm_x_150_m_transparente_Pretul_33.jpg', 5, 2, 1, 37.9300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(521, 'H-0249', 'Pinza punta recta 7\" para abrir anillos, mango de PVC', NULL, 'LOCKER FILA 3', 171.55, 1, '2024-04-19 15:42:48', 1, 17, 1, 1, 'Pinza_punta_recta_7_para_abrir_anillos_mango_de_PVC_87.jpg', 5, 2, 1, 171.5500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(522, 'H-0250', 'Lija de agua grano 240 de carburo de silicio, Truper', NULL, '', 7.32, 6, '2024-04-19 15:43:52', 2, 17, 1, 1, 'Lija_de_agua_grano_240_de_carburo_de_silicio_Truper_10.jpg', 5, 2, 1, 7.3200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(524, 'H-0252', 'Lija de agua grano 280 de carburo de silicio, Truper', NULL, '', 7.32, 39, '2024-04-19 15:47:20', 2, 17, 1, 1, 'Lija_de_agua_grano_280_de_carburo_de_silicio_Truper_57.jpg', 5, 2, 1, 7.3200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(525, 'DELT-6Ñ', 'CAMISA 1 (1/4\"), D.I. .250\", D.E. .350\" L. .500\"  MP-VC-250-8', NULL, 'D1', 0.07, 1980, '2024-04-22 10:17:42', 9, 10, 1, 2, 'CAMISA_1_1_4_D_I_250_D_E_350_L_500_MP_VC_250_8_58.png', 4, 2, 1, 0.0700, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(526, 'DELT-6P', 'CAMISA 2, D.I. 0.437\", D.E. 0.560\", L. 1\", MP-VC-437-16', NULL, 'D2', 0.14, 2480, '2024-04-22 10:21:30', 9, 10, 1, 2, 'CAMISA_2_D_I_0_437_D_E_0_560_L_1_MP_VC_437_16_42.png', 4, 2, 1, 0.1400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(527, 'DELT-6Q', 'ORING PARA VARILLA DE NIVEL  H70006- NBR 70 568-006 CS: 0.070 X ID:0.114 ORING D.I. 0.114, D.E. 1/4, W 1/16', NULL, 'B2', 0.34, 2400, '2024-04-22 10:27:31', 9, 4, 1, 1, 'ORING_PARA_CONDILO_D_I_0_74mm_D_E_2_78mm_84.png', 4, 2, 1, 0.3400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(528, 'DELT-6R', 'SOPORTE HORIZONTAL PARA HORQUILLA (PALETA)', NULL, 'MESA', 15.00, 134, '2024-04-22 10:35:21', 9, 3, 1, 1, 'SOPORTE_HORIZONTAL_PARA_HORQUILLA_57.png', 3, 2, 1, 15.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(529, 'DELT-6S', 'VARILLA VERTICAL PARA NIÑOS', NULL, '', 15.00, 0, '2024-04-22 10:38:21', 9, 3, 1, 1, 'VARILLA_VERTICAL_PARA_NI_OS_53.png', 3, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(530, 'DELT-6T', 'TORNILLO PARA VARILLA DE SOPORTE Y PARA SOPORTE DE POSICIONADOR M5', NULL, 'GABETA-G7', 15.00, 209, '2024-04-22 10:40:27', 9, 3, 1, 1, 'TORNILLO_PARA_VARILLA_DE_SOPORTE_20.png', 2, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(531, 'DELT-6X', 'PERNO PARA CENTRADOR ANALOGO, PERNO RANURADO, 1/16\" x 7/16\"', NULL, 'B3', 0.34, 739, '2024-04-22 10:50:48', 9, 13, 1, 1, 'PERNO_PARA_CENTRADOR_ANALOGO_0.png', 1, 2, 1, 0.3400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(532, 'DELT-6Y', 'BASE DE CALIBRACION SUPERIOR ANALOGO', NULL, '', 75.00, 129, '2024-04-22 10:59:55', 9, 3, 1, 1, 'BASE_DE_CALIBRACION_SUPERIOR_ANALOGO_63.png', 3, 2, 1, 75.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(533, 'DELT-6Z', 'BASE DE CALIBRACION INFERIOR ANALOGO', NULL, '', 75.00, 123, '2024-04-22 11:02:27', 9, 3, 1, 1, 'BASE_DE_CALIBRACION_INFERIOR_ANALOGO_87.png', 3, 2, 1, 75.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(534, 'DELT-7A', 'TRAVESAÑO PARA ARCO', NULL, '', 25.00, 158, '2024-04-22 11:04:26', 9, 3, 1, 1, 'TRAVESA_O_PARA_ARCO_7.png', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(535, 'DELT-7F', 'TORNILLO PARA TRAVESAÑO', NULL, 'GABETA-G6', 10.00, 240, '2024-04-22 11:07:35', 9, 3, 1, 1, 'TORNILLO_PARA_TRAVESA_O_26.png', 2, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(536, 'DELT-7G', 'VARILLA VERTICAL PARA HORQUILLA', NULL, 'GABETA-G6', 25.00, 206, '2024-04-22 11:12:15', 9, 3, 1, 1, 'VARILLA_VERTICAL_PARA_HORQUILLA_63.png', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(537, 'DELT-7H', 'TORNILLO PARA APUNTADOR ORBITAL', NULL, 'GABETA G8', 10.00, 132, '2024-04-22 11:15:29', 9, 3, 1, 1, 'TORNILLO_PARA_APUNTADOR_ORBITAL_12.png', 2, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(538, 'DELT-7J', 'MESA DE TRANSFERENCIA', NULL, '', 15.00, 150, '2024-04-22 11:17:49', 9, 3, 1, 1, 'MESA_DE_TRANSFERENCIA_61.png', 3, 2, 1, 15.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(539, 'DELT-7N', 'VARILLA PARA POSICIONADOR NASAL', NULL, 'GABETA-G7', 25.00, 102, '2024-04-22 11:21:00', 9, 3, 1, 1, 'VARILLA_PARA_POSICIONADOR_NASAL_49.jpg', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(540, 'DELT-7P', 'NIVEL DE GOTA', NULL, 'B6', 10.60, 608, '2024-04-22 11:23:59', 9, 4, 1, 1, 'NIVEL_DE_GOTA_70.png', 4, 2, 1, 10.6000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(541, 'DELT-7Q', 'RONDANA GROWER, RONDANA ESTRELLA EXTERIOR GALVANIZADA - #10', NULL, 'B7', 0.28, 1030, '2024-04-22 11:37:02', 9, 13, 1, 1, 'RONDANA_GROWER_RONDANA_ESTRELLA_EXTERIOR_GALVANIZADA_10_52.png', 1, 2, 1, 0.2800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(542, 'DELT-7S', 'VARILLA PARA HORQUILLA (tubo 1/4)', NULL, '', 25.00, 0, '2024-04-22 11:42:56', 9, 19, 1, 1, 'VARILLA_PARA_HORQUILLA_18.png', 3, 2, 1, 25.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(543, 'DELT-7X', 'PERNO AJUSTADOR CHICO (M4)', NULL, 's/d', 5.00, 307, '2024-04-22 11:45:10', 9, 3, 1, 1, 'PERNO_AJUSTADOR_CHICO_18.png', 3, 2, 1, 5.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(545, 'DELT-8B', 'APOYADOR NASAL', NULL, 'GABETA G8', 8.00, 180, '2024-04-22 11:49:22', 9, 3, 1, 1, 'APOYADOR_NASAL_12.png', 3, 2, 1, 8.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(546, 'DELT-8F', 'TORNILLO PARA VARILLA DE NIVEL DE ARTICULADOR M4', NULL, 'GABETA G7', 5.00, 149, '2024-04-22 11:52:31', 9, 3, 1, 1, 'TORNILLO_PARA_POSICIONADOR_NASAL_14.png', 2, 2, 1, 5.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(547, 'DELT-8G', 'TORNILLO FIJACION TIJERAS', NULL, 'GABETA-G1', 8.00, 133, '2024-04-22 11:55:38', 9, 3, 1, 1, 'TORNILLO_FIJACION_TIJERAS_16.png', 2, 2, 1, 8.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(548, 'DELT-8H', 'BLOCK DE ETIQUETAS PARA REGISTRO CPI', NULL, 'G1', 5.00, 365, '2024-04-22 11:59:33', 9, 4, 1, 1, 'ETIQUETA_CPI_92.png', 4, 50, 1, 5.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(549, 'DELT-8J', 'BLOCK DE REGISTRO (HOJA DE TRABAJO)', NULL, 'G2', 5.00, 400, '2024-04-22 12:04:49', 9, 4, 1, 1, 'HOJA_DE_TRABAJO_66.png', 4, 2, 1, 5.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(550, 'DELT-8K', 'MANUAL CPI', NULL, '', 0.00, 0, '2024-04-22 12:06:41', 9, 4, 1, 1, 'MANUAL_CPI_28.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(551, 'DELT-8M', 'MANUAL DE CALIBRACION CPI', NULL, '', 0.00, 0, '2024-04-22 12:08:17', 9, 4, 1, 1, 'MANUAL_DE_CALIBRACION_CPI_31.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(552, 'DELT-8N', 'MANUAL ANALOGO', NULL, '', 0.00, 0, '2024-04-22 12:10:06', 9, 4, 1, 1, 'MANUAL_ANALOGO_25.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(553, 'DELT-8Ñ', 'MANUAL CALIBRACION ANALOGO', NULL, '', 0.00, 0, '2024-04-22 12:11:40', 9, 4, 1, 1, 'MANUAL_CALIBRACION_ANALOGO_36.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(554, 'DELT-8P', 'BASE', NULL, 'sin asignar', 5.00, 110, '2024-04-22 12:12:58', 9, 3, 1, 1, 'BASE_63.png', 3, 2, 1, 5.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(555, 'DELT-8Q', 'BASE MOVIL', NULL, '', 10.00, 122, '2024-04-22 12:14:51', 9, 3, 1, 1, 'BASE_MOVIL_64.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(556, 'DELT-8R', 'SOLERA HORIZONTAL PARA SOPORTE DE HORQUILLA', NULL, 'S/U', 10.00, 156, '2024-04-22 12:16:54', 9, 3, 1, 1, 'VARILLA_VERTICAL_PA_36.png', 3, 2, 1, 10.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(558, 'DELT-8T', 'MANUAL ARCO FACIAL', NULL, '', 0.00, 0, '2024-04-22 12:21:09', 9, 4, 1, 1, 'MANUAL_ARCO_FACIAL_53.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(559, 'DELT-8W', 'MANUAL CALIBRACION ARCO FACIAL', NULL, '', 0.00, 14, '2024-04-22 12:22:52', 9, 4, 1, 1, 'MANUAL_CALIBRACION_ARCO_FACIAL_0.png', 4, 2, 1, 0.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(560, 'DELT-8Z', 'HORQUILLA PARA NIÑOS', NULL, '', 30.00, 30, '2024-04-22 13:14:51', 9, 19, 1, 1, '', 4, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(561, 'DELT-9A', 'TORNILLO PARA CONDILO, TORNILLO CABEZA BOTON ALLEN M4 x 12MM', NULL, 'B13', 0.90, 1400, '2024-04-22 13:46:27', 9, 13, 1, 1, 'TORNILLO_PARA_CONDILO_TORNILLO_CABEZA_BOTON_ALLEN_1_8_X_1_2__82.jpg', 1, 2, 1, 0.9000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(562, 'H-0253', 'VASTAGO MITUTOYO AM GAGE', NULL, '', 97.50, 2, '2024-04-24 11:47:09', 3, 11, 1, 2, 'VASTAGO_MITUTOYO_AM_GAGE_90.jpg', 5, 2, 0, 97.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(563, 'H-0254', 'Cortador largo, 4 gavilanes, diámetro corte 3/8\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-3/8\", CARBURO, hélice 30°, para fresado profundo.', NULL, 'HM2-12', 124.50, 5, '2024-04-24 11:49:45', 3, 11, 1, 2, 'Cortador_largo_4_gavilanes_di_metro_corte_3_8_longitud_de_corte_1_longitud_total_4_longitud_zanco_reducido_1_3_8_CARBURO_h_lice_30_para_fresado_profundo__94.jpg', 5, 2, 0, 124.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(564, 'H-0255', 'Cortador largo, 4 gavilanes, diámetro corte 1/4\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-1/4\", CARBURO, hélice 30°, para fresado profundo.', NULL, 'HM2-12', 89.50, 4, '2024-04-24 11:52:01', 3, 11, 1, 2, 'Cortador_largo_4_gavilanes_di_metro_corte_1_4_longitud_de_corte_1_longitud_total_4_longitud_zanco_reducido_1_1_4_CARBURO_h_lice_30_para_fresado_profundo__99.jpg', 5, 2, 0, 89.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(565, 'H-0256', 'MACHUELO HELICOIDAL 5-40', NULL, 'HM2-19', 764.10, 4, '2024-04-24 14:30:27', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_5_40_97.jpg', 5, 0, 1, 764.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(566, 'H-0257', 'RIMA RECTA 1/8', NULL, 'HM3-7', 675.00, 2, '2024-04-24 14:36:11', 3, 2, 1, 1, 'RIMA_RECTA_1_8__29.jpg', 5, 1, 1, 675.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(567, 'H-0258', 'MACHUELO HELICOIDAL 3/8', NULL, 'HM2-10', 680.00, 1, '2024-04-24 14:38:09', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_3_8_24__34.jpg', 5, 1, 1, 680.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(569, 'H-0259', 'MANERAL TIPO GARROTE PARA MACHUELOS DE 1/16\" A 1/4\"', NULL, 'LOCKER FILA 3', 70.69, 6, '2024-05-06 13:33:24', 1, 17, 1, 1, 'MANERAL_TIPO_GARROTE_PARA_MACHUELOS_DE_1_16_A_1_4__39.jpg', 5, 2, 1, 70.6900, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(570, 'DELT-8S', 'PERNO RANURADO 1/8\" x 3/8\"', NULL, 'B15', 0.50, 350, '2024-05-06 14:28:32', 9, 13, 1, 1, 'PERNO_RANURADO_1_8_quot_x_3_8_quot__36.jpg', 1, 2, 1, 0.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(571, 'DELT-9D', 'COJIN PARA APOYADOR NASAL', NULL, 'F1', 4.00, 1000, '2024-05-10 11:10:42', 9, 30, 1, 1, 'ALMOADILLA_23.jpg', 4, 2, 1, 4.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(572, 'H-0260', 'ESCARIADOR (RIMA) CN H7, HSS+E, DIAMETRO DE CORTE 6.4mm (0.252', NULL, 'HM3-8', 40.50, 2, '2024-05-21 11:19:14', 3, 11, 1, 2, 'ESCARIADOR_RIMA_CN_H7_HSS_E_DIAMETRO_DE_CORTE_6_4mm_0_252_MCA_GARANT_TECNOLOGIA_ALEMANA__95.jpg', 5, 1, 1, 40.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(573, 'H-0261', 'Escariador mecánico CN de MDI (carburo), diámetro de corte 6,4 mm (0.252\"), MCA. GARANT. TECNOLOGIA ALEMANA.', NULL, 'HM3-8', 155.50, 1, '2024-05-21 11:30:19', 3, 11, 1, 2, 'Escariador_mec_nico_CN_de_MDI_carburo_di_metro_de_corte_6_4_mm_0_252_MCA_GARANT_TECNOLOGIA_ALEMANA__75.jpg', 5, 2, 0, 155.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(574, 'H-0262', 'CORTADOR DE 3/16 DE DIAMETRO 4 FILOS DE CORTE X 5/8 DE LARGO DE CORTE X 2 DE LARGO TOTAL MCA. DORMER', NULL, 'HM3-9', 12.60, 0, '2024-05-21 11:49:45', 3, 11, 1, 2, 'CORTADOR_DE_3_16_DE_DIAMETRO_4_FILOS_DE_CORTE_X_5_8_DE_LARGO_DE_CORTE_X_2_DE_LARGO_TOTAL_MCA_DORMER_89.jpg', 5, 4, 1, 12.6000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(575, 'H-0263', 'Fresa (cortador) 4 filos, diámetro 1/8', NULL, 'HM3-9', 28.90, 0, '2024-05-21 11:59:51', 3, 11, 1, 2, 'Fresa_cortador_4_filos_di_metro_1_8_recto_longitud_de_corte_1_zanco_cil_ndrico_1_8_largo_carburo_en_acabado_brillante_Marca_Dormer_0.jpg', 5, 5, 1, 28.9000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(576, 'H-0264', 'Fresa (cortador) 4 filos, diámetro 1/8, recto, longitud de corte 1, zanco cilíndrico 1/8,  Corto, carburo en acabado brillante, Marca Dormer', NULL, 'HM3-9', 11.95, 4, '2024-05-21 12:01:56', 3, 11, 1, 2, 'Fresa_4_filos_di_metro_1_8_recto_longitud_de_corte_1_zanco_cil_ndrico_1_8_Corto_carburo_en_acabado_brillante_Marca_Dormer_67.jpg', 5, 5, 1, 11.9500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(577, 'H-0265', 'RIMA RECTA HSS Ø 1/4', NULL, 'HM3-8', 877.50, 5, '2024-05-21 13:18:45', 3, 2, 1, 1, 'RIMA_RECTA_HSS_1_4__26.jpg', 5, 1, 1, 877.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(578, 'H-0266', 'CORTADOR VERTICAL CARBURO Ø3/32&quot; 4FSER ALTIN', NULL, 'HM3-8', 259.00, 8, '2024-05-21 13:24:24', 3, 2, 1, 1, 'CORTADOR_VERTICAL_CARBURO_3_32_4F_TIALN_45.jpg', 5, 7, 1, 259.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(579, 'DELT-9C', 'TORNILLO ALLEN SOCKET CILINDRO INOXIDABLE A2 M4x12MM', NULL, 'B16', 0.94, 900, '2024-05-29 11:32:59', 9, 13, 1, 1, 'TORNILLO_ALLEN_SOCKET_CILINDRO_INOXIDABLE_A2_M4x12MM_44.jpg', 1, 2, 1, 0.9400, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(580, 'I-0201', 'POLISH BLANCO', NULL, 'FILA 1', 70.00, 1, '2024-05-31 12:04:49', 2, 4, 1, 1, 'POLISH_BLANCO_10.jpg', 5, 2, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(581, 'I-0202', 'SILICON SELLADOR DE ALTA TEMPERATURA', NULL, 'FILA 1', 70.00, 5, '2024-05-31 12:07:23', 2, 4, 1, 1, 'SILICON_SELLADOR_DE_ALTA_TEMPERATURA_55.jpg', 5, 2, 1, 70.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(582, 'I-0204', 'PASTA PARA SOLDAR', NULL, 'FILA 1', 80.00, 3, '2024-05-31 12:10:16', 2, 4, 1, 1, 'PASTA_PARA_SOLDAR_53.jpg', 5, 2, 1, 80.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(583, 'I-0205', 'SOLDADURA EN ALAMBRE', NULL, 'FILA 1', 850.00, 2, '2024-05-31 12:11:23', 2, 2, 1, 1, 'SOLDADURA_EN_ALAMBRE_53.jpg', 5, 2, 1, 850.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(584, 'I-0206', 'PILA ENERGIZER  A23', NULL, 'LOCKER FILA 2', 300.00, 2, '2024-05-31 12:26:39', 2, 4, 1, 1, 'PILA_ENERGIZER_A23_96.jpg', 5, 2, 1, 300.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(585, 'H-267', 'ATOMIZADOR DE 1 LITRO', NULL, 'LOCKER FILA 2', 40.00, 3, '2024-05-31 13:10:31', 1, 17, 1, 1, 'ATOMIZADOR_DE_1_LITRO_40.jpg', 5, 2, 1, 40.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(586, 'H-0267', 'DADO LARGO 9/16\"', NULL, 'LOCKER FILA 3', 80.00, 2, '2024-05-31 14:24:48', 1, 17, 1, 1, 'DADO_LARGO_9_16__41.jpg', 5, 2, 1, 80.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(587, 'H-0268', 'DADO LARGO 1/2\"', NULL, 'LOCKER FILA 3', 80.00, 2, '2024-05-31 14:25:30', 1, 17, 1, 1, 'DADO_LARGO_1_2__52.jpg', 5, 2, 1, 80.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(588, 'H-0269', 'Machuelo Helicoidal Yellow Shark UNF 3/8\"-24 HPP, tolerancia 2B, 0.3810\" zanco, 0.2840\" cuadrillo de arrastre, HSS-E, MCA DOMER', NULL, 'HM3-9', 63.10, 1, '2024-06-03 11:30:03', 3, 11, 1, 2, 'Machuelo_Helicoidal_Yellow_Shark_UNF_3_8_24_HPP_tolerancia_2B_0_3810_zanco_0_2840_cuadrillo_de_arrastre_HSS_E_MCA_DOMER_64.jpg', 5, 2, 1, 63.1000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(589, 'DELT-9E', 'Desarmador (destornillador) Allen Hexagonal de 3 mm, con mango recubierto', NULL, 'F1', 59.68, 243, '2024-06-04 15:22:59', 9, 13, 1, 1, 'DESTORMILLADOR_PARA_PUNTAS_INTERCAMBIABLES_90.jpg', 4, 26, 1, 59.6800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(596, 'H-0271', '(cortador) Fresa de punta esférica serie estándar, 2 canales, diámetro 1/4&quot;, longitud de corte 3/4&quot;, longitud total 2-1/2&quot;, zanco cilíndrico 1/4&quot;.', NULL, 'HM3-4', 28.80, 3, '2024-06-13 11:53:54', 3, 11, 1, 2, '_cortador_Fresa_de_punta_esf_rica_serie_est_ndar_2_canales_di_metro_1_4_longitud_de_corte_3_4_longitud_total_2_1_2_zanco_cil_ndrico_1_4__88.jpg', 5, 2, 0, 28.8000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(597, 'H-0272', '(cortador) Fresa de punta esférica serie estándar, 2 canales, diámetro 3/8&quot;, longitud decorte 7/8&quot;, longitud total 2-1/2&quot;, zanco cilíndrico 3/8&quot;.', NULL, 'HM3-4', 46.13, 3, '2024-06-13 11:55:23', 3, 11, 1, 2, 'Fresa_de_punta_esf_rica_serie_est_ndar_2_canales_di_metro_3_8_longitud_de_corte_7_8_longitud_total_2_1_2_zanco_cil_ndrico_3_8__55.jpg', 5, 2, 0, 46.1300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(598, 'H-0273', '(cortador) Fresa de punta esférica serie extra larga, 2 canales, diámetro 3/8&quot;,longitud de corte 1-3/4&quot;, longitud total 4&quot;, zanco cilíndrico 3/8&quot;.', NULL, 'HM3-4', 71.40, 3, '2024-06-13 11:56:25', 3, 11, 1, 2, 'Fresa_de_punta_esf_rica_serie_extra_larga_2_canales_di_metro_3_8_longitud_de_corte_1_3_4_longitud_total_4_zanco_cil_ndrico_3_8__85.jpg', 5, 2, 0, 71.4000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(599, 'H-0274', 'Macho machuelo recto de mano, con segunda entrada de 4-6xP, A IZQUIERDA Rosca MétricaISO M4 con 0.70 mm de paso, tolerancia 6H, mango de 4.0mm y cuadradillo dearrastre de 3.15mm, HSS con', NULL, 'HM2-15', 25.50, 3, '2024-06-14 10:53:39', 3, 11, 1, 2, 'Macho_recto_de_mano_con_segunda_entrada_de_4_6xP_A_IZQUIERDA_Rosca_M_trica_ISO_M4_con_0_70_mm_de_paso_tolerancia_6H_mango_de_4_0mm_y_cuadradillo_de_arrastre_de_3_15mm_HSS_con__72.jpg', 5, 2, 0, 25.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(600, 'H-275', 'PIEDRA PARA ASENTAR 150MM. DOBLE GRANO 150 Y 240', NULL, 'LOCKER FILA 4', 66.38, 1, '2024-06-17 09:18:08', 1, 17, 1, 1, 'PIEDRA_PARA_ASENTAR_150MM_DOBLE_GRANO_150_Y_240_93.jpg', 5, 2, 1, 66.3800, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(601, 'H-0276', 'Macho machuelo Helicoidal, rosca ISO-Métrica M5 paso de 0,80 mm, clase de ajuste 6H, vástago de 0,1940&quot; y cuadrado de 0,1520&quot;, HSSM5 X 0.8 mm', NULL, 'HM2-11', 21.50, 5, '2024-06-18 14:19:27', 3, 11, 1, 2, 'Macho_Helicoidal_rosca_ISO_M_trica_M5_paso_de_0_80_mm_clase_de_ajuste_6H_v_stago_de_0_1940_y_cuadrado_de_0_1520_HSS_M5_X_0_8_mm_92.jpg', 5, 2, 1, 21.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(605, 'DELT-9H', 'ANALOGO IZQUIERDO CON PERNOS', NULL, 'MESA', 30.00, 236, '2024-07-10 15:37:34', 9, 26, 1, 1, 'ANALOGO_IZQUIERDO_2.jpg', 4, 2, 1, 30.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(606, 'DELT-9G', 'ANALOGO DERECHO CON PERNOS', NULL, 'MESA', 30.00, 236, '2024-07-10 15:39:50', 9, 26, 1, 1, 'ANALOGO_DERECHO_53.jpg', 4, 50, 1, 30.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(607, 'MPM-004', 'SOLERA DE ALUMINIO 6061 DE 1 X 3 X  3.66 MTS.', NULL, 'MAQUINADOS', 2820.00, 4, '2024-07-11 09:56:07', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0254, 3.6600, 0.0762, 0.0000, '2025-06-22 11:11:48'),
(608, 'MPM-009', 'SOLERA DE ALUMINIO 6061 DE 1/2 X 3 X 3.66 MTS.', NULL, 'MAQUINADO', 1410.00, 15, '2024-07-11 09:57:49', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0127, 3.6600, 0.0762, 0.0000, '2025-06-22 11:11:48'),
(609, 'MPM-007', 'SOLERA DE ALUMINIO 6061 DE 3/4 X 5 X 3.66 MTS.', NULL, 'MAQUINADO', 3770.00, 8, '2024-07-11 10:00:18', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0190, 3.6600, 0.1270, 0.0000, '2025-06-22 11:11:48'),
(611, 'MPM-002', 'PLACA DE ALUMINIO 6061 DE 1-1/2 X 3 X 3.66', NULL, 'MAQUINADO', 4238.00, 8, '2024-07-11 10:06:17', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0381, 3.6600, 0.0762, 0.0000, '2025-06-22 11:11:48'),
(614, 'MPM-008', 'SOLERA DE ALUMINIO 6061 DE 3/4 X 2-1/2 X 3.66 MTS.', NULL, 'MAQUINADO', 1890.00, 2, '2024-07-11 10:14:02', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0190, 3.6600, 0.0635, 0.0000, '2025-06-22 11:11:48'),
(615, 'MPM-001', 'SOLERA ALUMINIO 6061 DE 3/4 X 2 X 3.66 MTS.', NULL, 'MAQUINADO', 1410.00, 5, '2024-07-11 10:15:18', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0190, 3.6600, 0.0500, 0.0000, '2025-06-22 11:11:48'),
(616, 'MPM-010', 'SOLERA  DE ALUMINIO 6061 DE 1/2 X 2 X 3.66 MTS.', NULL, 'MAQUINADO', 945.00, 1, '2024-07-11 10:16:34', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0127, 3.6600, 0.0508, 0.0000, '2025-06-22 11:11:48'),
(617, 'MPM-005', 'SOLERA  DE ALUMINIO 6061 DE 1 X 2-1/2 X 3.66 MTS.', NULL, 'MAQUINADO', 2592.00, 1, '2024-07-11 10:19:26', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0254, 3.6600, 0.0635, 0.0000, '2025-06-22 11:11:48'),
(618, 'MPM-012', 'BARRA REDONDA DE ALUMINIO 6061 DE 2-1/2 X 3.66', NULL, 'MAQUINADO', 4466.00, 7, '2024-07-11 10:29:54', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0635, '2025-06-22 11:11:48'),
(619, 'MPM-016', 'BARRA REDONDA DE ALUMINIO 6061 DE 1/2 INCH X 3.66MTS.', NULL, 'MAQUINADO', 184.00, 4, '2024-07-11 10:32:32', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0127, '2025-06-22 11:11:48'),
(620, 'MPM-014', 'BARRA REDONDA DE ALUMINIO 6061 DE 1 INCH X 3.66 MTS.', NULL, 'MAQUINADO', 718.00, 12, '2024-07-11 10:34:45', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0254, '2025-06-22 11:11:48'),
(621, 'MPM-022', 'BARRA DE ACERO INOXIDABLE T-304 DE 1/4 INCH X 3.05 MTS.', NULL, 'MAQUINADO', 74.00, 14, '2024-07-11 10:36:18', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.0500, 0.0000, 0.0063, '2025-06-22 11:11:48'),
(622, 'MPM-019', 'BARRA REDONDA DE ACERO INOXIDABLE T-304 DE 1/2 INCH X 3..05 MTS.', NULL, 'MAQUINADO', 292.00, 8, '2024-07-11 10:37:50', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.0500, 0.0000, 0.0127, '2025-06-22 11:11:48'),
(628, 'H-0277', 'DISCO DE SIERRA 12', NULL, 'MAQUINADO', 1560.00, 2, '2024-07-16 16:37:51', 3, 2, 1, 1, 'DISCO_DE_SIERRA_12_DW03240_DEWALT_15.jpg', 5, 1, 1, 1560.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(635, 'I-0210', 'GU-152 GUANTE DE NITRILO NEGRO, MEDIANO', NULL, 'LOCKER FILA 4', 47.42, 4, '2024-07-22 08:54:57', 2, 17, 8, 1, 'GU_152_GUANTE_DE_NITRILO_NEGRO_MEDIANO_23.jpg', 5, 2, 1, 47.4200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(636, 'I-0211', 'GU-151 GUANTE DE NITRILO NEGRO, CHICO', NULL, 'LOCKER FILA 4', 47.42, 4, '2024-07-22 08:56:31', 2, 17, 8, 1, 'GU_151_GUANTE_DE_NITRILO_NEGRO_CHICO_88.jpg', 5, 2, 1, 47.4200, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(637, 'H-0284', 'PORTA INSERTO RANURADO A4 DER. ZANCO 3/4\" INS. W2.0 MMA4SMR120214', NULL, 'HM3-1', 195.00, 1, '2024-07-24 13:47:23', 3, 2, 1, 2, 'PORTA_INSERTO_RANURADO_A4_DER_ZANCO_3_4_INS_W2_0_MMA4SMR120214_100.jpg', 5, 2, 1, 195.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(638, 'H-0285', 'TORNILLO STC 5 KENNAMETAL, 5653853, 4506708677 CVG1', NULL, 'HM3-6', 3.85, 8, '2024-07-26 14:26:12', 3, 2, 1, 2, 'TORNILLO_STC_5_KENNAMETAL_5653853_4506708677_CVG1_19.jpg', 5, 2, 1, 3.8500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(639, 'H-0286', 'TORNILLO PARA MAQUINADOS, S310, 6-32 X 1/2 SHCS, 1019940  4506348367  CVF9', NULL, 'HM3-6', 4.00, 9, '2024-07-26 14:31:35', 3, 2, 1, 2, 'TORNILLO_PARA_MAQUINADOS_S310_6_32_X_1_2_SHCS_1019940_4506348367_CVF9_80.jpg', 5, 2, 1, 4.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(640, 'H-0287', 'TORNILLO DE MAQUINADOS, S2112, BTN HD CAP SCR #10-32 X 0.750,  2050082  4506728018 CVL1', NULL, 'HM3-6', 4.50, 9, '2024-07-26 14:37:08', 3, 2, 1, 2, 'TORNILLO_DE_MAQUINADOS_S2112_BTN_HD_CAP_SCR_10_32_X_0_750_2050082_4506728018_CVL1_26.jpg', 5, 2, 1, 4.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(641, 'H-0288', 'Macho (Machuelo) helicoidal Blue Shark con chaflán forma C, con entrada de 2-3xP, UNF 1/4\"\r\ncon 28 HPP, tolerancia 0.002\", zanco 0.2550\", cuadro 0.1890\", HSS-E pulvimetalúrgico con\r\n', NULL, 'HM2-20', 59.50, 3, '2024-07-30 13:32:48', 3, 11, 1, 2, 'Macho_Machuelo_helicoidal_Blue_Shark_con_chafl_n_forma_C_con_entrada_de_2_3xP_UNF_1_4_con_28_HPP_tolerancia_0_002_zanco_0_2550_cuadro_0_1890_HSS_E_pulvimetal_rgico_con__3.jpg', 5, 2, 1, 59.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(642, 'H-0289', 'INSERTOS PARA ALUMINIO,SINTERGRIP ALU PARA PRENSA 5 EJES,MCA. SMW AUTOBLOK.', NULL, 'HM2-16', 48.00, 1, '2024-07-31 14:44:57', 3, 11, 9, 2, 'SET_DE_10_INSERTOS_PARA_ALUMINIO_SINTERGRIP_ALU_PARA_PRENSA_5_EJES_MCA_SMW_AUTOBLOK__73.jpg', 5, 2, 1, 48.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(644, 'H-0289', 'MICROFRESA DE MDI (CARBURO) DIÁMETRO DE CORTE 2.5mm, ZANCO REDUCIDO 20mm, MCA. GARANT', NULL, 'HM2-15', 91.50, 9, '2024-08-07 09:59:52', 3, 11, 1, 2, 'MICROFRESA_DE_MDI_CARBURO_DI_METRO_DE_CORTE_2_5mm_ZANCO_REDUCIDO_20mm_MCA_GARANT_45.jpg', 5, 2, 1, 91.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(645, 'H-0290', 'BARRA DE INTERIORES A-SCLCR 8-2 ISCAR', NULL, 'HM2-15', 237.30, 1, '2024-08-08 13:51:46', 3, 2, 1, 2, 'BARRA_DE_INTERIORES_A_SCLCR_8_2_ISCAR_59.jpg', 5, 2, 1, 237.3000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(646, 'H-0291', 'INSERTOS DE CARBURO CCMT 2-1F3P IC8150ISCAR', NULL, 'HM2-15', 15.50, 10, '2024-08-08 13:53:40', 3, 2, 1, 2, 'INSERTOS_DE_CARBURO_CCMT_2_1F3P_IC8150ISCAR_87.jpg', 5, 2, 1, 15.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(649, 'H-0292', 'VCGT 11 03 02-UM 1125 Plaquita (insertos) CoroTurn® 107 para torneado, MCA. Sandvik', NULL, 'HM2-15', 32.80, 25, '2024-09-12 08:37:13', 3, 11, 1, 2, 'VCGT_11_03_02_UM_1125_Plaquita_insertos_CoroTurn_107_para_torneado_MCA_Sandvik_36.jpg', 5, 10, 1, 32.8000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(650, 'H-0293', 'MACHUELO HELICOIDAL M4 x 0.7 YG1', NULL, 'HM2-19', 432.00, 5, '2024-09-12 10:10:07', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M4_x_0_7_YG1_43.jpg', 5, 5, 1, 432.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(651, 'H-0294', 'Juego de Machuelos M2 x 0.4 6H', NULL, 'HM3-6', 1215.00, 3, '2024-09-12 10:35:53', 3, 2, 1, 1, 'Juego_de_Machuelos_M2_x_0_4_6H_16.jpg', 5, 3, 1, 1215.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(652, 'H-0295', 'Juego de Machuelos 1/8\"-40 2B ROYCO ', NULL, 'HM3-6', 405.00, 3, '2024-09-12 10:42:40', 3, 2, 1, 1, 'Juego_de_Machuelos_1_8_40_2B_ROYCO__53.jpg', 5, 2, 1, 405.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(653, 'H-0296', 'TARRAJA M2 x .4 x 1\" DIAM. EXT. ROYCO', NULL, 'HM3-6', 810.00, 1, '2024-09-12 10:50:28', 3, 2, 1, 1, 'TARRAJA_M2_x_4_x_1_DIAM_EXT_ROYCO_10.jpg', 5, 1, 1, 810.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(654, 'H-0297', 'CORTADOR DE CARBURO  DIAM 3/4\" x Z 1-1/2\" x LT 4\" SIN REC. 4FL CLEVELAND', NULL, 'HM3-8', 2310.00, 2, '2024-09-12 11:07:32', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_DIAM_1_2_x_Z_1_1_2_x_LT_4_SIN_REC_4FL_CLEVELAND__92.jpg', 5, 2, 1, 2310.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(655, 'H-0298', 'CORTADOR DE CARBURO DIAM. 1/4 X FILO 3/8 X LT 2.5 DE 4 FL. SIN REC. BRIGHT COBRA CARBIDE', NULL, 'HM2-10', 364.00, 17, '2024-09-12 12:10:20', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_DIAM_1_4_X_FILO_3_8_X_LT_2_5_DE_4_FL_SIN_REC_BRIGHT_COBRA_CARBIDE_77.jpg', 5, 3, 1, 364.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(656, 'H-0299', 'INSERTO DE CARBURO EDPT140408PDSRGD KCPK30 KENNAMETAL ( RADIO .8 MM)', NULL, ' HM2-16', 20.63, 20, '2024-09-18 14:05:17', 3, 2, 1, 2, 'INSERTO_DE_CARBURO_EDPT140408PDSRGD_KCPK30_KENNAMETAL_RADIO_8_MM__39.jpg', 5, 10, 1, 20.6300, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(657, 'H-0300', 'JUEGO DE MACHUELOS N4-40 ROYCO', NULL, 'HM3-7', 476.00, 3, '2024-09-18 14:20:37', 3, 2, 1, 1, 'JUEGO_DE_MACHUELOS_N4_40_ROYCO_95.jpg', 5, 3, 1, 476.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(658, 'DELT-9U', 'PERNO DE POSICION 2 (3/16 x .400) (PARA BASES DE CALIBRACION Y PORTAPLATINAS)', NULL, 'A5', 2.00, 400, '2024-09-24 15:01:52', 9, 3, 1, 1, 'PERNO_DE_POSICION_2_3_16_x_400_PARA_BASES_DE_CALIBRACION_Y_PORTAPLATINAS__78.jpg', 4, 300, 1, 2.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(659, 'H-0301', 'TARRAJA #4 - 40 X 13/16', NULL, 'HM2-12', 455.00, 1, '2024-09-27 15:00:22', 3, 2, 1, 1, 'TARRAJA_4_40_X_13_16_13.jpg', 5, 0, 0, 455.0000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(660, 'H-0302', 'MANERAL PARA TARRAJAS 1\"', NULL, 'HM3-7', 148.50, 2, '2024-09-27 15:04:30', 3, 2, 1, 1, 'MANERAL_PARA_TARRAJAS_1__87.jpg', 5, 0, 0, 148.5000, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(661, 'H-0302', 'MANERAL PARA TARRAJAS DE 13/16\"', NULL, 'HM3-7', 182.25, 2, '2024-09-27 15:05:59', 3, 2, 1, 1, 'MANERAL_PARA_TARRAJAS_DE_13_16__25.jpg', 5, 0, 0, 182.2500, NULL, NULL, NULL, NULL, NULL, '2025-06-22 11:11:48'),
(662, 'MPM-013', 'BARRA REDONDA ALUMINIO 6061 DE 1-1/4 Inch X 3.66 MTS.', NULL, 'MAQUINADO', 1122.00, 1, '2024-09-30 14:35:22', 6, 1, 1, 1, '', 5, 8, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0317, '2025-06-22 11:11:48'),
(665, 'H-0303', 'CORTADOR VERTICAL BOLA CARBURO Ø1/8\" 4 FL REC. TIALN COBRA\r\nCARBID', NULL, 'HM2-11', 261.00, 4, '2024-10-03 14:43:39', 3, 2, 1, 1, 'CORTADOR_VERTICAL_BOLA_CARBURO_1_8_4_FL_REC_TIALN_COBRA_CARBID_8.jpg', 5, 3, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 3.1750, '2025-06-22 11:11:48'),
(666, 'H-0304', 'BROCA RECTA HSS Ø19/64\" CLEV', NULL, 'HM2-9', 78.30, 5, '2024-10-03 14:45:44', 3, 2, 1, 1, 'BROCA_RECTA_HSS_19_64_CLEV_89.jpg', 5, 5, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 7.5406, '2025-06-22 11:11:48'),
(667, 'DELT-9F', 'PERNO DE POSICION 3 (3/16 x .450) (PARA MARCO CON BASE INFERIOR)', NULL, 'MESA-GABETAS', 3.00, 900, '2024-10-08 09:09:56', 9, 3, 1, 1, 'PERNO_DE_POSICION_3_3_16_x_400_PARA_BASES_DE_CALIBRACION_Y_PORTAPLATINAS__40.jpg', 4, 450, 1, 0.0000, 0.0000, 0.0000, 111.4300, 0.0000, 4.7600, '2025-06-22 11:11:48'),
(669, 'MPM-023', 'BARRA REDONDA ACERO INOXIDABLE T-304 DE 3/16 Inch X 3.05 mts.', NULL, 'MAQUINADOS', 64.00, 3, '2024-10-11 15:02:05', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.0500, 0.0000, 0.0047, '2025-06-22 11:11:48'),
(670, 'MPM-021', 'BARRA REDONDA ACERO INOXIDABLE T-304 DE 5/16 Inch X 3.05 Mts', NULL, 'MAQUINADOS', 1115.00, 11, '2024-10-11 15:04:25', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.0500, 0.0000, 0.0079, '2025-06-22 11:11:48'),
(671, 'MPM-024', 'BARRA REDONDA ACERO INOXIDABLE T-304 DE 1/8 Inch X 3.66 MTS.', NULL, 'MAQUINADOS', 45.00, 4, '2024-10-11 15:09:24', 6, 1, 1, 1, '', 5, 4, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0031, '2025-06-22 11:11:48'),
(673, 'H-0306', 'HERRAMIENTA DE CARBURO PARA CHAMBER A 45 GRADOS', NULL, 'HM3-8', 840.00, 20, '2024-10-21 12:06:48', 3, 18, 1, 1, 'HERRAMIENTA_DE_CARBURO_PARA_CHAMBER_A_45_GRADOS_60.jpg', 5, 4, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(674, 'DELT-9I', 'CAJA PARA ARCO FACIAL', NULL, 'RACK-001', 7.22, 324, '2024-10-21 12:19:42', 9, 4, 1, 1, 'CAJA_PARA_ARCO_FACIAL_33.jpg', 4, 50, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(675, 'DELT-9J', 'FOAM PARA CAJA DE ARCO', NULL, 'RACK-001', 5.00, 149, '2024-10-21 12:22:10', 9, 4, 1, 1, 'BASE_DE_FOAM_PARA_CAJA_DE_ARCO_86.jpg', 4, 50, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(680, 'H-0309', 'TORNILLO MS2166 / PARA CORONA KENNAMETAL', NULL, 'HM3-9', 6.94, 10, '2024-10-23 14:57:20', 3, 2, 1, 2, '', 5, 5, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(681, 'H-0310', 'MACHUELO RECTO M4 X 0.7 ( 1. 1/2 hilos de chaflán) ROYCO', NULL, 'HM2-12', 168.00, 5, '2024-10-23 15:08:52', 3, 2, 1, 1, '', 5, 3, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(682, 'H-0311', 'BROCA RECTA Ø5/32\" X 3\" CORTE X 5.3/8\" LARGO TOTAL, CLEV', NULL, 'HM2-8', 98.00, 5, '2024-10-23 15:12:24', 3, 2, 1, 1, '', 5, 3, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(683, 'DELT-9K', 'MOCHILA PARA ARCO FACIAL', NULL, 'RACK1', 200.00, 130, '2024-10-29 15:19:28', 9, 4, 1, 1, 'MOCHILA_PARA_ARCO_FACIAL_2.jpg', 4, 100, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(684, 'H-0312', 'TONILLO DE CABEZA AVELLANADA PARA SUJECION DE PARA PORTA HERRAMIENTA 122B-B1, MCA SANDVIK', NULL, 'HM3-8', 4.68, 10, '2024-10-31 14:01:02', 3, 11, 1, 2, 'TONILLO_DE_CABEZA_AVELLANADA_PARA_SUJECION_DE_PARA_PORTA_HERRAMIENTA_122B_B1_MCA_SANDVIK_96.jpg', 5, 4, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(685, 'H-0313', 'BOQUILLA ER16 10-9', NULL, 'HM3-4', 428.04, 2, '2024-11-08 14:51:29', 3, 2, 1, 1, 'BOQUILLA_ER16_10_9_6.jpg', 5, 1, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(686, 'H-0314', 'BOQUILLA ER16 7-6 OLIMA', NULL, 'HM3-4', 428.04, 2, '2024-11-08 14:53:30', 3, 2, 1, 1, 'BOQUILLA_ER16_7_6_OLIMA_17.jpg', 5, 1, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(687, 'H-0315', 'RIMA RECTA HSS 5/16\" FENES', NULL, 'HM3-1', 433.04, 2, '2024-11-08 14:54:59', 3, 2, 1, 1, 'RIMA_RECTA_HSS_5_16_FENES_72.jpg', 5, 1, 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '2025-06-22 11:11:48'),
(689, 'MPM-003', 'SOLERA ALUMINIO 6061 DE 1 X 1-1/2 X 3.66MTS.', NULL, 'MAQUINADOS', 1510.00, 3, '2024-11-20 11:05:50', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0254, 3.6600, 0.0381, 0.0000, '2025-06-22 11:11:48'),
(690, 'MPM-006', 'SOLERA ALUMINIO 6061 DE 1-1/4 X 2 X 3.66 MTS.', NULL, 'MAQUINADOS', 2592.00, 2, '2024-11-20 11:17:33', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0317, 3.6600, 0.0508, 0.0000, '2025-06-22 11:11:48'),
(691, 'MPM-011', 'SOLERA NYLAMID T-M DE 1 X 11/2 X 3.05 MTS.', NULL, 'MAQUINADOS', 1920.00, 1, '2024-11-20 11:41:17', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0254, 3.0500, 0.0381, 0.0000, '2025-06-22 11:11:48'),
(692, 'MPM-015', 'BARRA REDONDA DE ALUMINIO 6061 DE 5/8 INCH X 3.66 MTS.', NULL, 'MAQUINADOS', 285.00, 8, '2024-11-20 12:03:36', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0158, '2025-06-22 11:11:48'),
(693, 'MPM-017', 'BARRA REDONDA ALUMINIO 6061 DE 5/16 INCH X 3.66 MTS.', NULL, 'MAQUINADOS', 80.00, 12, '2024-11-20 12:09:57', 6, 1, 1, 1, '', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0079, '2025-06-22 11:11:48'),
(694, 'MPM-018', 'BARRA REDONDA DE ALUMINIO 6061 1/4 INCH X 3.66 MTS.', 'Barra', 'MAQUINADO', 48.00, 2, '2024-11-20 12:18:11', 6, 1, 1, 1, 'assets/images/products/product_694.png', 5, 2, 1, 0.0000, 0.0000, 0.0000, 3.6600, 0.0000, 0.0063, '2025-06-27 21:27:29'),
(705, 'producto1', 'producto1', '', 'producto1', 12.00, 12, '2025-06-22 19:37:19', 1, 2, 1, 1, 'assets/images/products/product_705.jpg', 5, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-28 17:38:27'),
(706, 'producto2', 'producto2', 'producto2d', 'producto2', 20.00, 30, '2025-06-28 11:23:02', 2, 17, 1, 1, 'assets/images/products/product_706.jpg', 5, 20, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-28 11:23:02'),
(707, 'producto311', 'producto3', 'producto3', 'producto3', 10.00, 10, '2025-06-28 13:25:51', 3, 11, 1, 1, 'assets/images/products/product_707.jpg', 3, 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-28 13:55:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `subcategory_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`subcategory_id`, `subcategory_name`) VALUES
(1, 'TORNILLERIA COMPRA EXTERNA PARA KIT'),
(2, 'TORNILLERIA MAQUINADOS'),
(3, 'PIEZAS KIT MAQUINADOS'),
(4, 'PIEZAS COMPRA EXTERNA PARA KIT'),
(5, 'SIN SUB CATEGORIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_rfc` varchar(20) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(100) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_rfc`, `supplier_email`, `supplier_phone`, `supplier_address`, `supplier_contact`) VALUES
(1, 'MAPI', 'LOMG900317UX8', 'mapiventas@outlook.com, mapifacturas@outlook.com', '5516579866, 5511629508', 'Torre Ladera, Lt 19/Mz 202, Santa María Guadalupe ...', 'David Castro Monroy'),
(2, 'HIGHER-TOOLS', 'HTO150907A20', 'ventas1@higher-tools.com, facturacion@higher-tools...', '5545022954, 5556087437', '5 DE MAYO, MANZANA 28 LOTE 8, LOS REYES CULHUACAN,...', 'Andres Tello Hurtado'),
(3, 'MAQUINADOS', NULL, 'sup_maquinados@borgatta.com.mx', 'ext. 418', NULL, 'Luis Antonio'),
(4, 'COMPRAS EXTERNAS', NULL, NULL, NULL, NULL, NULL),
(5, 'TONY PAPELERIA', NULL, NULL, NULL, NULL, NULL),
(10, 'MICRO PARTES', 'MPM060610BR1', 'aramirez@micropartes.com.mx', '8127453490', 'Calle: NUEVA YORK No. 4003, Col. INDUSTRIAL HABITA...', 'Azeneth Ramirez'),
(11, 'INGHECO S DE RL DE CV', 'DHI160120JA1', 'francisco.gonzalez@ingheco.com.mx', '5519531412', 'Avenida Hacienda El Roble Mz. 5 Lt...', 'Francisco Gonzalez Gutierrez'),
(12, 'Quantum', 'PMI190325T31', 'thalia.zilch@gpoquantum.com', '5574615084', 'Jorge Washington No 2 PB Col Moderna CP 03510 Ciudad...', 'Thalia M Zilch Cruz'),
(13, 'FIJATEC CITY', 'FCI110511SV8', 'city@fijatec.com', '5555617279', 'Av Azcapotzalco No 742 local A', 'Edgar Medina'),
(14, 'TORNILLOS TOREC', 'TT0230821357', 'ventas1@torec.mx', '3323940278', 'Susana Gomez Palafox #5334 C.P. 45079 Paseos del S...', 'DIEGO ALBERTO BARAJAS MARTINEZ'),
(15, 'INDUSTRIA ANODIZADORA NACIONAL', 'SARA8301082M0', 'electropintarq@gmail.com', '5572580254', 'San Francisco 3 col San Francisco Tlaltenco Tlahua...', 'Sergio Hernandez'),
(16, 'FERNANDO SAUL VALERO ARIAS', 'VAAF700813PWA', 'saul.valero@hotmail.com', '5593132882', 'Circuito Hacienda de San Pablo N° Ext.Mz 19 Lt 68...', 'FERNANDO SAUL VALERO ARIAS'),
(17, 'INFRA', 'INF891031lt4', 'ixtapalucaurbana@infra.com.mx', '5522300455', 'SUCURSAL 107 IXTAPALUCA AV. CUAUHTEMOC NUMERO 240 ...', 'ARMANDO GONZALEZ WHATAPP: 5534926376'),
(18, 'INGENIERIA EN EMPAQUES DURAN', 'IED990212AY6', 'claudia_g.p@hotmail.com', '5511563641', 'Av Henry Ford No. 4111, Col. Gertrudis Sánchez 2a ...', 'CLAUDIA GARCIA PEREZ'),
(19, 'ONLY IMPRESION', 'HEJL941125FL5', 'maytep@onlyimpression.com', '00000000', 'SIN DEFINIR', 'LILIANA VANESSA HERNANDEZ JAIME'),
(23, 'CAJAS Y SERVICIOS MELGAR', 'MERP850326HY2', 'PORDEFINIR2@GMAIL.COM', '558862538', 'AV. INDEPENDENCIA 1 CERRO DEL TEJOLOTE CD 56567 IX...', 'PEDRO MEJIA RAMIREZ'),
(24, 'CPACSA COMERCIALIZADORA DE PORTATROQUELES Y ACCESORIOS', 'CPT840820M37', 'daniel@cpacsa.com', '5557524551', 'AV 45 METROS N.651 SAN BARTOLO ATEPEHUACAN CP. 077...', 'DANIEL'),
(25, 'INNOVATEC', 'IPR910118NJ5', 'ventas@imanesdemexico.com', '018183330709', 'WASHINGTON 2712 PTE. COL. DEPORTOVP OBISPADO MONTE...', 'MAURICIO BOLADO'),
(26, 'FERNANDO SAUL VALERO ARIAS', 'VAAF700813PWA', 'saul.valero@hotmail.com', '5593132882', 'Circuito Hacienda de San Pablo N° Ext.Mz 19 Lt 68...', 'FERNANDO SAUL VALERO ARIAS'),
(27, 'INFRA', 'INF891031lt4', 'ixtapalucaurbana@infra.com.mx', '5522300455', 'SUCURSAL 107 IXTAPALUCA AV. CUAUHTEMOC NUMERO 240 ...', 'ARMANDO GONZALEZ WHATAPP: 5534926376'),
(28, 'INGENIERIA EN EMPAQUES DURAN', 'IED990212AY6', 'claudia_g.p@hotmail.com', '5511563641', 'Av Henry Ford No. 4111, Col. Gertrudis Sánchez 2a ...', 'CLAUDIA GARCIA PEREZ'),
(29, 'ONLY IMPRESION', 'HEJL941125FL5', 'maytep@onlyimpression.com', '00000000', 'SIN DEFINIR', 'LILIANA VANESSA HERNANDEZ JAIME'),
(30, 'PEDRO MEJIA RAMIREZ', 'MERP850326HY2', 'SINCORREO@SIN.COM', '5565560882', 'Avenida Independencia, 1, Cerro del Tejolote, 5656...', 'PEDRO MEJIA RAMIREZ'),
(31, 'Grupo Eléctrico Delta, Victor Manuel Garcia Arteaga', 'GAAV5610016W0', 'ventas@devsa.mx', '59740256', 'Av. Cuauhtémoc 90, Santo Tomas, 56560 Ixtapaluca, ...', 'Victor Manuel Garcia Arteaga'),
(32, 'RAUL JESUS DELGADO BARRIOS', 'DEBR860728U34', 'raul_delgado86@hotmail.com', '7227099856', 'sin especificar', 'RAUL JESUS DELGADO BARRIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1, 'Pieza'),
(2, 'Kilogramos'),
(3, 'Metros'),
(4, 'Centímetros'),
(5, 'Pulgadas'),
(6, 'Milímetros'),
(7, 'Litros'),
(8, 'Par'),
(9, 'Juego'),
(10, 'Gramos'),
(11, 'SERVICIO'),
(12, 'KIT'),
(13, 'MILLAR'),
(14, 'CIENTO');

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
(2, 'administrador2', 'administrador2@gmail.com', '$2y$10$GgtTWrlYykHcv6hednsnKOEJEKyOG5JQmrMnHjX736nL4p6gK2bAW', 6, '2025-03-18 20:15:59', '2025-06-16 23:12:36', ''),
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
(2, 27, 'login', '2025-06-07 13:25:05'),
(3, 27, 'login', '2025-06-08 21:54:20'),
(4, 27, 'login', '2025-06-09 20:02:21'),
(5, 27, 'login', '2025-06-10 19:47:52'),
(6, 27, 'login', '2025-06-10 21:02:52'),
(7, 27, 'login', '2025-06-10 22:06:47'),
(8, 27, 'login', '2025-06-11 14:37:51'),
(9, 27, 'login', '2025-06-11 18:20:29'),
(10, 27, 'login', '2025-06-11 21:55:55'),
(11, 27, 'login', '2025-06-12 10:38:49'),
(12, 27, 'login', '2025-06-12 13:13:09'),
(13, 27, 'login', '2025-06-12 17:25:34'),
(14, 27, 'login', '2025-06-12 21:12:06'),
(15, 27, 'login', '2025-06-13 08:30:44'),
(16, 27, 'login', '2025-06-13 19:30:25'),
(17, 27, 'login', '2025-06-13 20:35:17'),
(18, 27, 'login', '2025-06-14 07:34:38'),
(19, 27, 'login', '2025-06-14 08:39:44'),
(20, 27, 'login', '2025-06-14 11:16:43'),
(21, 27, 'login', '2025-06-14 15:50:03'),
(22, 27, 'login', '2025-06-14 20:22:16'),
(23, 27, 'login', '2025-06-16 16:16:32'),
(24, 27, 'logout', '2025-06-16 17:09:31'),
(25, 46, 'login', '2025-06-16 17:09:43'),
(26, 46, 'logout', '2025-06-16 17:10:02'),
(27, 27, 'login', '2025-06-16 17:10:09'),
(28, 27, 'logout', '2025-06-16 17:12:47'),
(29, 2, 'login', '2025-06-16 17:12:57'),
(30, 2, 'logout', '2025-06-16 17:13:16'),
(31, 27, 'login', '2025-06-16 17:13:25'),
(32, 27, 'login', '2025-06-16 19:43:02'),
(33, 27, 'login', '2025-06-20 14:17:21'),
(34, 27, 'login', '2025-06-21 11:59:26'),
(35, 27, 'login', '2025-06-21 14:54:27'),
(36, 27, 'login', '2025-06-21 17:12:39'),
(37, 27, 'login', '2025-06-21 18:24:41'),
(38, 27, 'login', '2025-06-21 19:25:50'),
(39, 27, 'login', '2025-06-21 22:21:23'),
(40, 27, 'login', '2025-06-22 07:42:58'),
(41, 27, 'login', '2025-06-22 09:34:07'),
(42, 27, 'login', '2025-06-22 11:45:27'),
(43, 27, 'login', '2025-06-22 18:30:54'),
(44, 27, 'login', '2025-06-26 15:56:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indices de la tabla `levels_users`
--
ALTER TABLE `levels_users`
  ADD PRIMARY KEY (`id_level_user`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_supplier` (`supplier_id`),
  ADD KEY `idx_unit` (`unit_id`),
  ADD KEY `idx_currency` (`currency_id`),
  ADD KEY `idx_subcategory` (`subcategory_id`);

--
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indices de la tabla `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

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
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `levels_users`
--
ALTER TABLE `levels_users`
  MODIFY `id_level_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=708;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products-categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products-currencies` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`currency_id`),
  ADD CONSTRAINT `products-subcategorys` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`subcategory_id`),
  ADD CONSTRAINT `products-supliers` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `products-units` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`);

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
