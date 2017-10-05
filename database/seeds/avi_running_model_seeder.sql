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

-- Dumping structure for table avicenna.dev.avi_running_model
CREATE TABLE IF NOT EXISTS `avi_running_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `line_name` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `back_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `part_number` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `dandori_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.avi_running_model: ~1 rows (approximately)
/*!40000 ALTER TABLE `avi_running_model` DISABLE KEYS */;
INSERT INTO `avi_running_model` (`id`, `ip_address`, `line_name`, `back_number`, `part_number`, `quantity`, `dandori_date`, `created_at`, `updated_at`) VALUES
	(1, '172.18.16.41', 'AS600', 'PPH3', 'XXXX', 1, '2017-10-05 14:15:20', '2017-10-05 14:15:21', '2017-10-05 14:15:22');
/*!40000 ALTER TABLE `avi_running_model` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
