/*
SQLyog Community v12.02 (64 bit)
MySQL - 5.6.17 : Database - test_new_db1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `admin_type` int(11) NOT NULL COMMENT 'Referencing to admin_type table',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin` */

LOCK TABLES `admin` WRITE;

UNLOCK TABLES;

/*Table structure for table `admin_type` */

DROP TABLE IF EXISTS `admin_type`;

CREATE TABLE `admin_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_type` */

LOCK TABLES `admin_type` WRITE;

insert  into `admin_type`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'SUPER_ADMIN',0,'2016-06-30 17:11:53','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL COMMENT 'References Invoice Table',
  `medicine` int(11) NOT NULL COMMENT 'References Medicine Table',
  `quantity` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL DEFAULT '0.00',
  `total_price` double(10,2) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_percentage` double(10,2) NOT NULL DEFAULT '0.00',
  `unit_discount` float(5,2) NOT NULL,
  `discount` double(10,2) NOT NULL DEFAULT '0.00',
  `is_removed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cart` */

LOCK TABLES `cart` WRITE;

UNLOCK TABLES;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pincode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `country` int(11) NOT NULL COMMENT 'Referencing Country Table',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `customer` */

LOCK TABLES `customer` WRITE;

UNLOCK TABLES;

/*Table structure for table `ed_professional` */

DROP TABLE IF EXISTS `ed_professional`;

CREATE TABLE `ed_professional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prof_id` int(11) NOT NULL,
  `prof_first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `prof_last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prof_address` text COLLATE utf8_unicode_ci NOT NULL,
  `prof_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `prof_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prof_pincode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `prof_created_on` datetime NOT NULL,
  `prof_updated_on` datetime NOT NULL,
  `prof_is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ed_professional` */

LOCK TABLES `ed_professional` WRITE;

UNLOCK TABLES;

/*Table structure for table `gcm_users` */

DROP TABLE IF EXISTS `gcm_users`;

CREATE TABLE `gcm_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gcm_regid` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `gcm_users` */

LOCK TABLES `gcm_users` WRITE;

UNLOCK TABLES;

