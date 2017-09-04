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
-- Dumping data for table avicenna.dev.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Ferry Avianto', 'ferry@aiia.co.id', '$2y$10$1rJ/l5UiRxByX6zXezWTDej9pXkYBvtaKRc39L4uUpGOK/vu91fDG', 'fDtbvPwt7Lw72fpaVEXq97gSkGVA5c2h7kyd7H9BvaQRwwtuJ6mnuMWIhL8C', '2017-08-21 08:15:12', '2017-08-21 08:15:12'),
	(2, 'Yudo Maryanto', 'yudo@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'l5PC2TExrOOiOWtNt02UdLI9vq5dQMoJCxOWrrNBdQGFwvmsdGwzIzKBSmYP', '2017-08-24 10:25:07', '2017-08-24 10:25:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
