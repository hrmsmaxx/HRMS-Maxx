-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: dbramario.cjlsowozibi0.us-east-1.rds.amazonaws.com
-- Generation Time: Nov 09, 2020 at 07:33 AM
-- Server version: 5.7.26-log
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ramario_device`
--

-- --------------------------------------------------------

--
-- Table structure for table `_attendance`
--

CREATE TABLE `_attendance` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `workcode_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `origin_type` enum('manual','standalone','adms','batch') DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `verification_type` enum('pin','password','card','fingerprint','face','other') DEFAULT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_device`
--

CREATE TABLE `_device` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `serial_number` varchar(20) DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `port` varchar(10) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `update_mode` enum('time','interval') DEFAULT NULL,
  `update_interval` time DEFAULT NULL,
  `update_time` time DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT NULL,
  `consume_mode` enum('time','interval') DEFAULT NULL,
  `last_consume` timestamp NULL DEFAULT NULL,
  `consume_time` time DEFAULT NULL,
  `consume_interval` time DEFAULT NULL,
  `clock_mode` enum('time','interval') DEFAULT NULL,
  `clock_interval` time DEFAULT NULL,
  `clock_time` time DEFAULT NULL,
  `last_clock` timestamp NULL DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `clean_attendance` tinyint(1) DEFAULT NULL,
  `save_employee` tinyint(1) DEFAULT NULL,
  `action` varchar(10000) DEFAULT NULL,
  `answer` varchar(10000) DEFAULT NULL,
  `device_model` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_device`
--

