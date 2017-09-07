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

-- Dumping structure for table avicenna.dev.avi_uoms
CREATE TABLE IF NOT EXISTS `avi_uoms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_uoms: ~0 rows (approximately)
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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
