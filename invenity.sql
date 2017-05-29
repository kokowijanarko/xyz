-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2017 at 06:17 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invenity`
--

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE `component` (
  `component_id` int(11) NOT NULL,
  `component_name` varchar(30) NOT NULL COMMENT 'Component Name',
  `component_page` varchar(100) NOT NULL COMMENT 'Component Page',
  `component_type` enum('system','standard') NOT NULL DEFAULT 'standard' COMMENT 'Component Type',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`component_id`, `component_name`, `component_page`, `component_type`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 'User Management', 'user_management.php', 'system', 'yes', 'admin', '2015-12-04 07:54:58', 'admin', '2015-12-22 14:46:59', 2),
(2, 'Component Management', 'component_management.php', 'system', 'yes', 'admin', '2015-12-04 07:54:58', 'admin', '2015-12-22 14:46:29', 2),
(3, 'System Log', 'system_log.php', 'system', 'yes', 'admin', '2015-12-04 07:54:58', 'admin', '2015-12-22 14:46:55', 2),
(4, 'System Settings', 'system_settings.php', 'system', 'yes', 'admin', '2015-12-04 07:54:58', 'admin', '2015-12-22 14:46:57', 2),
(5, 'Produk Management', 'device_management.php', 'system', 'yes', 'admin', '2015-12-03 15:01:55', 'admin', '2015-12-22 14:46:47', 2),
(6, 'Location Management', 'location_management.php', 'system', 'yes', 'admin', '2015-12-03 15:01:55', 'admin', '2015-12-22 14:46:52', 2),
(7, 'Report', 'report.php', 'system', 'yes', 'admin', '2015-12-22 11:17:36', 'admin', '2016-02-17 14:14:29', 4),
(8, 'Inventory', 'device_management.php', 'standard', 'yes', 'admin', '2017-05-03 08:01:35', 'admin', '2017-05-06 10:32:16', 5);

-- --------------------------------------------------------

--
-- Table structure for table `device_changes`
--

CREATE TABLE `device_changes` (
  `changes_id` int(12) UNSIGNED ZEROFILL NOT NULL,
  `device_id` int(11) NOT NULL,
  `changes` text,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_changes`
--

