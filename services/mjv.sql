-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2016 at 09:32 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mjv`
--

-- --------------------------------------------------------

--
-- Table structure for table `mjv_announcements`
--

CREATE TABLE IF NOT EXISTS `mjv_announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `public` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mjv_article`
--

CREATE TABLE IF NOT EXISTS `mjv_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portal_type` smallint(6) NOT NULL,
  `title` varchar(64) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `content` mediumblob NOT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `portal_type` (`portal_type`),
  KEY `status` (`status`),
  KEY `created_by` (`created_by`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mjv_article_status`
--

CREATE TABLE IF NOT EXISTS `mjv_article_status` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mjv_article_status`
--

INSERT INTO `mjv_article_status` (`id`, `name`) VALUES
(1, 'Yet to be reviewed'),
(2, 'Closed by self'),
(3, 'Rejected'),
(4, 'Published');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_cmd`
--

CREATE TABLE IF NOT EXISTS `mjv_cmd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mjv_gallery`
--

CREATE TABLE IF NOT EXISTS `mjv_gallery` (
  `name` varchar(64) NOT NULL,
  `physical_path` varchar(255) NOT NULL,
  PRIMARY KEY (`name`,`physical_path`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mjv_id_proofs`
--

CREATE TABLE IF NOT EXISTS `mjv_id_proofs` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mjv_id_proofs`
--

INSERT INTO `mjv_id_proofs` (`id`, `name`) VALUES
(1, 'Aadhar Card'),
(2, 'Electoral Id'),
(3, 'Pan Card'),
(4, 'Passport'),
(5, 'Driving License'),
(6, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_portal_sub_type`
--

CREATE TABLE IF NOT EXISTS `mjv_portal_sub_type` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `portal_type` smallint(6) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portal_type` (`portal_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `mjv_portal_sub_type`
--

INSERT INTO `mjv_portal_sub_type` (`id`, `name`, `portal_type`, `created_date`, `last_updated_date`) VALUES
(1, 'Medical counselling', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(2, 'Doctor appointment', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(3, 'Blood donation', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(4, 'Sponsor funds for health recovery', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(5, 'Health camps', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(6, 'Medical awarness programs', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(7, 'Career guidance', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(8, 'Job opportunities', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(9, 'Job references', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(10, 'Online trainings', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(11, 'Education sponsorship', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(12, 'Medical counselling', 4, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(13, 'Doctor appointment', 4, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(14, 'Blood donation', 4, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(15, 'Art related carnivals', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(16, 'Music', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(17, 'Dance festival', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(18, 'Competitions', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(19, 'References for the training institutes', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(20, 'Women specific job opportunities', 6, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(21, 'Trainings on self employment,', 6, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(22, 'Women safety', 6, '2016-04-30 17:56:49', '2016-04-30 17:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_portal_type`
--

CREATE TABLE IF NOT EXISTS `mjv_portal_type` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `display_order` smallint(6) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mjv_portal_type`
--

INSERT INTO `mjv_portal_type` (`id`, `name`, `display_order`, `created_date`, `last_updated_date`) VALUES
(1, 'General Updates', 1, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(2, 'Health & Welfare', 2, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(3, 'Career & Education', 3, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(4, 'Social & Security', 4, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(5, 'Art & Culture', 5, '2016-04-30 17:56:49', '2016-04-30 17:56:49'),
(6, 'Women welfare', 6, '2016-04-30 17:56:49', '2016-04-30 17:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_service_request`
--

CREATE TABLE IF NOT EXISTS `mjv_service_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `requestor_name` varchar(80) DEFAULT NULL,
  `requestor_email` varchar(80) DEFAULT NULL,
  `requestor_contact` varchar(14) DEFAULT NULL,
  `requestor_address` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  `severity` smallint(6) NOT NULL,
  `priority` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL,
  `portal_type` smallint(6) NOT NULL,
  `service_type` smallint(6) NOT NULL,
  `submitted_by_user_id` int(11) DEFAULT NULL,
  `assigned_to_user_id` int(11) DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `severity` (`severity`),
  KEY `status` (`status`),
  KEY `priority` (`priority`),
  KEY `portal_type` (`portal_type`),
  KEY `service_type` (`service_type`),
  KEY `submitted_by_user_id` (`submitted_by_user_id`),
  KEY `assigned_to_user_id` (`assigned_to_user_id`),
  KEY `approver_user_id` (`approver_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mjv_service_request_priority`
--

CREATE TABLE IF NOT EXISTS `mjv_service_request_priority` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mjv_service_request_priority`
--

INSERT INTO `mjv_service_request_priority` (`id`, `name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_service_request_severity`
--

CREATE TABLE IF NOT EXISTS `mjv_service_request_severity` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mjv_service_request_severity`
--

INSERT INTO `mjv_service_request_severity` (`id`, `name`) VALUES
(1, 'Minor'),
(2, 'Medium'),
(3, 'Critical');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_service_request_status`
--

CREATE TABLE IF NOT EXISTS `mjv_service_request_status` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mjv_service_request_status`
--

INSERT INTO `mjv_service_request_status` (`id`, `name`) VALUES
(1, 'open'),
(2, 'In Progress'),
(3, 'Closed'),
(4, 'Force Closed');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_token`
--

CREATE TABLE IF NOT EXISTS `mjv_token` (
  `user_id` int(11) NOT NULL,
  `token_string` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`,`token_string`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mjv_token`
--

INSERT INTO `mjv_token` (`user_id`, `token_string`) VALUES
(12, '02UGCrQbqNIhZtdu'),
(12, '0FdfoJv14REatJvE'),
(12, '0mBUScuIevD03rI4'),
(12, '31g4LqsAPiNAA2oO'),
(12, '4XozGhjCzdWn5Ybh'),
(12, '5l00lbmsgU0rCBJT'),
(12, '5RSg2oPkfHFJqnUV'),
(12, '6TSnSQTbj8XbmnOv'),
(12, '76EwpAgAF1gVpcCc'),
(12, 'AHasOtkFR5mUkvJu'),
(12, 'AMHVjPIksFKjYjI0'),
(12, 'bDDS8fbR6eQjLiro'),
(12, 'bTI1Ru4srEXsckHm'),
(12, 'cqjXwRY4ZjxSftOO'),
(12, 'Ct4no4sE54mNF4dZ'),
(12, 'cvju6hjSiDwNuzrs'),
(12, 'D28AZyHTd42i8d3C'),
(12, 'dinoCzyKhA4M7zde'),
(12, 'DmWg0wtjGEo0MkIK'),
(12, 'dwZFtusTtZoPbTjU'),
(12, 'DxTLtLbEzSAKKjWD'),
(12, 'g2YBUbUXRchQrhf0'),
(12, 'ggtRYQBXQdIl3FLT'),
(12, 'GkIsAT5NthiTJbRg'),
(12, 'H4IA1ZMEnacZfTFT'),
(12, 'hmMbnYkgswmJgFpT'),
(12, 'IHCdv6lMxdKPs5UP'),
(12, 'ImGhudR2QtNtGXtp'),
(12, 'iQBwlCljiv1OTsG2'),
(12, 'jiqqL5gpFtjzPUjD'),
(12, 'jWxRclLusBQH0Hnz'),
(12, 'JyThoaaFzrOnn5Bm'),
(12, 'koBXt55exAKZQCrB'),
(12, 'LI2fdskMCDLagULL'),
(12, 'MfcsEM4omEJU1KzT'),
(12, 'n4ZA4sY4EPfnYsZi'),
(12, 'pafS3Uw8Qn5iZI4O'),
(12, 'PCy3LRUoUYX5uN8r'),
(12, 'pswpV1vGaCUSsAQB'),
(12, 'QgDr4lb7SOkhLkpF'),
(12, 'R4GTRL08Az4jQU0w'),
(12, 'rEVbu12ijo7S1rdD'),
(12, 'rjmZjWh0K263aXZL'),
(12, 'RyRINFL2qWfw04Mj'),
(12, 't8BEkKkehmGCnrsD'),
(12, 'tIZWfGQ1exBYtjIU'),
(12, 'tUkRBVRQTVFp8aPY'),
(12, 'tw0CFbTCSODHsuZZ'),
(12, 'UgynUfYpELPjgu3H'),
(12, 'uStqV4HGIJpzD13E'),
(12, 'vwTatoqrNozGnhlM'),
(12, 'Wy5dAilo3VAlIKZ3'),
(12, 'xQ3FOFPRsPSDp6P6'),
(12, 'xz2Gv7HrjeyUYo1p'),
(12, 'y5NZPgisxukctruW'),
(12, 'YguXIzvKrFaZpLJZ'),
(12, 'YunAHCjZoTJzfg2P'),
(12, 'z5maFeHkyzaHcDSB'),
(12, 'zCLdtYi4XAXSevKa'),
(12, 'Zhi3o7sOoLT8TcU6');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_users`
--

CREATE TABLE IF NOT EXISTS `mjv_users` (
  `user_email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mjv_users`
--

INSERT INTO `mjv_users` (`user_email`, `password`, `user_id`) VALUES
('roju@gmail.com', '12345', 12);

-- --------------------------------------------------------

--
-- Table structure for table `mjv_user_contributions`
--

CREATE TABLE IF NOT EXISTS `mjv_user_contributions` (
  `user_id` int(11) NOT NULL,
  `portal_type` smallint(6) NOT NULL,
  PRIMARY KEY (`user_id`,`portal_type`),
  KEY `user_id` (`user_id`),
  KEY `portal_type` (`portal_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mjv_user_contributions`
--

INSERT INTO `mjv_user_contributions` (`user_id`, `portal_type`) VALUES
(12, 1),
(12, 2),
(12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `mjv_user_profile`
--

CREATE TABLE IF NOT EXISTS `mjv_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `id_proof_type` smallint(6) NOT NULL,
  `id_proof_name` varchar(64) NOT NULL,
  `id_proof_value` varchar(64) NOT NULL,
  `profession` varchar(64) NOT NULL,
  `profile_pic_path` varchar(64) DEFAULT NULL,
  `contact_number` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_proof_type` (`id_proof_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `mjv_user_profile`
--

INSERT INTO `mjv_user_profile` (`id`, `first_name`, `last_name`, `email`, `id_proof_type`, `id_proof_name`, `id_proof_value`, `profession`, `profile_pic_path`, `contact_number`) VALUES
(12, 'roju', 'vamshi', 'roju@gmail.com', 4, 'Passport', 'ASW654D890', 'soft ware', '1462097518.jpg', '9877886654');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_user_role`
--

CREATE TABLE IF NOT EXISTS `mjv_user_role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mjv_user_role`
--

INSERT INTO `mjv_user_role` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Can add new tabs and key services in knowledge portal, edit, delete existing content, approve or reject service requests submitted by volunteers, review and publish the contents'),
(2, 'volunteer', 'create a service request, update and delete service requests raised by self and submit content for knowledge portal');

-- --------------------------------------------------------

--
-- Table structure for table `mjv_user_to_role`
--

CREATE TABLE IF NOT EXISTS `mjv_user_to_role` (
  `user_id` int(11) NOT NULL,
  `role_id` smallint(6) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mjv_user_to_role`
--

INSERT INTO `mjv_user_to_role` (`user_id`, `role_id`) VALUES
(12, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mjv_article`
--
ALTER TABLE `mjv_article`
  ADD CONSTRAINT `mjv_article_ibfk_1` FOREIGN KEY (`portal_type`) REFERENCES `mjv_portal_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_article_ibfk_2` FOREIGN KEY (`status`) REFERENCES `mjv_article_status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_article_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_article_ibfk_4` FOREIGN KEY (`last_updated_by`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_portal_sub_type`
--
ALTER TABLE `mjv_portal_sub_type`
  ADD CONSTRAINT `mjv_portal_sub_type_ibfk_1` FOREIGN KEY (`portal_type`) REFERENCES `mjv_portal_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_service_request`
--
ALTER TABLE `mjv_service_request`
  ADD CONSTRAINT `mjv_service_request_ibfk_1` FOREIGN KEY (`severity`) REFERENCES `mjv_service_request_severity` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_2` FOREIGN KEY (`status`) REFERENCES `mjv_service_request_status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_3` FOREIGN KEY (`priority`) REFERENCES `mjv_service_request_priority` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_4` FOREIGN KEY (`portal_type`) REFERENCES `mjv_portal_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_5` FOREIGN KEY (`service_type`) REFERENCES `mjv_portal_sub_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_6` FOREIGN KEY (`submitted_by_user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_7` FOREIGN KEY (`submitted_by_user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_service_request_ibfk_8` FOREIGN KEY (`approver_user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_token`
--
ALTER TABLE `mjv_token`
  ADD CONSTRAINT `mjv_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_users`
--
ALTER TABLE `mjv_users`
  ADD CONSTRAINT `mjv_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_user_contributions`
--
ALTER TABLE `mjv_user_contributions`
  ADD CONSTRAINT `mjv_user_contributions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_user_contributions_ibfk_2` FOREIGN KEY (`portal_type`) REFERENCES `mjv_portal_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_user_profile`
--
ALTER TABLE `mjv_user_profile`
  ADD CONSTRAINT `mjv_user_profile_ibfk_1` FOREIGN KEY (`id_proof_type`) REFERENCES `mjv_id_proofs` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mjv_user_to_role`
--
ALTER TABLE `mjv_user_to_role`
  ADD CONSTRAINT `mjv_user_to_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mjv_user_profile` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mjv_user_to_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `mjv_user_role` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
