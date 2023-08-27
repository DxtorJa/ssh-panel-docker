# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.20)
# Database: __
# Generation Time: 2018-05-20 13:00:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account_notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account_notes`;

CREATE TABLE `account_notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `account_notes` WRITE;
/*!40000 ALTER TABLE `account_notes` DISABLE KEYS */;

INSERT INTO `account_notes` (`id`, `account_id`, `content`, `created_at`, `updated_at`)
VALUES
	(1,11,'ini note ya bos','2018-05-10 16:51:03','2018-05-10 16:51:03'),
	(2,12,NULL,'2018-05-10 16:54:37','2018-05-10 16:54:37'),
	(3,3,NULL,'2018-05-10 16:59:56','2018-05-10 16:59:56'),
	(4,4,NULL,'2018-05-10 17:01:45','2018-05-10 17:01:45');

/*!40000 ALTER TABLE `account_notes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cf_email_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf_api_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_up` tinyint(1) NOT NULL,
  `site_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_thumbnails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table certs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `certs`;

CREATE TABLE `certs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table dns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dns`;

CREATE TABLE `dns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reseller_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subdomain` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pointed_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table features
# ------------------------------------------------------------

DROP TABLE IF EXISTS `features`;

CREATE TABLE `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;

INSERT INTO `features` (`id`, `prefix`, `title`, `description`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'vpn','VPN Account Creator','This feature allow Admin or Reseller create new VPN Account.',1,'2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(2,'dns','DNS Record Creator','This feature allow Admin or Reseller create new DNS Record.',1,'2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(3,'coupon','Coupon System','This feature allow Admin or Reseller to redeem coupon but only Admin can generate coupon.',1,'2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(4,'reseller','Reseller System','This feature allow Reseller to Login, Admin To create new reseller & Reseller activities.',1,'2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(5,'tickets','Ticketing System','This feature allow user support through Ticket.',1,'2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(6,'register','Register System','This feature allow Registration on Panel',1,'2018-05-20 19:59:35','2018-05-20 19:59:35');

/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gifts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gifts`;

CREATE TABLE `gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messages` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_reedemed` tinyint(1) NOT NULL,
  `reedemed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reedemed_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gifts_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `infos`;

CREATE TABLE `infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://dummyimage.com/750x350/808080/595659.png&text=750X350',
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpublished',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `triggerer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2017_03_14_114135_create_gifts_table',1),
	(4,'2017_03_14_114203_create_dns_table',1),
	(5,'2017_03_15_082217_create_servers_table',1),
	(6,'2017_03_15_092211_create_vpns_table',1),
	(7,'2017_03_15_092217_create_sshes_table',1),
	(8,'2017_03_15_093101_create_notifs_table',1),
	(9,'2017_03_20_133522_create_logs_table',1),
	(10,'2017_03_30_170459_create_tickets_table',1),
	(11,'2017_03_30_170641_create_tickets_message_migrations',1),
	(12,'2017_03_30_170838_create_tickets_attachment_table',1),
	(13,'2017_04_08_214656_create_trials_table',1),
	(14,'2017_04_09_050721_create_pesans_table',1),
	(15,'2017_04_10_015727_create_admins_table',1),
	(16,'2017_04_13_100955_create_zones_table',1),
	(17,'2017_04_16_180745_create_infos_table',1),
	(18,'2018_03_15_045418_add_ticket_id_to_ticket_message',1),
	(19,'2018_03_15_050130_create_ticket_categories_table',1),
	(20,'2018_03_15_070504_drop_tickets_id_column_from_tickets_categories_table',1),
	(21,'2018_03_16_012349_create_ticket_comments_table',1),
	(22,'2018_03_16_013301_add_user_id_to_ticket_table',1),
	(23,'2018_03_16_041149_create_certs_table',1),
	(24,'2018_03_31_021207_create_features_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notifs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifs`;

CREATE TABLE `notifs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icons` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `callback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pesans
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pesans`;

CREATE TABLE `pesans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pesan_ssh_sukses` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_ssh_gagal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_vpn_sukses` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_vpn_gagal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_trial_sukses` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_trial_gagal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_saldo_tidak_cukup` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_ssh_sukses_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_ssh_gagal_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_vpn_sukses_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_vpn_gagal_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_trial_sukses_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_trial_gagal_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_saldo_tidak_cukup_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table servers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `servers`;

CREATE TABLE `servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table sshes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sshes`;

CREATE TABLE `sshes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reseller_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `at_server` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_on` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ticket_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ticket_categories`;

CREATE TABLE `ticket_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `ticket_categories` WRITE;
/*!40000 ALTER TABLE `ticket_categories` DISABLE KEYS */;

INSERT INTO `ticket_categories` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Technical','2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(2,'Support','2018-05-20 19:59:35','2018-05-20 19:59:35'),
	(3,'Services','2018-05-20 19:59:35','2018-05-20 19:59:35');

/*!40000 ALTER TABLE `ticket_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ticket_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ticket_comments`;

CREATE TABLE `ticket_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tickets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tickets_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'opened',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tickets_attachment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets_attachment`;

CREATE TABLE `tickets_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tickets_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tickets_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets_messages`;

CREATE TABLE `tickets_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tickets_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messages` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `have_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table trials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trials`;

CREATE TABLE `trials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reseller_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'http://lorempixel.com/200/200/cats/',
  `balance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  `suspend` tinyint(1) NOT NULL DEFAULT '0',
  `api_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table vpn_software
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vpn_software`;

CREATE TABLE `vpn_software` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` int(11) DEFAULT NULL,
  `type` varchar(222) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `l2tp_password` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table vpns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vpns`;

CREATE TABLE `vpns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reseller_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `at_server` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_on` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table zones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `zones`;

CREATE TABLE `zones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_count` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
