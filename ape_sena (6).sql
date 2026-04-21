-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 03:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ape sena`
--

-- --------------------------------------------------------

--
-- Table structure for table `asesor`
--

CREATE TABLE `asesor` (
  `ase_id` int(11) NOT NULL,
  `ase_nrocontrato` varchar(45) DEFAULT NULL,
  `ase_tipo_asesor` enum('OT','OV') NOT NULL DEFAULT 'OT',
  `ase_vigencia` varchar(45) DEFAULT NULL,
  `ase_password` varchar(255) DEFAULT NULL,
  `ase_correo` varchar(100) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL,
  `ase_foto` varchar(255) DEFAULT 'images/foto de perfil.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asesor`
--

INSERT INTO `asesor` (`ase_id`, `ase_nrocontrato`, `ase_tipo_asesor`, `ase_vigencia`, `ase_password`, `ase_correo`, `PERSONA_pers_doc`, `ase_foto`) VALUES
(2, NULL, 'OT', NULL, '123456', 'asesor@sena.edu.co', 12345678, 'images/foto de perfil.jpg'),
(3, NULL, 'OV', NULL, '123456', 'asesor1@sena.edu.co', 11111111, 'images/foto de perfil.jpg'),
(4, NULL, 'OT', NULL, '123456', 'asesor2@sena.edu.co', 22222222, 'images/foto de perfil.jpg'),
(6, 'CONT-2026', 'OT', '2027-12-31', '123456', 'asesor@sena.edu.co', 20002000, 'images/foto de perfil.jpg'),
(7, 'CONT-2026', 'OT', '2027-12-31', '123456', 'asesor@sena.edu.co', 20002000, 'images/foto de perfil.jpg'),
(8, 'CONT-2026102', 'OT', '2027-03-25', '$2y$12$vV5WzyLdf764PTIXRK9DnewI7DEIZX1CNybUR/8MuCKTdtuP2jqmm', 'juanbayona@sena.edu.co', 1092529985, 'images/foto de perfil.jpg'),
(9, 'CONT-2026204', 'OT', '2027-03-25', '$2y$12$TtwkE6xf08.YKCSqh2HQ9Otsjigs1Jb2.8J0lEF8Et2mIYoDCk9.m', 'mariac@sena.edu.co', 123456789, 'images/foto de perfil.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `atencion`
--

CREATE TABLE `atencion` (
  `atnc_id` int(11) NOT NULL,
  `atnc_hora_inicio` datetime DEFAULT NULL,
  `atnc_hora_fin` datetime DEFAULT NULL,
  `atnc_tipo` enum('General','Prioritaria','Victimas') NOT NULL,
  `ASESOR_ase_id` int(11) DEFAULT NULL,
  `TURNO_tur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atencion`
--

INSERT INTO `atencion` (`atnc_id`, `atnc_hora_inicio`, `atnc_hora_fin`, `atnc_tipo`, `ASESOR_ase_id`, `TURNO_tur_id`) VALUES
(5, '2026-03-23 22:20:17', '2026-03-25 13:11:01', 'Victimas', 3, 10),
(6, '2026-03-23 22:52:02', '2026-03-23 22:52:10', 'General', 4, 11),
(7, '2026-03-23 23:43:27', '2026-03-24 00:02:41', 'Prioritaria', 2, 13),
(8, '2026-03-24 13:48:16', '2026-04-05 19:50:52', 'Prioritaria', 4, 14),
(9, '2026-04-05 19:12:43', '2026-04-05 19:51:23', 'Victimas', 3, 16),
(10, '2026-04-05 19:23:20', '2026-04-05 20:14:43', 'Victimas', 3, 20),
(11, '2026-04-05 19:23:39', '2026-04-05 19:50:56', 'Prioritaria', 4, 18),
(12, '2026-04-05 19:41:46', '2026-04-05 19:51:05', 'Prioritaria', 4, 22),
(13, '2026-04-05 19:42:01', '2026-04-05 20:14:52', 'Victimas', 3, 24),
(14, '2026-04-05 19:42:10', '2026-04-05 20:14:53', 'Victimas', 3, 26),
(15, '2026-04-05 19:46:29', '2026-04-05 20:14:55', 'Victimas', 3, 27),
(16, '2026-04-05 19:50:47', '2026-04-05 20:06:12', 'Prioritaria', 4, 23),
(17, '2026-04-05 19:51:00', '2026-04-05 20:14:26', 'General', 4, 17),
(18, '2026-04-05 20:05:54', '2026-04-20 16:09:02', 'General', 4, 19),
(19, '2026-04-05 20:05:59', '2026-04-20 16:09:04', 'General', 4, 21),
(20, '2026-04-05 20:06:14', '2026-04-20 16:09:05', 'General', 4, 25),
(21, '2026-04-05 20:14:50', '2026-04-21 01:23:34', 'Victimas', 3, 28),
(22, '2026-04-20 16:11:46', '2026-04-21 00:50:58', 'Prioritaria', 4, 31),
(23, '2026-04-21 01:03:22', NULL, 'Prioritaria', 4, 33),
(24, '2026-04-21 01:25:56', '2026-04-21 01:34:37', 'General', 3, 36),
(25, '2026-04-21 01:34:36', NULL, 'Prioritaria', 3, 32);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-53f11be06b43e2ad45a869078b38dfd8', 'i:1;', 1776701529),
('laravel-cache-53f11be06b43e2ad45a869078b38dfd8:timer', 'i:1776701529;', 1776701529),
('laravel-cache-ef855c70c9e517abb1c7e71b78a2eded', 'i:1;', 1776735318),
('laravel-cache-ef855c70c9e517abb1c7e71b78a2eded:timer', 'i:1776735318;', 1776735318);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coordinador`
--

CREATE TABLE `coordinador` (
  `coor_id` int(11) NOT NULL,
  `coor_vigencia` varchar(45) DEFAULT NULL,
  `coor_correo` varchar(100) DEFAULT NULL,
  `coor_password` varchar(100) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinador`
--

INSERT INTO `coordinador` (`coor_id`, `coor_vigencia`, `coor_correo`, `coor_password`, `PERSONA_pers_doc`) VALUES
(1, '2027-12-31', 'coordinador@sena.edu.co', 'coord2026', 9000000001),
(4, '2027-12-31', 'coordinador@sena.edu.co', 'coord2026', 9000000001);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_21_032735_change_pers_doc_to_bigint_on_multiple_tables', 2),
(5, '2026_04_15_000001_add_fields_to_turno_table', 3),
(6, '2026_04_15_000002_create_pausas_asesor_table', 4),
(7, '2026_04_20_000001_add_hora_llamado_to_turno_table', 5),
(8, '2026_04_20_000002_standardize_ase_tipo_asesor', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pausas_asesor`
--

CREATE TABLE `pausas_asesor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ASESOR_ase_id` int(10) UNSIGNED NOT NULL,
  `hora_inicio` datetime NOT NULL,
  `hora_fin` datetime DEFAULT NULL,
  `duracion` int(10) UNSIGNED DEFAULT NULL COMMENT 'Duración en minutos',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pausas_asesor`
--

INSERT INTO `pausas_asesor` (`id`, `ASESOR_ase_id`, `hora_inicio`, `hora_fin`, `duracion`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-04-20 16:09:07', '2026-04-20 16:09:17', 0, '2026-04-20 21:09:07', '2026-04-20 21:09:17'),
(2, 4, '2026-04-20 16:09:24', '2026-04-20 16:09:29', 0, '2026-04-20 21:09:24', '2026-04-20 21:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `pers_doc` bigint(20) UNSIGNED NOT NULL,
  `pers_tipodoc` varchar(45) DEFAULT NULL,
  `pers_nombres` varchar(100) DEFAULT NULL,
  `pers_apellidos` varchar(100) DEFAULT NULL,
  `pers_telefono` bigint(10) DEFAULT NULL,
  `pers_fecha_nac` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`pers_doc`, `pers_tipodoc`, `pers_nombres`, `pers_apellidos`, `pers_telefono`, `pers_fecha_nac`) VALUES
(0, 'CC', 'Usuario', 'Kiosco', 8888888888, NULL),
(123, 'CC', 'Test', 'User', NULL, NULL),
(186342, 'CE', 'Usuario', 'Kiosco', 3228574190, NULL),
(205741, 'CC', 'Usuario', 'Kiosco', 3205417580, NULL),
(208547, 'CE', 'Usuario', 'Kiosco', 3521470956, NULL),
(208657, 'CC', 'Usuario', 'Kiosco', 3903507210, NULL),
(555555, 'TI', 'Usuario', 'Kiosco', 355284800, NULL),
(2507540, 'CC', 'Usuario', 'Kiosco', 3603207510, NULL),
(7777777, 'CC', 'pepito', 'Kiosco', 0, NULL),
(8051082, 'CC', 'Usuario', 'Kiosco', 3103207240, NULL),
(8888888, 'CC', 'Usuario', 'Kiosco', 5555555, NULL),
(10001000, 'CC', 'Carlos Coord', 'Administrador', 3001234567, NULL),
(11111111, 'CC', 'Asesor 1', 'Especializado', 3001111111, '1990-01-01 00:00:00'),
(12345678, 'CC', 'Asesor', 'Pruebas', 3000000000, '1990-01-01 00:00:00'),
(20002000, 'CC', 'Ana Asesor', 'Servicio', 3109876543, NULL),
(20567120, 'CC', 'Usuario', 'Kiosco', 361320457, NULL),
(22222222, 'CC', 'Asesor 2', 'General', 3002222222, '1990-01-01 00:00:00'),
(28888888, 'CC', 'Usuario', 'Kiosco', 3200082408, NULL),
(55555555, 'CC', 'Usuario', 'Kiosco', 332415720, NULL),
(60321456, 'CC', 'Usuario', 'Kiosco', 3229615723, NULL),
(87654321, 'CC', 'Andres', 'General', NULL, '1990-01-01 00:00:00'),
(111111111, 'CC', 'Usuario', 'Kiosco', 888888, NULL),
(120365584, 'CC', 'Usuario', 'Kiosco', 3222222222, NULL),
(123456789, 'CC', 'Test', 'User', 3000000000, NULL),
(147895320, 'CC', 'Usuario', 'Kiosco', 380350724, NULL),
(300000000, 'NIT', 'Usuario', 'Kiosco', 3208443, NULL),
(444444444, 'CC', 'Usuario', 'Kiosco', 320587410, NULL),
(666666666, 'CC', 'Usuario', 'Kiosco', 3204874699, NULL),
(777777777, 'CE', 'Usuario', 'Kiosco', 360265417, NULL),
(1000000001, 'CC', 'Coordinador', 'Principal SENA', 3000000000, NULL),
(1062576432, 'CC', 'Usuario', 'Kiosco', 322715489, NULL),
(1092529985, 'CC', 'Usuario', 'Kiosco', 3207241503, NULL),
(2222222222, 'CC', 'Usuario', 'Kiosco', 3603102478, NULL),
(9000000001, 'CC', 'Coordinador', 'SENA APE', 3000000001, NULL),
(10125725412, 'CC', 'Usuario', 'Kiosco', 350321470, NULL),
(11111111111, 'CC', 'Usuario', 'Kiosco', 88888877, NULL),
(77777777777, 'TI', 'Usuario', 'Kiosco', 8888888888, NULL),
(99999999999, 'CC', 'Usuario', 'Kiosco', 7777777777, NULL),
(111111111111, 'CC', 'Usuario', 'Kiosco', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `solicitante`
--

CREATE TABLE `solicitante` (
  `sol_id` int(11) NOT NULL,
  `sol_tipo` varchar(45) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solicitante`
--

INSERT INTO `solicitante` (`sol_id`, `sol_tipo`, `PERSONA_pers_doc`) VALUES
(1, 'Externo', 1092529985),
(2, 'Externo', 2222222222),
(3, 'Externo', 55555555),
(4, 'Externo', 8888888),
(5, 'Externo', 666666666),
(6, 'General', 123),
(7, 'Externo', 7777777),
(8, 'Externo', 1062576432),
(9, 'Externo', 123456789),
(10, 'Externo', 555555),
(11, NULL, 300000000),
(12, 'Externo', 120365584),
(13, 'Externo', 111111111111),
(14, 'Externo', 0),
(15, 'Externo', 444444444),
(16, 'Externo', 99999999999),
(17, 'Externo', 111111111),
(18, 'Externo', 10125725412),
(19, 'Externo', 60321456),
(20, 'Externo', 20567120),
(21, 'Externo', 11111111111),
(22, 'Externo', 777777777),
(23, 'Externo', 77777777777),
(24, 'Externo', 147895320),
(25, 'Prioritario', 186342),
(26, 'Empresario', 205741),
(27, 'Prioritario', 2507540),
(28, 'General', 208657),
(29, 'Prioritario', 8051082),
(30, 'Victima', 208547),
(31, 'Prioritario', 28888888);

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `tur_id` int(11) NOT NULL,
  `tur_hora_fecha` datetime DEFAULT NULL,
  `tur_hora_llamado` datetime DEFAULT NULL COMMENT 'Timestamp cuando el asesor llama al turno (CU-02)',
  `tur_numero` varchar(45) DEFAULT NULL,
  `tur_tipo` enum('General','Prioritario','Victimas') NOT NULL,
  `tur_perfil` enum('General','Víctima','Prioritario','Empresario') NOT NULL DEFAULT 'General',
  `tur_tipo_atencion` enum('Normal','Especial') NOT NULL DEFAULT 'Normal',
  `tur_servicio` enum('Orientación','Formación','Emprendimiento') NOT NULL DEFAULT 'Orientación',
  `tur_telefono` varchar(20) DEFAULT NULL,
  `SOLICITANTE_sol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`tur_id`, `tur_hora_fecha`, `tur_hora_llamado`, `tur_numero`, `tur_tipo`, `tur_perfil`, `tur_tipo_atencion`, `tur_servicio`, `tur_telefono`, `SOLICITANTE_sol_id`) VALUES
(1, '2026-03-21 02:44:11', NULL, 'G-001', 'General', 'General', 'Normal', 'Orientación', NULL, 1),
(2, '2026-03-21 02:47:50', NULL, 'V-001', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 1),
(3, '2026-03-21 03:32:14', NULL, 'P-001', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 2),
(4, '2026-03-21 03:32:33', NULL, 'P-002', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 3),
(5, '2026-03-22 02:09:34', NULL, 'P-001', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 4),
(6, '2026-03-22 02:12:02', NULL, 'G-001', 'General', 'General', 'Normal', 'Orientación', NULL, 5),
(7, '2026-03-22 02:38:35', NULL, 'G-999', 'General', 'General', 'Normal', 'Orientación', NULL, 6),
(8, '2026-03-22 02:39:42', NULL, 'G-999', 'General', 'General', 'Normal', 'Orientación', NULL, 6),
(9, '2026-03-22 03:14:58', NULL, 'B-002', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 1),
(10, '2026-03-23 22:03:18', NULL, 'A-001', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 7),
(11, '2026-03-23 22:46:10', NULL, 'C-001', 'General', 'General', 'Normal', 'Orientación', NULL, 8),
(12, '2026-03-23 23:19:52', NULL, 'C-002', 'General', 'General', 'Normal', 'Orientación', NULL, 9),
(13, '2026-03-23 23:22:35', NULL, 'B-001', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 10),
(14, '2026-03-24 13:47:27', NULL, 'B-001', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 3),
(15, '2026-03-25 20:51:03', NULL, 'C-001', 'General', 'General', 'Normal', 'Orientación', NULL, 11),
(16, '2026-04-05 03:53:38', NULL, 'A-001', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 12),
(17, '2026-04-05 03:55:59', NULL, 'C-001', 'General', 'General', 'Normal', 'Orientación', NULL, 13),
(18, '2026-04-05 03:56:29', NULL, 'B-001', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 14),
(19, '2026-04-05 03:57:48', NULL, 'C-002', 'General', 'General', 'Normal', 'Orientación', NULL, 15),
(20, '2026-04-05 03:59:34', NULL, 'A-002', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 16),
(21, '2026-04-05 04:06:35', NULL, 'C-003', 'General', 'General', 'Normal', 'Orientación', NULL, 17),
(22, '2026-04-05 19:14:46', NULL, 'B-002', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 18),
(23, '2026-04-05 19:21:01', NULL, 'B-003', 'Prioritario', 'General', 'Normal', 'Orientación', NULL, 19),
(24, '2026-04-05 19:23:07', NULL, 'A-003', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 20),
(25, '2026-04-05 19:24:10', NULL, 'C-004', 'General', 'General', 'Normal', 'Orientación', NULL, 21),
(26, '2026-04-05 19:39:38', NULL, 'A-004', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 22),
(27, '2026-04-05 19:46:19', NULL, 'A-005', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 23),
(28, '2026-04-05 20:13:23', NULL, 'A-006', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 24),
(29, '2026-04-05 20:25:37', NULL, 'A-007', 'Victimas', 'General', 'Normal', 'Orientación', NULL, 2),
(30, '2026-04-15 03:18:25', NULL, 'E-001', 'Prioritario', 'Empresario', 'Especial', 'Orientación', NULL, 21),
(31, '2026-04-20 16:11:09', NULL, 'P-001', 'Prioritario', 'Prioritario', 'Normal', 'Formación', NULL, 25),
(32, '2026-04-21 00:50:10', '2026-04-21 01:34:36', 'E-001', 'Prioritario', 'Empresario', 'Especial', 'Formación', NULL, 26),
(33, '2026-04-21 00:54:37', '2026-04-21 01:03:22', 'P-001', 'Prioritario', 'Prioritario', 'Normal', 'Orientación', NULL, 27),
(34, '2026-04-21 00:56:12', NULL, 'G-001', 'General', 'General', 'Normal', 'Orientación', NULL, 28),
(35, '2026-04-21 01:03:11', NULL, 'P-002', 'Prioritario', 'Prioritario', 'Normal', 'Orientación', NULL, 29),
(36, '2026-04-21 01:25:47', '2026-04-21 01:25:56', 'V-001', 'Victimas', 'Víctima', 'Normal', 'Orientación', NULL, 30),
(37, '2026-04-21 01:34:18', NULL, 'P-003', 'Prioritario', 'Prioritario', 'Especial', 'Emprendimiento', NULL, 31);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asesor`
--
ALTER TABLE `asesor`
  ADD PRIMARY KEY (`ase_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);

--
-- Indexes for table `atencion`
--
ALTER TABLE `atencion`
  ADD PRIMARY KEY (`atnc_id`),
  ADD KEY `ASESOR_ase_id` (`ASESOR_ase_id`),
  ADD KEY `TURNO_tur_id` (`TURNO_tur_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`coor_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pausas_asesor`
--
ALTER TABLE `pausas_asesor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`pers_doc`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`sol_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`tur_id`),
  ADD KEY `SOLICITANTE_sol_id` (`SOLICITANTE_sol_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asesor`
--
ALTER TABLE `asesor`
  MODIFY `ase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `atencion`
--
ALTER TABLE `atencion`
  MODIFY `atnc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `coor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pausas_asesor`
--
ALTER TABLE `pausas_asesor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `sol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `tur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asesor`
--
ALTER TABLE `asesor`
  ADD CONSTRAINT `asesor_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);

--
-- Constraints for table `atencion`
--
ALTER TABLE `atencion`
  ADD CONSTRAINT `atencion_ibfk_1` FOREIGN KEY (`ASESOR_ase_id`) REFERENCES `asesor` (`ase_id`),
  ADD CONSTRAINT `atencion_ibfk_2` FOREIGN KEY (`TURNO_tur_id`) REFERENCES `turno` (`tur_id`);

--
-- Constraints for table `coordinador`
--
ALTER TABLE `coordinador`
  ADD CONSTRAINT `coordinador_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);

--
-- Constraints for table `solicitante`
--
ALTER TABLE `solicitante`
  ADD CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);

--
-- Constraints for table `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `turno_ibfk_1` FOREIGN KEY (`SOLICITANTE_sol_id`) REFERENCES `solicitante` (`sol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
