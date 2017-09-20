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

-- Dumping structure for table avicenna.dev.avi_part_pis
CREATE TABLE IF NOT EXISTS `avi_part_pis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_kind` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `part_dock` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `back_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_kanban` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_part_pis: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_part_pis` DISABLE KEYS */;
INSERT INTO `avi_part_pis` (`id`, `part_number`, `part_kind`, `part_dock`, `back_number`, `qty_kanban`, `created_at`, `updated_at`) VALUES
	(1, '423108-11770', 'OEM', '43', 'MP24', 5.00, '2017-09-20 13:44:39', '2017-09-20 13:44:39'),
	(2, '423108-11770', 'GNP', '53', 'MP24', 1.00, '2017-09-20 13:44:58', '2017-09-20 13:44:59');
/*!40000 ALTER TABLE `avi_part_pis` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
