-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table avicenna.avi_dashboard_genbas
CREATE TABLE IF NOT EXISTS `avi_dashboard_genbas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categories` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normal` int(11) DEFAULT NULL,
  `abnormality` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.avi_dashboard_genbas: ~4 rows (approximately)
/*!40000 ALTER TABLE `avi_dashboard_genbas` DISABLE KEYS */;
INSERT INTO `avi_dashboard_genbas` (`id`, `categories`, `normal`, `abnormality`, `created_at`, `updated_at`) VALUES
	(1, '4l45W', 80, 20, NULL, NULL),
	(2, '230B', 70, 20, NULL, NULL),
	(3, '640A', 60, 30, NULL, NULL),
	(4, '692N(Export)', 30, 0, NULL, NULL);
/*!40000 ALTER TABLE `avi_dashboard_genbas` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
