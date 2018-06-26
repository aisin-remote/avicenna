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

-- Dumping structure for table avicenna_dev.avi_andons
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

-- Dumping data for table avicenna_dev.avi_andons: ~6 rows (approximately)
/*!40000 ALTER TABLE `avi_andons` DISABLE KEYS */;
REPLACE INTO `avi_andons` (`line`, `target`, `target_qty`, `actual_qty`, `balance`, `achive`, `dandori`, `loss_time_qa`, `loss_time_parts`, `loss_time_mc`) VALUES
	('AS523', 1000, 0, 0, 1000, 1000, 0, 1000, 1000, 1000),
	('AS546', 1000, 934, 669, 1000, 1000, 0, 1000, 1000, 1000),
	('AS547', 1223, 0, 15, 1000, 1000, 0, 1000, 1000, 1000),
	('AS600', 1600, 983, 886, 1000, 1000, 0, 1000, 1000, 1000),
	('AS721', 0, 92, 0, 0, 0, 0, 0, 0, 0),
	('AS731', 169, 104, 0, 1000, 1000, 0, 1000, 1000, 1000),
	('AS751', 1000, 0, 0, 1000, 1000, 0, 1000, 1000, 1000);
/*!40000 ALTER TABLE `avi_andons` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
