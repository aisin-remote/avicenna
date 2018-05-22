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

-- Dumping structure for table avicenna.avi_andons
CREATE TABLE IF NOT EXISTS `avi_andons` (
  `line` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target` int(11) DEFAULT NULL,
  `target_qty` int(11) DEFAULT NULL,
  `actual_qty` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `achive` int(11) DEFAULT NULL,
  `dandori` int(11) DEFAULT NULL,
  `loss_time_qa` int(11) DEFAULT NULL,
  `loss_time_parts` int(11) DEFAULT NULL,
  `loss_time_mc` int(11) DEFAULT NULL,
  PRIMARY KEY (`line`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.avi_andons: ~6 rows (approximately)
/*!40000 ALTER TABLE `avi_andons` DISABLE KEYS */;
INSERT INTO `avi_andons` (`line`, `target`, `target_qty`, `actual_qty`, `balance`, `achive`, `dandori`, `loss_time_qa`, `loss_time_parts`, `loss_time_mc`) VALUES
	('AS523', 2, 434, 233, 2, 2, 2, 2, 2, 2),
	('AS546', 3, 133, 100, 3, 3, 3, 3, 3, 3),
	('AS547', 4, 4, 4, 4, 4, 4, 4, 4, 4),
	('AS600', 1, 988, 899, 1, 2, 3, 1, 2, 1),
	('AS731', 1, 2123, 1133, 1, 1, 1, 1, 1, 1),
	('AS751', 1, 3455, 3223, 1, 2, 3, 1, 2, 1);
/*!40000 ALTER TABLE `avi_andons` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
