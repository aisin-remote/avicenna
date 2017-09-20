-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.0.17-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table avicenna.dev.ais_apps
CREATE TABLE IF NOT EXISTS `ais_apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `apps_tcode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `apps_level` int(11) NOT NULL,
  `apps_has_child` tinyint(1) NOT NULL,
  `apps_sname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `apps_tcode_parent` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `apps_tcode_root` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `apps_route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apps_fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apps_icon_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apps_icon_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apps_store_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ais_apps_apps_tcode_unique` (`apps_tcode`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.ais_apps: ~10 rows (approximately)
/*!40000 ALTER TABLE `ais_apps` DISABLE KEYS */;
INSERT INTO `ais_apps` (`id`, `apps_tcode`, `apps_level`, `apps_has_child`, `apps_sname`, `apps_tcode_parent`, `apps_tcode_root`, `apps_route`, `apps_fname`, `apps_icon_code`, `apps_icon_path`, `apps_store_path`, `created_at`, `updated_at`) VALUES
	(1, 'AV00', 0, 1, 'avicenna', 'AV00', 'AV00', '', 'Avicenna', 'fa fa-line-chart', '', NULL, '2017-08-21 11:52:51', '2017-08-21 11:52:53'),
	(2, 'PI00', 1, 1, 'pis', 'AV00', 'AV00', '', 'PIS Digital', 'fa fa-calendar-check-o', '', 'pis/', '2017-08-21 11:52:43', '2017-08-21 11:52:49'),
	(3, 'PI01', 2, 0, 'pis_scan', 'PI00', 'AV00', 'pis', 'PIS Scanner', 'fa fa-barcode', '', 'pis/', '2017-08-21 11:54:36', '2017-08-21 11:54:37'),
	(4, 'PI02', 2, 0, 'pis_master', 'PI00', 'AV00', 'pis/master', 'PIS Master Data', 'fa fa-id-card', '', 'pis/', '2017-08-21 11:55:22', '2017-08-21 11:55:23'),
	(5, 'ST00', 1, 1, 'sto', 'AV00', 'AV00', '#', 'Stock Opname', 'fa fa-cubes', '', 'sto/', '2017-08-21 11:56:02', '2017-08-21 11:56:03'),
	(6, 'ST01', 2, 0, 'sto_entry', 'ST00', 'AV00', '/opname', 'STO Data Entry', 'fa fa-circle-o', '', 'sto/', '2017-08-21 11:57:31', '2017-08-21 11:57:32'),
	(7, 'AC00', 0, 0, 'aca', 'AC00', 'AC00', 'aca/', 'Aisin Cutting Tools', 'fa fa-scissors', '', NULL, '2017-08-21 11:58:27', '2017-08-21 11:58:28'),
	(8, 'DA00', 1, 1, 'dboard', 'AV00', 'AV00', '', 'Dashboard', 'glyphicon glyphicon-dashboard', '', NULL, '2017-09-04 16:00:46', '2017-09-04 16:00:47'),
	(9, 'DA01', 2, 0, 'dboard_mutation', 'DA00', 'AV00', 'dashboard/viewDashboardMutation', 'Mutation', 'glyphicon glyphicon-dashboard', '', NULL, '2017-09-04 16:00:48', '2017-09-04 16:00:49'),
	(10, 'DA02', 2, 0, 'dboard_genba', 'DA00', 'AV00', 'dashboard/viewDashboardGenba', 'Genba', 'glyphicon glyphicon-dashboard', '', NULL, '2017-09-04 16:00:50', '2017-09-04 16:00:50');
/*!40000 ALTER TABLE `ais_apps` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_customers
CREATE TABLE IF NOT EXISTS `avi_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_customers: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_customers` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_dashboard_genbas
CREATE TABLE IF NOT EXISTS `avi_dashboard_genbas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categories` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normal` int(11) DEFAULT NULL,
  `abnormality` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_dashboard_genbas: ~4 rows (approximately)
/*!40000 ALTER TABLE `avi_dashboard_genbas` DISABLE KEYS */;
INSERT INTO `avi_dashboard_genbas` (`id`, `categories`, `normal`, `abnormality`, `created_at`, `updated_at`) VALUES
	(1, '4l45W', 80, 20, NULL, NULL),
	(2, '230B', 70, 20, NULL, NULL),
	(3, '640A', 60, 30, NULL, NULL),
	(4, '692N(Export)', 30, 0, NULL, NULL);
/*!40000 ALTER TABLE `avi_dashboard_genbas` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_dashboard_models
CREATE TABLE IF NOT EXISTS `avi_dashboard_models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `back_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `min_stock` double(8,2) DEFAULT NULL,
  `max_stock` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_dashboard_models: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_dashboard_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_dashboard_models` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_locations
CREATE TABLE IF NOT EXISTS `avi_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `sname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_locations: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_locations` DISABLE KEYS */;
INSERT INTO `avi_locations` (`id`, `code`, `sname`, `fname`, `created_at`, `updated_at`) VALUES
	(1, 'FG01', 'fg_store', 'Finish Good Store', '2017-09-11 11:18:57', '2017-09-11 11:18:58');
