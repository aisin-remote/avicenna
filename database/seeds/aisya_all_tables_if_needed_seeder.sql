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
-- Dumping data for table avicenna.dev.ais_apps: ~7 rows (approximately)
/*!40000 ALTER TABLE `ais_apps` DISABLE KEYS */;
INSERT INTO `ais_apps` (`id`, `apps_tcode`, `apps_level`, `apps_has_child`, `apps_sname`, `apps_tcode_parent`, `apps_tcode_root`, `apps_route`, `apps_fname`, `apps_icon_code`, `apps_icon_path`, `created_at`, `updated_at`) VALUES
	(1, 'AV00', 0, 1, 'avicenna', 'AV00', 'AV00', '', 'Avicenna', 'fa fa-line-chart', '', '2017-08-21 11:52:51', '2017-08-21 11:52:53'),
	(2, 'PI00', 1, 1, 'pis', 'AV00', 'AV00', '', 'PIS Digital', 'fa fa-calendar-check-o', '', '2017-08-21 11:52:43', '2017-08-21 11:52:49'),
	(3, 'PI01', 2, 0, 'pis_scan', 'PI00', 'AV00', 'pis', 'PIS Scanner', 'fa fa-circle-o', '', '2017-08-21 11:54:36', '2017-08-21 11:54:37'),
	(4, 'PI02', 2, 0, 'pis_entry', 'PI00', 'AV00', 'pis/entry', 'PIS Data Entry', 'fa fa-circle-o', '', '2017-08-21 11:55:22', '2017-08-21 11:55:23'),
	(5, 'ST00', 1, 1, 'sto', 'AV00', 'AV00', '#', 'Stock Opname', 'fa fa-cubes', '', '2017-08-21 11:56:02', '2017-08-21 11:56:03'),
	(6, 'ST01', 2, 0, 'sto_entry', 'ST00', 'AV00', 'opname', 'STO Data Entry', 'fa fa-circle-o', '', '2017-08-21 11:57:31', '2017-08-21 11:57:32'),
	(7, 'AC00', 0, 0, 'aca', 'AC00', 'AC00', 'aca', 'Aisin Cutting Tools', 'fa fa-scissors', '', '2017-08-21 11:58:27', '2017-08-21 11:58:28');
/*!40000 ALTER TABLE `ais_apps` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.avi_customers: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_customers` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.avi_mutations: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_mutations` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_mutations` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.avi_opname: ~0 rows (approximately)
/*!40000 ALTER TABLE `avi_opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `avi_opname` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.avi_parts: ~2 rows (approximately)
/*!40000 ALTER TABLE `avi_parts` DISABLE KEYS */;
INSERT INTO `avi_parts` (`id`, `customer_id`, `supplier_id`, `back_number`, `part_number`, `part_number_customer`, `part_name`, `product_group`, `product_line`, `quantity`, `created_at`, `updated_at`) VALUES
	(1, 'TOY01', NULL, NULL, '82811-77M20-000', NULL, NULL, NULL, NULL, 5.00, NULL, NULL),
	(2, 'SUZ01', NULL, NULL, '692100W01100', NULL, NULL, NULL, NULL, 5.00, NULL, NULL);
/*!40000 ALTER TABLE `avi_parts` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.migrations: ~9 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2017_08_04_094833_create_permission_tables', 1),
	(4, '2017_08_15_071809_create_avi_parts_table', 1),
	(5, '2017_08_15_073552_create_avi_customers_table', 1),
	(6, '2017_08_15_073708_create_avi_mutations_table', 1),
	(7, '2017_08_16_025426_create_ais_apps_table', 1),
	(8, '2017_08_16_040640_create_avi_opname_migration', 1),
	(9, '2017_08_29_082133_role_has_apps', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.permissions: ~10 rows (approximately)
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

-- Dumping data for table avicenna.dev.roles: ~10 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'ais_admin', '2017-08-24 16:09:06', '2017-08-24 16:09:07'),
	(2, 'avi_admin', '2017-08-24 16:19:30', '2017-08-24 16:19:33'),
	(3, 'avi_leader', '2017-08-24 16:20:29', '2017-08-24 16:20:30'),
	(4, 'avi_entry', '2017-08-24 16:21:37', '2017-08-24 16:21:38'),
	(5, 'avi_operator', '2017-08-24 16:24:01', '2017-08-24 16:24:01'),
	(6, 'avi_spv', '2017-08-24 16:24:13', '2017-08-24 16:24:14'),
	(7, 'avi_mgr', '2017-08-24 16:24:25', '2017-08-24 16:24:26'),
	(8, 'avi_gm', '2017-08-24 16:24:36', '2017-08-24 16:24:37'),
	(9, 'avi_bod', '2017-08-24 16:24:49', '2017-08-24 16:24:50'),
	(10, 'pis_operator', '2017-08-24 16:37:05', '2017-08-24 16:37:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.role_has_apps: ~18 rows (approximately)
/*!40000 ALTER TABLE `role_has_apps` DISABLE KEYS */;
INSERT INTO `role_has_apps` (`role_id`, `apps_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
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
	(3, 6);
/*!40000 ALTER TABLE `role_has_apps` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.role_has_permissions: ~4 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(2, 4),
	(5, 10);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Ferry Avianto', 'ferry@aiia.co.id', '$2y$10$1rJ/l5UiRxByX6zXezWTDej9pXkYBvtaKRc39L4uUpGOK/vu91fDG', 'BTKDQ9citQ19ag05nY3r63ycmp50dYCpnr58pg0ap4bY1faxhuAToUxHXCKg', '2017-08-21 08:15:12', '2017-08-21 08:15:12'),
	(2, 'Yudo Maryanto', 'yudo@aiia.co.id', '$2y$10$C3JMXQk3ksvz9xuAePMC/e9S3.rUBTa7g6pu4lrV8Q.S1zkKVW5c6', 'sV06IDGruLgsKg1MbszvHegDGc18rmHVBrOccPfU7nklFtTa8asH1E6EQXtk', '2017-08-24 10:25:07', '2017-08-24 10:25:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.user_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_permissions` ENABLE KEYS */;

-- Dumping data for table avicenna.dev.user_has_roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_has_roles` DISABLE KEYS */;
INSERT INTO `user_has_roles` (`role_id`, `user_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 2);
/*!40000 ALTER TABLE `user_has_roles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
