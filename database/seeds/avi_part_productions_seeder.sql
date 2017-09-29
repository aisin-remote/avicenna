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

-- Dumping structure for table avicenna.dev.avi_part_productions
CREATE TABLE IF NOT EXISTS `avi_part_productions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_number_ag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_number_kanban` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line_number_ag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_kanban` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_part_productions: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_part_productions` DISABLE KEYS */;
INSERT INTO `avi_part_productions` (`id`, `part_number`, `part_number_ag`, `part_number_kanban`, `line_number`, `line_number_ag`, `back_number`, `qty_kanban`, `created_at`, `updated_at`) VALUES
	(1, '439430-12511', '', '', 'AS600', '', 'PPH1', 18.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(2, '439430-12521', '', '', 'AS600', '', 'PPH2', 18.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(3, '439430-12511', '', '', 'AS600', '', 'PPI1', 18.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(4, '439430-12521', '', '', 'AS600', '', 'PPI2', 18.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(5, '439430-13330', '', '', 'AS600', '', 'PPH3', 14.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(6, '439430-13340', '', '', 'AS600', '', 'PPH4', 14.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(7, '439430-13330', '', '', 'AS600', '', 'PPI3', 14.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(8, '439430-13340', '', '', 'AS600', '', 'PPI4', 14.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(9, '439430-12531', '', '', 'AS600', '', 'PPH5', 12.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(10, '439430-12541', '', '', 'AS600', '', 'PPH6', 12.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(11, '439430-12531', '', '', 'AS600', '', 'PPI5', 12.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00'),
	(12, '439430-12541', '', '', 'AS600', '', 'PPI6', 12.00, '2017-09-29 00:00:00', '2017-09-29 00:00:00');
/*!40000 ALTER TABLE `avi_part_productions` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