INSERT INTO `_device` (`id`, `subdomain_id`, `serial_number`, `ip`, `port`, `location_id`, `update_mode`, `update_interval`, `update_time`, `last_update`, `consume_mode`, `last_consume`, `consume_time`, `consume_interval`, `clock_mode`, `clock_interval`, `clock_time`, `last_clock`, `timezone`, `clean_attendance`, `save_employee`, `action`, `answer`, `device_model`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, NULL, '192.168.137.21', '4370', NULL, NULL, '00:00:00', '00:00:00', '2005-06-12 02:48:53', NULL, '2005-05-27 03:00:00', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00', '2020-07-22 02:51:28', '1', 0, 1, '', '{\"message\":\"Acción no encontrada\"}', 0, 1, '2020-07-22 02:52:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_device_event`
--

CREATE TABLE `_device_event` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_type` enum('verification','fingerprint','card','connected','disconnected','attendance','status','information','upload_employees','update_employees','update_workcodes','clean','force_clean','update_clock','clean_action') NOT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_employee`
--

CREATE TABLE `_employee` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `device_code` int(10) DEFAULT NULL,
  `rfid_card` int(11) DEFAULT NULL,
  `device_password` varchar(25) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_employee`
--

INSERT INTO `_employee` (`id`, `subdomain_id`, `first_name`, `last_name`, `device_code`, `rfid_card`, `device_password`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 'adf', 'bfdsf', 1, NULL, NULL, 1, '2020-07-04 18:10:28', 1),
(5, 1, 'fdasf', 'sadfs', 123, NULL, NULL, 1, '2020-07-04 17:55:14', 1),
(10, 1, 'f', 'd', 2, NULL, NULL, 1, '2020-07-04 17:56:34', 1),
(11, 1, 'a', 'b', 3, NULL, NULL, 1, '2020-07-04 17:56:45', 1),
(13, 1, '', NULL, 1337, NULL, '123', 1, '2020-07-22 02:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_employee_device`
--

CREATE TABLE `_employee_device` (
  `employee_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `access_limit` int(11) NOT NULL DEFAULT '0',
  `updated` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `privilege_type` enum('default','moderator','administrator','owner') NOT NULL DEFAULT 'default',
  `updated_sent` tinyint(1) NOT NULL DEFAULT '0',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_employee_device`
--

INSERT INTO `_employee_device` (`employee_id`, `device_id`, `subdomain_id`, `access_limit`, `updated`, `status`, `deleted`, `privilege_type`, `updated_sent`, `modification_date`, `modification_user`) VALUES
(1, 18, 1, 0, 0, 1, 0, 'administrator', 0, '2020-07-22 01:13:29', NULL),
(13, 1, 1, 0, 1, 1, 0, 'default', 0, '2020-07-22 02:48:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_employee_face`
--

CREATE TABLE `_employee_face` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `base64` text NOT NULL,
  `length` int(11) NOT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_employee_fingerprint`
--

CREATE TABLE `_employee_fingerprint` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `base64` text NOT NULL,
  `finger_number` int(1) NOT NULL DEFAULT '6',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_employee_fingerprint`
--

INSERT INTO `_employee_fingerprint` (`id`, `subdomain_id`, `employee_id`, `base64`, `finger_number`, `modification_date`, `modification_user`) VALUES
(2, 1, 13, 'TRdTUzIxAAAEVFYECAUHCc7QAAAcVWkBAAAAhPkgjlQzAJoPfACGABtbuwBNAKQP8gBQVH8PJABsALEPmVR6ACcPygBuAKFb5QCrAKUPAQCrVCMPuwC1AGIPP1S2APQKJgB5AAZavgDBACcPlwDOVJwPWQDLAOkPL1TXABYPTgAcAJNbHwDjAA4PyQDsVOEPdQDoAGgPIFToAFMP0QA5AKFbKAADAVoOcgAHVakPswAXAWYPPVQcAY4OaADoAaFbYAA6AZoP1ABEVfQPWQBKAUoPkVRNAZsPuACKAZdbRH7/ h93 IZvK477N35zDqKHWlj6Y/fn6viGg0sjMoYHC4MHgYZBVTCCXQNahJcDTCrJf6n9wIfJg8VRBPaqWOLhsBK9u8v2DIMlBeiG7CYsCIKo2JJ0leptzAm5xSUXcPzBOW BlL5V SwxkYGgjo7NdoKjG3dEzUb9PbF2lP86UpKD4QtSzB9NJVHMB5 Dpf0HAh9GnzQP9APp9Aw2TGoZvfQ5DUYMaz1en5NrxfUD7J9W6wl/ ncCt/mvpq7v8LCRGeVKBVazIpUPAHrZGkQ/UmT/DwBq4BzFlv1VWFvBB8W4KHb Uv4PAGHpF8SWKcBYwMBsxgCkZB//CQCwMeJJQZQKAJ00J3uAWApUUzcGKlTAnlwLVDI5Cf5UOIHBYlwBUj0M/kCOEQR1QQZBwTX/BVHEOAwAgEUe/5bAxJTBchcAHUjMwfkDOUX/wMH9u8CBUQEzU4DDhtIAGAn7wP0v/UwH/cWrwVvC/5IExQdspCwVADhiBjv/ qtK/2tbwoEEFgR8agA7/v3C6v/FlFnC/8PAwcAApSklWAsAnX/sa/qWZcIUAAaBKDsqqVr ZWLAE8UKgaRB/MAoRlgFfABUBo7wwP4UxTCFV/8rNf/BRQdmelABUJGQkAPFI44lwAMATJaMBAMEd5NwwgQAXV8cOl0Be7wrwFgHZAJUR5yMw8KUzACKyCZSVcEHAImdMJbC/WoDAFtbIPtdAXbALWT/VQMEAaEiwA4AbngwaTN5wv/EBgCCo4iXwpIFADmksYgHVFSpJMEOAK/DNJb8d2nBwXvGADv7JsIFAM6v5VsBVEayHDsNAKngLQyFeHAFAMd3IsUFBwA6tIPGBJEAVCq7AB4GAAbDIDLDBgC/xSm0wRRUVc4wbcB4vW/GWwFk4CtbhATBxT7FEgAu0gw4/TyWwP/BwcH/BsNVUgE3w4PFw18FBHPWacPBwg3FL9xC/zLAwv6HBwQEe8tww8INAJTcLQFxeIQJACIn/fxmwFwSACjn2fx1P8F1wVrCBMUg7AhcBQAl7UA5IwBUH/VQJwUQfgcklnIFECkIVzhMAUQ5ESLCSwTVKx49wcAEELcb33kMRFw6l//DxFgMFEc97f/8/f87/8WWWAcQZT4aBcJdUhEVQvfA/Tj/DkQLUPD KU8ECBRYVv09/1dShwAPFwAAAAtFUg==', 0, '2020-07-22 02:14:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_location`
--

CREATE TABLE `_location` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `parent_location_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_location`
--

INSERT INTO `_location` (`id`, `subdomain_id`, `name`, `parent_location_id`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 'test', NULL, 0, '2020-06-20 00:25:42', 1),
(2, 1, 'testb', NULL, 1, '2020-07-04 17:46:02', 1),
(3, 1, 'sdafsdf', NULL, 1, '2020-06-20 00:25:33', 1),
(4, 1, 'wqerwqer', 3, 1, '2020-06-20 00:25:37', 1),
(5, 1, 'gfsdgsdf', 3, 1, '2020-07-04 17:45:27', 1),
(6, 1, 'gfsdgsdf', 3, 1, '2020-07-04 17:45:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `_menu`
--

CREATE TABLE `_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_menu`
--

INSERT INTO `_menu` (`id`, `name`, `status`, `modification_date`, `modification_user`) VALUES
(1, 'Default', 1, '2020-06-19 23:16:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_menu_item`
--

CREATE TABLE `_menu_item` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `menu_id` int(11) NOT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_menu_item`
--

INSERT INTO `_menu_item` (`id`, `name`, `link`, `icon`, `permissions`, `menu_id`, `modification_date`, `modification_user`) VALUES
(1, 'Dashboard', '?option=dashboard', 'md md-home', '[{\"o\":\"ver\",\"n\":\"Ver\"}]', 1, '2020-06-19 23:16:38', NULL),
(2, 'Workcodes', '?option=workcodes', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(3, 'Locations', '?option=locations', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(4, 'Employees', '?option=employees', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(5, 'Attendances', '?option=attendances', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(6, 'Users', '?option=users', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(7, 'Users roles', '?option=users_roles', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL),
(8, 'Devices', '?option=devices', 'md md-list', '[{\"o\":\"ver\",\"n\":\"Ver\"},{\"o\":\"Agregar\",\"n\":\"Agregar\"}]', 1, '2020-06-19 23:16:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_subdomain`
--

CREATE TABLE `_subdomain` (
  `subdomain_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subdomain` varchar(30) NOT NULL,
  `apikey` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_subdomain`
--

INSERT INTO `_subdomain` (`subdomain_id`, `name`, `subdomain`, `apikey`, `status`, `modification_date`, `modification_user`) VALUES
(1, 'Sample', 'sample', 'bxwYQ/MaNDMf3rJPxfLYLM8UiTlEIKpR19CSTZDG48zCagURVs', 1, '2020-07-22 00:17:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_user`
--

CREATE TABLE `_user` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `username` varchar(65) NOT NULL,
  `hashed_password` varchar(33) NOT NULL,
  `first_name` varchar(400) DEFAULT NULL,
  `last_name` varchar(400) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user`
--

INSERT INTO `_user` (`id`, `subdomain_id`, `user_role_id`, `username`, `hashed_password`, `first_name`, `last_name`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 'DS', 1, '2020-06-19 23:16:06', NULL),
(2, 1, 1, 'admin 2', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 'DS', 1, '2020-06-19 23:16:06', NULL),
(3, 1, 1, 'test', 'e10adc3949ba59abbe56e057f20f883e', 'test', 'fdsaf', 1, '2020-07-11 17:18:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_user_role`
--

CREATE TABLE `_user_role` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` text NOT NULL,
  `menu_id` int(11) NOT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user_role`
--

INSERT INTO `_user_role` (`id`, `subdomain_id`, `name`, `permissions`, `menu_id`, `modification_date`, `modification_user`) VALUES
(1, 1, 'Administrator', '{\"16\":{\"ver\":true},\"14\":{\"ver\":true},\"6\":{\"ver\":true,\"agregar\":true},\"11\":{\"ver\":true},\"1\":{\"ver\":true},\"13\":{\"ver\":true,\"agregar\":true},\"10\":{\"ver\":true},\"5\":{\"ver\":true},\"4\":{\"ver\":true},\"15\":{\"ver\":true},\"7\":{\"ver\":true},\"12\":{\"ver\":true},\"8\":{\"ver\":true},\"9\":{\"ver\":true,\"agregar\":true},\"2\":{\"ver\":true,\"agregar\":true}}', 1, '2020-06-19 23:16:30', NULL),
(2, 1, 'test a', '{\"5\":{\"ver\":true,\"Agregar\":true},\"1\":{\"ver\":true},\"3\":{\"Agregar\":true}}', 1, '2020-07-11 17:33:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_workcode`
--

CREATE TABLE `_workcode` (
  `id` int(11) NOT NULL,
  `subdomain_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `device_code` varchar(5) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_workcode`
--

INSERT INTO `_workcode` (`id`, `subdomain_id`, `name`, `device_code`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 'test', NULL, 1, '2020-06-20 00:10:53', 1),
(2, 1, 'testab', '2', 1, '2020-07-04 17:41:52', 1),
(3, 1, 'asdfsaf', '6', 1, '2020-06-20 00:11:58', 1),
(4, 1, 'asdfsdf', NULL, 1, '2020-06-20 00:12:05', 1),
(5, 1, 'test', NULL, 1, '2020-07-04 17:40:08', 1),
(6, 1, 'fsadf', '41234', 1, '2020-07-04 17:40:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `__log__employee`
--

CREATE TABLE `__log__employee` (
  `log_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `subdomain_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `device_code` int(10) DEFAULT NULL,
  `rfid_card` int(11) DEFAULT NULL,
  `device_password` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__log__employee`
--

INSERT INTO `__log__employee` (`log_id`, `id`, `subdomain_id`, `first_name`, `last_name`, `device_code`, `rfid_card`, `device_password`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 1, 'a', 'b', 1, NULL, NULL, 1, '2020-07-04 17:47:54', 1),
(2, 1, 1, 'a', 'bfdsf', 1, NULL, NULL, 1, '2020-07-04 18:09:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `__log__location`
--

CREATE TABLE `__log__location` (
  `log_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `subdomain_id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `parent_location_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__log__location`
--

INSERT INTO `__log__location` (`log_id`, `id`, `subdomain_id`, `name`, `parent_location_id`, `status`, `modification_date`, `modification_user`) VALUES
(1, 1, 1, 'test', NULL, 1, '2020-06-20 00:25:21', 1),
(2, 2, 1, 'test', NULL, 1, '2020-06-20 00:25:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `__log__workcode`
--

CREATE TABLE `__log__workcode` (
  `log_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `subdomain_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `device_code` varchar(5) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modification_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__log__workcode`
--

INSERT INTO `__log__workcode` (`log_id`, `id`, `subdomain_id`, `name`, `device_code`, `status`, `modification_date`, `modification_user`) VALUES
(1, 2, 1, 'test', '2', 1, '2020-06-20 00:11:51', 1),
(2, 2, 1, 'testab', '2', 1, '2020-07-04 17:41:52', 1),
(3, 2, 1, 'testab', '2', 1, '2020-07-04 17:41:52', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `_attendance`
--
ALTER TABLE `_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance` (`employee_id`,`date`,`subdomain_id`) USING BTREE,
  ADD KEY `_attendance_ibfk_2` (`device_id`),
  ADD KEY `_attendance_ibfk_3` (`workcode_id`),
  ADD KEY `_attendance_ibfk_4` (`modification_user`);

--
-- Indexes for table `_device`
--
ALTER TABLE `_device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`,`port`,`subdomain_id`) USING BTREE,
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `_device_ibfk_1` (`location_id`),
  ADD KEY `_device_ibfk_2` (`modification_user`);

--
-- Indexes for table `_device_event`
--
ALTER TABLE `_device_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_device_event_ibfk_1` (`device_id`),
  ADD KEY `_device_event_ibfk_2` (`modification_user`);

--
-- Indexes for table `_employee`
--
ALTER TABLE `_employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`device_code`,`subdomain_id`) USING BTREE,
  ADD UNIQUE KEY `rfid_card` (`rfid_card`,`subdomain_id`) USING BTREE,
  ADD KEY `_employee_ibfk_1` (`modification_user`);

--
-- Indexes for table `_employee_device`
--
ALTER TABLE `_employee_device`
  ADD PRIMARY KEY (`employee_id`,`device_id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `modification_user` (`modification_user`);

--
-- Indexes for table `_employee_face`
--
ALTER TABLE `_employee_face`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_employee_face_ibfk_1` (`employee_id`),
  ADD KEY `_employee_face_ibfk_2` (`modification_user`);

--
-- Indexes for table `_employee_fingerprint`
--
ALTER TABLE `_employee_fingerprint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_employee_fingerprint_ibfk_1` (`employee_id`),
  ADD KEY `_employee_fingerprint_ibfk_2` (`modification_user`);

--
-- Indexes for table `_location`
--
ALTER TABLE `_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_location_ibfk_1` (`parent_location_id`),
  ADD KEY `_location_ibfk_2` (`modification_user`);

--
-- Indexes for table `_menu`
--
ALTER TABLE `_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_menu_ibfk_1` (`modification_user`);

--
-- Indexes for table `_menu_item`
--
ALTER TABLE `_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_menu_item_ibfk_1` (`menu_id`),
  ADD KEY `_menu_item_ibfk_2` (`modification_user`);

--
-- Indexes for table `_subdomain`
--
ALTER TABLE `_subdomain`
  ADD PRIMARY KEY (`subdomain_id`),
  ADD UNIQUE KEY `subdomain` (`subdomain`),
  ADD KEY `_parameters_ibfk_1` (`modification_user`);

--
-- Indexes for table `_user`
--
ALTER TABLE `_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`subdomain_id`),
  ADD KEY `_user_ibfk_1` (`user_role_id`),
  ADD KEY `_user_ibfk_2` (`modification_user`);

--
-- Indexes for table `_user_role`
--
ALTER TABLE `_user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_user_role_ibfk_1` (`menu_id`),
  ADD KEY `_user_role_ibfk_2` (`modification_user`);

--
-- Indexes for table `_workcode`
--
ALTER TABLE `_workcode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_code` (`subdomain_id`,`device_code`),
  ADD KEY `_workcode_ibfk_1` (`modification_user`);

--
-- Indexes for table `__log__employee`
--
ALTER TABLE `__log__employee`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `__log__location`
--
ALTER TABLE `__log__location`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `__log__workcode`
--
ALTER TABLE `__log__workcode`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `_attendance`
--
ALTER TABLE `_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_device`
--
ALTER TABLE `_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_device_event`
--
ALTER TABLE `_device_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_employee`
--
ALTER TABLE `_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `_employee_face`
--
ALTER TABLE `_employee_face`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_employee_fingerprint`
--
ALTER TABLE `_employee_fingerprint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `_location`
--
ALTER TABLE `_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_menu`
--
ALTER TABLE `_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_menu_item`
--
ALTER TABLE `_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `_subdomain`
--
ALTER TABLE `_subdomain`
  MODIFY `subdomain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_user`
--
ALTER TABLE `_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `_user_role`
--
ALTER TABLE `_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `_workcode`
--
ALTER TABLE `_workcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `__log__employee`
--
ALTER TABLE `__log__employee`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `__log__location`
--
ALTER TABLE `__log__location`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `__log__workcode`
--
ALTER TABLE `__log__workcode`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `_attendance`
--
ALTER TABLE `_attendance`
  ADD CONSTRAINT `_attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `_employee` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_attendance_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `_device` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_attendance_ibfk_3` FOREIGN KEY (`workcode_id`) REFERENCES `_workcode` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_attendance_ibfk_4` FOREIGN KEY (`modification_user`) REFERENCES `_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `_device`
--
ALTER TABLE `_device`
  ADD CONSTRAINT `_device_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `_location` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_device_ibfk_2` FOREIGN KEY (`modification_user`) REFERENCES `_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `_device_event`
--
ALTER TABLE `_device_event`
  ADD CONSTRAINT `_device_event_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `_device` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_device_event_ibfk_2` FOREIGN KEY (`modification_user`) REFERENCES `_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `_employee`
--
ALTER TABLE `_employee`
  ADD CONSTRAINT `_employee_ibfk_1` FOREIGN KEY (`modification_user`) REFERENCES `_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `_employee_face`
--
ALTER TABLE `_employee_face`
  ADD CONSTRAINT `_employee_face_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `_employee` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_employee_face_ibfk_2` FOREIGN KEY (`modification_user`) REFERENCES `_user` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
