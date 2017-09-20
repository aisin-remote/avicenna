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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
