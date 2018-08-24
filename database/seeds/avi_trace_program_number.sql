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
-- Dumping data for table avicenna.avi_trace_program_number: ~8 rows (approximately)
/*!40000 ALTER TABLE `avi_trace_program_number` DISABLE KEYS */;
INSERT INTO `avi_trace_program_number` (`id`, `code`, `product`, `part_number`, `back_number`, `part_name`, `customer`, `created_at`, `updated_at`) VALUES
	(1, '01', 'TCC D98E', '212110-34010-A', 'CI11', 'CASE A/S, FRONT W/ WATER PUMP & OIL PUMP', 'ADM', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(2, '02', 'TCC 889F', '212110-34040-A', 'CI12', 'CASE ASSY, FR W/WATER PUMP&OIL PUMP', 'TMMIN', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(3, '03', 'TCC D72F', '212110-34140-C', 'CI13', 'COVER ASSY, TIMING GEAR', 'ADM', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(4, '04', 'TCC D18E', '212110-34270', 'CI14', 'COVER ASSY, TIMING GEAR', 'ADM', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(5, '07', 'CSH D98E', '243131-10260-B', 'ABC', 'HOUSING, CAMSHAFT', 'OTICS', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(6, '15', 'OPN 889F', '243202-10630-C', 'EI11', 'PAN SUB ASSY, OIL, NO.1', 'TMMIN', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(7, '11', 'OPN 922F', '243202-10680-B', 'EI12', 'PAN SUB ASSY, OIL, NO,1', 'TMMIN', '2018-07-06 14:25:05', '2018-07-06 14:25:05'),
	(8, '12', 'OPN D72F', '243202-10710-B', 'EI13', 'PAN SUB-ASSY, OIL', 'ADM', '2018-07-06 14:25:05', '2018-07-06 14:25:05');
/*!40000 ALTER TABLE `avi_trace_program_number` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
