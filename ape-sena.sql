-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 29-04-2026 a las 18:32:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Base de datos: `ape sena`
--

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `asesor`
--

CREATE TABLE `asesor` (
  `ase_id` int(11) NOT NULL,
  `ase_nrocontrato` varchar(45) DEFAULT NULL,
  `ase_tipo_asesor` enum('OT', 'OV') NOT NULL DEFAULT 'OT',
  `ase_vigencia` varchar(45) DEFAULT NULL,
  `ase_password` varchar(255) DEFAULT NULL,
  `ase_correo` varchar(100) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL,
  `ase_foto` varchar(255) DEFAULT 'images/foto de perfil.jpg'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `asesor`
--

INSERT INTO `asesor` (
    `ase_id`,
    `ase_nrocontrato`,
    `ase_tipo_asesor`,
    `ase_vigencia`,
    `ase_password`,
    `ase_correo`,
    `PERSONA_pers_doc`,
    `ase_foto`
  )
VALUES (
    2,
    NULL,
    'OT',
    NULL,
    'asesorprueba',
    'asesorprueba@sena.edu.co',
    12345678,
    'images/foto de perfil.jpg'
  ),
  (
    3,
    NULL,
    'OV',
    NULL,
    'asesor123',
    'asesor1@sena.edu.co',
    11111111,
    'images/foto de perfil.jpg'
  ),
  (
    4,
    NULL,
    'OT',
    NULL,
    'asesor234',
    'asesor2@sena.edu.co',
    22222222,
    'images/foto de perfil.jpg'
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `atencion`
--

CREATE TABLE `atencion` (
  `atnc_id` int(11) NOT NULL,
  `atnc_hora_inicio` datetime DEFAULT NULL,
  `atnc_hora_fin` datetime DEFAULT NULL,
  `atnc_tipo` enum('General', 'Prioritaria', 'Victimas') NOT NULL,
  `ASESOR_ase_id` int(11) DEFAULT NULL,
  `TURNO_tur_id` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `atencion`
--

INSERT INTO `atencion` (
    `atnc_id`,
    `atnc_hora_inicio`,
    `atnc_hora_fin`,
    `atnc_tipo`,
    `ASESOR_ase_id`,
    `TURNO_tur_id`
  )
VALUES (
    5,
    '2026-03-23 22:20:17',
    '2026-03-25 13:11:01',
    'Victimas',
    3,
    10
  ),
  (
    6,
    '2026-03-23 22:52:02',
    '2026-03-23 22:52:10',
    'General',
    4,
    11
  ),
  (
    7,
    '2026-03-23 23:43:27',
    '2026-03-24 00:02:41',
    'Prioritaria',
    2,
    13
  ),
  (
    8,
    '2026-03-24 13:48:16',
    '2026-04-05 19:50:52',
    'Prioritaria',
    4,
    14
  ),
  (
    9,
    '2026-04-05 19:12:43',
    '2026-04-05 19:51:23',
    'Victimas',
    3,
    16
  ),
  (
    10,
    '2026-04-05 19:23:20',
    '2026-04-05 20:14:43',
    'Victimas',
    3,
    20
  ),
  (
    11,
    '2026-04-05 19:23:39',
    '2026-04-05 19:50:56',
    'Prioritaria',
    4,
    18
  ),
  (
    12,
    '2026-04-05 19:41:46',
    '2026-04-05 19:51:05',
    'Prioritaria',
    4,
    22
  ),
  (
    13,
    '2026-04-05 19:42:01',
    '2026-04-05 20:14:52',
    'Victimas',
    3,
    24
  ),
  (
    14,
    '2026-04-05 19:42:10',
    '2026-04-05 20:14:53',
    'Victimas',
    3,
    26
  ),
  (
    15,
    '2026-04-05 19:46:29',
    '2026-04-05 20:14:55',
    'Victimas',
    3,
    27
  ),
  (
    16,
    '2026-04-05 19:50:47',
    '2026-04-05 20:06:12',
    'Prioritaria',
    4,
    23
  ),
  (
    17,
    '2026-04-05 19:51:00',
    '2026-04-05 20:14:26',
    'General',
    4,
    17
  ),
  (
    18,
    '2026-04-05 20:05:54',
    '2026-04-20 16:09:02',
    'General',
    4,
    19
  ),
  (
    19,
    '2026-04-05 20:05:59',
    '2026-04-20 16:09:04',
    'General',
    4,
    21
  ),
  (
    20,
    '2026-04-05 20:06:14',
    '2026-04-20 16:09:05',
    'General',
    4,
    25
  ),
  (
    21,
    '2026-04-05 20:14:50',
    '2026-04-21 01:23:34',
    'Victimas',
    3,
    28
  ),
  (
    22,
    '2026-04-20 16:11:46',
    '2026-04-21 00:50:58',
    'Prioritaria',
    4,
    31
  ),
  (
    23,
    '2026-04-21 01:03:22',
    '2026-04-22 21:57:24',
    'Prioritaria',
    4,
    33
  ),
  (
    24,
    '2026-04-21 01:25:56',
    '2026-04-21 01:34:37',
    'General',
    3,
    36
  ),
  (
    25,
    '2026-04-21 01:34:36',
    '2026-04-22 21:22:05',
    'Prioritaria',
    3,
    32
  ),
  (
    26,
    '2026-04-22 21:57:26',
    '2026-04-22 22:19:24',
    'General',
    4,
    38
  ),
  (
    27,
    '2026-04-22 21:57:44',
    '2026-04-22 21:57:49',
    'General',
    3,
    39
  ),
  (
    66,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    225
  ),
  (
    67,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    227
  ),
  (
    68,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    229
  ),
  (
    69,
    '2026-04-26 03:59:01',
    NULL,
    'General',
    2,
    224
  ),
  (
    70,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    231
  ),
  (
    71,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    233
  ),
  (
    72,
    '2026-04-26 03:59:01',
    NULL,
    'Prioritaria',
    2,
    235
  ),
  (
    73,
    '2026-04-26 03:59:01',
    NULL,
    'General',
    2,
    226
  ),
  (
    74,
    '2026-04-26 03:59:01',
    '2026-04-26 04:04:28',
    'Prioritaria',
    3,
    265
  ),
  (
    75,
    '2026-04-26 03:59:01',
    '2026-04-29 14:33:49',
    'Prioritaria',
    3,
    267
  ),
  (
    76,
    '2026-04-26 03:59:01',
    '2026-04-29 16:04:46',
    'Prioritaria',
    3,
    269
  ),
  (
    77,
    '2026-04-26 03:59:01',
    '2026-04-29 16:04:52',
    'Prioritaria',
    3,
    271
  ),
  (
    78,
    '2026-04-26 03:59:12',
    '2026-04-29 14:34:08',
    'Prioritaria',
    4,
    237
  ),
  (
    79,
    '2026-04-26 04:00:03',
    '2026-04-29 14:34:11',
    'Prioritaria',
    4,
    239
  ),
  (
    80,
    '2026-04-26 04:00:26',
    '2026-04-29 16:04:54',
    'Prioritaria',
    3,
    273
  ),
  (
    81,
    '2026-04-26 04:11:14',
    '2026-04-29 16:04:56',
    'Prioritaria',
    3,
    275
  ),
  (
    82,
    '2026-04-29 14:34:06',
    '2026-04-29 15:43:53',
    'Prioritaria',
    4,
    285
  ),
  (
    83,
    '2026-04-29 15:43:59',
    '2026-04-29 15:46:22',
    'General',
    4,
    286
  ),
  (
    84,
    '2026-04-29 15:49:48',
    '2026-04-29 15:51:14',
    'Prioritaria',
    4,
    287
  ),
  (
    85,
    '2026-04-29 16:01:14',
    '2026-04-29 16:04:25',
    'Prioritaria',
    4,
    288
  ),
  (
    86,
    '2026-04-29 16:04:49',
    '2026-04-29 16:04:58',
    'General',
    3,
    289
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`)
VALUES (
    'laravel-cache-53f11be06b43e2ad45a869078b38dfd8',
    'i:1;',
    1776701529
  ),
  (
    'laravel-cache-53f11be06b43e2ad45a869078b38dfd8:timer',
    'i:1776701529;',
    1776701529
  ),
  (
    'laravel-cache-ef855c70c9e517abb1c7e71b78a2eded',
    'i:1;',
    1777479202
  ),
  (
    'laravel-cache-ef855c70c9e517abb1c7e71b78a2eded:timer',
    'i:1777479202;',
    1777479202
  ),
  (
    'laravel-cache-prioritario_counter',
    'i:1;',
    1777564874
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `coor_id` int(11) NOT NULL,
  `coor_vigencia` varchar(45) DEFAULT NULL,
  `coor_correo` varchar(100) DEFAULT NULL,
  `coor_password` varchar(100) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (
    `coor_id`,
    `coor_vigencia`,
    `coor_correo`,
    `coor_password`,
    `PERSONA_pers_doc`
  )
VALUES (
    4,
    '2027-12-31',
    'coordinador@sena.edu.co',
    'coord2026',
    9000000001
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `job_batches`
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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (1, '0001_01_01_000000_create_users_table', 1),
  (2, '0001_01_01_000001_create_cache_table', 1),
  (3, '0001_01_01_000002_create_jobs_table', 1),
  (
    4,
    '2026_03_21_032735_change_pers_doc_to_bigint_on_multiple_tables',
    2
  ),
  (
    5,
    '2026_04_15_000001_add_fields_to_turno_table',
    3
  ),
  (
    6,
    '2026_04_15_000002_create_pausas_asesor_table',
    4
  ),
  (
    7,
    '2026_04_20_000001_add_hora_llamado_to_turno_table',
    5
  ),
  (
    8,
    '2026_04_20_000002_standardize_ase_tipo_asesor',
    6
  ),
  (
    9,
    '2026_04_22_024747_add_triggers_to_pausas_asesor',
    7
  ),
  (10, '2026_04_25_225000_optimize_turno_table', 8),
  (
    11,
    '2026_04_29_000001_add_estado_to_turno_table',
    9
  ),
  (
    12,
    '2026_04_29_000002_add_credentials_to_coordinador_table',
    9
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `pausas_asesor`
--

CREATE TABLE `pausas_asesor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ASESOR_ase_id` int(10) UNSIGNED NOT NULL,
  `hora_inicio` datetime NOT NULL,
  `hora_fin` datetime DEFAULT NULL,
  `duracion` int(10) UNSIGNED DEFAULT NULL COMMENT 'Duración en minutos',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Volcado de datos para la tabla `pausas_asesor`
--

INSERT INTO `pausas_asesor` (
    `id`,
    `ASESOR_ase_id`,
    `hora_inicio`,
    `hora_fin`,
    `duracion`,
    `created_at`,
    `updated_at`
  )
VALUES (
    1,
    4,
    '2026-04-20 16:09:07',
    '2026-04-20 16:09:17',
    0,
    '2026-04-20 21:09:07',
    '2026-04-20 21:09:17'
  ),
  (
    2,
    4,
    '2026-04-20 16:09:24',
    '2026-04-20 16:09:29',
    0,
    '2026-04-20 21:09:24',
    '2026-04-20 21:09:29'
  ),
  (
    3,
    2,
    '2026-04-22 19:43:26',
    '2026-04-22 19:43:29',
    0,
    '2026-04-23 00:43:26',
    '2026-04-23 00:43:29'
  ),
  (
    4,
    3,
    '2026-04-22 21:22:07',
    '2026-04-22 21:22:10',
    0,
    '2026-04-23 02:22:07',
    '2026-04-23 02:22:10'
  ),
  (
    5,
    4,
    '2026-04-22 22:19:27',
    '2026-04-22 22:19:29',
    0,
    '2026-04-23 03:19:27',
    '2026-04-23 03:19:29'
  ),
  (
    6,
    4,
    '2026-04-22 22:19:31',
    '2026-04-22 22:21:42',
    2,
    '2026-04-23 03:19:31',
    '2026-04-23 03:21:42'
  ),
  (
    7,
    4,
    '2026-04-29 15:46:39',
    '2026-04-29 15:46:43',
    0,
    '2026-04-29 20:46:39',
    '2026-04-29 20:46:43'
  ),
  (
    8,
    4,
    '2026-04-29 15:46:49',
    '2026-04-29 15:47:54',
    1,
    '2026-04-29 20:46:49',
    '2026-04-29 20:47:54'
  );
--
-- Disparadores `pausas_asesor`
--
DELIMITER $$
CREATE TRIGGER `trg_calc_duracion_receso` BEFORE
UPDATE ON `pausas_asesor` FOR EACH ROW BEGIN IF NEW.hora_fin IS NOT NULL
  AND OLD.hora_fin IS NULL THEN
SET NEW.duracion = TIMESTAMPDIFF(MINUTE, NEW.hora_inicio, NEW.hora_fin);
END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `trg_evitar_doble_receso` BEFORE
INSERT ON `pausas_asesor` FOR EACH ROW BEGIN
DECLARE pausas_abiertas INT;
SELECT COUNT(*) INTO pausas_abiertas
FROM pausas_asesor
WHERE ASESOR_ase_id = NEW.ASESOR_ase_id
  AND hora_fin IS NULL;
IF pausas_abiertas > 0 THEN SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'ERROR: El asesor ya tiene un receso activo en curso.';
END IF;
END $$
DELIMITER ;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `pers_doc` bigint(20) UNSIGNED NOT NULL,
  `pers_tipodoc` varchar(45) DEFAULT NULL,
  `pers_nombres` varchar(100) DEFAULT NULL,
  `pers_apellidos` varchar(100) DEFAULT NULL,
  `pers_telefono` bigint(10) DEFAULT NULL,
  `pers_fecha_nac` datetime DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (
    `pers_doc`,
    `pers_tipodoc`,
    `pers_nombres`,
    `pers_apellidos`,
    `pers_telefono`,
    `pers_fecha_nac`
  )
VALUES (0, 'CC', 'Usuario', 'Kiosco', 8888888888, NULL),
  (123, 'CC', 'Test', 'User', NULL, NULL),
  (
    186342,
    'CE',
    'Usuario',
    'Kiosco',
    3228574190,
    NULL
  ),
  (
    205741,
    'CC',
    'Usuario',
    'Kiosco',
    3205417580,
    NULL
  ),
  (
    208547,
    'CE',
    'Usuario',
    'Kiosco',
    3521470956,
    NULL
  ),
  (
    208657,
    'CC',
    'Usuario',
    'Kiosco',
    3903507210,
    NULL
  ),
  (
    250859,
    'CC',
    'Usuario',
    'Kiosco',
    3603904155,
    NULL
  ),
  (
    555555,
    'TI',
    'Usuario',
    'Kiosco',
    355284800,
    NULL
  ),
  (
    624538,
    'CC',
    'Usuario',
    'Kiosco',
    3203604472,
    NULL
  ),
  (
    627458,
    'CC',
    'Usuario',
    'Kiosco',
    3213244157,
    NULL
  ),
  (
    2507540,
    'CC',
    'Usuario',
    'Kiosco',
    3603207510,
    NULL
  ),
  (7777777, 'CC', 'pepito', 'Kiosco', 0, NULL),
  (
    8051082,
    'CC',
    'Usuario',
    'Kiosco',
    3103207240,
    NULL
  ),
  (
    8888888,
    'CC',
    'Usuario',
    'Kiosco',
    5555555,
    NULL
  ),
  (
    10001000,
    'CC',
    'Carlos Coord',
    'Administrador',
    3001234567,
    NULL
  ),
  (
    10203040,
    'CC',
    'Ciudadano',
    'Prueba',
    NULL,
    NULL
  ),
  (
    11111111,
    'CC',
    'Asesor 1',
    'Especializado',
    3001111111,
    '1990-01-01 00:00:00'
  ),
  (
    12345678,
    'CC',
    'Asesor',
    'Pruebas',
    3000000000,
    '1990-01-01 00:00:00'
  ),
  (
    20002000,
    'CC',
    'Ana Asesor',
    'Servicio',
    3109876543,
    NULL
  ),
  (
    20567120,
    'CC',
    'Usuario',
    'Kiosco',
    361320457,
    NULL
  ),
  (
    22222222,
    'CC',
    'Usuario',
    'Kiosco',
    3229615724,
    '1990-01-01 00:00:00'
  ),
  (
    28888888,
    'CC',
    'Usuario',
    'Kiosco',
    3200082408,
    NULL
  ),
  (
    55555555,
    'CC',
    'Usuario',
    'Kiosco',
    332415720,
    NULL
  ),
  (
    60321456,
    'CC',
    'Usuario',
    'Kiosco',
    3229615723,
    NULL
  ),
  (
    60356258,
    'CE',
    'Usuario',
    'Kiosco',
    3603207512,
    NULL
  ),
  (
    87654321,
    'CC',
    'Andres',
    'General',
    NULL,
    '1990-01-01 00:00:00'
  ),
  (
    111111111,
    'CC',
    'Usuario',
    'Kiosco',
    888888,
    NULL
  ),
  (
    120365584,
    'CC',
    'Usuario',
    'Kiosco',
    3222222222,
    NULL
  ),
  (
    123456789,
    'CC',
    'Test',
    'User',
    3000000000,
    NULL
  ),
  (
    147895320,
    'CC',
    'Usuario',
    'Kiosco',
    380350724,
    NULL
  ),
  (
    300000000,
    'NIT',
    'Usuario',
    'Kiosco',
    3208443,
    NULL
  ),
  (
    444444444,
    'CC',
    'Usuario',
    'Kiosco',
    320587410,
    NULL
  ),
  (
    666666666,
    'CC',
    'Usuario',
    'Kiosco',
    3204874699,
    NULL
  ),
  (
    777777777,
    'CE',
    'Usuario',
    'Kiosco',
    360265417,
    NULL
  ),
  (
    1000000001,
    'CC',
    'Coordinador',
    'Principal SENA',
    3000000000,
    NULL
  ),
  (
    1062576432,
    'CC',
    'Usuario',
    'Kiosco',
    322715489,
    NULL
  ),
  (
    1092529985,
    'CC',
    'Usuario',
    'Kiosco',
    3229615724,
    NULL
  ),
  (
    2222222222,
    'CC',
    'Usuario',
    'Kiosco',
    3603102478,
    NULL
  ),
  (
    9000000001,
    'CC',
    'Coordinador',
    'SENA APE',
    3000000001,
    NULL
  ),
  (
    10125725412,
    'CC',
    'Usuario',
    'Kiosco',
    350321470,
    NULL
  ),
  (
    11111111111,
    'CC',
    'Usuario',
    'Kiosco',
    88888877,
    NULL
  ),
  (
    22222222222,
    'CC',
    'Usuario',
    'Kiosco',
    3502586384,
    NULL
  ),
  (
    77777777777,
    'TI',
    'Usuario',
    'Kiosco',
    8888888888,
    NULL
  ),
  (
    99999999999,
    'CC',
    'Usuario',
    'Kiosco',
    7777777777,
    NULL
  ),
  (
    111111111111,
    'CC',
    'Usuario',
    'Kiosco',
    3508350671,
    NULL
  ),
  (
    222222222222,
    'CC',
    'Usuario',
    'Kiosco',
    3333333333,
    NULL
  ),
  (
    555555555555,
    'CC',
    'Usuario',
    'Kiosco',
    3503207251,
    NULL
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `sol_id` int(11) NOT NULL,
  `sol_tipo` varchar(45) DEFAULT NULL,
  `PERSONA_pers_doc` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `solicitante`
--

INSERT INTO `solicitante` (`sol_id`, `sol_tipo`, `PERSONA_pers_doc`)
VALUES (1, 'Externo', 1092529985),
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
  (31, 'Prioritario', 28888888),
  (32, 'General', 222222222222),
  (33, 'Victima', 22222222222),
  (34, 'Prioritario', 22222222),
  (35, 'Prioritario', 555555555555),
  (36, NULL, 10203040),
  (37, 'Victima', 60356258),
  (38, 'Prioritario', 627458),
  (39, 'General', 624538),
  (40, 'Victima', 250859);
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `tur_id` int(11) NOT NULL,
  `tur_estado` enum('Espera', 'Atendiendo', 'Finalizado', 'Ausente') NOT NULL DEFAULT 'Espera',
  `tur_hora_fecha` datetime DEFAULT NULL,
  `tur_hora_llamado` datetime DEFAULT NULL COMMENT 'Timestamp cuando el asesor llama al turno (CU-02)',
  `tur_numero` varchar(45) DEFAULT NULL,
  `tur_tipo` enum('General', 'Prioritario', 'Victimas') NOT NULL,
  `tur_perfil` enum('General', 'Víctima', 'Prioritario', 'Empresario') NOT NULL DEFAULT 'General',
  `tur_tipo_atencion` enum('Normal', 'Especial') NOT NULL DEFAULT 'Normal',
  `tur_servicio` enum('Orientación', 'Formación', 'Emprendimiento') NOT NULL DEFAULT 'Orientación',
  `tur_telefono` varchar(20) DEFAULT NULL,
  `SOLICITANTE_sol_id` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (
    `tur_id`,
    `tur_estado`,
    `tur_hora_fecha`,
    `tur_hora_llamado`,
    `tur_numero`,
    `tur_tipo`,
    `tur_perfil`,
    `tur_tipo_atencion`,
    `tur_servicio`,
    `tur_telefono`,
    `SOLICITANTE_sol_id`
  )
VALUES (
    1,
    'Espera',
    '2026-03-21 02:44:11',
    NULL,
    'G-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    1
  ),
  (
    2,
    'Espera',
    '2026-03-21 02:47:50',
    NULL,
    'V-001',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    1
  ),
  (
    3,
    'Espera',
    '2026-03-21 03:32:14',
    NULL,
    'P-001',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    2
  ),
  (
    4,
    'Espera',
    '2026-03-21 03:32:33',
    NULL,
    'P-002',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    3
  ),
  (
    5,
    'Espera',
    '2026-03-22 02:09:34',
    NULL,
    'P-001',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    4
  ),
  (
    6,
    'Espera',
    '2026-03-22 02:12:02',
    NULL,
    'G-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    5
  ),
  (
    7,
    'Espera',
    '2026-03-22 02:38:35',
    NULL,
    'G-999',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    6
  ),
  (
    8,
    'Espera',
    '2026-03-22 02:39:42',
    NULL,
    'G-999',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    6
  ),
  (
    9,
    'Espera',
    '2026-03-22 03:14:58',
    NULL,
    'B-002',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    1
  ),
  (
    10,
    'Finalizado',
    '2026-03-23 22:03:18',
    NULL,
    'A-001',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    7
  ),
  (
    11,
    'Finalizado',
    '2026-03-23 22:46:10',
    NULL,
    'C-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    8
  ),
  (
    12,
    'Espera',
    '2026-03-23 23:19:52',
    NULL,
    'C-002',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    9
  ),
  (
    13,
    'Finalizado',
    '2026-03-23 23:22:35',
    NULL,
    'B-001',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    10
  ),
  (
    14,
    'Finalizado',
    '2026-03-24 13:47:27',
    NULL,
    'B-001',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    3
  ),
  (
    15,
    'Espera',
    '2026-03-25 20:51:03',
    NULL,
    'C-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    11
  ),
  (
    16,
    'Finalizado',
    '2026-04-05 03:53:38',
    NULL,
    'A-001',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    12
  ),
  (
    17,
    'Finalizado',
    '2026-04-05 03:55:59',
    NULL,
    'C-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    13
  ),
  (
    18,
    'Finalizado',
    '2026-04-05 03:56:29',
    NULL,
    'B-001',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    14
  ),
  (
    19,
    'Finalizado',
    '2026-04-05 03:57:48',
    NULL,
    'C-002',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    15
  ),
  (
    20,
    'Finalizado',
    '2026-04-05 03:59:34',
    NULL,
    'A-002',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    16
  ),
  (
    21,
    'Finalizado',
    '2026-04-05 04:06:35',
    NULL,
    'C-003',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    17
  ),
  (
    22,
    'Finalizado',
    '2026-04-05 19:14:46',
    NULL,
    'B-002',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    18
  ),
  (
    23,
    'Finalizado',
    '2026-04-05 19:21:01',
    NULL,
    'B-003',
    'Prioritario',
    'General',
    'Normal',
    'Orientación',
    NULL,
    19
  ),
  (
    24,
    'Finalizado',
    '2026-04-05 19:23:07',
    NULL,
    'A-003',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    20
  ),
  (
    25,
    'Finalizado',
    '2026-04-05 19:24:10',
    NULL,
    'C-004',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    21
  ),
  (
    26,
    'Finalizado',
    '2026-04-05 19:39:38',
    NULL,
    'A-004',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    22
  ),
  (
    27,
    'Finalizado',
    '2026-04-05 19:46:19',
    NULL,
    'A-005',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    23
  ),
  (
    28,
    'Finalizado',
    '2026-04-05 20:13:23',
    NULL,
    'A-006',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    24
  ),
  (
    29,
    'Espera',
    '2026-04-05 20:25:37',
    NULL,
    'A-007',
    'Victimas',
    'General',
    'Normal',
    'Orientación',
    NULL,
    2
  ),
  (
    30,
    'Espera',
    '2026-04-15 03:18:25',
    NULL,
    'E-001',
    'Prioritario',
    'Empresario',
    'Especial',
    'Orientación',
    NULL,
    21
  ),
  (
    31,
    'Finalizado',
    '2026-04-20 16:11:09',
    NULL,
    'P-001',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Formación',
    NULL,
    25
  ),
  (
    32,
    'Finalizado',
    '2026-04-21 00:50:10',
    '2026-04-21 01:34:36',
    'E-001',
    'Prioritario',
    'Empresario',
    'Especial',
    'Formación',
    NULL,
    26
  ),
  (
    33,
    'Finalizado',
    '2026-04-21 00:54:37',
    '2026-04-21 01:03:22',
    'P-001',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    27
  ),
  (
    34,
    'Espera',
    '2026-04-21 00:56:12',
    NULL,
    'G-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    28
  ),
  (
    35,
    'Espera',
    '2026-04-21 01:03:11',
    NULL,
    'P-002',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    29
  ),
  (
    36,
    'Finalizado',
    '2026-04-21 01:25:47',
    '2026-04-21 01:25:56',
    'V-001',
    'Victimas',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    30
  ),
  (
    37,
    'Espera',
    '2026-04-21 01:34:18',
    NULL,
    'P-003',
    'Prioritario',
    'Prioritario',
    'Especial',
    'Emprendimiento',
    NULL,
    31
  ),
  (
    38,
    'Finalizado',
    '2026-04-22 20:18:27',
    '2026-04-22 21:57:26',
    'G-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    32
  ),
  (
    39,
    'Finalizado',
    '2026-04-22 21:57:09',
    '2026-04-22 21:57:44',
    'V-001',
    'Victimas',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    33
  ),
  (
    40,
    'Espera',
    '2026-04-22 22:31:52',
    NULL,
    'P-001',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    33
  ),
  (
    41,
    'Espera',
    '2026-04-22 22:45:34',
    NULL,
    'V-002',
    'Victimas',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    13
  ),
  (
    42,
    'Espera',
    '2026-04-22 22:51:54',
    NULL,
    'P-002',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    34
  ),
  (
    224,
    'Atendiendo',
    '2026-04-26 02:20:01',
    '2026-04-26 03:59:01',
    'G-1',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    225,
    'Atendiendo',
    '2026-04-26 02:20:01',
    '2026-04-26 03:59:01',
    'P-1',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    226,
    'Atendiendo',
    '2026-04-26 02:21:01',
    '2026-04-26 03:59:01',
    'G-2',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    227,
    'Atendiendo',
    '2026-04-26 02:21:01',
    '2026-04-26 03:59:01',
    'P-2',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    228,
    'Espera',
    '2026-04-26 02:22:01',
    NULL,
    'G-3',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    229,
    'Atendiendo',
    '2026-04-26 02:22:01',
    '2026-04-26 03:59:01',
    'P-3',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    230,
    'Espera',
    '2026-04-26 02:23:01',
    NULL,
    'G-4',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    231,
    'Atendiendo',
    '2026-04-26 02:23:01',
    '2026-04-26 03:59:01',
    'P-4',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    232,
    'Espera',
    '2026-04-26 02:24:01',
    NULL,
    'G-5',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    233,
    'Atendiendo',
    '2026-04-26 02:24:01',
    '2026-04-26 03:59:01',
    'P-5',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    234,
    'Espera',
    '2026-04-26 02:25:01',
    NULL,
    'G-6',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    235,
    'Atendiendo',
    '2026-04-26 02:25:01',
    '2026-04-26 03:59:01',
    'P-6',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    236,
    'Espera',
    '2026-04-26 02:26:01',
    NULL,
    'G-7',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    237,
    'Finalizado',
    '2026-04-26 02:26:01',
    '2026-04-26 03:59:12',
    'P-7',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    238,
    'Espera',
    '2026-04-26 02:27:01',
    NULL,
    'G-8',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    239,
    'Finalizado',
    '2026-04-26 02:27:01',
    '2026-04-26 04:00:03',
    'P-8',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    240,
    'Espera',
    '2026-04-26 02:28:01',
    NULL,
    'G-9',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    241,
    'Espera',
    '2026-04-26 02:28:01',
    NULL,
    'P-9',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    242,
    'Espera',
    '2026-04-26 02:29:01',
    NULL,
    'G-10',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    243,
    'Espera',
    '2026-04-26 02:29:01',
    NULL,
    'P-10',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    244,
    'Espera',
    '2026-04-26 02:30:01',
    NULL,
    'G-11',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    245,
    'Espera',
    '2026-04-26 02:30:01',
    NULL,
    'P-11',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    246,
    'Espera',
    '2026-04-26 02:31:01',
    NULL,
    'G-12',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    247,
    'Espera',
    '2026-04-26 02:31:01',
    NULL,
    'P-12',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    248,
    'Espera',
    '2026-04-26 02:32:01',
    NULL,
    'G-13',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    249,
    'Espera',
    '2026-04-26 02:32:01',
    NULL,
    'P-13',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    250,
    'Espera',
    '2026-04-26 02:33:01',
    NULL,
    'G-14',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    251,
    'Espera',
    '2026-04-26 02:33:01',
    NULL,
    'P-14',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    252,
    'Espera',
    '2026-04-26 02:34:01',
    NULL,
    'G-15',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    253,
    'Espera',
    '2026-04-26 02:34:01',
    NULL,
    'P-15',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    254,
    'Espera',
    '2026-04-26 02:35:01',
    NULL,
    'G-16',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    255,
    'Espera',
    '2026-04-26 02:35:01',
    NULL,
    'P-16',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    256,
    'Espera',
    '2026-04-26 02:36:01',
    NULL,
    'G-17',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    257,
    'Espera',
    '2026-04-26 02:36:01',
    NULL,
    'P-17',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    258,
    'Espera',
    '2026-04-26 02:37:01',
    NULL,
    'G-18',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    259,
    'Espera',
    '2026-04-26 02:37:01',
    NULL,
    'P-18',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    260,
    'Espera',
    '2026-04-26 02:38:01',
    NULL,
    'G-19',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    261,
    'Espera',
    '2026-04-26 02:38:01',
    NULL,
    'P-19',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    262,
    'Espera',
    '2026-04-26 02:39:01',
    NULL,
    'G-20',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    263,
    'Espera',
    '2026-04-26 02:39:01',
    NULL,
    'P-20',
    'General',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    264,
    'Espera',
    '2026-04-26 03:10:01',
    NULL,
    'V-1',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    265,
    'Finalizado',
    '2026-04-26 03:10:01',
    '2026-04-26 03:59:01',
    'E-1',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    266,
    'Espera',
    '2026-04-26 03:11:01',
    NULL,
    'V-2',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    267,
    'Finalizado',
    '2026-04-26 03:11:01',
    '2026-04-26 03:59:01',
    'E-2',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    268,
    'Espera',
    '2026-04-26 03:12:01',
    NULL,
    'V-3',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    269,
    'Ausente',
    '2026-04-26 03:12:01',
    '2026-04-26 03:59:01',
    'E-3',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    270,
    'Espera',
    '2026-04-26 03:13:01',
    NULL,
    'V-4',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    271,
    'Finalizado',
    '2026-04-26 03:13:01',
    '2026-04-26 03:59:01',
    'E-4',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    272,
    'Espera',
    '2026-04-26 03:14:01',
    NULL,
    'V-5',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    273,
    'Finalizado',
    '2026-04-26 03:14:01',
    '2026-04-26 04:00:26',
    'E-5',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    274,
    'Espera',
    '2026-04-26 03:15:01',
    NULL,
    'V-6',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    275,
    'Finalizado',
    '2026-04-26 03:15:01',
    '2026-04-26 04:11:14',
    'E-6',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    276,
    'Espera',
    '2026-04-26 03:16:01',
    NULL,
    'V-7',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    277,
    'Espera',
    '2026-04-26 03:16:01',
    NULL,
    'E-7',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    278,
    'Espera',
    '2026-04-26 03:17:01',
    NULL,
    'V-8',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    279,
    'Espera',
    '2026-04-26 03:17:01',
    NULL,
    'E-8',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    280,
    'Espera',
    '2026-04-26 03:18:01',
    NULL,
    'V-9',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    281,
    'Espera',
    '2026-04-26 03:18:01',
    NULL,
    'E-9',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    282,
    'Espera',
    '2026-04-26 03:19:01',
    NULL,
    'V-10',
    'General',
    'Víctima',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    283,
    'Espera',
    '2026-04-26 03:19:01',
    NULL,
    'E-10',
    'General',
    'Empresario',
    'Normal',
    'Orientación',
    NULL,
    36
  ),
  (
    284,
    'Espera',
    '2026-04-26 04:11:03',
    NULL,
    'V-011',
    'Victimas',
    'Víctima',
    'Normal',
    'Formación',
    NULL,
    37
  ),
  (
    285,
    'Finalizado',
    '2026-04-29 14:22:44',
    '2026-04-29 14:34:06',
    'P-001',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Orientación',
    NULL,
    38
  ),
  (
    286,
    'Finalizado',
    '2026-04-29 15:41:40',
    '2026-04-29 15:43:59',
    'G-001',
    'General',
    'General',
    'Normal',
    'Orientación',
    NULL,
    39
  ),
  (
    287,
    'Ausente',
    '2026-04-29 15:49:26',
    '2026-04-29 15:49:48',
    'P-002',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Formación',
    NULL,
    1
  ),
  (
    288,
    'Ausente',
    '2026-04-29 16:00:53',
    '2026-04-29 16:01:14',
    'P-003',
    'Prioritario',
    'Prioritario',
    'Especial',
    'Orientación',
    NULL,
    1
  ),
  (
    289,
    'Ausente',
    '2026-04-29 16:04:12',
    '2026-04-29 16:04:49',
    'V-001',
    'Victimas',
    'Víctima',
    'Normal',
    'Emprendimiento',
    NULL,
    40
  ),
  (
    290,
    'Espera',
    '2026-04-29 16:10:26',
    NULL,
    'P-004',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Formación',
    NULL,
    1
  ),
  (
    291,
    'Espera',
    '2026-04-29 16:12:22',
    NULL,
    'P-005',
    'Prioritario',
    'Prioritario',
    'Normal',
    'Formación',
    NULL,
    33
  );
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `users`
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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `view_estado_actual_asesores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_estado_actual_asesores` (
`modulo` int(11),
`asesor` varchar(201),
`estado` varchar(10),
`minutos_en_receso_actual` bigint(21)
);
-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `view_resumen_pausas_hoy`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_resumen_pausas_hoy` (
`modulo` int(11),
`asesor` varchar(201),
`total_pausas` bigint(21),
`minutos_totales` decimal(32, 0),
`ultimo_receso` datetime
);
-- --------------------------------------------------------
--
-- Estructura para la vista `view_estado_actual_asesores`
--
DROP TABLE IF EXISTS `view_estado_actual_asesores`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_estado_actual_asesores` AS
SELECT `a`.`ase_id` AS `modulo`,
  concat(`p`.`pers_nombres`, ' ', `p`.`pers_apellidos`) AS `asesor`,
  CASE
    WHEN exists(
      select 1
      from `pausas_asesor`
      where `pausas_asesor`.`ASESOR_ase_id` = `a`.`ase_id`
        AND `pausas_asesor`.`hora_fin` is null
      limit 1
    ) THEN 'EN RECESO'
    WHEN exists(
      select 1
      from `atencion`
      where `atencion`.`ASESOR_ase_id` = `a`.`ase_id`
        AND `atencion`.`atnc_hora_fin` is null
      limit 1
    ) THEN 'ATENDIENDO'
    ELSE 'DISPONIBLE'
  END AS `estado`,
  (
    select timestampdiff(
        MINUTE,
        `pausas_asesor`.`hora_inicio`,
        current_timestamp()
      )
    from `pausas_asesor`
    where `pausas_asesor`.`ASESOR_ase_id` = `a`.`ase_id`
      and `pausas_asesor`.`hora_fin` is null
    limit 1
  ) AS `minutos_en_receso_actual`
FROM (
    `asesor` `a`
    join `persona` `p` on(`a`.`PERSONA_pers_doc` = `p`.`pers_doc`)
  );
-- --------------------------------------------------------
--
-- Estructura para la vista `view_resumen_pausas_hoy`
--
DROP TABLE IF EXISTS `view_resumen_pausas_hoy`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_resumen_pausas_hoy` AS
SELECT `a`.`ase_id` AS `modulo`,
  concat(`p`.`pers_nombres`, ' ', `p`.`pers_apellidos`) AS `asesor`,
  count(`pa`.`id`) AS `total_pausas`,
  sum(coalesce(`pa`.`duracion`, 0)) AS `minutos_totales`,
  max(`pa`.`hora_inicio`) AS `ultimo_receso`
FROM (
    (
      `asesor` `a`
      join `persona` `p` on(`a`.`PERSONA_pers_doc` = `p`.`pers_doc`)
    )
    left join `pausas_asesor` `pa` on(
      `a`.`ase_id` = `pa`.`ASESOR_ase_id`
      and cast(`pa`.`hora_inicio` as date) = curdate()
    )
  )
GROUP BY `a`.`ase_id`,
  `p`.`pers_nombres`,
  `p`.`pers_apellidos`;
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asesor`
--
ALTER TABLE `asesor`
ADD PRIMARY KEY (`ase_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);
--
-- Indices de la tabla `atencion`
--
ALTER TABLE `atencion`
ADD PRIMARY KEY (`atnc_id`),
  ADD KEY `ASESOR_ase_id` (`ASESOR_ase_id`),
  ADD KEY `TURNO_tur_id` (`TURNO_tur_id`);
--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);
--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);
--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
ADD PRIMARY KEY (`coor_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);
--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);
--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);
--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
ADD PRIMARY KEY (`id`);
--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
ADD PRIMARY KEY (`id`);
--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
ADD PRIMARY KEY (`email`);
--
-- Indices de la tabla `pausas_asesor`
--
ALTER TABLE `pausas_asesor`
ADD PRIMARY KEY (`id`);
--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
ADD PRIMARY KEY (`pers_doc`);
--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);
--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
ADD PRIMARY KEY (`sol_id`),
  ADD KEY `PERSONA_pers_doc` (`PERSONA_pers_doc`);
--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
ADD PRIMARY KEY (`tur_id`),
  ADD KEY `SOLICITANTE_sol_id` (`SOLICITANTE_sol_id`),
  ADD KEY `turno_tur_perfil_index` (`tur_perfil`),
  ADD KEY `turno_tur_estado_index` (`tur_estado`),
  ADD KEY `turno_tur_hora_fecha_index` (`tur_hora_fecha`);
--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asesor`
--
ALTER TABLE `asesor`
MODIFY `ase_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;
--
-- AUTO_INCREMENT de la tabla `atencion`
--
ALTER TABLE `atencion`
MODIFY `atnc_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 87;
--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
MODIFY `coor_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13;
--
-- AUTO_INCREMENT de la tabla `pausas_asesor`
--
ALTER TABLE `pausas_asesor`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;
--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
MODIFY `sol_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 41;
--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
MODIFY `tur_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 292;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asesor`
--
ALTER TABLE `asesor`
ADD CONSTRAINT `asesor_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);
--
-- Filtros para la tabla `atencion`
--
ALTER TABLE `atencion`
ADD CONSTRAINT `atencion_ibfk_1` FOREIGN KEY (`ASESOR_ase_id`) REFERENCES `asesor` (`ase_id`),
  ADD CONSTRAINT `atencion_ibfk_2` FOREIGN KEY (`TURNO_tur_id`) REFERENCES `turno` (`tur_id`);
--
-- Filtros para la tabla `coordinador`
--
ALTER TABLE `coordinador`
ADD CONSTRAINT `coordinador_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);
--
-- Filtros para la tabla `solicitante`
--
ALTER TABLE `solicitante`
ADD CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`PERSONA_pers_doc`) REFERENCES `persona` (`pers_doc`);
--
-- Filtros para la tabla `turno`
--
ALTER TABLE `turno`
ADD CONSTRAINT `turno_ibfk_1` FOREIGN KEY (`SOLICITANTE_sol_id`) REFERENCES `solicitante` (`sol_id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;