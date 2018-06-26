-- --------------------------------------------------------
-- Host:                         172.18.3.9
-- Versi server:                 5.5.41-MariaDB - MariaDB Server
-- OS Server:                    Linux
-- HeidiSQL Versi:               9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table avicenna_dev.avi_running_model
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna_dev.avi_running_model: ~7 rows (approximately)
/*!40000 ALTER TABLE `avi_running_model` DISABLE KEYS */;
REPLACE INTO `avi_running_model` (`id`, `line_number`, `back_number`, `part_number`, `running_qty`, `dandori_date`, `id_mutation`, `cumulative_qty`, `created_at`, `updated_at`) VALUES
	(1, 'AS600', 'PPH4', '439430-13340', 137, '2018-05-31 12:44:02', 315125, 749, '2018-01-05 11:03:32', '2018-05-31 12:44:02'),
	(2, 'AS731', 'RP21', '416520-10430-A', 0, '2018-05-31 11:41:19', 327167, 0, '2018-01-16 10:04:00', '2018-05-31 11:41:19'),
	(3, 'AS751', 'RP28', '426120-10651', -48, '2018-05-31 06:01:01', 324783, 48, '2018-05-21 08:13:28', '2018-05-31 06:01:01'),
	(4, 'AS523', 'KP2O', '423110-13830', 0, '2018-05-30 12:56:03', 324784, 0, '2018-05-21 08:14:44', '2018-05-30 12:56:03'),
	(5, 'AS547', 'MPJ4', '423106-11770', 0, '2018-05-31 11:11:02', 324787, 15, '2018-05-21 08:14:50', '2018-05-31 11:11:02'),
	(6, 'AS546', 'MP21', '423105-11660', -121, '2018-05-31 12:44:02', 324786, 790, '2018-05-21 08:14:49', '2018-05-31 12:44:02'),
	(7, 'AS721', 'RP36', '423680-11041', 0, '2018-05-31 11:15:51', 0, 0, '2018-05-31 11:15:53', '2018-05-31 11:15:54');
/*!40000 ALTER TABLE `avi_running_model` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
