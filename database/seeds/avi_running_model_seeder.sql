-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.1.9-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table avicenna.avi_running_model
CREATE TABLE IF NOT EXISTS `avi_running_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_number` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `back_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `part_number` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `running_qty` int(11) NOT NULL,
  `dandori_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_mutation` int(11) NOT NULL,
  `cumulative_qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.avi_running_model: ~6 rows (approximately)
/*!40000 ALTER TABLE `avi_running_model` DISABLE KEYS */;
INSERT INTO `avi_running_model` (`id`, `line_number`, `back_number`, `part_number`, `running_qty`, `dandori_date`, `id_mutation`, `cumulative_qty`, `created_at`, `updated_at`) VALUES
	(1, 'AS600', 'PPH6', '439430-12541', 603, '2018-04-04 10:27:07', 235433, 0, '2018-01-05 11:03:32', '2018-04-04 10:27:06'),
	(2, 'AS731', 'RP22', '416740-10300-A', 0, '2018-05-15 09:03:12', 300736, 229, '2018-01-16 10:04:00', '2018-05-15 09:03:12'),
	(3, 'AS751', 'A', 'A', 0, '2018-05-22 09:57:34', 0, 0, '2018-05-22 09:02:40', '2018-05-22 09:02:45'),
	(4, 'AS547', 'B', 'B', 0, '2018-05-22 09:57:37', 0, 0, '2018-05-22 09:02:41', '2018-05-22 09:02:46'),
	(5, 'AS523', 'C', 'C', 0, '2018-05-22 09:57:39', 0, 0, '2018-05-22 09:02:42', '2018-05-22 09:02:47'),
	(6, 'AS546', 'D', 'D', 0, '2018-05-22 09:57:42', 0, 0, '2018-05-22 09:02:43', '2018-05-22 09:02:49');
/*!40000 ALTER TABLE `avi_running_model` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
