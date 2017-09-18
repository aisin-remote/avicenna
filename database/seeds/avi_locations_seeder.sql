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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
