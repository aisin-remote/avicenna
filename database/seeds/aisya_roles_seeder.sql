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

-- Dumping structure for table avicenna.dev.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.roles: ~10 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'ais_admin', '2017-08-24 16:09:06', '2017-08-24 16:09:07'),
	(2, 'avi_admin', '2017-08-24 16:19:30', '2017-08-24 16:19:33'),
	(3, 'avi_leader', '2017-08-24 16:20:29', '2017-08-24 16:20:30'),
	(4, 'avi_entry', '2017-08-24 16:21:37', '2017-08-24 16:21:38'),
	(5, 'avi_operator', '2017-08-24 16:24:01', '2017-08-24 16:24:01'),
	(6, 'avi_spv', '2017-08-24 16:24:13', '2017-08-24 16:24:14'),
	(7, 'avi_mgr', '2017-08-24 16:24:25', '2017-08-24 16:24:26'),
	(8, 'avi_gm', '2017-08-24 16:24:36', '2017-08-24 16:24:37'),
	(9, 'avi_bod', '2017-08-24 16:24:49', '2017-08-24 16:24:50'),
	(10, 'avi_pis_scan', '2017-08-24 16:37:05', '2017-08-24 16:37:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