/*Table structure for table `invoice` */

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pres_id` int(11) NOT NULL COMMENT 'Referencing Prescription Table ',
  `user_id` int(11) NOT NULL COMMENT 'Referencing User Table ',
  `status_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Referencing Invoice Status Table',
  `sub_total` double(10,2) NOT NULL DEFAULT '0.00',
  `discount` double(10,2) NOT NULL DEFAULT '0.00',
  `tax_percentage` float(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `shipping` double(10,2) NOT NULL DEFAULT '0.00',
  `total` double(10,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `shipping_status` int(11) NOT NULL DEFAULT '1' COMMENT 'Referencing Shipping Status Table',
  `shipping_mode` int(11) NOT NULL COMMENT 'Referencing Shipping Table',
  `shipping_id` int(11) NOT NULL COMMENT 'Shipping Reference Id',
  `payment_status` int(11) NOT NULL DEFAULT '1' COMMENT 'Referencing payment status Table',
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payment Reference Transaction ID',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoice` */

LOCK TABLES `invoice` WRITE;

UNLOCK TABLES;

/*Table structure for table `invoice_status` */

DROP TABLE IF EXISTS `invoice_status`;

CREATE TABLE `invoice_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoice_status` */

LOCK TABLES `invoice_status` WRITE;

insert  into `invoice_status`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'PENDING',0,'2016-06-30 17:11:53','0000-00-00 00:00:00',1,0),(2,'PAID',0,'2016-06-30 17:11:53','0000-00-00 00:00:00',1,0),(3,'UNPAID',0,'2016-06-30 17:11:53','0000-00-00 00:00:00',1,0),(4,'CANCELLED',0,'2016-06-30 17:11:53','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `medicine` */

DROP TABLE IF EXISTS `medicine`;

CREATE TABLE `medicine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch_no` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` double(10,2) NOT NULL,
  `purchase_price` double(10,2) NOT NULL,
  `rack_number` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `selling_price` double(10,2) NOT NULL,
  `expiry` date NOT NULL,
  `tax_type` enum('PERCENTAGE','AMOUNT') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'AMOUNT',
  `tax` double(10,2) NOT NULL DEFAULT '0.00',
  `composition` text COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` enum('PERCENTAGE','AMOUNT') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'AMOUNT',
  `discount` double(10,2) NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketed_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `medicine` */

LOCK TABLES `medicine` WRITE;

UNLOCK TABLES;

/*Table structure for table `medicine_request` */

DROP TABLE IF EXISTS `medicine_request`;

CREATE TABLE `medicine_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `medicine_request` */

LOCK TABLES `medicine_request` WRITE;

UNLOCK TABLES;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

LOCK TABLES `migrations` WRITE;

insert  into `migrations`(`migration`,`batch`) values ('2016_04_18_171237_create_ed_admin_table',1),('2016_04_18_171237_create_ed_customer_table',1),('2016_04_18_171237_create_ed_invoice_table',1),('2016_04_18_171237_create_ed_item_list_table',1),('2016_04_18_171237_create_ed_medicine_name_table',1),('2016_04_18_171237_create_ed_new_med_email_table',1),('2016_04_18_171237_create_ed_new_medicines_table',1),('2016_04_18_171237_create_ed_prescription_table',1),('2016_04_18_171237_create_ed_professional_table',1),('2016_04_18_171237_create_ed_user_type_table',1),('2016_04_18_171237_create_ed_users_table',1),('2016_04_18_171237_create_gcm_users_table',1),('2016_04_18_171237_create_sessions_table',1),('2016_04_20_164045_settings_table',1),('2016_05_24_144025_create_admin_type',1),('2016_05_24_144156_create_invoice_status',1),('2016_05_24_144227_create_shipping_status',1),('2016_05_24_144246_create_payment_status',1),('2016_05_24_144259_create_shipping',1),('2016_05_24_144310_create_prescription_status',1),('2016_05_24_144319_create_user_status',1),('2016_06_18_174217_create_payment_mode_table',1),('2016_06_20_163808_create_payment_gateway_setting',1);

UNLOCK TABLES;

/*Table structure for table `pay_gateway_setting` */

DROP TABLE IF EXISTS `pay_gateway_setting`;

CREATE TABLE `pay_gateway_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` int(11) NOT NULL COMMENT 'References Payment Gateway Table',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEXT',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `dataset` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Serialised Data set',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pay_gateway_setting` */

LOCK TABLES `pay_gateway_setting` WRITE;

insert  into `pay_gateway_setting`(`id`,`gateway_id`,`key`,`value`,`description`,`type`,`is_hidden`,`dataset`,`created_at`,`updated_at`) values (1,2,'merchant_key','','Merchant Key','TEXT',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,'merchant_hash','','Merchant Hash','TEXT',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,2,'payumoney_live_url','https://secure.payu.in','Paypal sandbox url','TEXT',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,'payumoney_sandbox_url','https://test.payu.in','Paypal sandbox url','TEXT',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,'business_email','','Business Account Email ID','EMAIL',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,1,'paypal_live_url','https://www.paypal.com/cgi-bin/webscr?','Live transaction Url ','TEXT',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,1,'paypal_sandbox_url','https://www.sandbox.paypal.com/cgi-bin/webscr?','Paypal sandbox url','TEXT',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,1,'paypal_currency','USD','Paypal Supported Currencies','SELECT',0,'a:25:{s:3:\"AUD\";s:17:\"Australian Dollar\";s:3:\"BRL\";s:14:\"Brazilian Real\";s:3:\"CAD\";s:15:\"Canadian Dollar\";s:3:\"CZK\";s:12:\"Czech Koruna\";s:3:\"DKK\";s:12:\"Danish Krone\";s:3:\"EUR\";s:4:\"Euro\";s:3:\"HKD\";s:16:\"Hong Kong Dollar\";s:3:\"HUF\";s:16:\"Hungarian Forint\";s:3:\"ILS\";s:18:\"Israeli New Sheqel\";s:3:\"JPY\";s:12:\"Japanese Yen\";s:3:\"MYR\";s:17:\"Malaysian Ringgit\";s:3:\"MXN\";s:12:\"Mexican Peso\";s:3:\"NOK\";s:15:\"Norwegian Krone\";s:3:\"NZD\";s:18:\"New Zealand Dollar\";s:3:\"PHP\";s:15:\"Philippine Peso\";s:3:\"PLN\";s:12:\"Polish Zloty\";s:3:\"GBP\";s:14:\"Pound Sterling\";s:3:\"RUB\";s:13:\"Russian Ruble\";s:3:\"SGD\";s:16:\"Singapore Dollar\";s:3:\"SEK\";s:13:\"Swedish Krona\";s:3:\"CHF\";s:11:\"Swiss Franc\";s:3:\"TWD\";s:17:\"Taiwan New Dollar\";s:3:\"THB\";s:9:\"Thai Baht\";s:3:\"TRY\";s:12:\"Turkish Lira\";s:3:\"USD\";s:11:\"U.S. Dollar\";}','0000-00-00 00:00:00','0000-00-00 00:00:00');

UNLOCK TABLES;

/*Table structure for table `payment_gateways` */

DROP TABLE IF EXISTS `payment_gateways`;

CREATE TABLE `payment_gateways` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `payment_gateways` */

LOCK TABLES `payment_gateways` WRITE;

insert  into `payment_gateways`(`id`,`name`,`image`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'Paypal','paypal.png',0,'2016-06-30 17:11:55','0000-00-00 00:00:00',1,0),(2,'Pay U Money','payumoney.png',0,'2016-06-30 17:11:55','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `payment_status` */

DROP TABLE IF EXISTS `payment_status`;

CREATE TABLE `payment_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `payment_status` */

LOCK TABLES `payment_status` WRITE;

insert  into `payment_status`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'PENDING',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(2,'SUCCESS',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(3,'FAILURE',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `prescription` */

DROP TABLE IF EXISTS `prescription`;

CREATE TABLE `prescription` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pres_id` int(11) NOT NULL,
  `path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'References Prescription Status Table',
  `user_id` int(11) NOT NULL COMMENT 'References User Table',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `prescription` */

LOCK TABLES `prescription` WRITE;

UNLOCK TABLES;

/*Table structure for table `prescription_status` */

DROP TABLE IF EXISTS `prescription_status`;

CREATE TABLE `prescription_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `prescription_status` */

LOCK TABLES `prescription_status` WRITE;

insert  into `prescription_status`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'UNVERIFIED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(2,'VERIFIED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(3,'REJECTED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `request_list` */

DROP TABLE IF EXISTS `request_list`;

CREATE TABLE `request_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL COMMENT 'Reference Medicine request table',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `request_list` */

LOCK TABLES `request_list` WRITE;

UNLOCK TABLES;

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference Medicine Table',
  `medicine_name` text COLLATE utf8_unicode_ci NOT NULL,
  `medicine_count` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `unit_price` float(8,2) NOT NULL,
  `item_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sessions` */

LOCK TABLES `sessions` WRITE;

UNLOCK TABLES;

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('TEXT','IMAGE','INTEGER','FLOAT','SERIALIZED','HASHED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEXT',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `settings` */

LOCK TABLES `settings` WRITE;

insert  into `settings`(`id`,`group`,`key`,`value`,`type`,`is_active`,`created_at`,`updated_at`) values (1,'site','app_name','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'site','logo','','IMAGE',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'site','mail','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'site','website','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'site','address','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'site','timezone','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'site','phone','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'site','discount','','FLOAT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'site','currency','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,'site','curr_position','BEFORE','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,'mail','username','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,'mail','password','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,'mail','address','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,'mail','name','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,'mail','port','587','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,'mail','host','smtp.gmail.com','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,'mail','driver','smtp','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,'payment','mode','','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,'payment','type','TEST','TEXT',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');

UNLOCK TABLES;

/*Table structure for table `shipping` */

DROP TABLE IF EXISTS `shipping`;

CREATE TABLE `shipping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `shipping` */

LOCK TABLES `shipping` WRITE;

UNLOCK TABLES;

/*Table structure for table `shipping_status` */

DROP TABLE IF EXISTS `shipping_status`;

CREATE TABLE `shipping_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `shipping_status` */

LOCK TABLES `shipping_status` WRITE;

insert  into `shipping_status`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'NOT SHIPPED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(2,'SHIPPED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(3,'RETURNED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0),(4,'RECEIVED',0,'2016-06-30 17:11:54','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `user_status` */

DROP TABLE IF EXISTS `user_status`;

CREATE TABLE `user_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_status` */

LOCK TABLES `user_status` WRITE;

insert  into `user_status`(`id`,`name`,`is_delete`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'PENDING',0,'2016-06-30 17:11:55','0000-00-00 00:00:00',1,0),(2,'ACTIVE',0,'2016-06-30 17:11:55','0000-00-00 00:00:00',1,0),(3,'INACTIVE',0,'2016-06-30 17:11:55','0000-00-00 00:00:00',1,0);

UNLOCK TABLES;

/*Table structure for table `user_type` */

DROP TABLE IF EXISTS `user_type`;

CREATE TABLE `user_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_type` */

LOCK TABLES `user_type` WRITE;

insert  into `user_type`(`id`,`user_type`,`is_delete`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (1,'ADMIN',0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'MEDICAL_PROFESSIONAL',0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'CUSTOMER',0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `user_type_id` int(11) NOT NULL COMMENT 'References User Type Table',
  `security_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT 'References User Status Table',
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'References Customer,Medical Professional, Admin Table based on user type',
  `remember_token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
