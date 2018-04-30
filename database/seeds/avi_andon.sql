-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.0.17-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- membuang struktur untuk table avicenna.dev.avi_andon_actual
DROP TABLE IF EXISTS `avi_andon_actual`;
CREATE TABLE IF NOT EXISTS `avi_andon_actual` (
  `line` varchar(20) NOT NULL,
  `reg_address` int(11) DEFAULT NULL,
  `name_reg` varchar(50) DEFAULT NULL,
  `value_reg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel avicenna.dev.avi_andon_actual: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `avi_andon_actual` DISABLE KEYS */;
INSERT INTO `avi_andon_actual` (`line`, `reg_address`, `name_reg`, `value_reg`) VALUES
	('AS523', 405, 'Actual Qty', 289),
	('AS546', 405, 'Actual Qty', 809),
	('AS547', 405, 'Actual Qty', 15),
	('AS600', 455, 'Actual Qty', 1014),
	('AS721', 455, 'Actual Qty', 180),
	('AS751', 455, 'Actual Qty', 58);
/*!40000 ALTER TABLE `avi_andon_actual` ENABLE KEYS */;

-- membuang struktur untuk table avicenna.dev.avi_andon_target
DROP TABLE IF EXISTS `avi_andon_target`;
CREATE TABLE IF NOT EXISTS `avi_andon_target` (
  `line` varchar(20) NOT NULL,
  `reg_address` int(11) DEFAULT NULL,
  `name_reg` varchar(50) DEFAULT NULL,
  `value_reg` int(11) DEFAULT NULL,
  PRIMARY KEY (`line`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel avicenna.dev.avi_andon_target: ~6 rows (lebih kurang)
/*!40000 ALTER TABLE `avi_andon_target` DISABLE KEYS */;
INSERT INTO `avi_andon_target` (`line`, `reg_address`, `name_reg`, `value_reg`) VALUES
	('AS523', 405, 'Target Qty', 289),
	('AS546', 405, 'Target Qty', 809),
	('AS547', 405, 'Target Qty', 15),
	('AS600', 455, 'Target Qty', 1014),
	('AS721', 455, 'Target Qty', 180),
	('AS751', 455, 'Target Qty', 58);
/*!40000 ALTER TABLE `avi_andon_target` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