INSERT INTO `device_changes` (`changes_id`, `device_id`, `changes`, `updated_by`, `updated_date`) VALUES
(000000000001, 39, 'Dev m2 :  -> . Dev mx x 2 :  -> . Dev kg id :  -> . Dev kg1 :  -> . Dev cek :  -> . ', 'admin', '2017-05-04 13:29:46'),
(000000000002, 44, 'Dev m2 :  -> . Dev mx x 2 :  -> . Dev kg id :  -> . Dev cek :  -> . ', 'admin', '2017-05-04 15:11:54'),
(000000000003, 44, 'Dev m2 :  -> . Dev mx x 2 :  -> . Dev kg id :  -> . Dev cek :  -> . ', 'admin', '2017-05-04 15:13:16'),
(000000000004, 31, 'Dev m2 :  -> . Dev mx x 2 : 19.1288 -> . Dev kg id : sdh cek -> . Dev kg1 : 25 x 25 -> . Dev cek : mustakim -> . ', 'admin', '2017-05-04 15:23:49'),
(000000000005, 44, 'Dev m2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev cek : dasdasdasd -> . ', 'admin', '2017-05-04 15:24:44'),
(000000000006, 44, 'Dev m2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev cek : dasdasdasd -> . ', 'admin', '2017-05-04 15:26:31'),
(000000000007, 44, 'Dev m2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev cek : dasdasdasd -> . ', 'admin', '2017-05-04 15:27:50'),
(000000000008, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev cek : dasdasdasd -> . ', 'admin', '2017-05-04 15:29:15'),
(000000000009, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev cek : dasdasdasd -> . ', 'admin', '2017-05-04 15:31:09'),
(000000000010, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> dasd. Dev kg id : keterangan -> dasd. Dev cek : dasdasdasd -> dasd. ', 'admin', '2017-05-04 15:32:09'),
(000000000011, 31, 'm2 : 9.5644 -> . Dev mx x 2 : 19.1288 -> dasd. Dev kg id : sdh cek -> dasd. Dev kg1 : 25 x 25 -> . Dev cek : mustakim -> dasd. ', 'admin', '2017-05-04 15:32:49'),
(000000000012, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> dasdas. Dev kg id : keterangan -> dasd. Dev cek : dasdasdasd -> dasda. ', 'admin', '2017-05-04 15:33:31'),
(000000000013, 45, 'm2 :  -> . Dev mx x 2 :  -> dsad. ', 'admin', '2017-05-04 15:36:36'),
(000000000014, 44, 'm2 :  -> . ', 'admin', '2017-05-04 15:43:34'),
(000000000015, 31, 'Dev mx x 2 :  -> dsad. Dev cek :  -> mustakim. ', 'admin', '2017-05-04 15:54:37'),
(000000000016, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> asdaf. Dev kg id : keterangan -> . ', 'admin', '2017-05-04 15:55:35'),
(000000000017, 44, 'm2 : m2 -> dasdsa. Dev mx x 2 : m2 x 2 -> asdaf. Dev kg id : keterangan -> dasd. Dev mprod:  -> dasdas. ', 'admin', '2017-05-04 15:57:09'),
(000000000018, 44, 'm2 : m2 -> . Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> dasd. Dev mprod:  -> dasd. ', 'admin', '2017-05-04 15:58:47'),
(000000000019, 44, 'm2 : m2 -> dasdasd. Dev mx x 2 : m2 x 2 -> dasdas. Dev kg id : keterangan -> dasd. Dev mprod:  -> dasdas. ', 'admin', '2017-05-04 15:59:40'),
(000000000020, 44, 'Dev description : <p>dasdasd</p> -> <p>dasdasddad</p>. m2 : m2 -> dasdasd. Dev mx x 2 : m2 x 2 -> dasdas. Dev kg id : keterangan -> dasda. Dev mprod: m3 prod -> dasdsa. ', 'admin', '2017-05-04 16:02:44'),
(000000000021, 44, 'Dev m2 : m2 -> dasdsa. Dev mx x 2 : m2 x 2 -> dasdas. Dev kg id : keterangan -> dasdsa. Dev mprod: m3 prod -> dasdas. ', 'admin', '2017-05-04 16:03:40'),
(000000000022, 44, 'Dev m2 : m2 -> dasdsad. Dev mx x 2 : m2 x 2 -> asdsa. Dev kg id : keterangan -> dasdsa. Dev mprod: m3 prod -> dasdsa. ', 'admin', '2017-05-04 16:04:55'),
(000000000023, 44, 'Dev m2 : m2 -> fsdfsdf. Dev mx x 2 : m2 x 2 -> . Dev kg id : keterangan -> . Dev mprod: m3 prod -> . ', 'admin', '2017-05-04 16:08:34'),
(000000000024, 44, 'Dev mprod: m3 prod -> . ', 'admin', '2017-05-04 16:10:58'),
(000000000025, 44, 'Dev m2 : m2 -> qweq. Dev mx x 2 : m2 x 2 -> eqweqe. Dev mprod: m3 prod -> . ', 'admin', '2017-05-04 16:13:30'),
(000000000026, 44, 'Dev m2 : m2 -> m2gg. Dev mx x 2 : m2 x 2 -> m2 gdfgfd. Dev mprod: m3 prod -> . ', 'admin', '2017-05-04 16:17:04'),
(000000000027, 44, 'Dev m2 :  -> ertert. Dev mx x 2 :  -> tertert. Dev kg id :  -> keterangan. Dev cek :  -> dasdasdasd. Dev mprod:  -> terter. ', 'admin', '2017-05-04 16:18:18'),
(000000000028, 44, 'Dev mprod: m3 prod -> dasdad. ', 'admin', '2017-05-04 16:19:08'),
(000000000029, 44, 'Dev m2 : m2 -> m2ghfhfghgf. Dev mx x 2 : m2 x 2 -> fhfgh. Dev mprod: m3 prod -> jfghfh. ', 'admin', '2017-05-04 16:19:44'),
(000000000030, 44, 'Dev description : <p>dasdasd</p> -> <p>dasdasddsad</p>. Dev m2 : m2 -> m2dasdsa. Dev mx x 2 : m2 x 2 -> dasds. Dev mprod: m3 prod -> dasda. ', 'admin', '2017-05-04 16:20:25'),
(000000000031, 44, 'Dev mprod: m3 prod -> asdasdsa. ', 'admin', '2017-05-04 16:28:17'),
(000000000032, 44, 'Dev mprod: m3 prod -> dasdas. ', 'admin', '2017-05-04 16:28:50'),
(000000000033, 44, 'Dev mprod: m3 prod -> dasdasd. ', 'admin', '2017-05-04 16:29:52'),
(000000000034, 44, 'Dev mprod: m3 prod -> dasdasd. ', 'admin', '2017-05-04 16:31:58'),
(000000000035, 44, 'Dev mprod: m3 prod -> dasdasd. ', 'admin', '2017-05-04 16:34:16'),
(000000000036, 44, 'Dev m2 : m2 -> m2dasd. Dev mx x 2 : m2 x 2 -> m2 x 2dasd. Dev mprod: m3 prod -> asdasd. ', 'admin', '2017-05-04 16:38:18'),
(000000000037, 44, 'Dev mprod: m3 prod -> dasdsad. ', 'admin', '2017-05-04 16:40:27'),
(000000000038, 44, 'Dev m2 : m2 -> m2dasd. Dev mx x 2 : m2 x 2 -> m2 x 2dasd. Dev mprod: m3 prod -> dasd. ', 'admin', '2017-05-04 16:41:16'),
(000000000039, 44, 'Dev mprod: m3 prod -> fsdfsf. ', 'admin', '2017-05-04 16:44:14'),
(000000000040, 44, 'Dev mprod: m3 prod -> zdfzsdfzs. ', 'admin', '2017-05-04 16:46:41'),
(000000000041, 44, 'Dev mprod: m3 prod -> dasdsad. ', 'admin', '2017-05-04 16:47:44'),
(000000000042, 44, 'Dev m2 : m2 -> m2dasd. Dev mx x 2 : m2 x 2 -> m2 x 2dasd. Dev mprod: m3 prod -> dasd. ', 'admin', '2017-05-04 16:48:11'),
(000000000043, 44, 'Dev mprod: m3 prod -> dasdsad. ', 'admin', '2017-05-04 16:50:06'),
(000000000044, 44, '', 'admin', '2017-05-04 16:50:39'),
(000000000045, 44, 'Dev description : <p>dasdasd</p> -> <p>dasdasddasd</p>. Dev cek : dasdasdasd -> dasdasdasddasdasdasdasd. Dev mprod: m3 prod -> dasdasd. ', 'admin', '2017-05-04 16:52:27'),
(000000000046, 44, 'Dev mprod: m3 prod -> asdasd. ', 'admin', '2017-05-04 16:53:06'),
(000000000047, 44, 'Dev mprod: m3 prod -> dasdsad. ', 'admin', '2017-05-04 16:56:55'),
(000000000048, 44, 'Dev mprod: m3 prod -> dasdasd. ', 'admin', '2017-05-04 16:59:34'),
(000000000049, 44, 'Dev mprod: m3 prod -> sdfsdf. ', 'admin', '2017-05-04 17:00:58'),
(000000000050, 31, 'Dev model : 0.85 -> 0.85fsfsdf. Dev mprod: 0.85 -> . ', 'admin', '2017-05-04 17:01:24'),
(000000000051, 56, 'Dev description :  -> <p>dasdas</p>. Dev mx x 2 :  -> dasdas. Dev mprod: 2.13 -> aseawe. ', 'admin', '2017-05-05 15:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `device_list`
--

CREATE TABLE `device_list` (
  `device_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL COMMENT 'FK Device Type',
  `device_code` varchar(100) NOT NULL COMMENT 'Unique Code (5 digit number in the back)',
  `device_brand` varchar(100) NOT NULL,
  `device_model` varchar(100) DEFAULT NULL,
  `device_serial` varchar(255) NOT NULL,
  `device_color` varchar(100) NOT NULL COMMENT 'Color',
  `device_description` text,
  `device_photo` text,
  `device_status` varchar(255) NOT NULL DEFAULT '',
  `location_id` int(11) DEFAULT NULL COMMENT 'FK Location',
  `device_deployment_date` datetime DEFAULT NULL COMMENT 'Fill this field when assigned to a location',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0',
  `m2` int(18) NOT NULL,
  `mx2` varchar(225) NOT NULL,
  `kg` varchar(225) NOT NULL,
  `kg1` varchar(225) NOT NULL,
  `cek` varchar(225) NOT NULL,
  `mprod` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_list`
--

INSERT INTO `device_list` (`device_id`, `type_id`, `device_code`, `device_brand`, `device_model`, `device_serial`, `device_color`, `device_description`, `device_photo`, `device_status`, `location_id`, `device_deployment_date`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`, `m2`, `mx2`, `kg`, `kg1`, `cek`, `mprod`) VALUES
(56, 5, 'BCB/2017/PRT/1', 'Lingerie Chest', '2.25', 'FA 972', 'W160 X D64 X H220', '', './assets/images/device_photos/FA 972.jpg', '', 0, '0000-00-00 00:00:00', 'admin', '2017-05-05 13:34:46', 'admin', '2017-05-05 13:34:46', 0, 11, '', 'china', '', 'IM', '2.13'),
(57, 5, 'BCB/2017/PRT/2', 'Medicine Cabinet', '0.04', 'FA 213B', 'W47 X D18 X H53', '<p>IM + Jok</p>', './assets/images/device_photos/FA 213B.jpg', '', 0, '0000-00-00 00:00:00', 'admin', '2017-05-05 13:43:01', 'admin', '2017-05-05 13:43:01', 0, 1, '', '', '', 'IM', '0.04'),
(58, 5, 'BCB/2017/PRT/3', 'dasdsadas', 'dasdas', 'dasdas', 'dasdas', '<p>dasdasd</p>', './assets/images/device_photos/dasdas.jpg', '', 0, '0000-00-00 00:00:00', 'admin', '2017-05-05 14:27:22', 'admin', '2017-05-05 14:27:22', 0, 12, '', 'dadas', '', 'dasdad', 'dasdasd'),
(59, 5, 'BCB/2017/PRT/4', 'dasdsad', 'dasdasd', 'dasdasd', 'dasdas', '<p>dasdasd</p>', './assets/images/device_photos/dasdasd.jpg', '', 0, '0000-00-00 00:00:00', 'admin', '2017-05-05 14:46:29', 'admin', '2017-05-05 14:46:29', 0, 3, '', 'dasdas', '', 'dasdas', 'dasdasd'),
(60, 3, 'BCB/2017/Beds/3', 'dasda', 'dasdasd', 'dasdasdasdas', 'dasdsad', '<p>dasda</p>', './assets/images/device_photos/standard_device.jpg', '', 0, '0000-00-00 00:00:00', 'admin', '2017-05-05 14:56:13', 'admin', '2017-05-05 14:56:13', 0, 2, '', 'dasda', '', 'dasd', 'dasa');

-- --------------------------------------------------------

--
-- Table structure for table `device_type`
--

CREATE TABLE `device_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(30) NOT NULL COMMENT 'Device Type Name',
  `type_code` varchar(30) NOT NULL COMMENT 'Device Type Code',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Device Type Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Device Type Changes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_type`
--

INSERT INTO `device_type` (`type_id`, `type_name`, `type_code`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 'Ottomans', 'OT', 'yes', 'admin', '2016-01-19 15:35:01', 'admin', '2016-02-17 10:43:01', 2),
(2, 'Head Boards', 'HB', 'yes', 'admin', '2016-01-19 15:37:36', 'admin', '2016-01-19 15:37:36', 0),
(3, 'Beds', 'Beds', 'yes', 'admin', '2016-01-19 15:37:45', 'admin', '2016-02-17 10:43:11', 2),
(4, 'Tables', 'TB', 'yes', 'admin', '2016-01-19 15:38:01', 'admin', '2016-01-19 15:38:01', 0),
(5, 'Armoires', 'PRT', 'yes', 'admin', '2016-01-19 15:38:15', 'admin', '2016-01-19 15:38:15', 0),
(6, 'Chairs', 'CH', 'yes', 'admin', '2017-05-05 00:00:00', 'admin', '2017-05-24 00:00:00', 0),
(7, 'Teak Root', 'TR', 'yes', 'admin', '2017-05-03 00:00:00', 'admin', '2017-05-05 00:00:00', 0),
(8, 'Teak Garden', 'TG', 'yes', 'admin', '2017-05-03 00:00:00', 'admin', '2017-05-05 00:00:00', 0),
(10, 'Et Cetera Set', 'ET', 'yes', 'admin', '2017-05-03 00:00:00', 'admin', '2017-05-05 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `idinventory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(30) NOT NULL COMMENT 'Location Name',
  `location_photo` text COMMENT 'Location Photo - If available',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Location Active Status',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Device Type Changes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_name`, `location_photo`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 'IT Room', NULL, 'no', 'admin', '2016-11-12 11:59:44', 'indomerapi', '2017-05-05 13:09:13', 2),
(2, 'Storage 1', NULL, 'no', 'admin', '2016-11-12 12:12:29', 'indomerapi', '2017-05-05 13:09:16', 1),
(3, 'dasdas', NULL, 'yes', 'admin', '2017-05-06 10:20:49', 'admin', '2017-05-06 10:20:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `location_building`
--

CREATE TABLE `location_building` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_building`
--

INSERT INTO `location_building` (`building_id`, `building_name`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 'Main Building', 'yes', 'admin', '2016-11-12 11:59:00', 'admin', '2016-11-12 11:59:00', 0),
(2, 'Warehouse', 'yes', 'admin', '2016-11-12 11:59:13', 'admin', '2016-11-12 11:59:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `location_details`
--

CREATE TABLE `location_details` (
  `detail_id` int(15) NOT NULL,
  `location_id` int(11) NOT NULL COMMENT 'FK location',
  `place_id` int(11) NOT NULL COMMENT 'FK place',
  `building_id` int(11) NOT NULL COMMENT 'FK building',
  `floor_id` int(11) NOT NULL COMMENT 'FK floor',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_details`
--

INSERT INTO `location_details` (`detail_id`, `location_id`, `place_id`, `building_id`, `floor_id`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 1, 1, 1, 3, 'yes', 'admin', '2016-11-12 12:09:02', 'admin', '2016-11-12 12:09:02', 0),
(2, 2, 2, 2, 1, 'yes', 'admin', '2016-11-12 12:12:29', 'admin', '2016-11-12 12:12:29', 0),
(3, 3, 1, 1, 1, 'yes', 'admin', '2017-05-06 10:20:49', 'admin', '2017-05-06 10:20:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `location_floor`
--

CREATE TABLE `location_floor` (
  `floor_id` int(11) NOT NULL,
  `floor_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_floor`
--

INSERT INTO `location_floor` (`floor_id`, `floor_name`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, '1st Floor', 'yes', 'admin', '2016-10-31 13:46:37', 'admin', '2016-11-12 11:56:48', 1),
(2, '2nd Floor', 'yes', 'admin', '2016-10-31 13:46:37', 'admin', '2016-11-12 11:56:59', 1),
(3, '3rd Floor', 'yes', 'admin', '2016-10-31 13:46:37', 'admin', '2016-11-12 11:56:39', 3),
(4, '4th Floor', 'no', 'admin', '2016-11-08 14:36:53', 'admin', '2016-11-12 11:57:08', 2);

-- --------------------------------------------------------

--
-- Table structure for table `location_place`
--

CREATE TABLE `location_place` (
  `place_id` int(11) NOT NULL,
  `place_name` varchar(30) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_place`
--

INSERT INTO `location_place` (`place_id`, `place_name`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
(1, 'Office One', 'yes', 'admin', '2016-10-31 13:46:37', 'admin', '2016-11-12 11:56:07', 1),
(2, 'Office Two', 'yes', 'admin', '2016-10-31 13:46:37', 'admin', '2016-11-12 11:56:19', 2);

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL,
  `log_date` datetime NOT NULL COMMENT 'Date',
  `username` varchar(30) NOT NULL COMMENT 'Username',
  `description` text NOT NULL COMMENT 'Log Descriptions'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`log_id`, `log_date`, `username`, `description`) VALUES
(1, '2017-05-03 07:53:52', 'admin', 'admin insert new data into the device_list table on 2017/05/03 07:53:52'),
(2, '2017-05-03 08:01:35', 'admin', 'admin insert new data into the component table on 2017/05/03 08:01:35'),
(3, '2017-05-03 08:03:53', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:03:53'),
(4, '2017-05-03 08:05:11', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:05:11'),
(5, '2017-05-03 08:06:13', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:06:13'),
(6, '2017-05-03 08:07:31', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:07:31'),
(7, '2017-05-03 08:08:23', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:08:23'),
(8, '2017-05-03 08:09:04', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:09:04'),
(9, '2017-05-03 08:11:35', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:11:35'),
(10, '2017-05-03 08:12:05', 'admin', 'admin insert new data into the device_list table on 2017/05/03 08:12:05'),
(11, '2017-05-03 11:04:15', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:04:15'),
(12, '2017-05-03 11:12:25', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:12:25'),
(13, '2017-05-03 11:14:10', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:14:10'),
(14, '2017-05-03 11:22:37', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:22:37'),
(15, '2017-05-03 11:25:37', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:25:37'),
(16, '2017-05-03 11:27:30', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:27:30'),
(17, '2017-05-03 11:35:07', 'admin', 'admin insert new data into the users table on 2017/05/03 11:35:07'),
(18, '2017-05-03 11:35:08', 'admin', 'admin insert new data into the user_privileges table on 2017/05/03 11:35:08'),
(19, '2017-05-03 11:38:48', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:38:48'),
(20, '2017-05-03 11:47:53', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:47:53'),
(21, '2017-05-03 11:53:35', 'admin', 'admin insert new data into the device_list table on 2017/05/03 11:53:35'),
(22, '2017-05-03 12:02:24', 'admin', 'admin insert new data into the device_list table on 2017/05/03 12:02:24'),
(23, '2017-05-03 12:03:48', 'admin', 'admin insert new data into the device_list table on 2017/05/03 12:03:48'),
(24, '2017-05-03 13:14:15', 'admin', 'admin insert new data into the device_list table on 2017/05/03 13:14:15'),
(25, '2017-05-03 13:14:55', 'admin', 'admin insert new data into the device_list table on 2017/05/03 13:14:55'),
(26, '2017-05-03 14:01:25', 'admin', 'admin insert new data into the device_list table on 2017/05/03 14:01:25'),
(27, '2017-05-03 14:02:31', 'admin', 'admin insert new data into the device_list table on 2017/05/03 14:02:31'),
(28, '2017-05-03 14:09:44', 'admin', 'admin update data :  active = \'no\' where  component_id = \'8\' from component table on 2017/05/03 14:09:44'),
(29, '2017-05-03 14:10:26', 'admin', 'admin update data :  setting_value=\'strange_bullseyes.png\' where  setting_name=\'body_background\' from system_settings table on 2017/05/03 14:10:26'),
(30, '2017-05-03 14:10:41', 'admin', 'admin update data :  setting_value=\'site-mint.min.css\' where  setting_name=\'color_scheme\' from system_settings table on 2017/05/03 14:10:41'),
(31, '2017-05-03 14:10:57', 'admin', 'admin update data :  setting_value=\'site-aqua.min.css\' where  setting_name=\'color_scheme\' from system_settings table on 2017/05/03 14:10:57'),
(32, '2017-05-03 14:20:03', 'admin', 'admin update data :  first_name=\'indo\', last_name=\'merapi\', password=\'new password\', salt=\'new salt\',  updated_by=\'admin\', updated_date=NOW(), revision = revision+1  where  username = \'indomerapi\' from users table on 2017/05/03 14:20:03'),
(33, '2017-05-03 14:20:03', 'admin', 'admin update data :  privileges=\'5,6,7\' where  username=\'indomerapi\' from user_privileges table on 2017/05/03 14:20:03'),
(34, '2017-05-03 15:11:37', 'admin', 'admin insert new data into the device_list table on 2017/05/03 15:11:37'),
(35, '2017-05-03 15:51:43', 'admin', 'admin insert new data into the device_list table on 2017/05/03 15:51:43'),
(36, '2017-05-03 15:58:08', 'admin', 'admin insert new data into the device_list table on 2017/05/03 15:58:08'),
(37, '2017-05-03 16:35:42', 'admin', 'admin insert new data into the device_list table on 2017/05/03 16:35:42'),
(38, '2017-05-03 16:56:52', 'admin', 'admin insert new data into the device_list table on 2017/05/03 16:56:52'),
(39, '2017-05-03 16:59:29', 'admin', 'admin insert new data into the device_list table on 2017/05/03 16:59:29'),
(40, '2017-05-03 17:14:19', 'admin', 'admin insert new data into the device_list table on 2017/05/03 17:14:19'),
(41, '2017-05-03 17:16:56', 'admin', 'admin insert new data into the device_list table on 2017/05/03 17:16:56'),
(42, '2017-05-03 17:17:33', 'admin', 'admin insert new data into the device_list table on 2017/05/03 17:17:33'),
(43, '2017-05-03 17:19:20', 'admin', 'admin insert new data into the device_list table on 2017/05/03 17:19:20'),
(44, '2017-05-03 17:36:42', 'admin', 'admin insert new data into the device_list table on 2017/05/03 17:36:42'),
(45, '2017-05-04 13:28:23', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:28:23'),
(46, '2017-05-04 13:34:02', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:34:02'),
(47, '2017-05-04 13:35:00', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:35:00'),
(48, '2017-05-04 13:37:19', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:37:19'),
(49, '2017-05-04 13:44:07', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:44:07'),
(50, '2017-05-04 13:54:22', 'admin', 'admin insert new data into the device_list table on 2017/05/04 13:54:22'),
(51, '2017-05-04 15:08:28', 'admin', 'admin insert new data into the device_list table on 2017/05/04 15:08:28'),
(52, '2017-05-04 17:09:12', 'admin', 'admin insert new data into the device_list table on 2017/05/04 17:09:12'),
(53, '2017-05-04 17:10:41', 'admin', 'admin insert new data into the device_list table on 2017/05/04 17:10:41'),
(54, '2017-05-05 08:03:08', 'admin', 'admin update data :  setting_value=\'Produk Management\' where  setting_name=\'inventory_name\' from system_settings table on 2017/05/05 08:03:08'),
(55, '2017-05-05 08:03:08', 'admin', 'admin update data :  setting_value=\'\' where  setting_name=\'inventory_slogan\' from system_settings table on 2017/05/05 08:03:08'),
(56, '2017-05-05 08:03:08', 'admin', 'admin update data :  setting_value=\'<p>Inventory is still under construction!</p>\' where  setting_name=\'inventory_description\' from system_settings table on 2017/05/05 08:03:08'),
(57, '2017-05-05 08:03:09', 'admin', 'admin update data :  setting_value=\'<p><a href=\"https://goo.gl/maps/eNofpLvBTkN2\">Jalan&nbsp;Piyungan&nbsp;-&nbsp;Prambanan&nbsp;4,1&nbsp;Kode&nbsp;Pos. 5557,&nbsp;&nbsp;Berbah&nbsp;- Jogo&nbsp;Tirto, Yogyakarta &ndash; Indonesia</a></p>\' where  setting_name=\'inventory_location\' from system_settings table on 2017/05/05 08:03:09'),
(58, '2017-05-05 08:03:09', 'admin', 'admin update data :  setting_value=\'0274 496862 \' where  setting_name=\'inventory_phone_number\' from system_settings table on 2017/05/05 08:03:09'),
(59, '2017-05-05 08:03:09', 'admin', 'admin update data :  setting_value=\'0274 439862\' where  setting_name=\'inventory_fax_number\' from system_settings table on 2017/05/05 08:03:09'),
(60, '2017-05-05 08:03:09', 'admin', 'admin update data :  setting_value=\'indomerapi@gmail.com\' where  setting_name=\'inventory_email\' from system_settings table on 2017/05/05 08:03:09'),
(61, '2017-05-05 08:03:09', 'admin', 'admin update data :  setting_value=\'www.indomerapi.com\' where  setting_name=\'inventory_website\' from system_settings table on 2017/05/05 08:03:09'),
(62, '2017-05-05 08:25:50', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 08:25:50'),
(63, '2017-05-05 10:36:34', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:36:34'),
(64, '2017-05-05 10:37:42', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:37:42'),
(65, '2017-05-05 10:48:18', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:48:18'),
(66, '2017-05-05 10:49:37', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:49:37'),
(67, '2017-05-05 10:50:29', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:50:29'),
(68, '2017-05-05 10:56:16', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 10:56:16'),
(69, '2017-05-05 13:09:13', 'indomerapi', 'indomerapi update data :  active=\'no\' where  location_id=\'1\' from location table on 2017/05/05 13:09:13'),
(70, '2017-05-05 13:09:16', 'indomerapi', 'indomerapi update data :  active=\'no\' where  location_id=\'2\' from location table on 2017/05/05 13:09:16'),
(71, '2017-05-05 13:12:54', 'indomerapi', 'indomerapi insert new data into the device_list table on 2017/05/05 13:12:54'),
(72, '2017-05-05 13:34:46', 'admin', 'admin insert new data into the device_list table on 2017/05/05 13:34:46'),
(73, '2017-05-05 13:43:01', 'admin', 'admin insert new data into the device_list table on 2017/05/05 13:43:01'),
(74, '2017-05-05 14:27:22', 'admin', 'admin insert new data into the device_list table on 2017/05/05 14:27:22'),
(75, '2017-05-05 14:46:29', 'admin', 'admin insert new data into the device_list table on 2017/05/05 14:46:29'),
(76, '2017-05-05 14:56:13', 'admin', 'admin insert new data into the device_list table on 2017/05/05 14:56:13'),
(77, '2017-05-06 10:20:49', 'admin', 'admin insert new data into the location_details table on 2017/05/06 10:20:49'),
(78, '2017-05-06 10:31:17', 'admin', 'admin update data :  active = \'yes\' where  component_id = \'8\' from component table on 2017/05/06 10:31:17'),
(79, '2017-05-06 10:31:47', 'admin', 'admin update data :  component_name = \'Furniture\', component_page = \'device_management.php\', active = \'yes\' where  component_id = \'8\'  from component table on 2017/05/06 10:31:47'),
(80, '2017-05-06 10:32:10', 'admin', 'admin update data :  component_name = \'inventory\', component_page = \'device_management.php\', active = \'yes\' where  component_id = \'8\'  from component table on 2017/05/06 10:32:10'),
(81, '2017-05-06 10:32:16', 'admin', 'admin update data :  component_name = \'Inventory\', component_page = \'device_management.php\', active = \'yes\' where  component_id = \'8\'  from component table on 2017/05/06 10:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_name` varchar(50) NOT NULL COMMENT 'Setting Name',
  `setting_value` text NOT NULL COMMENT 'Values',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_name`, `setting_value`, `active`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
('admin_email', 'admin@is_inventory.com', 'yes', 'system', '2015-12-10 09:33:16', 'system', '2015-12-10 09:33:16', 0),
('body_background', 'strange_bullseyes.png', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-03 14:10:25', 5),
('color_scheme', 'site-aqua.min.css', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-03 14:10:57', 6),
('device_code_format', 'BCB/year/devtype', 'yes', 'system', '2016-11-09 10:48:25', 'admin', '2016-11-09 10:48:25', 0),
('favicon', 'favicon.ico', 'no', 'system', '2015-12-10 09:33:16', 'system', '2015-12-10 09:33:16', 0),
('inventory_description', '<p>Inventory is still under construction!</p>', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:08', 2),
('inventory_email', 'indomerapi@gmail.com', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:09', 2),
('inventory_fax_number', '0274 439862', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:09', 2),
('inventory_location', '<p><a href=\"https://goo.gl/maps/eNofpLvBTkN2\">Jalan&nbsp;Piyungan&nbsp;-&nbsp;Prambanan&nbsp;4,1&nbsp;Kode&nbsp;Pos. 5557,&nbsp;&nbsp;Berbah&nbsp;- Jogo&nbsp;Tirto, Yogyakarta &ndash; Indonesia</a></p>', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:08', 2),
('inventory_logo', 'sclogo.png', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2016-11-12 11:51:41', 2),
('inventory_name', 'Produk Management', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:08', 1),
('inventory_phone_number', '0274 496862 ', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:09', 2),
('inventory_slogan', '', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:08', 1),
('inventory_website', 'www.indomerapi.com', 'yes', 'system', '2015-12-10 09:33:16', 'admin', '2017-05-05 08:03:09', 2),
('location_details', 'enable', 'yes', 'system', '2016-11-02 11:14:23', 'admin', '2016-11-08 11:39:25', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
  `revision` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Total Profile Changes/Revision'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `salt`, `level`, `active`, `first_name`, `last_name`, `photo`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
('admin', '24ce1033bdfe226997340a7104d79eeb43a54a27c101da24a5eb465c90a10800d6f8671346158f0ecf2efb4f1440f45e9c16fbc3e45d3e53e2bb94839781e95f', '1f78147ac76487d519cdf84a31df14b84948c6a01f763b522df896c75a5d7e4f', 'admin', 'yes', 'Super', 'User', './assets/images/user_photos/standard_photo.jpg', 'admin', '2015-12-02 11:26:49', 'admin', '2015-12-02 11:26:49', 0),
('anoerman', '44a29cbf152b01a23f1396c218e6f26a6e8164c1d0ce5fd30cd5fd66a3433b0388570977ab4d595251399c74401c5deac6b3159c6346affb2dd69ba00f981f87', '3ec34b8ad808561d280ee0df7f1c9269581882c96513ae985698e1232c44eda7', 'user', 'yes', 'Noerman', 'Agustiyan', './assets/images/user_photos/anoerman.png', 'admin', '2016-01-07 09:39:53', 'admin', '2016-03-15 10:58:01', 2),
('indomerapi', 'e4a8be2685bcd3d42206577c1b8b6dbf574a9cce66cea6a3a655e6021a3c872ed19ed43cdc40ec04c9677ed99d7c83f8650cbd945d56e43d8f68bf75a94f444d', '059787bfae244d8823a8c1204a871dfb44ccb5e9228bef7146f312344135a0bd', 'user', 'yes', 'indo', 'merapi', './assets/images/user_photos/standard_photo.jpg', 'admin', '2017-05-03 11:35:07', 'admin', '2017-05-03 14:20:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_privileges`
--

CREATE TABLE `user_privileges` (
  `username` varchar(30) NOT NULL,
  `privileges` text NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_date` datetime NOT NULL,
  `revision` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_privileges`
--

INSERT INTO `user_privileges` (`username`, `privileges`, `created_by`, `created_date`, `updated_by`, `updated_date`, `revision`) VALUES
('admin', '*', 'admin', '2015-12-10 08:00:24', 'admin', '2015-12-10 08:00:24', 0),
('anoerman', '5,6', 'admin', '2016-02-17 15:08:38', 'admin', '2016-03-15 10:58:01', 1),
('indomerapi', '5,6,7', 'admin', '2017-05-03 11:35:08', 'admin', '2017-05-03 14:20:03', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`component_id`);

--
-- Indexes for table `device_changes`
--
ALTER TABLE `device_changes`
  ADD PRIMARY KEY (`changes_id`);

--
-- Indexes for table `device_list`
--
ALTER TABLE `device_list`
  ADD PRIMARY KEY (`device_id`),
  ADD UNIQUE KEY `device_id` (`device_id`);

--
-- Indexes for table `device_type`
--
ALTER TABLE `device_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`idinventory`),
  ADD UNIQUE KEY `idinventory` (`idinventory`),
  ADD UNIQUE KEY `idinventory_2` (`idinventory`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `location_building`
--
ALTER TABLE `location_building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `location_details`
--
ALTER TABLE `location_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `location_floor`
--
ALTER TABLE `location_floor`
  ADD PRIMARY KEY (`floor_id`);

--
-- Indexes for table `location_place`
--
ALTER TABLE `location_place`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `component`
--
ALTER TABLE `component`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `device_changes`
--
ALTER TABLE `device_changes`
  MODIFY `changes_id` int(12) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `device_list`
--
ALTER TABLE `device_list`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `device_type`
--
ALTER TABLE `device_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `idinventory` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location_building`
--
ALTER TABLE `location_building`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `location_details`
--
ALTER TABLE `location_details`
  MODIFY `detail_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location_floor`
--
ALTER TABLE `location_floor`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `location_place`
--
ALTER TABLE `location_place`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