/*!40000 ALTER TABLE `avi_locations` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_mutations
CREATE TABLE IF NOT EXISTS `avi_mutations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mutation_date` date NOT NULL,
  `mutation_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `part_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `part_number_customer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_location` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double(15,2) NOT NULL,
  `uom_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `serial_no` int(11) DEFAULT NULL,
  `loading_list` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `npk` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `flag_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `npk_edited` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info_edited` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_mutations: ~94 rows (approximately)
/*!40000 ALTER TABLE `avi_mutations` DISABLE KEYS */;
INSERT INTO `avi_mutations` (`id`, `mutation_date`, `mutation_code`, `part_number`, `part_number_customer`, `store_location`, `quantity`, `uom_code`, `serial_no`, `loading_list`, `delivery`, `customer`, `part_name`, `npk`, `flag_confirm`, `npk_edited`, `info_edited`, `created_at`, `updated_at`) VALUES
	(1, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:37:01', '2017-09-19 02:37:01'),
	(2, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:39:26', '2017-09-19 02:39:26'),
	(3, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:45:25', '2017-09-19 02:45:25'),
	(4, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:46:16', '2017-09-19 02:46:16'),
	(5, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:46:54', '2017-09-19 02:46:54'),
	(6, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:47:40', '2017-09-19 02:47:40'),
	(7, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:47:54', '2017-09-19 02:47:54'),
	(8, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:52:12', '2017-09-19 02:52:12'),
	(9, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 02:53:32', '2017-09-19 02:53:32'),
	(10, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 03:05:16', '2017-09-19 03:05:16'),
	(11, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 06:14:33', '2017-09-19 06:14:33'),
	(12, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 06:14:35', '2017-09-19 06:14:35'),
	(13, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 07:05:18', '2017-09-19 07:05:18'),
	(14, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 07:22:18', '2017-09-19 07:22:18'),
	(15, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 07:22:56', '2017-09-19 07:22:56'),
	(16, '2017-09-19', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000940', 0, NULL, NULL, '2017-09-19 09:23:14', '2017-09-19 09:23:14'),
	(17, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:23:38', '2017-09-19 09:23:38'),
	(18, '2017-09-19', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000940', 0, NULL, NULL, '2017-09-19 09:42:24', '2017-09-19 09:42:24'),
	(19, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:42:40', '2017-09-19 09:42:40'),
	(20, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:42:44', '2017-09-19 09:42:44'),
	(21, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:43:22', '2017-09-19 09:43:22'),
	(22, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:43:28', '2017-09-19 09:43:28'),
	(23, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:55:52', '2017-09-19 09:55:52'),
	(24, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:56:30', '2017-09-19 09:56:30'),
	(25, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:56:51', '2017-09-19 09:56:51'),
	(26, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:57:07', '2017-09-19 09:57:07'),
	(27, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:57:25', '2017-09-19 09:57:25'),
	(28, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:57:30', '2017-09-19 09:57:30'),
	(29, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 09:57:36', '2017-09-19 09:57:36'),
	(30, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:57:40', '2017-09-19 09:57:40'),
	(31, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:57:57', '2017-09-19 09:57:57'),
	(32, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:57:59', '2017-09-19 09:57:59'),
	(33, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:58:07', '2017-09-19 09:58:07'),
	(34, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:58:48', '2017-09-19 09:58:48'),
	(35, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:58:56', '2017-09-19 09:58:56'),
	(36, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 09:59:06', '2017-09-19 09:59:06'),
	(37, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 10:00:52', '2017-09-19 10:00:52'),
	(38, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 10:05:03', '2017-09-19 10:05:03'),
	(39, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 10:05:13', '2017-09-19 10:05:13'),
	(40, '2017-09-19', '601', '423105-11660', '69201-0K040', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE LH', '000940', 0, NULL, NULL, '2017-09-19 10:05:26', '2017-09-19 10:05:26'),
	(41, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:05:38', '2017-09-19 10:05:38'),
	(42, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:05:42', '2017-09-19 10:05:42'),
	(43, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:02', '2017-09-19 10:06:02'),
	(44, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:06', '2017-09-19 10:06:06'),
	(45, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:18', '2017-09-19 10:06:18'),
	(46, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:19', '2017-09-19 10:06:19'),
	(47, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:23', '2017-09-19 10:06:23'),
	(48, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:53', '2017-09-19 10:06:53'),
	(49, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:06:59', '2017-09-19 10:06:59'),
	(50, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:09:22', '2017-09-19 10:09:22'),
	(51, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:09:35', '2017-09-19 10:09:35'),
	(52, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:15', '2017-09-19 10:25:15'),
	(53, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:17', '2017-09-19 10:25:17'),
	(54, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:19', '2017-09-19 10:25:19'),
	(55, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:21', '2017-09-19 10:25:21'),
	(56, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:32', '2017-09-19 10:25:32'),
	(57, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:39', '2017-09-19 10:25:39'),
	(58, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:40', '2017-09-19 10:25:40'),
	(59, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:25:47', '2017-09-19 10:25:47'),
	(60, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:28:35', '2017-09-19 10:28:35'),
	(61, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:28:39', '2017-09-19 10:28:39'),
	(62, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 10:28:41', '2017-09-19 10:28:41'),
	(63, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 10:28:50', '2017-09-19 10:28:50'),
	(64, '2017-09-19', '601', '455108-10900', '75762-0K010', 'FG01', -12.00, 'PC', NULL, NULL, NULL, 'C001', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '000940', 0, NULL, NULL, '2017-09-19 10:28:54', '2017-09-19 10:28:54'),
	(65, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:29:43', '2017-09-19 10:29:43'),
	(66, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:30:27', '2017-09-19 10:30:27'),
	(67, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:30:47', '2017-09-19 10:30:47'),
	(68, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:31:14', '2017-09-19 10:31:14'),
	(69, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:31:16', '2017-09-19 10:31:16'),
	(70, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 10:31:45', '2017-09-19 10:31:45'),
	(71, '2017-09-19', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000940', 0, NULL, NULL, '2017-09-19 11:01:40', '2017-09-19 11:01:40'),
	(72, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:37:38', '2017-09-20 04:37:38'),
	(73, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:38:58', '2017-09-20 04:38:58'),
	(74, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:39:46', '2017-09-20 04:39:46'),
	(75, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:47:08', '2017-09-20 04:47:08'),
	(76, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:47:46', '2017-09-20 04:47:46'),
	(77, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:48:11', '2017-09-20 04:48:11'),
	(78, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:48:59', '2017-09-20 04:48:59'),
	(79, '2017-09-20', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000017', 0, NULL, NULL, '2017-09-20 04:49:11', '2017-09-20 04:49:11'),
	(80, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:13', '2017-09-20 04:49:13'),
	(81, '2017-09-20', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000017', 0, NULL, NULL, '2017-09-20 04:49:15', '2017-09-20 04:49:15'),
	(82, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:16', '2017-09-20 04:49:16'),
	(83, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:17', '2017-09-20 04:49:17'),
	(84, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:18', '2017-09-20 04:49:18'),
	(85, '2017-09-20', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000017', 0, NULL, NULL, '2017-09-20 04:49:20', '2017-09-20 04:49:20'),
	(86, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:32', '2017-09-20 04:49:32'),
	(87, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:38', '2017-09-20 04:49:38'),
	(88, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 04:49:39', '2017-09-20 04:49:39'),
	(89, '2017-09-20', '601', '423107-11770', '69203-0K070', 'FG01', -4.00, 'PC', NULL, NULL, NULL, 'C002', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '000017', 0, NULL, NULL, '2017-09-20 04:49:39', '2017-09-20 04:49:39'),
	(90, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 06:40:24', '2017-09-20 06:40:24'),
	(91, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '000017', 0, NULL, NULL, '2017-09-20 06:40:31', '2017-09-20 06:40:31'),
	(92, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '001115', 0, NULL, NULL, '2017-09-20 06:44:12', '2017-09-20 06:44:12'),
	(93, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '001115', 0, NULL, NULL, '2017-09-20 06:44:19', '2017-09-20 06:44:19'),
	(94, '2017-09-20', '601', '423108-11770', '69204-0K070', 'FG01', -5.00, 'PC', NULL, NULL, NULL, 'C001', 'FRAME S/A RR DR O/S HANDLE RH', '001115', 0, NULL, NULL, '2017-09-20 06:44:25', '2017-09-20 06:44:25');
/*!40000 ALTER TABLE `avi_mutations` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_mutation_types
CREATE TABLE IF NOT EXISTS `avi_mutation_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_mutation_types: ~16 rows (approximately)
/*!40000 ALTER TABLE `avi_mutation_types` DISABLE KEYS */;
INSERT INTO `avi_mutation_types` (`id`, `code`, `name`, `desc`, `created_at`, `updated_at`) VALUES
	(1, 'Z01', 'sto_fg_in', 'Stock Opname In Finish Good', '2017-09-06 11:14:57', '2017-09-06 11:14:58'),
	(2, 'Z02', 'sto_fg_out', 'Stock Opname Out Finish Good', '2017-09-06 11:15:42', '2017-09-06 11:15:42'),
	(3, 'Z03', 'sto_comp_in', 'Stock Opname In Component', '2017-09-06 11:16:04', '2017-09-06 11:16:04'),
	(4, 'Z04', 'sto_comp_out', 'Stock Opname Out Component', '2017-09-06 11:16:29', '2017-09-06 11:16:30'),
	(5, '101', 'gr_purch_in', 'Good Receipt In Purchase', '2017-09-06 11:18:49', '2017-09-06 11:18:49'),
	(6, '102', 'gr_purch_out', 'Good Receipt Out (Reversal) Purchase', '2017-09-06 11:24:21', '2017-09-06 11:24:21'),
	(7, '131', 'gr_prod_in', 'Good Receipt In Production', '2017-09-06 11:25:07', '2017-09-06 11:25:09'),
	(8, '132', 'gr_prod_out', 'Good Receipt Out (Reversal) Production', '2017-09-06 11:25:52', '2017-09-06 11:25:58'),
	(9, '141', 'gr_andon_in', 'Good Receipt In Andon Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(10, '142', 'gr_andon_out', 'Good Receipt Out (Reversal) Andon Production', '2017-09-06 11:28:10', '2017-09-06 11:28:11'),
	(11, '261', 'consumption_out', 'Good Consumption Out From Production', '2017-09-06 11:30:46', '2017-09-06 11:30:49'),
	(12, '262', 'consumption_in', 'Good Consumption In (Reversal) From Production', '2017-09-06 11:31:33', '2017-09-06 11:31:33'),
	(13, '311', 'move_out_in', 'Good Movement Out From In To Location', '2017-09-06 11:34:11', '2017-09-06 11:34:12'),
	(14, '312', 'move_in_out', 'Good Movement In From Out To (Reversal) Location', '2017-09-06 11:35:10', '2017-09-06 11:35:10'),
	(15, '601', 'gi_out_delivery', 'Good Issue Out Delivery', '2017-09-07 15:05:30', '2017-09-07 15:05:30'),
	(16, '602', 'gi_in_delivery', 'Good Issue In (Reversal) Delivery', '2017-09-07 15:06:07', '2017-09-07 15:06:07');
/*!40000 ALTER TABLE `avi_mutation_types` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_opname
CREATE TABLE IF NOT EXISTS `avi_opname` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `opname_date` date NOT NULL,
  `opname_quantity` int(11) NOT NULL,
  `location_code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `opname_user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_opname: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_opname` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_parts
CREATE TABLE IF NOT EXISTS `avi_parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplier_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_number_nostrip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_number_customer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_line` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity_box` double(8,2) NOT NULL,
  `min_stock` double(8,2) DEFAULT NULL,
  `max_stock` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=490 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_parts: ~489 rows (approximately)
/*!40000 ALTER TABLE `avi_parts` DISABLE KEYS */;
INSERT INTO `avi_parts` (`id`, `customer_id`, `supplier_id`, `back_number`, `part_number`, `part_number_nostrip`, `part_number_customer`, `part_name`, `product_group`, `product_line`, `quantity_box`, `min_stock`, `max_stock`, `created_at`, `updated_at`) VALUES
	(1, 'C001', '', 'LP18', '423601-12320-11H', '4236011232011H', '69205-0K010-B1', 'HANDLE I/S FR RH PLATING 669L', '692N(Export)', '', 12.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'C001', '', 'LP1H', '423602-11940-12N', '4236021194012N', '69206-0K020-E0', 'HANDLE I/S FR RH EMBOSS IMV', '692N(Export)', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'C001', '', 'LP1B', '423602-12030-11H', '4236021203011H', '69206-0K010-B1', 'HANDLE SUB-ASSY, FR DOOR INSIDE LH', '692N(Export)', '', 12.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 'C001', '', 'LP1G', '423603-10700', '42360310700', '', 'HANDLE I/S FR LH EMBOSS IMV', '692N(Export)', '', 12.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 'C001', '', 'RO0R', '423604-10770', '42360410770', '', 'HANDLE SUB-ASSY,RR DOOR INSIDE,RH', '800A', '', 12.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 'C001', '', 'RO0S', '423501-10140-Z1', '42350110140Z1', '', 'HANDLE SUB-ASSY,RR DOOR INSIDE,LH', '800A', '', 12.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(7, 'C001', '', 'OPA2', '423501-10140', '42350110140', '82811-77M20', 'HANDLE BACK IMV', '692N(Export)', '', 10.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, 'C001', '', 'OPA1', '423501-10140', '42350110140', '69023-0K030', 'HANDLE BACK IMV', '692N(Export)', '', 20.00, 30.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, 'C003', '', 'OPA1', '423501-10140', '42350110140', '69023-0K030', 'HANDLE BACK IMV', 'D01N', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, 'C003', '', 'OPA1', '423501-10360', '42350110360', '69023-BZ030', 'HANDLE BACK IMV', 'D01N', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(11, 'C003', '', 'OPA3', '423107-10900', '42310710900', '69203-BZ020', 'HANDLE SUB-ASSY, BACK DOOR OUTSIDE', 'D30D', '', 20.00, 30.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(12, 'C003', '', 'MPA3', '423108-10870', '42310810870', '69203-BZ020', 'FRAME HANDLE RH D99B/D28D', 'D99B', '', 6.00, 13.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(13, 'C003', '', 'MPA4', '423105-10310', '42310510310', '69201-0K010', 'FRAME HANDLE LH D99B/D28D', 'D99B', '', 6.00, 13.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(14, 'C003', '', 'MP11', '423105-10310', '42310510310', '69201-0K010', 'FRAME HANDLE RH IMV/D99D/D28D', 'D99B', '', 8.00, 9.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(15, 'C001', '', 'MP11', '423106-10200', '42310610200', '69202-0K010', 'FRAME HANDLE RH IMV/D99D/D28D', '692N(Export)', '', 8.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(16, 'C003', '', 'MP12', '423106-10200', '42310610200', '69202-0K010', 'FRAME HANDLE LH IMV/D99D/D28D', 'D99B', '', 8.00, 9.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(17, 'C001', '', 'MP12', '423107-10450', '42310710450', '69203-0K040', 'FRAME HANDLE LH IMV/D99D/D28D', '692N(Export)', '', 8.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(18, 'C001', '', 'MP13', '423108-10430', '42310810430', '69204-0K040', 'FRAME S/A RR DR RH HANDLE, OUTSIDE', '692N(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(19, 'C001', '', 'MP14', '423105-10150', '42310510150', '', 'FRAME S/A RR DR LH HANDLE, OUTSIDE', '692N(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(20, 'C002', '', 'MP25', '423106-10110', '42310610110', '', 'FRAME S/A RR DR O/S HANDLE RH, YL8-C002', 'YL8', '', 9.00, 21.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(21, 'C002', '', 'MP26', '423107-10660', '42310710660', '', 'FRAME S/A RR DR O/S HANDLE LH, YL8-C002', 'YL8', '', 9.00, 21.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(22, 'C002', '', 'MP27', '423108-10650', '42310810650', '', 'FRAME S/A RR DR O/S HANDLE RH, YL8-C002', 'YL8', '', 6.00, 33.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(23, 'C002', '', 'MP28', '423105-10370', '42310510370', '', 'FRAME S/A RR DR O/S HANDLE LH, YL8-C002', 'YL8', '', 6.00, 33.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(24, 'C002', '', 'MPA9', '423106-10260', '42310610260', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH', 'YL8(Export)', '', 4.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(25, 'C002', '', 'MPAA', '423107-11770', '42310711770', '69203-0K070', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', 'YL8(Export)', '', 4.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(26, 'C001', '', 'MP23', '423108-11770', '42310811770', '69204-0K070', 'FRAME S/A RR DR O/S HANDLE RH', '660A', '', 5.00, 111.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(27, 'C001', '', 'MP24', '423105-11660', '42310511660', '69201-0K040', 'FRAME S/A RR DR O/S HANDLE LH', '660A', '', 5.00, 111.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(28, 'C001', '', 'MP21', '423106-11660', '42310611660', '69202-0K040', 'FRAME S/A FR DR O/S HANDLE RH', '660A', '', 4.00, 139.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 'C001', '', 'MP22', '423105-11140', '42310511140', '69201-0D200', 'FRAME S/A FR DR O/S HANDLE LH', '660A', '', 4.00, 139.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(30, 'C001', '', 'MPA5', '423106-10680', '42310610680', '', 'FRAME SUB-ASSY, FR DOOR OUTS HANDLE, RH', '800A', '', 10.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(31, 'C001', '', 'MPA6', '423107-11800', '42310711800', '69203-0D170', 'FRAME SUB-ASSY, FR DOOR OUTS HANDLE, LH', '800A', '', 10.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(32, 'C001', '', 'MPA7', '423108-11800', '42310811800', '69204-0D170', 'FRAME SUB-ASSY, RR DOOR OUTS HANDLE, RH', '800A', '', 6.00, 44.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(33, 'C001', '', 'MPA8', '423105-11450', '42310511450', '69201-0D190', 'FRAME SUB-ASSY, RR DOOR OUTS HANDLE, LH', '800A', '', 6.00, 44.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(34, 'C001', '', 'MP16', '423105-11460', '42310511460', '69201-0D180', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH (SMART)', '810A', '', 6.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(35, 'C001', '', 'MP15', '423106-11450', '42310611450', '69202-0D180', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH (NORMAL)', '810A', '', 9.00, 23.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(36, 'C001', '', 'MP18', '423106-11460', '42310611460', '69202-0D060', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH (SMART)', '810A', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(37, 'C001', '', 'MP17', '423107-11590', '42310711590', '69203-0D150', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH (NORMAL)', '810A', '', 9.00, 24.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(38, 'C001', '', 'MP19', '423108-11590', '42310811590', '69204-0D150', 'FRAME SUB-ASSY, RR DOOR OUTSIDE HANDLE, RH', '810A', '', 5.00, 44.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(39, 'C001', '', 'MP20', '423110-10670', '42311010670', '', 'FRAME SUB-ASSY, RR DOOR OUTSIDE HANDLE, LH', '810A', '', 5.00, 44.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(40, 'C002', '', 'KP2T', '423110-13710-BD3', '42311013710BD3', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, EMBOSS', 'YL8', '', 6.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(41, 'C002', '', 'KPC1', '423110-13710-CDC', '42311013710CDC', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, METALIC SILKY SILVER', 'YL8', '', 6.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(42, 'C002', '', 'KPC4', '423110-13710-BDB', '42311013710BDB', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, PRIME COOL BLACK', 'YL8', '', 6.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(43, 'C002', '', 'KPC8', '423110-13710-DDS', '42311013710DDS', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, PRIME GRAPHITE GRAY', 'YL8', '', 6.00, 24.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(44, 'C002', '', 'KPCA', '423110-13710-DDR', '42311013710DDR', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, RADIANT RED PEARL', 'YL8', '', 6.00, 7.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(45, 'C002', '', 'KPC3', '423110-13710-ADE', '42311013710ADE', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, PEARL BURGUNDY RED', 'YL8', '', 6.00, 10.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(46, 'C002', '', 'KPCB', '423110-13710-KD3', '42311013710KD3', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, PRL. SNOW WHITE 4', 'YL8', '', 6.00, 40.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(47, 'C002', '', 'KPCC', '423110-13710-KD4', '42311013710KD4', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, MET. LILAC GRAY', 'YL8', '', 6.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(48, 'C002', '', 'KPCD', '484170-10330-BD3', '48417010330BD3', '', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH, PEARL TWILIGHT VIOLET', 'YL8', '', 6.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(49, 'C002', '', 'KP4V', '484170-10330-CDC', '48417010330CDC', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, METALIC SILKY SILVER', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(50, 'C002', '', 'KP4X', '484170-10330- BDB', '48417010330 BDB', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, PRIME COOL BLACK', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(51, 'C002', '', 'KP4Y', '484170-10330-DDS', '48417010330DDS', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, PRIME GRAPHITE GRAY', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(52, 'C002', '', 'KP4Z', '484170-10330-DDR', '48417010330DDR', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, RADIANT RED PEARL', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(53, 'C002', '', 'KP4W', '484170-10330-ADE', '48417010330ADE', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, PRL. BURGUNDY RED', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(54, 'C002', '', 'KP51', '484170-10330-KD3', '48417010330KD3', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, PRL SNOW WHITE 4', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(55, 'C002', '', 'KP5C', '484170-10330', '48417010330', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART, MET. LILAC GRAY', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(56, 'C002', '', 'SPC1', '423110-13260-BD3', '42311013260BD3', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, SMART', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(57, 'C002', '', 'KP52', '423110-13260-CDC', '42311013260CDC', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, METALIC SILKY SILVER', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(58, 'C002', '', 'KP54', '423110-13260-BDB', '42311013260BDB', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, PRIME COOL BLACK', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(59, 'C002', '', 'KP55', '423110-13260-DDS', '42311013260DDS', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, PRIME GRAPHITE GRAY', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(60, 'C002', '', 'KP56', '423110-13260-DDR', '42311013260DDR', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, RADIANT RED PEARL', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(61, 'C002', '', 'KP53', '423110-13260-ADE', '42311013260ADE', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, PRL. BURGUNDY RED', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(62, 'C002', '', 'KP57', '423110-13260-KD3', '42311013260KD3', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, PRL SNOW WHITE 4', 'YL8(Export)', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(63, '', '', 'KP59', '423207-10230', '42320710230', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, NORMAL, MET. LILAC GRAY', 'YL8(Export)', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(64, 'C002', '', 'NP12', '423205-10180-BD3', '42320510180BD3', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE EMBOSS', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(65, 'C002', '', 'NPCQ', '423205-10180-CDC', '42320510180CDC', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE METALIC SILKY SILVER', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(66, 'C002', '', 'NPCR', '423205-10180-BDB', '42320510180BDB', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE PRIME COOL BLACK', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(67, 'C002', '', 'NPCS', '423205-10180-DDS', '42320510180DDS', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE PRIME GRAPHITE GRAY', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(68, 'C002', '', 'NPCT', '423205-10180-DDR', '42320510180DDR', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE RADIANT RED PEARL', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(69, 'C002', '', 'NPCU', '423205-10180-ADE', '42320510180ADE', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE PEARL BURGUNDY RED', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(70, 'C002', '', 'NPCW', '423205-10180-KD3', '42320510180KD3', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE PRL. SNOW WHITE 4', 'YL8', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(71, 'C002', '', 'NPCH', '423205-10180-KD4', '42320510180KD4', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE MET. LILAC GRAY', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(72, 'C002', '', 'NPCG', '423275-10310-5PK', '423275103105PK', '', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE PEARL TWILIGHT VIOLET', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(73, 'C002', '', 'NA1N', '423207-10220-BD3', '42320710220BD3', '', 'CAP, FR DOOR OUTSIDE HANDLE RH, EMBOSS, YL8-C002', 'YL8', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(74, 'C002', '', 'NPCI', '423207-10220-CDC', '42320710220CDC', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE METALIC SILKY SILVER', 'YL8', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(75, 'C002', '', 'NPCJ', '423207-10220-BDB', '42320710220BDB', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE PRIME COOL BLACK', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(76, 'C002', '', 'NPCN', '423207-10220-DDS', '42320710220DDS', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE PRIME GRAPHITE GRAY', 'YL8', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(77, 'C002', '', 'NPCO', '423207-10220-DDR', '42320710220DDR', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE RADIANT RED PEARL', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(78, 'C002', '', 'NPCP', '423207-10220-ADE', '42320710220ADE', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE PEARL BURGUNDY RED', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(79, 'C002', '', 'NPCM', '423207-10220-KD3', '42320710220KD3', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE PRL. SNOW WHITE 4', 'YL8', '', 30.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(80, 'C002', '', 'NPCL', '423207-10220-KD4', '42320710220KD4', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE MET. LILAC GRAY', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(81, 'C002', '', 'NPCK', '423205-10470-BD3', '42320510470BD3', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE PEARL TWILIGHT VIOLET', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(82, 'C002', '', 'NP4U', '423205-10470-DDR', '42320510470DDR', '', 'CAP, FR DOOR OUTSIDE HANDLE, METALIC SILKY SILVER', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(83, 'C002', '', 'NP59', '423205-10470-CDC', '42320510470CDC', '', 'CAP, FR DOOR OUTSIDE HANDLE, PRL. BURGUNDY RED', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(84, 'C002', '', 'NP4V', '423205-10470-BDB', '42320510470BDB', '', 'CAP, FR DOOR OUTSIDE HANDLE, PRIME COOL BLACK', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(85, 'C002', '', 'NP4W', '423205-10470-DDS', '42320510470DDS', '', 'CAP, FR DOOR OUTSIDE HANDLE, PRIME GRAPHITE GRAY', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(86, 'C002', '', 'NP4X', '423205-10470-ADE', '42320510470ADE', '', 'CAP, FR DOOR OUTSIDE HANDLE, RADIANT RED PEARL', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(87, 'C002', '', 'NP4Y', '423205-10470-KD3', '42320510470KD3', '', 'CAP, FR DOOR OUTSIDE HANDLE, PRL SNOW WHITE 4', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(88, 'C002', '', 'NP5A', '423207-10540-BD3', '42320710540BD3', '', 'CAP, FR DOOR OUTSIDE HANDLE, MET. LILAC GRAY', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(89, 'C002', '', 'NP4Z', '423207-10540-DDR', '42320710540DDR', '', 'CAP, RR DOOR OUTSIDE HANDLE, METALIC SILKY SILVER', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(90, 'C002', '', 'NP51', '423207-10540-CDC', '42320710540CDC', '', 'CAP, RR DOOR OUTSIDE HANDLE, PRL. BURGUNDY RED', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(91, 'C002', '', 'NP52', '423207-10540-BDB', '42320710540BDB', '', 'CAP, RR DOOR OUTSIDE HANDLE, PRIME COOL BLACK', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(92, 'C002', '', 'NP53', '423207-10540-DDS', '42320710540DDS', '', 'CAP, RR DOOR OUTSIDE HANDLE, PRIME GRAPHITE GRAY', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(93, 'C002', '', 'NP54', '423207-10540-ADE', '42320710540ADE', '', 'CAP, RR DOOR OUTSIDE HANDLE, RADIANT RED PEARL', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(94, 'C002', '', 'NP55', '423207-10540-KD3', '42320710540KD3', '', 'CAP, RR DOOR OUTSIDE HANDLE, PRL SNOW WHITE 4', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(95, 'C002', '', 'NP5B', '423110-13710', '42311013710', '', 'CAP, RR DOOR OUTSIDE HANDLE, MET. LILAC GRAY', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(96, 'C002', '', 'KPCE', '#N/A', '#N/A', '69201-0K040', 'HANDLE ASSY, FRONT DOOR OUTSIDE RH (PAINTLESS)', 'YL8', '', 6.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(97, 'C002', '', 'NPCX', '#N/A', '#N/A', '69201-0K040', 'CAP SUB-ASSY,FR DOOR OUTSIDE HANDLE (PAINTELSS)', 'YL8', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(98, 'C002', '', 'NPCY', '423205-11480', '42320511480', '69217-0K560-A0', 'CAP SUB-ASSY, RR DOOR OUTSIDE HANDLE (PAINTELSS)', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(99, 'C001', '', 'NP57', '423207-11200', '42320711200', '69227-0K290-A0', 'CAP, FR DOOR OUTSIDE HANDLE, RH', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(100, 'C001', '', 'NP58', '423275-11920', '42327511920', '69217-0K550-A0', 'CAP, RR DOOR OUTSIDE HANDLE,', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(101, 'C001', '', 'NM08', '423205-11460', '42320511460', '69217-0K260', 'CAP HOLE, FR DOOR OUTSIDE HANDLE', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(102, 'C001', '', 'NP1Y', '423205-11480-A01', '42320511480A01', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH PLATING', '660A', '', 24.00, 12.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(103, 'C001', '', 'NP43', '423205-11480-A0U', '42320511480A0U', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, SUPER WHITE', '660A', '', 24.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(104, 'C001', '', 'NP44', '423205-11480-B2M', '42320511480B2M', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, PEARL WHITE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(105, 'C001', '', 'NP46', '423205-11480-B1R', '42320511480B1R', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, DARK GRAY METALIC', '660A', '', 24.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(106, 'C001', '', 'NP45', '423205-11480-C0H', '42320511480C0H', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, SILVER METALIC', '660A', '', 24.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(107, 'C001', '', 'NP47', '423205-11480-E35', '42320511480E35', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, ATTITUDE BLACK', '660A', '', 24.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(108, 'C001', '', 'NP49', '423205-11480-E2V', '42320511480E2V', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, PHANTOM BROWN METALIC', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(109, 'C001', '', 'NP48', '423205-11480-G3C', '42320511480G3C', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, AVANT GRADE BROWN', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(110, 'C001', '', 'NP4B', '423205-11480-J4N', '42320511480J4N', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, ALUMINA JADE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(111, 'C001', '', 'NP4A', '423205-11480-4Q0', '423205114804Q0', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, NEBULA BLUE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(112, 'C001', '', 'NP5G', '423207-11180', '42320711180', '69227-0K140', 'CAP, FR DOOR OUTSIDE HANDLE, RH, YANMAR BEIGE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(113, 'C001', '', 'NP4C', '423207-11200-A01', '42320711200A01', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH PLATING ', '660A', '', 24.00, 24.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(114, 'C001', '', 'NP4D', '423207-11200-A0U', '42320711200A0U', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, SUPER WHITE', '660A', '', 24.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(115, 'C001', '', 'NP4E', '423207-11200-B2M', '42320711200B2M', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, PEARL WHITE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(116, 'C001', '', 'NP4G', '423207-11200-B1R', '42320711200B1R', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, DARK GRAY METALIC', '660A', '', 24.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(117, 'C001', '', 'NP4F', '423207-11200-C0H', '42320711200C0H', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, SILVER METALIC', '660A', '', 24.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(118, 'C001', '', 'NP4H', '423207-11200-E35', '42320711200E35', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, ATTITUDE BLACK', '660A', '', 24.00, 7.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(119, 'C001', '', 'NP4J', '423207-11200-E2V', '42320711200E2V', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, PHANTOM BROWN METALIC', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(120, 'C001', '', 'NP4I', '423207-11200-G3C', '42320711200G3C', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, AVANT GRADE BROWN', '660A', '', 24.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(121, 'C001', '', 'NP4L', '423207-11200-J4N', '42320711200J4N', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, ALUMINA JADE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(122, 'C001', '', 'NP4K', '423207-11200-4Q0', '423207112004Q0', '', 'CAP, RR DOOR OUTSIDE HANDLE, RH, NEBULA BLUE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(123, 'C001', '', 'NP5H', '423205-10720-A01', '42320510720A01', '69217-0D490-A0', 'CAP, RR DOOR OUTSIDE HANDLE, RH, YANMAR BEIGE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(124, 'C001', '', 'NP4M', '423205-10720-B1L', '42320510720B1L', '69217-0D490-B0', 'CAP, FR DOOR OUTSIDE HANDLE, RH SUPER WHITE', '800A', '', 32.00, 7.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(125, 'C001', '', 'NP4N', '423205-10720-B2M', '42320510720B2M', '69217-0D490-B1', 'CAP, FR DOOR OUTSIDE HANDLE, RH SILVER METALIC', '800A', '', 32.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(126, 'C001', '', 'NP4O', '423205-10720-C0H', '42320510720C0H', '69217-0D490-C0', 'CAP, FR DOOR OUTSIDE HANDLE, RH DARK GRAY METALIC', '800A', '', 32.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(127, 'C001', '', 'NP4P', '423205-10720-E37', '42320510720E37', '69217-0D490-E2', 'CAP, FR DOOR OUTSIDE HANDLE, RH ATTITUDE BLACK', '800A', '', 32.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(128, 'C001', '', 'NP4Q', '423205-10720-F10', '42320510720F10', '69217-0D490-E0', 'CAP, FR DOOR OUTSIDE HANDLE, RH QUARTZ BROWN METALIC', '800A', '', 32.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(129, 'C001', '', 'NP4R', '423205-10720-E2N', '42320510720E2N', '69217-0D490-E1', 'CAP, FR DOOR OUTSIDE HANDLE, RH ORANGE METALIC', '800A', '', 32.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(130, 'C001', '', 'NP4S', '423205-10720-D2D', '42320510720D2D', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH DARK BROWN M.M', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(131, 'C001', '', 'NP5D', '423205-10740', '42320510740', '69217-0D510', 'CAP, FR DOOR OUTSIDE HANDLE, RH RED MICA METALLIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(132, 'C001', '', 'NP4T', '484170-10870-55-A01', '4841701087055A01', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH EMBOSS', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(133, 'Sub assy', '', 'KO11', '484170-10870-55-B1L', '4841701087055B1L', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(134, 'Sub assy', '', 'KO12', '484170-10870-55-B2M', '4841701087055B2M', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(135, 'Sub assy', '', 'KO13', '484170-10870-55-C0H', '4841701087055C0H', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(136, 'Sub assy', '', 'KO14', '484170-10870-55-E37', '4841701087055E37', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(137, 'Sub assy', '', 'KO15', '484170-10870-55-F10', '4841701087055F10', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(138, 'Sub assy', '', 'KO16', '484170-10870-55-E2N', '4841701087055E2N', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(139, 'Sub assy', '', 'KO17', '484170-10870-55-D2D', '4841701087055D2D', '', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(140, 'Sub assy', '', 'KO17', '484170-10850', '48417010850', '69210-0K090', 'HANDLE ASSY, ELECTRIC KEY, ANTENNA-WB', '', '', 0.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(141, 'C001', '', 'KP45', '484170-10870-A01', '48417010870A01', '69210-0D440-A0', 'HANDLE A/S FR DR O/S RH ELECTRICAL KEY, ANTENNA PLATING (SMART)', '660A', '', 4.00, 93.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(142, 'C001', '', 'KP47', '484170-10870-B1L', '48417010870B1L', '69210-0D440-B0', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART SUPER WHITE', '800A', '', 15.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(143, 'C001', '', 'KP48', '484170-10870-B2M', '48417010870B2M', '69210-0D440-B1', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART SILVER METALIC', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(144, 'C001', '', 'KP49', '484170-10870-C0H', '48417010870C0H', '69210-0D440-C0', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART DARK GRAY METALIC', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(145, 'C001', '', 'KP4A', '484170-10870-E37', '48417010870E37', '69210-0D440-E2', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART ATTITUDE BLACK', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(146, 'C001', '', 'KP4B', '484170-10870-F10', '48417010870F10', '69210-0D440-E0', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART QUARTZ BROWN METALIC', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(147, 'C001', '', 'KP4C', '484170-10870-E2N', '48417010870E2N', '69210-0D440-E1', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART ORANGE METALIC', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(148, 'C001', '', 'KP4D', '484170-10870-D2D', '48417010870D2D', '', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART DARK BROWN M.M', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(149, 'C001', '', 'KP5W', '484170-10870', '48417010870', '69210-0D440-A0', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART RED MICA ', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(150, 'C001', '', 'KP5F', '484170-11270', '48417011270', '', 'HANDLE ASSY, FR DOOR, OUTSIDE RH SMART', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(151, 'C004', '', 'SPJ1', '484180-11270', '48418011270', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH (SMART PLAT)', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(152, 'C004', '', 'SPJ2', '484170-11210-AA7', '48417011210AA7', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH (SMART PLAT)', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(153, 'C004', '', 'SPJ3', '484170-11210-BAQ', '48417011210BAQ', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, WHITE', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(154, 'C004', '', 'SPJ4', '484170-11210-CA8', '48417011210CA8', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, SILVER', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(155, 'C004', '', 'SPJ5', '484170-11210-BAN', '48417011210BAN', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, BLACK', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(156, 'C004', '', 'SPJ6', '484170-11210-EAD', '48417011210EAD', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, GRAY', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(157, 'C004', '', 'SPJ7', '484170-11210-DAD', '48417011210DAD', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, BROWN', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(158, 'C004', '', 'SPJ8', '484180-11210-AA7', '48418011210AA7', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, RH, RED', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(159, 'C004', '', 'SPJ9', '484180-11210-BAQ', '48418011210BAQ', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, WHITE', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(160, 'C004', '', 'SPJA', '484180-11210-CA8', '48418011210CA8', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, SILVER', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(161, 'C004', '', 'SPJB', '484180-11210-BAN', '48418011210BAN', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, BLACK', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(162, 'C004', '', 'SPJC', '484180-11210-EAD', '48418011210EAD', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, GRAY', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(163, 'C004', '', 'SPJD', '484180-11210-DAD', '48418011210DAD', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, BROWN', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(164, 'C004', '', 'SPJE', '423110-13430', '42311013430', '', 'HANDLE ASSY, ELECTRICAL KEY, ANTENNA, LH, RED', '4l45W', '', 20.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(165, 'HMMI', '', 'KPE1', '423110-13430', '42311013430', '', 'HANDLE FR RH 913L', '913L', '', 5.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(166, 'HMMI', '', 'KPE1', '423120-10700', '42312010700', '', 'HANDLE FR RH 913L', '913L', '', 5.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(167, 'HMMI', '', 'KPE2', '423120-10700', '42312010700', '', 'HANDLE FR LH 913L', '913L', '', 5.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(168, 'HMMI', '', 'KPE2', '423110-13690-C0K', '42311013690C0K', '69210-0D190-C0', 'HANDLE FR LH 913L', '913L', '', 5.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(169, 'C001', '', 'KP36', '423110-13690-J4E', '42311013690J4E', '69210-0D190-J0', 'HANDLE A/S FR DR O/S RH ( Black MICA ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(170, 'C001', '', 'KP3A', '423110-13690-B3M', '42311013690B3M', '69210-0D190-B1', 'HANDLE A/S FR DR O/S RH ( Blue Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(171, 'C001', '', 'KP3I', '423110-13690-B3Q', '42311013690B3Q', '', 'HANDLE A/S FR DR O/S RH ( Gray Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(172, 'C001', '', 'KP3M', '423110-13690-A0A', '42311013690A0A', '69210-0D190-A0', 'HANDLE A/S FR DR O/S RH ( Silver Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(173, 'C001', '', 'KP3R', '423110-13690-D2X', '42311013690D2X', '', 'HANDLE A/S FR DR O/S RH ( White ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(174, 'C001', '', 'KP3Y', '423110-13690-B1L', '42311013690B1L', '', 'HANDLE ASSY, FR DOOR OUTSIDE RH, RED MICA METALLIC, 988A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(175, 'C001', '', 'KP58', '423120-13690-C0K', '42312013690C0K', '', 'HANDLE ASSY, FR DOOR OUTSIDE RH, SILVER METALIC', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(176, 'C001', '', 'KP37', '423120-13690-J4E', '42312013690J4E', '', 'HANDLE A/S FR DR O/S LH ( Black MICA ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(177, 'C001', '', 'KP3B', '423120-13690-B3M', '42312013690B3M', '', 'HANDLE A/S FR DR O/S LH ( Blue Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(178, 'C001', '', 'KP3J', '423120-13690-B3Q', '42312013690B3Q', '', 'HANDLE A/S FR DR O/S LH ( Gray Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(179, 'C001', '', 'KP3N', '423120-13690-A0A', '42312013690A0A', '', 'HANDLE A/S FR DR O/S LH ( Silver Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(180, 'C001', '', 'KP3T', '423120-13690-D2X', '42312013690D2X', '', 'HANDLE A/S FR DR O/S LH ( White ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(181, 'C001', '', 'KP2Y', '423120-13690-B1L', '42312013690B1L', '', 'HANDLE ASSY, FR DOOR OUTSIDE LH, RED MICA METALLIC, 988A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(182, 'C001', '', 'KP5G', '423130-11790-C0K', '42313011790C0K', '69230-0D140-C0', 'HANDLE ASSY, FR DOOR OUTSIDE LH, SILVER METALIC', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(183, 'C001', '', 'KP38', '423130-11790-J4E', '42313011790J4E', '69230-0D140-J0', 'HANDLE A/S FR DR O/S RH ( Black MICA ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(184, 'C001', '', 'KP3C', '423130-11790-B3M', '42313011790B3M', '69230-0D140-B1', 'HANDLE A/S FR DR O/S RH ( Blue Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(185, 'C001', '', 'KP3K', '423130-11790-B3Q', '42313011790B3Q', '', 'HANDLE A/S FR DR O/S RH ( Gray Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(186, 'C001', '', 'KP3O', '423130-11790-A0A', '42313011790A0A', '69230-0D140-A0', 'HANDLE A/S FR DR O/S RH ( Silver Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(187, 'C001', '', 'KP3V', '423130-11790-D2X', '42313011790D2X', '', 'HANDLE A/S FR DR O/S RH ( White ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(188, 'C001', '', 'KP2Z', '423130-11790-B1L', '42313011790B1L', '', 'HANDLE ASSY, RR DOOR OUTSIDE RH, RED MICA METALLIC, 988A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(189, 'C001', '', 'KP5A', '423140-11790-C0K', '42314011790C0K', '69240-0D140-C0', 'HANDLE ASSY, RR DOOR OUTSIDE RH, SILVER METALIC', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(190, 'C001', '', 'KP39', '423140-11790-J4E', '42314011790J4E', '69240-0D140-J0', 'HANDLE A/S FR DR O/S LH ( Black MICA ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(191, 'C001', '', 'KP3D', '423140-11790-B3M', '42314011790B3M', '69240-0D140-B1', 'HANDLE A/S FR DR O/S LH ( Blue Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(192, 'C001', '', 'KP3L', '423140-11790-B3Q', '42314011790B3Q', '', 'HANDLE A/S FR DR O/S LH ( Gray Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(193, 'C001', '', 'KP3P', '423140-11790-A0A', '42314011790A0A', '69240-0D140-A0', 'HANDLE A/S FR DR O/S LH ( Silver Metallic ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(194, 'C001', '', 'KP3X', '423140-11790-D2X', '42314011790D2X', '', 'HANDLE A/S FR DR O/S LH ( White ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(195, 'C001', '', 'KP31', '423140-11790-B1L', '42314011790B1L', '', 'HANDLE ASSY, RR DOOR OUTSIDE LH, RED MICA METALLIC, 988A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(196, 'C001', '', 'KP5B', '423110-13640', '42311013640', '69210-0D180', 'HANDLE ASSY, RR DOOR OUTSIDE LH, SILVER METALIC', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(197, 'C001', '', 'KP3E', '423120-13640', '42312013640', '69220-0D130', 'HANDLE A/S FR DR O/S RH ( Emboss ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(198, 'C001', '', 'KP3F', '423130-11780', '42313011780', '69230-0D130', 'HANDLE A/S FR DR O/S LH ( Emboss ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(199, 'C001', '', 'KP3G', '423140-11780', '42314011780', '69240-0D130', 'HANDLE A/S FR DR O/S RH ( Emboss ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(200, 'C001', '', 'KP3H', '423207-10420-A01', '42320710420A01', '69227-0K050-A0', 'HANDLE A/S FR DR O/S LH ( Emboss ) 700A', '700A', '', 12.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(201, 'C001', '', 'NP3V', '423207-10420-A0U', '42320710420A0U', '69227-0K050-A2', 'CAP S/A, RR DOOR OUTSIDE HANDLE RH, SUPER WHITE 2    ', '810A', '', 30.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(202, 'C001', '', 'NP36', '423207-10420-B1L', '42320710420B1L', '69227-0K050-B5', 'CAP S/A, RR DR O/S HDL RH, WHITE PEARL EFC-C', '810A', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(203, 'C001', '', 'NP37', '423207-10420-B2M', '42320710420B2M', '69227-0K050-B6', 'CAP S/A, RR DR O/S HDL RH, SILVER METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(204, 'C001', '', 'NP38', '423207-10420-C0H', '42320710420C0H', '69227-0K050-C2', 'CAP S/A, RR DOOR OUTSIDE HANDLE RH, GRAY METALIC, EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(205, 'C001', '', 'NP3U', '423207-10420-D2X', '42320710420D2X', '69227-0K050-D0', 'CAP S/A, RR DR O/S HDL RH, ATTITUDE BLACK MC 918A', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(206, 'C001', '', 'NP3A', '423207-10420-F10', '42320710420F10', '69227-0K050-E1', 'CAP S/A, RR DR O/S HDL RH, RED MICA METALIC EFC-C', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(207, 'C001', '', 'NP3B', '423207-10420-E37', '42320710420E37', '69227-0K050-E2', 'CAP S/A, RR DR O/S HDL RH, ORANGE METALIC EFC-C', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(208, 'C001', '', 'NP3C', '423207-10420-E38', '42320710420E38', '69227-0K050-E3', 'CAP S/A, RR DR O/S HDL RH, QUARTZ BROWN METALIC EFC-C', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(209, 'C001', '', 'NP3D', '423207-10420-J4F', '42320710420J4F', '69227-0K050-J3', 'CAP S/A, RR DR O/S HDL RH, SILKY BEIGE METALIC EFC-C', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(210, 'C001', '', 'NP3E', '423207-10210-Z1', '42320710210Z1', '', 'CAP S/A, RR DR O/S HDL RH, FROZEN BLUE METALIC EFC-C', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(211, 'C001', '', 'NP3W', '423205-10050', '42320510050', '69217-0K120', 'CAP O/S Rr Rh (Plating) IMV/D99B', '810A', '', 30.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(212, 'C001', '', 'NP3Y', '423207-10200-Z1', '42320710200Z1', '', 'CAP D99B/D28D/942L Plating', '810A', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(213, 'C001', '', 'NP3X', '423205-10050', '42320510050', '69217-0K120', 'CAP O/S Rr Rh (Emboss) IMV/D99B/D28D', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(214, 'C001', '', 'NP2Z', '423205-10050', '42320510050', '69217-0K120', 'CAP D99B/D28D/942L Plating', '692N(Export)', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(215, 'C003', '', 'NP2Z', '423205-10050', '42320510050', '69217-0K120', 'CAP D99B/D28D/942L Plating', 'D99B', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(216, 'C003', '', 'NP2Z', '423207-10210', '42320710210', '69227-0K040', 'CAP D99B/D28D/942L Plating', 'D54T', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(217, 'C001', '', 'NP29', '423207-10210', '42320710210', '69227-0K040', 'CAP O/S Rr Rh (Plating) IMV/D99B', '692N(Export)', '', 30.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(218, 'C003', '', 'NP29', '423207-10210', '42320710210', '69227-0K040', 'CAP O/S Rr Rh (Plating) IMV/D99B', 'D99B', '', 30.00, 5.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(219, 'C003', '', 'NP29', '423205-10030', '42320510030', '69217-0K130', 'CAP O/S Rr Rh (Plating) IMV/D99B', 'D54T', '', 30.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(220, 'C001', '', 'NP31', '423205-10030', '42320510030', '69217-0K130', 'CAP, FR DR OUTSIDE HANDLE LH, EMBOSS', '692N(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(221, 'C003', '', 'NP31', '423207-10200', '42320710200', '69227-0K030', 'CAP, FR DR OUTSIDE HANDLE LH, EMBOSS', 'D99B', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(222, 'C001', '', 'NP1V', '423207-10200', '42320710200', '69227-0K030', 'CAP O/S Rr Rh (Emboss) IMV/D99B/D28D', '692N(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(223, 'C003', '', 'NP1V', '423275-11050', '42327511050', '69217-0D480-A0', 'CAP, RR DR OUTSIDE HANDLE RH, EMBOSS', 'D99B', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(224, 'C001', '', 'NM09', '423205-10720', '42320510720', '69217-0D490-A0', 'CAP, FR DOOR OUTSIDE HANDLE, RH ', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(225, 'C001', '', 'NP5C', '423205-11870-AA7', '42320511870AA7', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH', '800A', '', 32.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(226, 'C004', '', 'NPJ3', '423205-11870-BAQ', '42320511870BAQ', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH,  WHITE', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(227, 'C004', '', 'NPJ4', '423205-11870-CA8', '42320511870CA8', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH, LH, SILVER', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(228, 'C004', '', 'NPJ5', '423205-11870-BAN', '42320511870BAN', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH, BLACK', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(229, 'C004', '', 'NPJ6', '423205-11870-EAD', '42320511870EAD', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH, GRAY', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(230, 'C004', '', 'NPJ7', '423205-11870-DAD', '42320511870DAD', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, BROWN', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(231, 'C004', '', 'NPJ8', '423206-11870-AA7', '42320611870AA7', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH, RED', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(232, 'C004', '', 'NPJ9', '423206-11870-BAQ', '42320611870BAQ', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, WHITE', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(233, 'C004', '', 'NPJA', '423206-11870-CA8', '42320611870CA8', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, SILVER', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(234, 'C004', '', 'NPJB', '423206-11870-BAN', '42320611870BAN', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, BLACK', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(235, 'C004', '', 'NPJC', '423206-11870-EAD', '42320611870EAD', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, GRAY', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(236, 'C004', '', 'NPJD', '423206-11870-DAD', '42320611870DAD', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, BROWN', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(237, 'C004', '', 'NPJE', '423205-11920', '42320511920', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH, RED', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(238, 'C004', '', 'NPJ1', '423206-11920', '42320611920', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH (PLAT.)', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(239, 'C004', '', 'NPJ2', '423110-10410-Z1', '42311010410Z1', '', 'CAP SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH (PLAT.)', '4l45W', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(240, 'C001', '', 'KP5V', '423110-10410', '42311010410', '69210-0K010', 'HANDLE ASSY O/S FR DR (PLATING) KD PLANT', '810A', '', 6.00, 44.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(241, 'C001', '', 'KP13', '423110-10410', '42311010410', '69210-0K010', 'HANDLE O/S IMV/D99B PLATING', '692N(Export)', '', 6.00, 101.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(242, 'C003', '', '', '423110-10410', '42311010410', '69210-0K010', 'HANDLE, FR DR OUTSIDE RH, PLATING', 'D99B', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(243, 'C003', '', 'KP13', '423111-10100', '42311110100', '69211-42010', 'HANDLE, FR DR OUTSIDE RH, PLATING', 'D28B', '', 6.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(244, 'C001', '', 'KP14', '423111-10100', '42311110100', '69211-42010', 'HANDLE O/S FR DR RH, EMBOSS, EFC-C/IMV', '692N(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(245, 'C003', '', '', '423110-14280', '42311014280', '', '', 'D99B', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(246, 'C004', '', 'KPJ1', '423120-14280', '42312014280', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH (PLAT.)', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(247, 'C004', '', 'KPJ2', '423110-14170-AA7', '42311014170AA7', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH  (PLAT.)', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(248, 'C004', '', 'KPJ3', '423110-14170-BAQ', '42311014170BAQ', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH,  WHITE', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(249, 'C004', '', 'KPJ4', '423110-14170-CA8', '42311014170CA8', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, SILVER', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(250, 'C004', '', 'KPJ5', '423110-14170-BAN', '42311014170BAN', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, BLACK', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(251, 'C004', '', 'KPJ6', '423110-14170-EAD', '42311014170EAD', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, GRAY', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(252, 'C004', '', 'KPJ7', '423110-14170-DAD', '42311014170DAD', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, BROWN', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(253, 'C004', '', 'KPJ8', '423120-14170-AA7', '42312014170AA7', '', 'HANDLE ASSY, FR DOOR OUTSIDE, RH, RED', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(254, 'C004', '', 'KPJ9', '423120-14170-BAQ', '42312014170BAQ', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH,  WHITE', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(255, 'C004', '', 'KPJA', '423120-14170-CA8', '42312014170CA8', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH, SILVER', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(256, 'C004', '', 'KPJB', '423120-14170-BAN', '42312014170BAN', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH, BLACK', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(257, 'C004', '', 'KPJC', '423120-14170-EAD', '42312014170EAD', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH, GRAY', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(258, 'C004', '', 'KPJD', '423120-14170-DAD', '42312014170DAD', '', 'HANDLE ASSY, FR DOOR OUTSIDE, LH, BROWN', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(259, 'C004', '', 'KPJE', '423110-13830', '42311013830', '69210-0K130', 'HANDLE ASSY, FR DOOR OUTSIDE, LH, RED', '4l45W', '', 20.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(260, 'C001', '', 'KP2O', '423110-13820-A01', '42311013820A01', '', 'HANDLE A/S FR DR O/S RH (PLATING)', '660A', '', 4.00, 189.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(261, 'C001', '', 'KP2M', '423110-13820-A0U', '42311013820A0U', '', 'HANDLE A/S FR DR O/S RH, SUPER WHITE', '660A', '', 4.00, 72.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(262, 'C001', '', 'KP46', '423110-13820-B2M', '42311013820B2M', '', 'HANDLE A/S FR DR O/S RH, PEARL WHITE', '660A', '', 4.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(263, 'C001', '', 'KP2W', '423110-13820-B1R', '42311013820B1R', '', 'HANDLE A/S FR DR O/S RH, DARK GRAY METALIC', '660A', '', 4.00, 45.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(264, 'C001', '', 'KP2V', '423110-13820-C0H', '42311013820C0H', '', 'HANDLE A/S FR DR O/S RH, SILVER METALIC', '660A', '', 4.00, 51.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(265, 'C001', '', 'KP3Z', '423110-13820-E35', '42311013820E35', '', 'HANDLE A/S FR DR O/S RH, ATTITUDE BLACK', '660A', '', 4.00, 84.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(266, 'C001', '', 'KP42', '423110-13820-E2V', '42311013820E2V', '', 'HANDLE A/S FR DR O/S RH, PHANTOM BROWN METALIC', '660A', '', 4.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(267, 'C001', '', 'KP41', '423110-13820-G3C', '42311013820G3C', '', 'HANDLE A/S FR DR O/S RH, AVANT GRADE BROWN', '660A', '', 4.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(268, 'C001', '', 'KP44', '423110-13820-J4N', '42311013820J4N', '', 'HANDLE A/S FR DR O/S RH, ALUMINA JADE', '660A', '', 4.00, 7.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(269, 'C001', '', 'KP43', '423110-13820-4Q0', '423110138204Q0', '', 'HANDLE A/S FR DR O/S RH NEBULA BLUE', '660A', '', 4.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(270, 'C001', '', 'KP5J', '423110-13820', '42311013820', '69210-0K320-A0', 'HANDLE A/S FR DR O/S RH YANMAR BEIGE', '660A', '', 4.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(271, 'C001', '', 'KP5H', '423110-14180-A01', '42311014180A01', '69211-0D370-A0', 'HANDLE A/S FR DR O/S RH', '660A', '', 4.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(272, 'C001', '', 'KP4E', '423110-14180-B1L', '42311014180B1L', '69211-0D370-B0', 'HANDLE, FR DOOR, OUTSIDE RH SUPER WHITE', '800A', '', 15.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(273, 'C001', '', 'KP4F', '423110-14180-B2M', '42311014180B2M', '69211-0D370-B1', 'HANDLE, FR DOOR, OUTSIDE RH SILVER METALIC', '800A', '', 15.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(274, 'C001', '', 'KP4G', '423110-14180-C0H', '42311014180C0H', '69211-0D370-C0', 'HANDLE, FR DOOR, OUTSIDE RHDARK GRAY METALIC', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(275, 'C001', '', 'KP4H', '423110-14180-E37', '42311014180E37', '69211-0D370-E2', 'HANDLE, FR DOOR, OUTSIDE RH ATTITUDE BLACK', '800A', '', 15.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(276, 'C001', '', 'KP4I', '423110-14180-F10', '42311014180F10', '69211-0D370-E0', 'HANDLE, FR DOOR, OUTSIDE RH QUARTZ BROWN METALIC', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(277, 'C001', '', 'KP4J', '423110-14180-E2N', '42311014180E2N', '69211-0D370-E1', 'HANDLE, FR DOOR, OUTSIDE RH ORANGE METALIC', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(278, 'C001', '', 'KP4K', '423110-14180-D2D', '42311014180D2D', '', 'HANDLE, FR DOOR, OUTSIDE RH DARK BROWN M.M', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(279, 'C001', '', 'KP5X', '423110-14190', '42311014190', '69211-0D380', 'HANDLE, FR DOOR, OUTSIDE RH RED MICA ', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(280, 'C001', '', 'KP4L', '423110-14180', '42311014180', '69211-0D370-A0', 'HANDLE, FR DOOR, OUTSIDE RH EMBOSS', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(281, 'C001', '', 'KP5D', '423130-11870-A01', '42313011870A01', '69213-0D170-A0', 'HANDLE, FR DOOR, OUTSIDE RH', '800A', '', 15.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(282, 'C001', '', 'KP4M', '423130-11870-B1L', '42313011870B1L', '69213-0D170-B0', 'HANDLE, RR DOOR OUTSIDE, RH SUPER WHITE', '800A', '', 15.00, 9.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(283, 'C001', '', 'KP4N', '423130-11870-B2M', '42313011870B2M', '69213-0D170-B1', 'HANDLE, RR DOOR OUTSIDE, RH SILVER METALIC', '800A', '', 15.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(284, 'C001', '', 'KP4O', '423130-11870-C0H', '42313011870C0H', '69213-0D170-C0', 'HANDLE, RR DOOR OUTSIDE, RH DARK GRAY METALIC', '800A', '', 15.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(285, 'C001', '', 'KP4Q', '423130-11870-E37', '42313011870E37', '69213-0D170-E2', 'HANDLE, RR DOOR OUTSIDE, RH ATTITUDE BLACK', '800A', '', 15.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(286, 'C001', '', 'KP4R', '423130-11870-F10', '42313011870F10', '69213-0D170-E0', 'HANDLE, RR DOOR OUTSIDE, RH QUARTZ BROWN METALIC', '800A', '', 15.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(287, 'C001', '', 'KP4S', '423130-11870-E2N', '42313011870E2N', '69213-0D170-E1', 'HANDLE, RR DOOR OUTSIDE, RH ORANGE METALIC', '800A', '', 15.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(288, 'C001', '', 'KP4T', '423130-11870-D2D', '42313011870D2D', '', 'HANDLE, RR DOOR OUTSIDE, RH DARK BROWN M.M', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(289, 'C001', '', 'KP5Y', '423130-11880', '42313011880', '69213-0D180', 'HANDLE, RR DOOR OUTSIDE, RH DARK RED MICA ', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(290, 'C001', '', 'KP4U', '423130-11870', '42313011870', '69213-0D170-A0', 'HANDLE, RR DOOR OUTSIDE, RH EMBOSS', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(291, 'C001', '', 'KP5E', '484170-11290', '48417011290', '', 'HANDLE, RR DOOR OUTSIDE, RH ', '800A', '', 15.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(292, 'C001', '', 'SP11', '423110-13830-Z1', '42311013830Z1', '', 'HANDLE ASSY,ELECTRICAL KEY,ANTENNA (SMART PLATING)', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(293, 'C001', '', 'KP5J', '423110-13820-Z1', '42311013820Z1', '', 'HANDLE ASSY,FR DOOR OUTSIDE (NORMAL PLATING)', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(294, 'C001', '', 'KP5H', '423110-13820-Z1-A01', '42311013820Z1A01', '', 'HANDLE ASSY, FR DOOR OUTSIDE (COLOR) PAINTLESS', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(295, 'C001', '', 'KP5M', '423110-13820-Z1-A0U', '42311013820Z1A0U', '', 'HANDLE ASSY, FR DOOR OUTSIDE SUPER WHITE 2', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(296, 'C001', '', 'KP5N', '423110-13820-B1L', '42311013820B1L', '', 'HANDLE ASSY, FR DOOR OUTSIDE WHITE PEARL CS', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(297, 'C001', '', 'KP5P', '423110-13820-Z1-B2M', '42311013820Z1B2M', '', 'HANDLE ASSY, FR DOOR OUTSIDE SILVER METALIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(298, 'C001', '', 'KP5Q', '423110-13820-Z1-C0H', '42311013820Z1C0H', '', 'HANDLE ASSY, FR DOOR OUTSIDE DARK GREY METALIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(299, 'C001', '', 'KP5R', '423110-13820-D2D', '42311013820D2D', '', 'HANDLE ASSY, FR DOOR OUTSIDE ATTITUDE BLACK', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(300, 'C001', '', 'KP5S', '423110-13820-F10', '42311013820F10', '', 'HANDLE ASSY, FR DOOR OUTSIDE RED MICA METALLIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(301, 'C001', '', 'KP5T', '423110-13820-E37', '42311013820E37', '', 'HANDLE ASSY, FR DOOR OUTSIDE ORANGE METALIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(302, 'C001', '', 'KP5U', '423110-13820-G3B', '42311013820G3B', '', 'HANDLE ASSY, FR DOOR OUTSIDE QUARTZ BROWN METALLIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(303, 'C001', '', 'KP5Z', '423110-13820-J4C', '42311013820J4C', '', 'HANDLE ASSY, FR DOOR OUTSIDE CITRUS MICA METALLIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(304, 'C001', '', 'KP6A', '423110-13840', '42311013840', '', 'HANDLE ASSY, FR DOOR OUTSIDE DARK BLUE METALLIC', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(305, 'C001', '', 'KP6B', '423207-11180-Z1', '42320711180Z1', '', 'HANDLE ASSY, FR DOOR OUTSIDE (EMBOSS)', '230B', '', 10.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(306, 'C001', '', 'NP5E', '423207-11200-Z1', '42320711200Z1', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE (PLATING)', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(307, 'C001', '', 'NP5F', '423207-11200-Z1-A01', '42320711200Z1A01', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE (COLOR) PAINTLESS', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(308, 'C001', '', 'NP5G', '423207-11200-Z1-A0U', '42320711200Z1A0U', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE SUPER WHITE 2', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(309, 'C001', '', 'NP5H', '423207-11200-B1L', '42320711200B1L', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE WHITE PEARL CS', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(310, 'C001', '', 'NP5J', '423207-11200-Z1-B2M', '42320711200Z1B2M', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE SILVER METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(311, 'C001', '', 'NP5K', '423207-11200-Z1-C0H', '42320711200Z1C0H', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE DARK GREY METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(312, 'C001', '', 'NP5L', '423207-11200-D2D', '42320711200D2D', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE ATTITUDE BLACK', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(313, 'C001', '', 'NP5M', '423207-11200-F10', '42320711200F10', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE RED MICA METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(314, 'C001', '', 'NP5N', '423207-11200-E37', '42320711200E37', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE ORANGE METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(315, 'C001', '', 'NP5P', '423207-11200-G3B', '42320711200G3B', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE QUARTZ BROWN METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(316, 'C001', '', 'NP5Q', '423207-11200-J4C', '42320711200J4C', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE CITRUS MICA METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(317, 'C001', '', 'NP5R', '423207-11190', '42320711190', '', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE DARK BLUE METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(318, 'C001', '', 'NP5S', '455105-10890', '45510510890', '75755-0D070', 'CAP SUB-ASSY,RR DOOR OUTSIDE HANDLE (EMBOSS)', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(319, 'C001', '', 'QP11', '455106-10780', '45510610780', '75756-0D070', 'MOULDING S/A, CENTER PILLAR FRAME, FR RH, EFC-C / 810-A 810-A', '810A', '', 12.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(320, 'C001', '', 'QP12', '455107-10920', '45510710920', '75761-0D050', 'MOULDING S/A, CENTER PILLAR FRAME, FR LH, EFC-C / 810-A 810-A', '810A', '', 12.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(321, 'C001', '', 'QP13', '455108-10880', '45510810880', '', 'MOULDING S/A, CENTER PILLAR FRAME, RR RH, EFC-C / 810-A 810-A', '810A', '', 12.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(322, 'C001', '', 'QP14', '455105-10950', '45510510950', '75755-0K010', 'MOULDING S/A, CENTER PILLAR FRAME, RR LH, EFC-C / 810-A 810-A', '810A', '', 12.00, 14.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(323, 'C001', '', 'QP16', '455106-10830', '45510610830', '75756-0K010', 'MOULDING, FR DOOR WINDOW FRAME, RR RH', '660A', '', 12.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(324, 'C001', '', 'QP17', '455107-10980', '45510710980', '75761-0K010', 'MOULDING, FR DOOR WINDOW FRAME, RR LH', '660A', '', 12.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(325, 'C001', '', 'QP18', '455108-10900', '45510810900', '75762-0K010', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '660A', '', 12.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(326, 'C001', '', 'QP19', '455105-10950-Z1', '45510510950Z1', '', 'MOULDING, RR DOOR WINDOW FRAME, FR LH', '660A', '', 12.00, 27.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(327, 'C001', '', 'QP1G', '455106-10830-Z1', '45510610830Z1', '', 'MOULDING, FR DOOR WINDOW FRAME, RR RH', '660A Export', '', 10.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(328, 'C001', '', 'QP1H', '455107-10980-Z1', '45510710980Z1', '', 'MOULDING, FR DOOR WINDOW FRAME, RR LH', '660A Export', '', 10.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(329, 'C001', '', 'QP1I', '455108-10900-Z1', '45510810900Z1', '', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '660A Export', '', 10.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(330, 'C001', '', 'QP1J', '455105-10970', '45510510970', '75755-0D080', 'MOULDING, RR DOOR WINDOW FRAME, FR LH', '660A Export', '', 10.00, 15.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(331, 'C001', '', 'QP1A', '455106-10840', '45510610840', '75756-0D080', 'MOULDING, FR DOOR WINDOW FRAME, RR RH', '800A', '', 10.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(332, 'C001', '', 'QP1B', '455107-11010', '45510711010', '75761-0D060', 'MOULDING, FR DOOR WINDOW FRAME, RR LH', '800A', '', 10.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(333, 'C001', '', 'QP1C', '455108-10950', '45510810950', '75762-0D060', 'MOULDING, RR DOOR WINDOW FRAME, FR RH', '800A', '', 8.00, 22.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(334, 'C001', '', 'QP1D', '455107-11020', '45510711020', '75765-0D010', 'MOULDING, RR DOOR WINDOW FRAME, FR LH', '800A', '', 8.00, 22.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(335, 'C001', '', 'QP1E', '455108-10970', '45510810970', '75766-0D010', 'MOULDING, RR DOOR WINDOW FRAME, RR RH', '800A', '', 10.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(336, 'C001', '', 'QP1F', '455105-10890-Z1', '45510510890Z1', '', 'MOULDING, RR DOOR WINDOW FRAME, RR LH', '800A', '', 10.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(337, 'C001', '', 'QP1K', '455106-10780-Z1', '45510610780Z1', '', 'MOULDING SUB-ASSY,CTR PILLAR FRAME,FR RH', '230B', '', 12.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(338, 'C001', '', 'QP1L', '455107-10920-Z1', '45510710920Z1', '', 'MOULDING SUB-ASSY,CTR PILLAR FRAME,FR LH', '230B', '', 12.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(339, 'C001', '', 'QP1M', '455108-10880-Z1', '45510810880Z1', '', 'MOULDING SUB-ASSY,CTR PILLAR FRAME,RR RH', '230B', '', 12.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(340, 'C001', '', 'QP1N', '439430-12511-Z1', '43943012511Z1', '', 'MOULDING SUB-ASSY,CTR PILLAR FRAME,RR LH', '230B', '', 12.00, 18.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(341, 'TTI', '', 'PPH1', '439430-12521-Z1', '43943012521Z1', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, SLIDE RH', '640A', '', 18.00, 35.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(342, 'TTI', '', 'PPH2', '439430-13330-Z1', '43943013330Z1', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, SLIDE LH', '640A', '', 18.00, 24.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(343, 'TTI', '', 'PPH3', '439430-13340-Z1', '43943013340Z1', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, REC RH', '640A', '', 14.00, 47.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(344, 'TTI', '', 'PPH4', '439430-12531-Z1', '43943012531Z1', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, REC LH', '640A', '', 14.00, 31.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(345, 'TTI', '', 'PPH5', '439430-12541-Z1', '43943012541Z1', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, TILT RH', '640A', '', 12.00, 51.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(346, 'TTI', '', 'PPH6', '439430-12511', '43943012511', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, TILT LH', '640A', '', 12.00, 35.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(347, 'TBINA', '', 'PPI1', '439430-12521', '43943012521', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, SLIDE RH', '640A', '', 12.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(348, 'TBINA', '', 'PPI2', '439430-13330', '43943013330', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, SLIDE LH', '640A', '', 12.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(349, 'TBINA', '', 'PPI3', '439430-13340', '43943013340', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, REC RH', '640A', '', 12.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(350, 'TBINA', '', 'PPI4', '439430-12531', '43943012531', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, REC LH', '640A', '', 12.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(351, 'TBINA', '', 'PPI5', '439430-12541', '43943012541', '', 'MOTOR ASSY, POWER SEAT, W/GEAR, TILT RH', '640A', '', 12.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(352, 'TBINA', '', 'PPI6', '413110-10410', '41311010410', '69370-0D010', 'MOTOR ASSY, POWER SEAT, W/GEAR, TILT LH', '640A', '', 12.00, 6.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(353, 'C001', '', 'RP11', '413120-10470', '41312010470', '69380-0D010', 'LOCK ASSY, SLIDE DOOR, FR RH ( W/ PROTECTOR )', '800A', '', 8.00, 33.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(354, 'C001', '', 'RP12', '423670-11010', '42367011010', '69070-0D010-C0', 'LOCK ASSY, SLIDE DOOR, FR LH ( W/ PROTECTOR )', '800A', '', 8.00, 22.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(355, 'C001', '', 'RP13', '423670-11020', '42367011020', '69070-0D020-C0', 'HANDLE ASSY,SLD DR INS W/REMOTE CONT,RH ', '800A', '', 6.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(356, 'C001', '', 'RP14', '423680-11040', '42368011040', '69080-0D010-C0', 'HANDLE ASSY,SLD DR INS W/REMOTE CONT,RH', '800A', '', 6.00, 10.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(357, 'C001', '', 'RP15', '423680-10890', '42368010890', '69080-0D020-C0', 'HANDLE ASSY,SLD DR INS W/REMOTE CONT,LH', '800A', '', 6.00, 29.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(358, 'C001', '', 'RP16', '416740-10300', '41674010300', '69409-0D010', 'HANDLE ASSY,SLD DR INS W/REMOTE CONT,LH', '800A', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(359, 'C001', '', 'RP22', '416520-10430', '41652010430', '69180-0D010', 'STOPPER ASSY, SLIDE DOOR HALF OPEN', '800A', '', 10.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(360, 'C001', '', 'RP21', '416520-10440', '41652010440', '69180-0D020', 'CONTROL ASSY, SLD DR HALF OPEN STOPPER', '800A', '', 16.00, 11.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(361, 'C001', '', 'RP23', '414530-10380', '41453010380', '69200-0D010', 'CONTROL ASSY, SLD DR HALF OPEN STOPPER', '800A', '', 16.00, 9.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(362, 'C001', '', 'RP17', '414530-10390', '41453010390', '69200-0D020', 'CLOSER ASSY, SLIDE DOOR, RH', '800A', '', 6.00, 20.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(363, 'C001', '', 'RP19', '414540-10600', '41454010600', '69300-0D010', 'CLOSER ASSY, SLIDE DOOR, RH', '800A', '', 6.00, 10.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(364, 'C001', '', 'RP18', '414540-10610', '41454010610', '69300-0D020', 'CLOSER ASSY, SLIDE DOOR, LH', '800A', '', 6.00, 29.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(365, 'C001', '', 'RP20', '426110-10600', '42611010600', '85005-0D010', 'CLOSER ASSY, SLIDE DOOR, LH', '800A', '', 6.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(366, 'C001', '', 'RP27', '426120-10650', '42612010650', '85006-0D010', 'UNIT, POWER SLIDING DOOR, RH', '800A', '', 2.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(367, 'C001', '', 'RP28', '426120-10730', '42612010730', '85006-0D020', 'UNIT, POWER SLIDING DOOR, LH', '800A', '', 2.00, 4.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(368, 'C001', '', 'RP24', '423105-11770', '42310511770', '', 'UNIT, POWER SLIDING DOOR, LH', '800A', '', 2.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(369, 'C004', '', 'MPJ1', '423105-11950', '42310511950', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH', '4L45W', '', 8.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(370, 'C004', '', 'MPJ3', '423106-11770', '42310611770', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH', '4L45W', '', 8.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(371, 'C004', '', 'MPJ2', '423105-11660-Z1', '42310511660Z1', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH', '4L45W', '', 8.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(372, 'C001', '', 'MPAB', '423106-11660-Z1', '42310611660Z1', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, RH ', '230B', '', 10.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(373, 'C001', '', 'MPAC', '423107-11940', '42310711940', '', 'FRAME SUB-ASSY, FR DOOR OUTSIDE HANDLE, LH ', '230B', '', 10.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(374, 'C001', '', 'MPAD', '423108-11940', '42310811940', '', 'FRAME SUB-ASSY, RR DOOR OUTSIDE HANDLE, RH', '230B', '', 10.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(375, 'C001', '', 'MPAE', '423187-10120', '42318710120', '', 'FRAME SUB-ASSY, RR DOOR OUTSIDE HANDLE, LH', '230B', '', 10.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(376, 'C002', '', 'KA2V', '423141-11170', '42314111170', '', 'CUSHION,DOOR OUTSIDE HANDLE', 'YL8', '', 500.00, 51.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(377, 'C002', '', 'KA2L', '423143-10130', '42314310130', '', 'PAD,FR DOOR OUTSIDE HANDLE,RH', 'YL8', '', 500.00, 34.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(378, 'C002', '', 'KA2N', '423275-10310', '42327510310', '', 'PAD,RR DOOR OUTSIDE HANDLE,RH', 'YL8', '', 500.00, 34.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(379, 'C002', '', 'NC11', '423141-10030-Z1', '42314110030Z1', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH EMBOSS', 'YL8', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(380, 'C001', '', 'KA37', '423141-10030', '42314110030', '69241-0D180', 'PAD FR DOOR OUTSIDE HANDLE RH', '810A', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(381, 'C001', '', 'KA2J', '423141-10030', '42314110030', '69241-0D180', 'PAD FR DOOR OUTSIDE HANDLE RH', '692N(Export)', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(382, 'C003', '', 'KA2J', '423143-10070-Z1', '42314310070Z1', '', 'PAD, FR DR OUTSIDE HANDLE', 'D99B', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(383, 'C001', '', 'KA2M', '423143-10070', '42314310070', '69241-0D190', 'PAD, REAR DOOR OUTSIDE HANDLE RH, EFC-C/810-A', '810A', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(384, 'C003', '', 'KP72', '423187-10020-Z1', '42318710020Z1', '', 'PAD, FR DR OUTSIDE HANDLE', 'D99B', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(385, 'C001', '', 'KA36', '423187-10020', '42318710020', '69242-0D120', 'PAD, REAR DOOR OUTSIDE HANDLE RH, EFC-C/810-A', '810A', '', 500.00, 34.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(386, 'C001', '', 'KA2T', '423187-10020', '42318710020', '69242-0D120', 'PAD FR DR, OUTSIDE HANDLE RR', '692N(Export)', '', 500.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(387, 'C003', '', 'KA2T', '423141-11620', '42314111620', '69241-0K070', 'PAD, FR DR OUTSIDE HANDLE LH', 'D99B', '', 500.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(388, 'C001', '', 'MCQ1', '423187-10670', '42318710670', '69242-0K060', 'PAD, FR DOOR OUTSIDE HANDLE, RH', '660A, 230B', '', 300.00, 62.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(389, 'C001', '', 'MCQ2', '423141-11360', '42314111360', '69241-0D210', 'CUSHION DOOR OUTSIDE HANDLE', '660A, 230B', '', 300.00, 62.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(390, 'C001', '', 'MCI4', '423187-10551', '42318710551', '69242-0D140', 'PAD, FR DOOR OUTSIDE HANDLE, FR', '800A', '', 300.00, 12.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(391, 'C001', '', 'MCI2', '423275-11070', '42327511070', '69217-0D500', 'PAD, FR DOOR OUTSIDE HANDLE, RR', '800A', '', 300.00, 12.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(392, 'C001', '', 'NA1Q', '423275-11890', '42327511890', '69217-0K250', 'CAP, FR DOOR OUTSIDE HANDLE, RH EMBOSS', '800A', '', 32.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(393, 'C001', '', 'NCVO', '423275-10030-Z1', '42327510030Z1', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH PLATING', '660A', '', 24.00, 16.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(394, 'C001', '', 'NCVS', '423275-10030', '42327510030', '69217-0K040', 'CAP Fr O/S Hdl Rh D99B, D28D (Plating)', '810A', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(395, 'C001', '', 'NCO2', '423275-10030', '42327510030', '69217-0K040', 'CAP Fr O/S Rh IMV (Plating)', '692N(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(396, 'C003', '', 'NCO2', '423275-10030', '42327510030', '69217-0K040', 'CAP Fr O/S Rh IMV (Plating)', 'D99B', '', 30.00, 16.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(397, 'C003', '', 'NCO2', '423275-10020-Z1', '42327510020Z1', '', 'CAP Fr O/S Rh IMV (Plating)', 'D28B', '', 30.00, 16.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(398, 'C001', '', 'NA1L', '423275-10020', '42327510020', '69217-0D380', 'CAP RR DR O/S HANDLE RH', '810A', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(399, 'C001', '', 'NA1J', '423275-10020', '42327510020', '69217-0D380', 'CAP RR DR O/S HANDLE RH', '692N(Export)', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(400, 'C003', '', 'NA1J', '423275-12280', '42327512280', '', 'CAP RR DR O/S HANDLE RH', 'D99B', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(401, 'C004', '', 'NCX1', '423276-12280', '42327612280', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH (PLAT.)', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(402, 'C004', '', 'NCX2', '423141-11690', '42314111690', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH (PLAT.)', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(403, 'C004', '', 'MCU1', '423142-11690', '42314211690', '', 'PAD, FR DOOR OUTSIDE HANDLE, RH', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(404, 'C004', '', 'MCU2', '423187-10840', '42318710840', '', 'PAD, FR DOOR OUTSIDE HANDLE, LH', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(405, 'C004', '', 'MCU3', '423197-10840', '42319710840', '', 'CUSHION, DOOR OUTSIDE HANDLE, RH', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(406, 'C004', '', 'MCU4', '423275-11890-Z1', '42327511890Z1', '', 'CUSHION, DOOR OUTSIDE HANDLE, LH', '4l45W', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(407, 'C001', '', 'NCO4', '423275-11900', '42327511900', '', 'CAP, FR DOOR OUTSIDE HANDLE (PLATING FR W/H)', '230B', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(408, 'C001', '', 'NM0G', '423125-10090-Z1', '42312510090Z1', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE (EMBOSS FR W/H)', '230B', '', 30.00, 17.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(409, 'AKL', '', 'MMG1', '423126-10060-Z1', '42312610060Z1', '', 'FRAME,FR DOOR OUTSIDE HANDLE,RH', '692N(AKL)', '', 52.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(410, 'AKL', '', 'MMG2', '423127-10090-Z1', '42312710090Z1', '', 'FRAME,FR DOOR OUTSIDE HANDLE,LH', '692N(AKL)', '', 52.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(411, 'AKL', '', 'MMG3', '423128-10080-Z1', '42312810080Z1', '', 'FRAME,RR DOOR OUTSIDE HANDLE,RH', '692N(AKL)', '', 78.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(412, 'AKL', '', 'MMG4', '423275-10290-BD3', '42327510290BD3', '', 'FRAME,RR DOOR OUTSIDE HANDLE,LH', '692N(AKL)', '', 78.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(413, 'C002', '', 'NN37', '423275-10290-CDC', '42327510290CDC', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH METALIC SILKY SILVER', 'YL8', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(414, 'C002', '', 'NN38', '423275-10290-BDB', '42327510290BDB', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH PRIME COOL BLACK', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(415, 'C002', '', 'NN39', '423275-10290-DDS', '42327510290DDS', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH PRIME GRAPHITE GRAY', 'YL8', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(416, 'C002', '', 'NN3A', '423275-10290-DDR', '42327510290DDR', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH RADIANT RED PEARL', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(417, 'C002', '', 'NN3B', '423275-10290-ADE', '42327510290ADE', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH PEARL BURGUNDY RED', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(418, 'C002', '', 'NN3C', '423275-10290-KD3', '42327510290KD3', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH PRL. SNOW WHITE 4', 'YL8', '', 30.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(419, 'C002', '', 'NN3E', '423275-10290-KD4', '42327510290KD4', '', 'CAP,FR DOOR OUTSIDE HANDLE,RH MET. LILAC GRAY', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(420, 'C002', '', 'NN3D', '423275-10290-KD4', '42327510290KD4', '69201-0K040', 'CAP,FR DOOR OUTSIDE HANDLE,RH PEARL TWILIGHT VIOLET', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(421, 'C001', '', 'NA18', '423111-10250-A01', '42311110250A01', '69211-0K050-A0', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE (PAINTLESS)', 'YL8', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(422, 'C001', '', 'KN25', '423111-10250-A0U', '42311110250A0U', '69211-0K050-A2', 'HANDLE O/S SUPER WHITE 669L', '810A', '', 18.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(423, 'C001', '', 'KN26', '423111-10250-B1L', '42311110250B1L', '69211-0K050-B5', 'HANDLE, FR DR O/S RH WHITE PEARL EFC-C', '810A', '', 18.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(424, 'C001', '', 'KN27', '423111-10250-B2M', '42311110250B2M', '69211-0K050-B6', 'HANDLE, FR DOOR OUTSIDE RH, SILVER METALIC, EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(425, 'C001', '', 'KN28', '423111-10250-C0H', '42311110250C0H', '69211-0K050-C2', 'HANDLE, FR DR O/S RH GRAY METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(426, 'C001', '', 'KN29', '423111-10250-D2X', '42311110250D2X', '69211-0K050-D0', 'HANDLE, FR DR O/S RH ATTITUDE BLACK MC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(427, 'C001', '', 'KN2A', '423111-10250-F10', '42311110250F10', '69211-0K050-E1', 'HANDLE, FR DR O/S RH RED MICA METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(428, 'C001', '', 'KN2B', '423111-10250-E37', '42311110250E37', '69211-0K050-E2', 'HANDLE, FR DR O/S RH ORANGE METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(429, 'C001', '', 'KN2C', '423111-10250-E38', '42311110250E38', '69211-0K050-E3', 'HANDLE, FR DR O/S RH QUARTZ BROWN METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(430, 'C001', '', 'KN2E', '423111-10250-J4F', '42311110250J4F', '69211-0K050-J3', 'HANDLE, FR DR O/S RH SILKY BEIGE METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(431, 'C001', '', 'KN2F', '423275-10010-A01', '42327510010A01', '69217-0K020-A0', 'HANDLE, FR DR O/S RH FROZEN BLUE METALIC EFC-C', '810A', '', 18.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(432, 'C001', '', 'NN3P', '423275-10010-A0U', '42327510010A0U', '69217-0K020-A2', 'CAP, FR DOOR OUTSIDE HANDLE RH, SUPER WHITE 2     ', '810A', '', 30.00, 8.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(433, 'C001', '', 'NN3Q', '423275-10010-B1L', '42327510010B1L', '69217-0K020-B5', 'CAP FR DOOR OUSIDE HANDLE RH, WHITE PEARL, EFC-C', '810A', '', 30.00, 5.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(434, 'C001', '', 'NN3R', '423275-10010-B2M', '42327510010B2M', '69217-0K020-B6', 'CAP FR DOOR OUSIDE HANDLE RH, SILVER METALIC, EFC-C', '810A', '', 30.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(435, 'C001', '', 'NN3S', '423275-10010-C0H', '42327510010C0H', '69217-0K020-C2', 'CAP, FR DR OUSIDE HDL RH, SILVER METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(436, 'C001', '', 'NN3T', '423275-10010-D2X', '42327510010D2X', '69217-0K020-D0', 'CAP, FR DR OUSIDE HDL RH, GRAY METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(437, 'C001', '', 'NN3V', '423275-10010-F10', '42327510010F10', '69217-0K020-E1', 'CAP, FR DR OUSIDE HDL RH, ATTITUDE BLACK MC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(438, 'C001', '', 'NCVF', '423275-10010-E37', '42327510010E37', '69217-0K020-E2', 'CAP, FR DR OUSIDE HDL RH, ORANGE METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(439, 'C001', '', 'NN3X', '423275-10010-E38', '42327510010E38', '69217-0K020-E3', 'CAP, FR DR OUSIDE HDL RH, RED MICA METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(440, 'C001', '', 'NN3Y', '423275-10010-J4F', '42327510010J4F', '69217-0K020-J3', 'CAP, FR DR OUSIDE HDL RH, QUARTZ BROWN METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(441, 'C001', '', 'NN3Z', '423275-11050-A01', '42327511050A01', '69217-0D480-A0', 'CAP, FR DR OUSIDE HDL RH, SILKY BEIGE METALIC EFC-C', '810A', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(442, 'C001', '', 'NN0S', '423275-11050-B1L', '42327511050B1L', '69217-0D480-B0', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE SUPER WHITE', '800A', '', 32.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(443, 'C001', '', 'NN0T', '423275-11050-B2M', '42327511050B2M', '69217-0D480-B1', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE SILVER METALIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(444, 'C001', '', 'NN0U', '423275-11050-C0H', '42327511050C0H', '69217-0D480-C0', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE DARK GRAY METALIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(445, 'C001', '', 'NN0V', '423275-11050-E37', '42327511050E37', '69217-0D480-E2', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE ATTITUDE BLACK', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(446, 'C001', '', 'NN0W', '423275-11050-F10', '42327511050F10', '69217-0D480-E0', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE QUARTZ BROWN METALIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(447, 'C001', '', 'NN0X', '423275-11050-E2N', '42327511050E2N', '69217-0D480-E1', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE ORANGE METALIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(448, 'C001', '', 'NN0Y', '423275-11050-D2D', '42327511050D2D', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE DARK BROWN M.M', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(449, 'C001', '', 'NN61', '423275-11920-A01', '42327511920A01', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH HOLE RED MICA METALLIC', '800A', '', 32.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(450, 'C001', '', 'NN0J', '423275-11920-A0U', '42327511920A0U', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, SUPER WHITE', '660A', '', 24.00, 5.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(451, 'C001', '', 'NN0K', '423275-11920-B2M', '42327511920B2M', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, PEARL WHITE', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(452, 'C001', '', 'NN0M', '423275-11920-B1R', '42327511920B1R', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, DARK GRAY METALIC', '660A', '', 24.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(453, 'C001', '', 'NN0L', '423275-11920-C0H', '42327511920C0H', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, SILVER METALIC', '660A', '', 24.00, 3.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(454, 'C001', '', 'NN0N', '423275-11920-E35', '42327511920E35', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, ATTITUDE BLACK', '660A', '', 24.00, 5.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(455, 'C001', '', 'NN0P', '423275-11920-E2V', '42327511920E2V', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, PHANTOM BROWN METALIC', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(456, 'C001', '', 'NN0O', '423275-11920-G3C', '42327511920G3C', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH , AVANT GRADE BROWN', '660A', '', 24.00, 2.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(457, 'C001', '', 'NN0Q', '423275-11920-J4N', '42327511920J4N', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, ALUMINA JADE', '660A', '', 24.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(458, 'C001', '', 'NN0R', '423275-11920-4Q0', '423275119204Q0', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, NEBULA BLUE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(459, 'C001', '', 'NN46', '423275-10800-BD3', '42327510800BD3', '', 'CAP HOLE, FR DOOR OUTSIDE HANDLE, RH, YANMAR BEIGE', '660A', '', 24.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(460, 'C002', '', 'NN17', '423275-10800-CDC', '42327510800CDC', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, METALIC SILKY SILVER', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(461, 'C002', '', 'NN19', '423275-10800-BDB', '42327510800BDB', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, PRIME COOL BLACK', 'YL8(Export)', '', 30.00, 0.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(462, 'C002', '', 'NN2A', '423275-10800-DDS', '42327510800DDS', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, PRIME GRAPHITE GRAY', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(463, 'C002', '', 'NN2B', '423275-10800-DDR', '42327510800DDR', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, RADIANT RED PEARL', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(464, 'C002', '', 'NN18', '423275-10800-ADE', '42327510800ADE', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, PRL. BURGUNDY RED', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(465, 'C002', '', 'NN2C', '423275-10800-KD3', '42327510800KD3', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, PRL SNOW WHITE 4', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(466, 'C002', '', 'NN43', '423275-12200-AA7', '42327512200AA7', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, HOLE, MET. LILAC GRAY', 'YL8(Export)', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(467, 'C004', '', 'NN57', '423275-12200-BAQ', '42327512200BAQ', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH,  WHITE', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(468, 'C004', '', 'NN58', '423275-12200-CA8', '42327512200CA8', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, SILVER', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(469, 'C004', '', 'NN59', '423275-12200-BAN', '42327512200BAN', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, BLACK', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(470, 'C004', '', 'NN49', '423275-12200-EAD', '42327512200EAD', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, GRAY', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(471, 'C004', '', 'NN4A', '423275-12200-DAD', '42327512200DAD', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, BROWN', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(472, 'C004', '', 'NN4B', '423276-12200-AA7', '42327612200AA7', '', 'CAP, FR DOOR OUTSIDE HANDLE, RH, RED', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(473, 'C004', '', 'NN4C', '423276-12200-BAQ', '42327612200BAQ', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH,  WHITE', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(474, 'C004', '', 'NN4D', '423276-12200-CA8', '42327612200CA8', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH, SILVER', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(475, 'C004', '', 'NN4E', '423276-12200-BAN', '42327612200BAN', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH, BLACK', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(476, 'C004', '', 'NN4F', '423276-12200-EAD', '42327612200EAD', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH, GRAY', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(477, 'C004', '', 'NN4G', '423276-12200-DAD', '42327612200DAD', '', 'CAP, FR DOOR OUTSIDE HANDLE, LH, BROWN', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(478, 'C004', '', 'NN4H', '423275-11920', '42327511920', '69217-0K550-A0', 'CAP, FR DOOR OUTSIDE HANDLE, LH, RED', '4L45W', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(479, 'C001', '', 'NM08', '423275-11920-Z1-A01', '42327511920Z1A01', '', 'CAP, FR DOOR OUTSIDE HANDLE (COLOR FR W/H) PAINTLESS', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(480, 'C001', '', 'NN0J', '423275-11920-Z1-A0U', '42327511920Z1A0U', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE SUPER WHITE 2', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(481, 'C001', '', 'NN0K', '423275-11920-B1L', '42327511920B1L', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE WHITE PEARL CS', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(482, 'C001', '', 'NN4U', '423275-11920-Z1-B2M', '42327511920Z1B2M', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE SILVER METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(483, 'C001', '', 'NN5A', '423275-11920-Z1-C0H', '42327511920Z1C0H', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE DARK GREY METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(484, 'C001', '', 'NN0N', '423275-11920-D2D', '42327511920D2D', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE ATTITUDE BLACK', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(485, 'C001', '', 'NN4V', '423275-11920-F10', '42327511920F10', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE RED MICA METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(486, 'C001', '', 'NN4W', '423275-11920-E37', '42327511920E37', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE ORANGE METALIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(487, 'C001', '', 'NN4X', '423275-11920-G3B', '42327511920G3B', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE QUARTZ BROWN METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(488, 'C001', '', 'NN4Y', '423275-11920-J4C', '42327511920J4C', '', 'CAP, FR DOOR OUTSIDE HANDLE HOLE CITRUS MICA METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(489, 'C001', '', 'NN4Z', '423275-11920-J4C', '42327511920J4C', '69201-0K040', 'CAP, FR DOOR OUTSIDE HANDLE HOLE DARK BLUE METALLIC', '230B', '', 30.00, 1.00, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `avi_parts` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_part_pis
CREATE TABLE IF NOT EXISTS `avi_part_pis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_number_agbond` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_kind` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `part_dock` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `back_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_kanban` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_part_pis: ~2 rows (approximately)
/*!40000 ALTER TABLE `avi_part_pis` DISABLE KEYS */;
INSERT INTO `avi_part_pis` (`id`, `part_number`, `part_number_agbond`, `part_kind`, `part_dock`, `back_number`, `qty_kanban`, `created_at`, `updated_at`) VALUES
	(1, '423108-11770', NULL, 'OEM', '43', 'MP24', 5.00, '2017-09-20 13:44:39', '2017-09-20 13:44:39'),
	(2, '423108-11770', NULL, 'GNP', '53', 'MP24', 1.00, '2017-09-20 13:44:58', '2017-09-20 13:44:59');
/*!40000 ALTER TABLE `avi_part_pis` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.avi_uoms
CREATE TABLE IF NOT EXISTS `avi_uoms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_uoms: ~13 rows (approximately)
/*!40000 ALTER TABLE `avi_uoms` DISABLE KEYS */;
INSERT INTO `avi_uoms` (`id`, `code`, `sname`, `fname`, `created_at`, `updated_at`) VALUES
	(1, 'PC', 'pcs', 'Piece', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'KG', 'kg', 'Kilogram', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'G', 'gram', 'Gram', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 'M', 'meter', 'Meter', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 'L', 'liter', 'Liter', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 'PAC', 'pack', 'Pack', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(7, 'SET', 'set', 'Set', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, 'ROL', 'rol', 'Role', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, 'BAG', 'bag', 'Bag', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, 'PAA', 'pair', 'Pair', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(11, 'DR', 'drum', 'Drum', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(12, 'BT', 'bottle', 'Bottle', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(13, 'CAR', 'carton', 'Carton', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `avi_uoms` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.permissions: ~11 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'create', '2017-08-24 16:29:18', '2017-08-24 16:29:18'),
	(2, 'modify', '2017-08-24 16:29:34', '2017-08-24 16:29:34'),
	(3, 'delete', '2017-08-24 16:29:45', '2017-08-24 16:29:46'),
	(4, 'show', '2017-08-24 16:30:02', '2017-08-24 16:30:03'),
	(5, 'register', '2017-08-24 16:32:46', '2017-08-24 16:32:46'),
	(6, 'unregister', '2017-08-24 16:47:21', '2017-08-24 16:47:22'),
	(7, 'backup', '2017-08-24 16:47:38', '2017-08-24 16:47:38'),
	(8, 'restore', '2017-08-24 16:47:43', '2017-08-24 16:47:44'),
	(9, 'insert', '2017-08-24 16:48:11', '2017-08-24 16:48:12'),
	(10, 'update', '2017-08-24 16:48:22', '2017-08-24 16:48:22'),
	(11, 'scan', '2017-09-18 12:00:24', '2017-09-18 12:00:25');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `route_redirect` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.roles: ~10 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `route_redirect`, `created_at`, `updated_at`) VALUES
	(1, 'ais_admin', NULL, '2017-08-24 16:09:06', '2017-08-24 16:09:07'),
	(2, 'avi_admin', NULL, '2017-08-24 16:19:30', '2017-08-24 16:19:33'),
	(3, 'avi_leader', NULL, '2017-08-24 16:20:29', '2017-08-24 16:20:30'),
	(4, 'avi_entry', NULL, '2017-08-24 16:21:37', '2017-08-24 16:21:38'),
	(5, 'avi_operator', NULL, '2017-08-24 16:24:01', '2017-08-24 16:24:01'),
	(6, 'avi_spv', NULL, '2017-08-24 16:24:13', '2017-08-24 16:24:14'),
	(7, 'avi_mgr', NULL, '2017-08-24 16:24:25', '2017-08-24 16:24:26'),
	(8, 'avi_gm', NULL, '2017-08-24 16:24:36', '2017-08-24 16:24:37'),
	(9, 'avi_bod', NULL, '2017-08-24 16:24:49', '2017-08-24 16:24:50'),
	(10, 'avi_pis_scan', 'pis', '2017-08-24 16:37:05', '2017-08-24 16:37:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.role_has_apps
CREATE TABLE IF NOT EXISTS `role_has_apps` (
  `role_id` int(10) unsigned NOT NULL,
  `apps_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`apps_id`),
  KEY `role_has_apps_apps_id_foreign` (`apps_id`),
  CONSTRAINT `role_has_apps_apps_id_foreign` FOREIGN KEY (`apps_id`) REFERENCES `ais_apps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_apps_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.role_has_apps: ~27 rows (approximately)
/*!40000 ALTER TABLE `role_has_apps` DISABLE KEYS */;
INSERT INTO `role_has_apps` (`role_id`, `apps_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
	(1, 8),
	(1, 9),
	(1, 10),
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(2, 5),
	(2, 6),
	(3, 1),
	(3, 2),
	(3, 3),
	(3, 5),
	(3, 6),
	(4, 1),
	(4, 2),
	(4, 4),
	(10, 1),
	(10, 2),
	(10, 3);
/*!40000 ALTER TABLE `role_has_apps` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.role_has_permissions: ~4 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(2, 4),
	(11, 10);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `npk` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.users: ~11 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `npk`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, '000017', 'Ferry Avianto', 'ferry@aiia.co.id', '$2y$10$1rJ/l5UiRxByX6zXezWTDej9pXkYBvtaKRc39L4uUpGOK/vu91fDG', 'Wo9YFD9Gg9CpVB3IbgqFfX0hzkGVoDDExJ1T5ZtfpQEszBNEeJu2u9RoSgTa', '2017-08-21 08:15:12', '2017-08-21 08:15:12'),
	(2, '001018', 'Yudo Maryanto', 'yudo@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'sV06IDGruLgsKg1MbszvHegDGc18rmHVBrOccPfU7nklFtTa8asH1E6EQXtk', '2017-08-24 10:25:07', '2017-08-24 10:25:07'),
	(3, '000124', 'Rizal Fahlepi', 'rizal@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'CpJ4lRrdhQ4WbWtlO2ClErNfuvqI5mBuEi1GxNZEFBOV17cvXzxtw9Ja6D8G', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, '000120', 'Ahmad Bayu', 'bayu@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '9dpfRFaqmgoD91P2mQK8q78qm9C6uvX0bcTu6nVcD79bnVU0SgFw6VcMaIaB', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, '000453', 'Bagas Jati', 'bagas.wicaksono@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, '000755', 'Ahmad Nur Sidiq', 'pis1@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '7Av7buG6RhQVhlULyzLFFzvbtkelS9DBvTVX1DHzBGf1kamaLwSQvbH6uUwN', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(7, '000940', 'Adi Rahmat', 'pis2@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'kOa1JEL4yIvmW96xC1Dme4FWxmyqQVyONTRf2CY7UsE6BZzK3u0UKTKSmJhH', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, '000416', 'Rian Fauzi', 'pis3@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '2luxtyMy0P7Y0s3RC95c1rhflBCcA3clYywyUepzLelVjIrCPwE8LLOZ0Q3i', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, '001115', 'Wahyu Suyanto', 'pis4@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'tc9QL1fUcTyh9vDtF4waxhOTLn8h7cwK2KmnuMVpBoajr5PY88WSfZfJ6DzC', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, '000149', 'Umbul Wahyu', 'pis5@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(11, '000146', 'Ahmad Khoeri', 'pis6@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.user_has_permissions
CREATE TABLE IF NOT EXISTS `user_has_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_has_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `user_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.user_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_permissions` ENABLE KEYS */;


-- Dumping structure for table avicenna.dev.user_has_roles
CREATE TABLE IF NOT EXISTS `user_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_has_roles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.user_has_roles: ~12 rows (approximately)
/*!40000 ALTER TABLE `user_has_roles` DISABLE KEYS */;
INSERT INTO `user_has_roles` (`role_id`, `user_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 2),
	(3, 3),
	(3, 4),
	(3, 5),
	(10, 6),
	(10, 7),
	(10, 8),
	(10, 9),
	(10, 10),
	(10, 11);
/*!40000 ALTER TABLE `user_has_roles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
