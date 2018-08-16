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

-- membuang struktur untuk table avicenna.dev.avi_mutation_types
CREATE TABLE IF NOT EXISTS `avi_mutation_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel avicenna.dev.avi_mutation_types: ~22 rows (lebih kurang)
/*!40000 ALTER TABLE `avi_mutation_types` DISABLE KEYS */;
INSERT INTO `avi_mutation_types` (`id`, `code`, `name`, `desc`, `created_at`, `updated_at`) VALUES
	(1, '701', 'sto_fg_in', 'Stock Opname In Finish Good', '2017-09-06 11:14:57', '2017-09-06 11:14:58'),
	(2, '702', 'sto_fg_out', 'Stock Opname Out Finish Good', '2017-09-06 11:15:42', '2017-09-06 11:15:42'),
	(3, '703', 'sto_comp_in', 'Stock Opname In Component', '2017-09-06 11:16:04', '2017-09-06 11:16:04'),
	(4, '704', 'sto_comp_out', 'Stock Opname Out Component', '2017-09-06 11:16:29', '2017-09-06 11:16:30'),
	(5, '101', 'gr_purch_in', 'Good Receipt In Purchase', '2017-09-06 11:18:49', '2017-09-06 11:18:49'),
	(6, '102', 'gr_purch_out', 'Good Receipt Out (Reversal) Purchase', '2017-09-06 11:24:21', '2017-09-06 11:24:21'),
	(7, '131', 'gr_prod_in', 'Good Receipt In Production', '2017-09-06 11:25:07', '2017-09-06 11:25:09'),
	(8, '132', 'gr_prod_out', 'Good Receipt Out (Reversal) Production', '2017-09-06 11:25:52', '2017-09-06 11:25:58'),
	(9, '133', 'gr_andon_in', 'Good Receipt In Andon Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(10, '134', 'gr_andon_out', 'Good Receipt Out (Reversal) Andon Production', '2017-09-06 11:28:10', '2017-09-06 11:28:11'),
	(11, '141', 'gr_ng_out', 'Good Receipt Out NG Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(12, '142', 'gr_ng_in', 'Good Receipt In NG (Reversal) Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(13, '143', 'gr_setting_out', 'Good Receipt Out Setting Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(14, '144', 'gr_setting_in', 'Good Receipt Out Setting (Reversal) Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(15, '145', 'gr_trial_out', 'Good Receipt Out Trial Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(16, '146', 'gr_trial_in', 'Good Receipt In Trial Production', '2017-09-06 11:27:43', '2017-09-06 11:27:44'),
	(17, '261', 'consumption_out', 'Good Consumption Out From Production', '2017-09-06 11:30:46', '2017-09-06 11:30:49'),
	(18, '262', 'consumption_in', 'Good Consumption In (Reversal) From Production', '2017-09-06 11:31:33', '2017-09-06 11:31:33'),
	(19, '311', 'move_out_in', 'Good Movement Out From In To Location', '2017-09-06 11:34:11', '2017-09-06 11:34:12'),
	(20, '312', 'move_in_out', 'Good Movement In From Out To (Reversal) Location', '2017-09-06 11:35:10', '2017-09-06 11:35:10'),
	(21, '601', 'gi_out_delivery', 'Good Issue Out Delivery', '2017-09-07 15:05:30', '2017-09-07 15:05:30'),
	(22, '602', 'gi_in_delivery', 'Good Issue In (Reversal) Delivery', '2017-09-07 15:06:07', '2017-09-07 15:06:07');
/*!40000 ALTER TABLE `avi_mutation_types` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
