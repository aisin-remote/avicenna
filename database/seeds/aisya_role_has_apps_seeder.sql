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

-- Dumping structure for table avicenna.dev.role_has_apps
CREATE TABLE IF NOT EXISTS `role_has_apps` (
  `role_id` int(10) unsigned NOT NULL,
  `apps_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`apps_id`),
  KEY `role_has_apps_apps_id_foreign` (`apps_id`),
  CONSTRAINT `role_has_apps_apps_id_foreign` FOREIGN KEY (`apps_id`) REFERENCES `ais_apps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_apps_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table avicenna.dev.role_has_apps: ~20 rows (approximately)
/*!40000 ALTER TABLE `role_has_apps` DISABLE KEYS */;
INSERT INTO `role_has_apps` (`role_id`, `apps_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
	(1, 8),
	(1, 9),
	(1, 10),
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(2, 5),
	(2, 6),
	(3, 1),
	(3, 2),
	(3, 3),
	(3, 5),
	(3, 6),
	(4, 1),
	(4, 2),
	(4, 4),
	(10, 1),
	(10, 2),
	(10, 3);
/*!40000 ALTER TABLE `role_has_apps` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
