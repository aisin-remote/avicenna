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
-- Dumping data for table avicenna.dev.permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'create', '2017-08-24 16:29:18', '2017-08-24 16:29:18'),
	(2, 'modify', '2017-08-24 16:29:34', '2017-08-24 16:29:34'),
	(3, 'delete', '2017-08-24 16:29:45', '2017-08-24 16:29:46'),
	(4, 'show', '2017-08-24 16:30:02', '2017-08-24 16:30:03'),
	(5, 'register', '2017-08-24 16:32:46', '2017-08-24 16:32:46'),
	(6, 'unregister', '2017-08-24 16:47:21', '2017-08-24 16:47:22'),
	(7, 'backup', '2017-08-24 16:47:38', '2017-08-24 16:47:38'),
	(8, 'restore', '2017-08-24 16:47:43', '2017-08-24 16:47:44'),
	(9, 'insert', '2017-08-24 16:48:11', '2017-08-24 16:48:12'),
	(10, 'update', '2017-08-24 16:48:22', '2017-08-24 16:48:22');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
