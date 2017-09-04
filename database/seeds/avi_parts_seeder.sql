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
-- Dumping data for table avicenna.dev.avi_parts: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_parts` DISABLE KEYS */;
INSERT INTO `avi_parts` (`id`, `customer_id`, `supplier_id`, `back_number`, `part_number`, `quantity`, `created_at`, `updated_at`) VALUES
	(1, 'TOY01', NULL, NULL, '82811-77M20-000', 5.00, NULL, NULL),
	(2, 'SUZ01', NULL, NULL, '692100W01100', 5.00, NULL, NULL);
/*!40000 ALTER TABLE `avi_parts` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
