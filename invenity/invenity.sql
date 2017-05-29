/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.11 : Database - invenity
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`invenity` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `invenity`;

/*Table structure for table `component` */

DROP TABLE IF EXISTS `component`;

CREATE TABLE `component` (
  `component_id` int(11) NOT NULL AUTO_INCREMENT,
  `component_name` varchar(30) NOT NULL COMMENT 'Component Name',
  `component_page` varchar(100) NOT NULL COMMENT 'Component Page',
  `component_type` enum('system','standard') NOT NULL DEFAULT 'standard' COMMENT 'Component Type',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`component_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `component` */

insert  into `component`(`component_id`,`component_name`,`component_page`,`component_type`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'User Management','user_management.php','system','yes','admin','2015-12-04 07:54:58','admin','2015-12-22 14:46:59',2),(2,'Component Management','component_management.php','system','yes','admin','2015-12-04 07:54:58','admin','2015-12-22 14:46:29',2),(3,'System Log','system_log.php','system','yes','admin','2015-12-04 07:54:58','admin','2015-12-22 14:46:55',2),(4,'System Settings','system_settings.php','system','yes','admin','2015-12-04 07:54:58','admin','2015-12-22 14:46:57',2),(5,'Device Management','device_management.php','system','yes','admin','2015-12-03 15:01:55','admin','2015-12-22 14:46:47',2),(6,'Location Management','location_management.php','system','yes','admin','2015-12-03 15:01:55','admin','2015-12-22 14:46:52',2),(7,'Report','report.php','system','yes','admin','2015-12-22 11:17:36','admin','2016-02-17 14:14:29',4);

/*Table structure for table `device_changes` */

DROP TABLE IF EXISTS `device_changes`;

CREATE TABLE `device_changes` (
  `changes_id` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `changes` text,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`changes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `device_changes` */

/*Table structure for table `device_list` */

DROP TABLE IF EXISTS `device_list`;

CREATE TABLE `device_list` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT 'FK Device Type',
  `device_code` varchar(100) NOT NULL COMMENT 'Unique Code (5 digit number in the back)',
  `device_brand` varchar(100) NOT NULL,
  `device_model` varchar(100) DEFAULT NULL,
  `device_serial` varchar(255) NOT NULL,
  `device_color` varchar(100) NOT NULL COMMENT 'Color',
  `device_description` text,
  `device_photo` text,
  `device_status` enum('new','in use','damaged','repaired','discarded') NOT NULL DEFAULT 'new',
  `location_id` int(11) DEFAULT NULL COMMENT 'FK Location',
  `device_deployment_date` datetime DEFAULT NULL COMMENT 'Fill this field when assigned to a location',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `device_list` */

insert  into `device_list`(`device_id`,`type_id`,`device_code`,`device_brand`,`device_model`,`device_serial`,`device_color`,`device_description`,`device_photo`,`device_status`,`location_id`,`device_deployment_date`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,5,'BCB/2016/PRT/1','Epson','L210','VGVK034060','Black','<p>Printer Admin IT</p>','./assets/images/device_photos/VGVK034060.jpg','in use',0,'2016-11-10 14:33:49','admin','2016-11-10 11:01:46','admin','2016-11-10 14:33:49',3),(2,1,'BCB/2016/MTR/2','Samsung','20M37A','501NDWEH3817','Black','<p>Monitor IT Software</p>','./assets/images/device_photos/501NDWEH3817.jpg','in use',1,'2016-11-12 12:09:19','admin','2016-11-10 14:43:34','admin','2016-11-12 12:09:19',4),(3,2,'BCB/2016/MSE/3','Logitech','K100','1516HS03TEL8','Black','<p>Mouse IT Software</p>','./assets/images/device_photos/standard_device.jpg','in use',1,'2016-11-12 12:17:31','admin','2016-11-12 12:17:31','admin','2016-11-12 12:17:31',0);

/*Table structure for table `device_type` */

DROP TABLE IF EXISTS `device_type`;

CREATE TABLE `device_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) NOT NULL COMMENT 'Device Type Name',
  `type_code` varchar(30) NOT NULL COMMENT 'Device Type Code',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Device Type Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Device Type Changes',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `device_type` */

insert  into `device_type`(`type_id`,`type_name`,`type_code`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'Monitor','MTR','yes','admin','2016-01-19 15:35:01','admin','2016-02-17 10:43:01',2),(2,'Mouse','MSE','yes','admin','2016-01-19 15:37:36','admin','2016-01-19 15:37:36',0),(3,'Keyboard','KBD','yes','admin','2016-01-19 15:37:45','admin','2016-02-17 10:43:11',2),(4,'Speaker','SPKR','yes','admin','2016-01-19 15:38:01','admin','2016-01-19 15:38:01',0),(5,'Printer','PRT','yes','admin','2016-01-19 15:38:15','admin','2016-01-19 15:38:15',0),(6,'Harddisk external','HDX','yes','admin','2016-05-20 07:24:50','admin','2016-06-07 11:02:05',2),(7,'Ups','UPS','yes','admin','2016-11-11 09:20:17','admin','2016-11-11 10:37:48',2),(8,'Switch','SWT','yes','admin','2016-11-12 12:11:51','admin','2016-11-12 12:11:51',0);

/*Table structure for table `location` */

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(30) NOT NULL COMMENT 'Location Name',
  `location_photo` text COMMENT 'Location Photo - If available',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Location Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Device Type Changes',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `location` */

insert  into `location`(`location_id`,`location_name`,`location_photo`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'IT Room',NULL,'yes','admin','2016-11-12 11:59:44','admin','2016-11-12 12:09:02',1),(2,'Storage 1',NULL,'yes','admin','2016-11-12 12:12:29','admin','2016-11-12 12:12:29',0);

/*Table structure for table `location_building` */

DROP TABLE IF EXISTS `location_building`;

CREATE TABLE `location_building` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `location_building` */

insert  into `location_building`(`building_id`,`building_name`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'Main Building','yes','admin','2016-11-12 11:59:00','admin','2016-11-12 11:59:00',0),(2,'Warehouse','yes','admin','2016-11-12 11:59:13','admin','2016-11-12 11:59:13',0);

/*Table structure for table `location_details` */

DROP TABLE IF EXISTS `location_details`;

CREATE TABLE `location_details` (
  `detail_id` int(15) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL COMMENT 'FK location',
  `place_id` int(11) NOT NULL COMMENT 'FK place',
  `building_id` int(11) NOT NULL COMMENT 'FK building',
  `floor_id` int(11) NOT NULL COMMENT 'FK floor',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `location_details` */

insert  into `location_details`(`detail_id`,`location_id`,`place_id`,`building_id`,`floor_id`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,1,1,1,3,'yes','admin','2016-11-12 12:09:02','admin','2016-11-12 12:09:02',0),(2,2,2,2,1,'yes','admin','2016-11-12 12:12:29','admin','2016-11-12 12:12:29',0);

/*Table structure for table `location_floor` */

DROP TABLE IF EXISTS `location_floor`;

CREATE TABLE `location_floor` (
  `floor_id` int(11) NOT NULL AUTO_INCREMENT,
  `floor_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`floor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `location_floor` */

insert  into `location_floor`(`floor_id`,`floor_name`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'1st Floor','yes','admin','2016-10-31 13:46:37','admin','2016-11-12 11:56:48',1),(2,'2nd Floor','yes','admin','2016-10-31 13:46:37','admin','2016-11-12 11:56:59',1),(3,'3rd Floor','yes','admin','2016-10-31 13:46:37','admin','2016-11-12 11:56:39',3),(4,'4th Floor','no','admin','2016-11-08 14:36:53','admin','2016-11-12 11:57:08',2);

/*Table structure for table `location_place` */

DROP TABLE IF EXISTS `location_place`;

CREATE TABLE `location_place` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `location_place` */

insert  into `location_place`(`place_id`,`place_name`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values (1,'Office One','yes','admin','2016-10-31 13:46:37','admin','2016-11-12 11:56:07',1),(2,'Office Two','yes','admin','2016-10-31 13:46:37','admin','2016-11-12 11:56:19',2);

/*Table structure for table `system_logs` */

DROP TABLE IF EXISTS `system_logs`;

CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_date` datetime NOT NULL COMMENT 'Date',
  `username` varchar(30) NOT NULL COMMENT 'Username',
  `description` text NOT NULL COMMENT 'Log Descriptions',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `system_logs` */

/*Table structure for table `system_settings` */

DROP TABLE IF EXISTS `system_settings`;

CREATE TABLE `system_settings` (
  `setting_name` varchar(50) NOT NULL COMMENT 'Setting Name',
  `setting_value` text NOT NULL COMMENT 'Values',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `system_settings` */

insert  into `system_settings`(`setting_name`,`setting_value`,`active`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values ('admin_email','admin@is_inventory.com','yes','system','2015-12-10 09:33:16','system','2015-12-10 09:33:16',0),('body_background','symphony.png','yes','system','2015-12-10 09:33:16','admin','2016-01-06 11:33:54',4),('color_scheme','site-default.min.css','yes','system','2015-12-10 09:33:16','admin','2016-01-06 11:33:53',4),('device_code_format','BCB/year/devtype','yes','system','2016-11-09 10:48:25','admin','2016-11-09 10:48:25',0),('favicon','favicon.ico','no','system','2015-12-10 09:33:16','system','2015-12-10 09:33:16',0),('inventory_description','<p>General Inventory is still under construction!</p>','yes','system','2015-12-10 09:33:16','admin','2015-12-15 16:18:09',1),('inventory_email','','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:51:41',1),('inventory_fax_number','','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:51:41',1),('inventory_location','<p>Your Location</p>','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:48:18',1),('inventory_logo','sclogo.png','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:51:41',2),('inventory_name','General Inventory','yes','system','2015-12-10 09:33:16','admin','2015-12-15 15:46:47',0),('inventory_phone_number','','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:51:41',1),('inventory_slogan','General Inventory | Standard Edition','yes','system','2015-12-10 09:33:16','admin','2015-12-15 15:46:47',0),('inventory_website','','yes','system','2015-12-10 09:33:16','admin','2016-11-12 11:51:41',1),('location_details','enable','yes','system','2016-11-02 11:14:23','admin','2016-11-08 11:39:25',8);

/*Table structure for table `user_privileges` */

DROP TABLE IF EXISTS `user_privileges`;

CREATE TABLE `user_privileges` (
  `username` varchar(30) NOT NULL,
  `privileges` text NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_privileges` */

insert  into `user_privileges`(`username`,`privileges`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values ('admin','*','admin','2015-12-10 08:00:24','admin','2015-12-10 08:00:24',0),('anoerman','5,6','admin','2016-02-17 15:08:38','admin','2016-03-15 10:58:01',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL COMMENT 'Unique Username',
  `password` varchar(128) NOT NULL COMMENT 'SHA512',
  `salt` varchar(64) NOT NULL COMMENT 'Random String SHA256',
  `level` enum('admin','user') NOT NULL DEFAULT 'user' COMMENT 'User Level',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'User Active Status',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `photo` text COMMENT 'User Photo Profile - Set default if empty',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Profile Changes/Revision',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`username`,`password`,`salt`,`level`,`active`,`first_name`,`last_name`,`photo`,`created_by`,`created_date`,`updated_by`,`updated_date`,`revision`) values ('admin','24ce1033bdfe226997340a7104d79eeb43a54a27c101da24a5eb465c90a10800d6f8671346158f0ecf2efb4f1440f45e9c16fbc3e45d3e53e2bb94839781e95f','1f78147ac76487d519cdf84a31df14b84948c6a01f763b522df896c75a5d7e4f','admin','yes','Super','User','./assets/images/user_photos/standard_photo.jpg','admin','2015-12-02 11:26:49','admin','2015-12-02 11:26:49',0),('anoerman','44a29cbf152b01a23f1396c218e6f26a6e8164c1d0ce5fd30cd5fd66a3433b0388570977ab4d595251399c74401c5deac6b3159c6346affb2dd69ba00f981f87','3ec34b8ad808561d280ee0df7f1c9269581882c96513ae985698e1232c44eda7','user','yes','Noerman','Agustiyan','./assets/images/user_photos/anoerman.png','admin','2016-01-07 09:39:53','admin','2016-03-15 10:58:01',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
