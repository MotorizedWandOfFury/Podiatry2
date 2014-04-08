-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2014 at 11:43 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `podiatry`
--

-- --------------------------------------------------------

--
-- Table structure for table `ans_demo`
--

CREATE TABLE IF NOT EXISTS `ans_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ans_demo`
--

INSERT INTO `ans_demo` (`id`, `dateof`, `answer`, `ques_num`, `pat_id`) VALUES
(1, 20120320, 1, 1, 1),
(2, 20120320, 6, 2, 1),
(3, 20120320, 12, 3, 1),
(4, 20120320, 18, 4, 1),
(5, 20120320, 25, 5, 1),
(6, 20120320, 33, 6, 1),
(7, 20121115, 1, 1, 1),
(8, 20121115, 5, 2, 1),
(9, 20121115, 10, 3, 1),
(10, 20121115, 16, 4, 1),
(11, 20121115, 25, 5, 1),
(12, 20121115, 33, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ans_eval`
--

CREATE TABLE IF NOT EXISTS `ans_eval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofexam` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`),
  KEY `sur_id` (`sur_id`),
  KEY `dateof_2` (`dateof`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=359 ;

--
-- Dumping data for table `ans_eval`
--

INSERT INTO `ans_eval` (`id`, `dateof`, `dateofexam`, `answer`, `ques_num`, `pat_id`, `sur_id`) VALUES
(131, 1336491143, 834033600, 2, 10, 4, 1),
(132, 1336491143, 834033600, 7, 11, 4, 1),
(133, 1336491143, 834033600, 12, 12, 4, 1),
(134, 1336491143, 834033600, 14, 13, 4, 1),
(135, 1336491143, 834033600, 16, 14, 4, 1),
(136, 1336491143, 834033600, 15, 15, 4, 1),
(338, 1336491803, 1012626000, 1, 10, 2, 1),
(339, 1336491803, 1012626000, 6, 11, 2, 1),
(340, 1336491803, 1012626000, 11, 12, 2, 1),
(341, 1336491803, 1012626000, 13, 13, 2, 1),
(342, 1336491803, 1012626000, 15, 14, 2, 1),
(343, 1336491803, 1012626000, 17, 15, 2, 1),
(345, 1336491803, 1012626000, 19, 17, 2, 1),
(346, 1336491803, 1012626000, 23, 17, 2, 1),
(347, 1336491803, 1012626000, 27, 17, 2, 1),
(348, 1336491803, 1012626000, 31, 18, 2, 1),
(349, 1336491803, 1012626000, 35, 18, 2, 1),
(350, 1336491803, 1012626000, 22, 19, 2, 1),
(351, 1336491803, 1012626000, 2, 20, 2, 1),
(352, 1336491803, 1012626000, 37, 21, 2, 1),
(353, 1336491803, 1012626000, 43, 22, 2, 1),
(354, 1336491803, 1012626000, 45, 23, 2, 1),
(355, 1336491803, 1012626000, 48, 24, 2, 1),
(356, 1336491803, 1012626000, 55, 25, 2, 1),
(357, 1336491803, 1012626000, 60, 26, 2, 1),
(358, 1336491803, 1012626000, 62, 27, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ans_foot`
--

CREATE TABLE IF NOT EXISTS `ans_foot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ans_foot`
--

INSERT INTO `ans_foot` (`id`, `dateof`, `answer`, `ques_num`, `pat_id`) VALUES
(1, 1355288400, 1, 4, 1),
(2, 1355288400, 6, 6, 1),
(3, 1355288400, 11, 7, 1),
(4, 1355288400, 16, 8, 1),
(5, 1355288400, 21, 10, 1),
(6, 1355288400, 26, 11, 1),
(7, 1355288400, 31, 13, 1),
(8, 1355288400, 36, 14, 1),
(9, 1355288400, 41, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ans_mcgillpain`
--

CREATE TABLE IF NOT EXISTS `ans_mcgillpain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`),
  KEY `sur_id` (`sur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ans_mcgillpain`
--

INSERT INTO `ans_mcgillpain` (`id`, `dateof`, `answer`, `ques_num`, `pat_id`, `sur_id`) VALUES
(1, 1355288400, 1, 5, 1, 1),
(2, 1355288400, 5, 6, 1, 1),
(3, 1355288400, 9, 7, 1, 1),
(4, 1355288400, 13, 8, 1, 1),
(5, 1355288400, 16, 9, 1, 1),
(6, 1355288400, 19, 10, 1, 1),
(7, 1355288400, 23, 11, 1, 1),
(8, 1355288400, 25, 12, 1, 1),
(9, 1355288400, 28, 13, 1, 1),
(10, 1355288400, 32, 14, 1, 1),
(11, 1355288400, 36, 15, 1, 1),
(12, 1355288400, 40, 16, 1, 1),
(13, 1355288400, 44, 17, 1, 1),
(14, 1355288400, 48, 18, 1, 1),
(15, 1355288400, 52, 19, 1, 1),
(16, 1355288400, 56, 20, 1, 1),
(17, 1355288400, 60, 21, 1, 1),
(18, 1355288400, 64, 22, 1, 1),
(19, 1355288400, 68, 23, 1, 1),
(20, 1355288400, 72, 24, 1, 1),
(21, 1355288400, 76, 25, 1, 1),
(22, 1355288400, 80, 26, 1, 1),
(23, 1355288400, 84, 27, 1, 1),
(24, 1355288400, 88, 28, 1, 1),
(25, 1355288400, 94, 29, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ans_post`
--

CREATE TABLE IF NOT EXISTS `ans_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofexam` int(10) DEFAULT NULL,
  `painmedused` int(11) NOT NULL,
  `dosepainmedused` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`),
  KEY `sur_id` (`sur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ans_sf36`
--

CREATE TABLE IF NOT EXISTS `ans_sf36` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `ans_sf36`
--

INSERT INTO `ans_sf36` (`id`, `dateof`, `answer`, `ques_num`, `pat_id`) VALUES
(1, 1336968000, 1, 4, 2),
(2, 1336968000, 1, 5, 2),
(3, 1336968000, 1, 7, 2),
(4, 1336968000, 1, 8, 2),
(5, 1336968000, 1, 9, 2),
(6, 1336968000, 1, 10, 2),
(7, 1336968000, 1, 11, 2),
(8, 1336968000, 1, 12, 2),
(9, 1336968000, 1, 13, 2),
(10, 1336968000, 1, 14, 2),
(11, 1336968000, 1, 15, 2),
(12, 1336968000, 1, 16, 2),
(13, 1336968000, 1, 18, 2),
(14, 1336968000, 1, 19, 2),
(15, 1336968000, 1, 20, 2),
(16, 1336968000, 1, 21, 2),
(17, 1336968000, 1, 23, 2),
(18, 1336968000, 1, 24, 2),
(19, 1336968000, 1, 25, 2),
(20, 1336968000, 1, 26, 2),
(21, 1336968000, 1, 27, 2),
(22, 1336968000, 1, 28, 2),
(23, 1336968000, 1, 31, 2),
(24, 1336968000, 1, 32, 2),
(25, 1336968000, 1, 33, 2),
(26, 1336968000, 1, 34, 2),
(27, 1336968000, 1, 35, 2),
(28, 1336968000, 1, 36, 2),
(29, 1336968000, 1, 37, 2),
(30, 1336968000, 1, 38, 2),
(31, 1336968000, 1, 39, 2),
(32, 1336968000, 1, 40, 2),
(33, 1336968000, 1, 42, 2),
(34, 1336968000, 1, 43, 2),
(35, 1336968000, 1, 44, 2),
(36, 1336968000, 1, 45, 2),
(39, 1273809600, 3, 7, 2),
(40, 1273809600, 3, 8, 2),
(41, 1273809600, 3, 9, 2),
(42, 1273809600, 3, 10, 2),
(43, 1273809600, 3, 11, 2),
(44, 1273809600, 3, 12, 2),
(45, 1273809600, 3, 13, 2),
(46, 1273809600, 3, 14, 2),
(47, 1273809600, 3, 15, 2),
(48, 1273809600, 3, 16, 2),
(49, 1273809600, 2, 18, 2),
(50, 1273809600, 2, 19, 2),
(51, 1273809600, 2, 20, 2),
(52, 1273809600, 2, 21, 2),
(53, 1273809600, 2, 23, 2),
(54, 1273809600, 2, 24, 2),
(55, 1273809600, 2, 25, 2),
(57, 1273809600, 6, 27, 2),
(59, 1273809600, 6, 31, 2),
(60, 1273809600, 6, 32, 2),
(61, 1273809600, 6, 33, 2),
(62, 1273809600, 6, 34, 2),
(63, 1273809600, 6, 35, 2),
(64, 1273809600, 6, 36, 2),
(65, 1273809600, 6, 37, 2),
(66, 1273809600, 6, 38, 2),
(67, 1273809600, 6, 39, 2),
(68, 1352955600, 1, 4, 1),
(69, 1352955600, 1, 5, 1),
(70, 1352955600, 1, 7, 1),
(71, 1352955600, 1, 8, 1),
(72, 1352955600, 1, 9, 1),
(73, 1352955600, 1, 10, 1),
(74, 1352955600, 1, 11, 1),
(75, 1352955600, 1, 12, 1),
(76, 1352955600, 1, 13, 1),
(77, 1352955600, 1, 14, 1),
(78, 1352955600, 1, 15, 1),
(79, 1352955600, 1, 16, 1),
(80, 1352955600, 1, 18, 1),
(81, 1352955600, 1, 19, 1),
(82, 1352955600, 1, 20, 1),
(83, 1352955600, 1, 21, 1),
(84, 1352955600, 1, 23, 1),
(85, 1352955600, 1, 24, 1),
(86, 1352955600, 1, 25, 1),
(87, 1352955600, 1, 26, 1),
(88, 1352955600, 1, 27, 1),
(89, 1352955600, 1, 28, 1),
(90, 1352955600, 1, 31, 1),
(91, 1352955600, 1, 32, 1),
(92, 1352955600, 1, 33, 1),
(93, 1352955600, 1, 34, 1),
(94, 1352955600, 1, 35, 1),
(95, 1352955600, 1, 36, 1),
(96, 1352955600, 1, 37, 1),
(97, 1352955600, 1, 38, 1),
(98, 1352955600, 1, 39, 1),
(99, 1352955600, 1, 40, 1),
(100, 1352955600, 1, 42, 1),
(101, 1352955600, 1, 43, 1),
(102, 1352955600, 1, 44, 1),
(103, 1352955600, 1, 45, 1),
(104, 1365912000, 1, 4, 7),
(105, 1365912000, 1, 5, 7),
(106, 1365912000, 1, 7, 7),
(107, 1365912000, 1, 8, 7),
(108, 1365912000, 1, 9, 7),
(109, 1365912000, 1, 10, 7),
(110, 1365912000, 1, 11, 7),
(111, 1365912000, 1, 12, 7),
(112, 1365912000, 1, 13, 7),
(113, 1365912000, 1, 14, 7),
(114, 1365912000, 1, 15, 7),
(115, 1365912000, 1, 16, 7),
(116, 1365912000, 1, 18, 7),
(117, 1365912000, 1, 19, 7),
(118, 1365912000, 1, 20, 7),
(119, 1365912000, 1, 21, 7),
(120, 1365912000, 1, 23, 7),
(121, 1365912000, 1, 24, 7),
(122, 1365912000, 1, 25, 7),
(123, 1365912000, 1, 26, 7),
(124, 1365912000, 1, 27, 7),
(125, 1365912000, 1, 28, 7),
(126, 1365912000, 1, 31, 7),
(127, 1365912000, 1, 32, 7),
(128, 1365912000, 1, 33, 7),
(129, 1365912000, 1, 34, 7),
(130, 1365912000, 1, 35, 7),
(131, 1365912000, 1, 36, 7),
(132, 1365912000, 1, 37, 7),
(133, 1365912000, 1, 38, 7),
(134, 1365912000, 1, 39, 7),
(135, 1365912000, 1, 40, 7),
(136, 1365912000, 1, 42, 7),
(137, 1365912000, 1, 43, 7),
(138, 1365912000, 1, 44, 7),
(139, 1365912000, 1, 45, 7);

-- --------------------------------------------------------

--
-- Table structure for table `ans_surgical`
--

CREATE TABLE IF NOT EXISTS `ans_surgical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofsurgery` int(10) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `answer` (`answer`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`),
  KEY `sur_id` (`sur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ans_surgical`
--

INSERT INTO `ans_surgical` (`id`, `dateof`, `dateofsurgery`, `answer`, `ques_num`, `pat_id`, `sur_id`) VALUES
(1, 1314579968, 1178769600, 15, 5, 3, 1),
(2, 1314579968, 1178769600, 17, 6, 3, 1),
(3, 1314579968, 1178769600, 19, 7, 3, 1),
(4, 1314579968, 1178769600, 22, 8, 3, 1),
(5, 1314579968, 1178769600, 23, 9, 3, 1),
(6, 1314579968, 1178769600, 26, 10, 3, 1),
(7, 1314579968, 1178769600, 27, 11, 3, 1),
(8, 1314579968, 1178769600, 29, 12, 3, 1),
(9, 1314579968, 1178769600, 32, 13, 3, 1),
(10, 1314579968, 1178769600, 34, 14, 3, 1),
(11, 1314579968, 1178769600, 36, 15, 3, 1),
(12, 1314579968, 1178769600, 38, 16, 3, 1),
(13, 1314579968, 1178769600, 43, 17, 3, 1),
(14, 1314579968, 1178769600, 47, 18, 3, 1),
(15, 1314579968, 1178769600, 50, 19, 3, 1),
(16, 1314579968, 1178769600, 52, 20, 3, 1),
(17, 1314579968, 1178769600, 53, 21, 3, 1),
(18, 1314579968, 1178769600, 56, 22, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ans_xrays`
--

CREATE TABLE IF NOT EXISTS `ans_xrays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofxrays` int(10) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `ques_num` int(11) NOT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof` (`dateof`,`ques_num`,`pat_id`),
  KEY `ques_num` (`ques_num`),
  KEY `pat_id` (`pat_id`),
  KEY `sur_id` (`sur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `complications_answers`
--

CREATE TABLE IF NOT EXISTS `complications_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `extremity` int(1) NOT NULL,
  `dateof` int(11) DEFAULT NULL,
  `dateofexam` int(11) NOT NULL,
  `dateofrevisionalsurgery` int(11) DEFAULT NULL,
  `dateofothercomplications` int(11) DEFAULT NULL,
  `Q5` int(2) DEFAULT NULL,
  `Q6` varchar(50) DEFAULT NULL,
  `Q7` varchar(22) DEFAULT NULL,
  `Q8` varchar(24) DEFAULT NULL,
  `Q9` varchar(20) DEFAULT NULL,
  `Q10` varchar(120) DEFAULT NULL,
  `Q11` varchar(60) DEFAULT NULL,
  `Q12` varchar(60) DEFAULT NULL,
  `Q13` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `complications_answers`
--

INSERT INTO `complications_answers` (`id`, `pat_id`, `sur_id`, `extremity`, `dateof`, `dateofexam`, `dateofrevisionalsurgery`, `dateofothercomplications`, `Q5`, `Q6`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`) VALUES
(1, 1, 1, 2, 1389589200, 1389589200, 0, 0, 2, 'None', '1|2|3|4|5|6|7|8|9', '1|2|3|4|5|6|7|8|9|10', '1|2|3|4|5|6|7', ' none', 'none', 'none', '');

-- --------------------------------------------------------

--
-- Table structure for table `demo_answers`
--

CREATE TABLE IF NOT EXISTS `demo_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `Q1` varchar(23) DEFAULT NULL,
  `Q2` varchar(36) DEFAULT NULL,
  `Q3` varchar(32) DEFAULT NULL,
  `Q4` varchar(83) DEFAULT NULL,
  `Q5` varchar(20) DEFAULT NULL,
  `Q6` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `demo_answers`
--

INSERT INTO `demo_answers` (`id`, `dateof`, `pat_id`, `Q1`, `Q2`, `Q3`, `Q4`, `Q5`, `Q6`) VALUES
(1, 1375419600, 2, '1', '3', '6', '1', '6', '4'),
(3, 1377752400, 1, '1', '1', '1', '1', '1', '1'),
(4, 977806800, 16, '2', '2', '4', '1', '7', '3'),
(5, 1389675600, 18, '2', '2', '3', '4', '3', '3'),
(6, 959058000, 19, '1', '3', '2', '5', '7', '4'),
(7, 953010000, 21, '1', '3', '4', '1', '3', '4'),
(8, 1392181200, 22, '1', '3', '6', '1', '5', '4');

-- --------------------------------------------------------

--
-- Table structure for table `eval_answers`
--

CREATE TABLE IF NOT EXISTS `eval_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofexam` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `extremity` int(11) DEFAULT NULL,
  `Q10` int(2) DEFAULT NULL,
  `Q11` int(2) DEFAULT NULL,
  `Q12` int(2) DEFAULT NULL,
  `Q13` int(2) DEFAULT NULL,
  `Q14` int(2) DEFAULT NULL,
  `Q15` int(4) DEFAULT NULL,
  `Q16` int(2) DEFAULT NULL,
  `Q17` varchar(27) DEFAULT NULL,
  `Q18` varchar(15) DEFAULT NULL,
  `Q19` int(4) DEFAULT NULL,
  `Q20` int(4) DEFAULT NULL,
  `Q21` int(2) DEFAULT NULL,
  `Q22` int(2) DEFAULT NULL,
  `Q23` int(2) DEFAULT NULL,
  `Q24` varchar(15) DEFAULT NULL,
  `Q25` int(2) DEFAULT NULL,
  `Q26` int(2) DEFAULT NULL,
  `Q27` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extremity` (`extremity`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `eval_answers`
--

INSERT INTO `eval_answers` (`id`, `dateof`, `dateofexam`, `pat_id`, `sur_id`, `height`, `weight`, `extremity`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `Q15`, `Q16`, `Q17`, `Q18`, `Q19`, `Q20`, `Q21`, `Q22`, `Q23`, `Q24`, `Q25`, `Q26`, `Q27`) VALUES
(1, 1375419600, 1375419600, 2, 1, 68, 160, 1, 1, 2, 2, 2, 2, 1, 1, '1', '1|4', 12, 12, 2, 2, 2, '1', 2, 2, '2'),
(3, 1376110800, 1376110800, 3, 1, 68, 150, 1, 1, 1, 1, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1377752400, 1377752400, 1, 1, 60, 160, 2, 1, 1, 2, 2, 1, 11, 2, '1|2|3|4|5|6|7|8|9|10|11|12', '2|3|4|5|6', 11, 10, 5, 2, 1, '3|4|6', 4, 3, '2|3|4|6'),
(5, 1378875600, 1378875600, 1, 1, 60, 120, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1383886800, 1383886800, 4, 1, 70, 150, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1383886800, 1383886800, 4, 1, 50, 150, 2, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1383886800, 969339600, 14, 5, 67, 120, 2, 1, 0, 0, 0, 1, 36, 1, '', '', 65, 20, 1, 2, 2, '', 4, 2, ''),
(9, 1384059600, 977806800, 16, 6, 59, 160, 2, 1, 2, 2, 2, 2, 60, 2, NULL, NULL, 60, 10, NULL, 2, 2, NULL, NULL, NULL, NULL),
(10, 1389243600, 1410238800, 17, 4, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1389675600, 975387600, 18, 5, 0, 0, 1, 1, NULL, 2, 2, 2, 24, NULL, '4', NULL, 60, 20, 1, 2, 2, NULL, 2, 1, '1'),
(12, 1390021200, 959058000, 19, 7, 0, 0, 2, 1, NULL, 2, 1, 1, 96, 2, NULL, '6', 50, 5, 2, 2, 2, NULL, 6, 3, '2'),
(13, 1390021200, 956725200, 20, 7, 0, 0, 1, 1, NULL, 1, 1, 1, 60, 2, '12', NULL, 40, 15, 2, 2, 2, NULL, 2, 3, NULL),
(14, 1392181200, 952578000, 21, 7, 0, 0, 1, 1, NULL, 2, 2, 2, 480, 2, NULL, NULL, 45, 10, 1, 2, 2, NULL, 1, 3, '2'),
(15, 1392181200, 975387600, 22, 8, 0, 0, 1, 1, NULL, 2, 2, 2, 24, 2, NULL, NULL, 60, 20, 3, 2, 2, NULL, 2, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `extremity`
--

CREATE TABLE IF NOT EXISTS `extremity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ex` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `extremity`
--

INSERT INTO `extremity` (`id`, `ex`) VALUES
(1, 'L'),
(2, 'R');

-- --------------------------------------------------------

--
-- Table structure for table `foot_answers`
--

CREATE TABLE IF NOT EXISTS `foot_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `Q4` int(2) DEFAULT NULL,
  `Q6` int(2) DEFAULT NULL,
  `Q7` int(2) DEFAULT NULL,
  `Q8` int(2) DEFAULT NULL,
  `Q10` int(2) DEFAULT NULL,
  `Q11` int(2) DEFAULT NULL,
  `Q13` int(2) DEFAULT NULL,
  `Q14` int(2) DEFAULT NULL,
  `Q15` int(2) DEFAULT NULL,
  `Q17` int(2) DEFAULT NULL,
  `Q18` int(2) DEFAULT NULL,
  `Q19` int(2) DEFAULT NULL,
  `Q20` int(2) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pat_id` (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `foot_answers`
--

INSERT INTO `foot_answers` (`id`, `dateof`, `pat_id`, `Q4`, `Q6`, `Q7`, `Q8`, `Q10`, `Q11`, `Q13`, `Q14`, `Q15`, `Q17`, `Q18`, `Q19`, `Q20`, `type`, `extremity`) VALUES
(2, 1377752400, 1, 5, 5, 5, NULL, 5, 5, 5, 5, 5, 5, 5, 5, 5, 1, 2),
(3, 1377752400, 1, 4, 4, 4, NULL, 4, 4, 4, 4, 4, 4, 4, 4, 4, 3, 2),
(4, 1377752400, 1, 3, 3, 3, 0, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 2),
(5, 1377752400, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 2),
(6, 1379048400, 1, 5, 5, 5, NULL, 5, 5, 5, 5, 5, 5, 5, 5, 5, 1, 1),
(7, 1379048400, 1, 4, 5, 5, NULL, 5, 5, 5, 5, 5, 5, 5, 5, 5, 3, 1),
(8, 1379048400, 1, 3, 5, 5, NULL, 5, 5, 5, 5, 5, 5, 5, 5, 5, 4, 1),
(9, 1379048400, 1, 2, 5, 5, NULL, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sex` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `sex`) VALUES
(1, 'M'),
(2, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `role` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `sex` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sex` (`sex`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `role`, `firstname`, `lastname`, `password`, `sex`) VALUES
(1, 'admin', 3, 'System', 'Administrator', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mcgillpain_answers`
--

CREATE TABLE IF NOT EXISTS `mcgillpain_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `Q5` int(2) DEFAULT NULL,
  `Q6` int(2) DEFAULT NULL,
  `Q7` int(2) DEFAULT NULL,
  `Q8` int(2) DEFAULT NULL,
  `Q9` int(2) DEFAULT NULL,
  `Q10` int(2) DEFAULT NULL,
  `Q11` int(2) DEFAULT NULL,
  `Q12` int(2) DEFAULT NULL,
  `Q13` int(2) DEFAULT NULL,
  `Q14` int(2) DEFAULT NULL,
  `Q15` int(2) DEFAULT NULL,
  `Q16` int(2) DEFAULT NULL,
  `Q17` int(2) DEFAULT NULL,
  `Q18` int(2) DEFAULT NULL,
  `Q19` int(2) DEFAULT NULL,
  `Q20` int(2) DEFAULT NULL,
  `Q21` int(2) DEFAULT NULL,
  `Q22` int(2) DEFAULT NULL,
  `Q23` int(2) DEFAULT NULL,
  `Q24` int(2) DEFAULT NULL,
  `Q25` int(2) DEFAULT NULL,
  `Q26` int(2) DEFAULT NULL,
  `Q27` int(2) DEFAULT NULL,
  `Q28` int(2) DEFAULT NULL,
  `Q29` int(2) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `mcgillpain_answers`
--

INSERT INTO `mcgillpain_answers` (`id`, `dateof`, `pat_id`, `sur_id`, `Q5`, `Q6`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `Q15`, `Q16`, `Q17`, `Q18`, `Q19`, `Q20`, `Q21`, `Q22`, `Q23`, `Q24`, `Q25`, `Q26`, `Q27`, `Q28`, `Q29`, `type`, `extremity`) VALUES
(3, 1377752400, 1, 1, 3, 2, 4, 3, 1, 1, 1, 3, 1, 1, 2, 2, 3, 3, 4, 4, 3, 3, 1, 1, 2, 3, 4, 3, 8, 1, 2),
(4, 1377752400, 1, 1, 2, 2, 1, 1, 2, 2, 2, 1, 4, 4, 3, 3, 2, 2, 1, 1, 2, 2, 3, 3, 4, 3, 2, 2, 10, 2, 2),
(5, 1377752400, 1, 1, 1, 1, 2, 2, 3, 3, 2, 1, 1, 1, 3, 3, NULL, 4, 4, 3, 3, 2, 2, 1, 2, 3, 4, 6, 1, 3, 2),
(6, 1377752400, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 4, 2),
(7, 1377752400, 1, 1, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 5, 2),
(8, 1378875600, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(9, 1378875600, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 1),
(10, 1378875600, 1, 1, 1, 1, 1, 1, 1, 1, 2, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 3, 3, 3, 3, 3, 1),
(11, 1378875600, 1, 1, NULL, 4, 3, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 4, 4, 4, 4, 4, 1),
(12, 1378875600, 1, 1, 4, 4, 4, 3, 3, 4, NULL, NULL, 4, 4, 4, 4, NULL, NULL, 4, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, 5, 7, 5, 1),
(13, 977806800, 16, 6, 1, 1, 2, 2, 3, 2, 2, 1, 2, 1, 1, 1, 1, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2),
(14, 1389675600, 18, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(15, 959058000, 19, 7, 2, 1, 3, 1, 3, NULL, 1, 1, 3, 2, 1, 1, 2, 2, 2, 3, 2, 3, 2, 3, 1, 1, 1, 2, 5, 1, 2),
(16, 956725200, 20, 7, 2, 1, 3, 3, 3, 3, 1, 2, 3, 1, 1, 1, 3, 3, 3, 3, 3, 4, 1, 1, 1, 1, 1, 3, 5, 1, 1),
(17, 957243600, 20, 7, NULL, NULL, 1, 2, 1, 2, 2, 2, 1, 2, 1, 1, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, NULL, 2, 2, 2, 1),
(18, 952578000, 21, 7, 1, 1, 3, 2, 3, 3, 2, 2, 3, 1, 1, 1, 1, 3, 1, 3, 3, 3, 1, 1, 1, 1, 1, 3, 4, 1, 1),
(19, 952923600, 21, 7, NULL, NULL, 1, 1, 1, 2, 2, 2, 3, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 2, 4, 2, 1),
(20, 960526800, 21, 7, 1, 1, 2, 1, 1, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1),
(21, 975992400, 22, 8, 4, 2, 3, 1, 2, 4, 1, 1, 4, 4, 3, 4, 1, 1, 1, 4, 1, 3, 2, 4, 4, 1, 4, 5, 9, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medicalrecordnumber` int(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `doctor` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `dob` int(10) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(59) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sex` (`sex`),
  KEY `doctor` (`doctor`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `medicalrecordnumber`, `username`, `firstname`, `lastname`, `password`, `doctor`, `role`, `dob`, `sex`, `phone`, `email`, `street`, `city`, `age`, `state`, `zip`) VALUES
(1, 2, 'spatients', 'Tom', 'Durnez', '356a192b7913b04c54574d18c28d46e6395428ab', 1, 1, 0, 2, '', '', '', '', 0, '', 0),
(2, 1, 'hreichgelt', 'Han', 'Reichgelt', '4ff615253469989932532e926006ae5c995e5dd6', 1, 1, -313354800, 1, '80', '165', '1100 S Marietta Parkway', 'Marietta', 52, 'GA', 0),
(3, 1, 'jbartley', 'Josephine', 'Bartley', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 1, 1, 691477200, 2, '63', '197', 'nowhere', 'middle of', 21, 'south dakota', 0),
(4, 1, 'ftest', 'Fred', 'Test', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 1, 1, -313354800, 1, '75', '120', 'Somewhere', 'Newark', 52, 'New Jersey', 0),
(5, 1, 'jstyles', 'Julia', 'Styles', '47b546fbebe811add7ad792278a6767869d901a2', 1, 1, 1259470800, 2, '75', '160', 'somewhere', 'over the rainbow', 23, 'GA', 30101),
(6, 1, 'smalone', 'Sam', 'Malone', '018a7954ed2dc8ec06bba9e87e1aad5cbb9a5135', 1, 1, 943938000, 1, '22', '700', '', 'Â ', 22, 'Â ', 0),
(7, 2, 'tpatient', 'test', 'patient', '606331c67f7e31821d533308ca048bade6760817', 2, 1, 849330000, 1, '0', '0', '', 'Â ', 0, 'Â ', 0),
(8, 2, 'dbuster', 'Dave', 'Buster', 'bf8e3e79e983a200abd392b0c938719c1f3f8bcd', 2, 1, -407444400, 1, '6', '150', '', '', 56, '', 0),
(9, 2, 'robustTest', 'Test', 'Someone', 'd2c1b61fc67389f1ac5ef4b71004d25b845e3758', 1, 1, 28854000, 1, '56', '54', '123 St', ' Main', 47, 'GA', 30000),
(10, 2, 'jsmith11', 'John', 'Smith', '140954f7e347ad2d3a7686ec78ac1616bca93c60', 1, 1, 315529200, 1, '57', '140', '123 St', 'Main', 39, 'GA', 30000),
(11, 1, 'jsmith11', 'John', 'Smith', 'f98fce897ba478da7f7287e34cd129e6bc08cd18', 1, 1, 631148400, 1, '56', '140', '123 St', 'Main', 25, 'GA', 30000),
(12, 2, 'tbrahe', 'Tycho', 'Brahe', '830db0827295e695a0338efab8a5c243f0c42d2a', 4, 1, 315529200, 1, '54', '125', '123 Main st', 'Atlanta', 80, 'Georgia', 30000),
(13, 55512, 'charliebrown', 'Charlie', 'Brown', '44c7ca6f3d6add4769d5d86f0f80962284137378', 1, 1, 12783600, 1, '5555555555', 'cbrown@aol.com', '100 main sy', 'atlanta', 10, 'GA', 30000),
(14, 123, 'bfishco', 'Luna', 'Miguel', '85d8d25c7ee99b55c614080ac926c341a5eb8b68', 5, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '123 Main st', 'marrietta', 49, 'ga', 30000),
(15, 1234, 'tomdurnez', 'Tom', 'Durnez', '4fa796e6908eb8cd3f1402642accbfd0bebffb92', 5, 1, -163558800, 1, '7707777777', 'bfishco@mail.com', '123 Main st', 'marrietta', 49, 'ga', 30000),
(16, 112233, 'joanneandrews', 'Joanne', 'Andrews', '690739b5936c4d1b6e9994c3958ac81d65aa317f', 6, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '123 Main st', 'marrietta', 49, 'ga', 30000),
(17, 0, 'msmith2', 'Mike', 'Smith', '97f4effea8fa5d57c76d4d5eef5c0f288af421ac', 4, 1, 0, 1, '', '', '123 St', 'Main', NULL, 'GA', 30000),
(18, 1142014, 'lwolff', 'Lori', 'Wolff', '9f2d188a274d30a4279c2b50278978016af4cbb7', 5, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000),
(19, 123456, 'ghughes', 'Gail', 'Hughes', '49af70bef39ea48b07cd5fc567aabde107607a1f', 7, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000),
(20, 88888, 'bpillot', 'Beverly', 'Pillot', '34d5a24bf4ff60664dab2ae0ec753a306272862c', 7, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000),
(21, 123456, 'evarisch', 'Eva', 'Risch', 'd09de01445ff5b8ce4483188474c5738b283d450', 7, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000),
(22, 123456789, '123456789', 'Lori', 'Wolff', 'f0d75978886f97ba59720c2959ac1abcec4a4eb7', 8, 1, -163558800, 2, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000),
(23, 123456789, 'Rbonds', 'Randall', 'Bonds', 'a0a10daf1c542f9447020c5938fc1a35afa39329', 9, 1, -163558800, 1, '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', NULL, 'ga', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `physicians`
--

CREATE TABLE IF NOT EXISTS `physicians` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` int(11) NOT NULL,
  `dob` int(10) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `experience` varchar(80) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(59) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sex` (`sex`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `physicians`
--

INSERT INTO `physicians` (`id`, `username`, `firstname`, `lastname`, `password`, `role`, `dob`, `sex`, `experience`, `phone`, `email`, `street`, `city`, `age`, `state`, `zip`) VALUES
(1, 'sdoctor', 'Dr', 'Fishco', '356a192b7913b04c54574d18c28d46e6395428ab', 2, 31446000, 1, '', '', '', '123 Main st', 'Atlanta', 40, 'Georgia', 30000),
(2, 'tdoctor', 'Test', 'doctor', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 2, 943938000, 2, '', NULL, NULL, '&amp;amp;#194;&amp;amp;#160;123 main st.', '&amp;amp;#194;&amp;amp;#160;', 20, '&amp;amp;#194;&amp;amp;#160;', 30000),
(3, 'einstein', 'Albert', 'Einstein', 'af49d4e63950a21e54cf4f91cb824ddddc5ec77a', 2, -1577926800, 1, 'Lots', NULL, NULL, '123 Main st', 'Atlanta', 85, 'Georgia', 30000),
(4, 'newton', 'Isaac', 'Newton', '2a0c492aeecbaafd302b67085aeaaff0d5329807', 2, 315529200, 1, 'Lots', '', '', '123 Main st', 'Atlanta', 100, 'Georgia', 30000),
(5, 'bfishco', 'Bill', 'Fishco', '474ab61145de25c66bd88bfd1b176b1082614640', 2, -315622800, 1, '25', '7707777777', 'bfishco@mail.com', '100 Main St', 'Atlanta', 61, 'Georgia', 30000),
(6, 'johnruch', 'John', 'Ruch', '8f694f676b27b037efb843b127779dba830fe5ef', 2, -163558800, 1, '30', '7707777777', 'bfishco@mail.com', '123 Main st', 'marrietta', 49, 'ga', 30000),
(7, 'goecker', 'Robert', 'Goecker', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, -163558800, 1, '1ddfg', '7707777777', 'bfishco@mail.com', '234', 'Rome', 49, 'ga', 30000),
(8, '123456', 'Raymond', 'Calaliere', '15720b9959e55abb17d0ecf4bf95eac95237ac87', 2, -163558800, 1, 'podiatry', '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', 49, 'ga', 30000),
(9, 'Banks', 'Alan', 'Banks', 'dfc7ba386806cf61fed6cc8130a466b21a3ca235', 2, -163558800, 1, '20', '7707777777', 'bfishco@mail.com', '409 West 10th Street', 'Rome', 49, 'ga', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `post_answers`
--

CREATE TABLE IF NOT EXISTS `post_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `dateofexam` int(10) DEFAULT NULL,
  `painmedused` int(11) NOT NULL,
  `dosepainmedused` int(11) NOT NULL,
  `Q7` int(2) DEFAULT NULL,
  `Q8` int(2) DEFAULT NULL,
  `Q9` int(2) DEFAULT NULL,
  `Q10` int(2) DEFAULT NULL,
  `Q11` int(2) DEFAULT NULL,
  `Q12` int(2) DEFAULT NULL,
  `Q13` int(2) DEFAULT NULL,
  `Q14` int(2) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `post_answers`
--

INSERT INTO `post_answers` (`id`, `dateof`, `pat_id`, `sur_id`, `dateofexam`, `painmedused`, `dosepainmedused`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `type`, `extremity`) VALUES
(2, 1377752400, 1, 1, 1377752400, 11, 11, 2, 3, 5, 5, 5, 5, 5, 5, 2, 2),
(3, 1377752400, 1, 1, 1377752400, 10, 120, 1, 2, 4, 4, 4, 4, 4, 4, 3, 2),
(4, 1377752400, 1, 1, 1377752400, 9, 9, 2, 1, 3, 3, 3, 3, 3, 3, 4, 2),
(5, 1377752400, 1, 1, 1377752400, 7, 7, 1, 2, 1, 1, 1, 1, 1, 1, 5, 2),
(6, 1379048400, 1, 1, 1379048400, 128, 11, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1),
(7, 1379048400, 1, 1, 1379048400, 128, 11, NULL, 3, 5, 5, 5, 4, 4, 3, 3, 1),
(8, 1379048400, 1, 1, 1379048400, 128, 1, 2, 1, NULL, 3, 3, 2, 1, 1, 4, 1),
(9, 1379048400, 1, 1, 1379048400, 1, 1, 2, 2, 4, 4, 4, 3, 4, 4, 5, 1),
(10, 1389675600, 18, 5, 1389675600, 25, 5, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1),
(11, 1390021200, 19, 7, 959662800, 4, 30, 1, 2, 2, 1, 1, 1, 1, 1, 2, 2),
(12, 1390021200, 20, 7, 957243600, 5, 30, 2, 3, 3, 1, 2, 1, 1, 1, 2, 1),
(13, 1392181200, 21, 7, 952923600, 2, 11, 2, 2, 2, 1, 1, 1, 1, 1, 2, 1),
(14, 1392181200, 22, 8, 976597200, 3, 12, 2, NULL, 2, 1, 1, 1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pre_opscore`
--

CREATE TABLE IF NOT EXISTS `pre_opscore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pat_id` int(11) NOT NULL,
  `dateof` int(10) DEFAULT NULL,
  `pfunctioning` double DEFAULT NULL,
  `rphysical` double DEFAULT NULL,
  `bpain` double DEFAULT NULL,
  `ghealth` double DEFAULT NULL,
  `vitality` double DEFAULT NULL,
  `sfunctioning` double DEFAULT NULL,
  `remotional` double DEFAULT NULL,
  `mhealth` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `dateof_2` (`dateof`,`pat_id`),
  KEY `pat_id` (`pat_id`),
  KEY `dateof` (`dateof`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `pre_opscore`
--

INSERT INTO `pre_opscore` (`id`, `pat_id`, `dateof`, `pfunctioning`, `rphysical`, `bpain`, `ghealth`, `vitality`, `sfunctioning`, `remotional`, `mhealth`) VALUES
(23, 2, 1336968000, 0, 0, 100, 60, 50, 50, 0, 40),
(24, 2, 1273809600, 100, 100, 0, -50, 50, -50, 100, 60),
(25, 1, 1352955600, 0, 0, 100, 60, 50, 50, 0, 40),
(27, 7, 1365912000, 0, 0, 100, 60, 50, 50, 0, 40);

-- --------------------------------------------------------

--
-- Table structure for table `ques_demo`
--

CREATE TABLE IF NOT EXISTS `ques_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ques_demo`
--

INSERT INTO `ques_demo` (`id`, `num`, `question`) VALUES
(1, 1, 'What race do you consider yourself?'),
(2, 2, 'What ethnicity do you consider yourself?'),
(3, 3, 'What is your highest level of education?'),
(4, 4, 'What is your job now? (If you are not working now, please tell us about your last job.)'),
(5, 5, 'What is your family/household income, from all sources last year before taxes?'),
(6, 6, 'If you were asked to use one of four names for your social class, which would you say you belong in?');

-- --------------------------------------------------------

--
-- Table structure for table `ques_eval`
--

CREATE TABLE IF NOT EXISTS `ques_eval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `mult` int(11) NOT NULL,
  `question` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ques_eval_prim` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `ques_eval`
--

INSERT INTO `ques_eval` (`id`, `num`, `mult`, `question`) VALUES
(1, 4, 0, 'Date of exam'),
(2, 10, 0, 'Chief bunion complaint'),
(3, 11, 0, '2nd bunion complaint'),
(4, 12, 0, 'Sub two pain'),
(5, 13, 0, '2nd IPK'),
(6, 14, 0, 'Hammertoe 2nd'),
(7, 15, 0, 'Duration of symptoms'),
(8, 16, 0, 'Current tobacco use'),
(9, 17, 1, 'Illnesses'),
(10, 18, 1, 'Medications'),
(11, 19, 0, 'Maximum dorsiflexion to metatarsal'),
(12, 20, 0, 'Maximum plantarflexion to metatarsal'),
(13, 21, 0, 'Previous treatment'),
(14, 22, 0, 'Prior HAV surgery same foot'),
(15, 23, 0, 'Prior HAV surgery opposite foot'),
(16, 24, 1, 'Family history bunions '),
(17, 25, 0, 'Work '),
(18, 26, 0, 'Exercise '),
(19, 27, 1, 'Type of exercise');

-- --------------------------------------------------------

--
-- Table structure for table `ques_foot`
--

CREATE TABLE IF NOT EXISTS `ques_foot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ques_foot`
--

INSERT INTO `ques_foot` (`id`, `num`, `question`) VALUES
(1, 4, 'What level of pain have you had <b><u>during the past week</u></b>'),
(2, 6, 'How often have you had foot pain?'),
(3, 7, 'How often did you feet ache?'),
(4, 8, 'How often did you get sharp pains in your feet?'),
(5, 10, 'Have your <u>feet</u> caused you to have difficlulties in your work or activities?'),
(6, 11, 'Were you limited in the kind of work you could do because of your feet?'),
(7, 13, 'How much does your <u>foot health</u> limit you walking?'),
(8, 14, 'How much does your foot <u>health limit</u> you climbing stairs?'),
(9, 15, 'How would you rate your overall <u>foot health</u>?'),
(10, 17, 'It is hard to find shoes that do not hurt my feet.'),
(11, 18, 'I have difficulty in find shoes that fit my feet.'),
(12, 19, 'I am limited in the number of shoes I can wear.'),
(13, 20, 'In general, what condition would you say your feet are in?');

-- --------------------------------------------------------

--
-- Table structure for table `ques_mcgillpain`
--

CREATE TABLE IF NOT EXISTS `ques_mcgillpain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ques_mcgillpain`
--

INSERT INTO `ques_mcgillpain` (`id`, `num`, `question`) VALUES
(1, 5, 'Activity restrictions'),
(2, 6, 'Work restrictions'),
(3, 7, 'shoe restrictions'),
(4, 8, 'Motion of big toe joint'),
(5, 9, 'Alignment & Appearance of big toe'),
(6, 10, 'Frequency of pain'),
(7, 11, 'Painful callus'),
(8, 12, 'Swelling in big toe'),
(9, 13, 'Throbbing'),
(10, 14, 'Shooting'),
(11, 15, 'Stabbing'),
(12, 16, 'Sharp'),
(13, 17, 'Cramping'),
(14, 18, 'Gnawing'),
(15, 19, 'Hot-burning'),
(16, 20, 'Aching'),
(17, 21, 'Heavy'),
(18, 22, 'Tender'),
(19, 23, 'Splinting'),
(20, 24, 'Tiring-Exhausting'),
(21, 25, 'Sickening'),
(22, 26, 'Fearful'),
(23, 27, 'Punishing-Cruel'),
(24, 28, 'Present pain intensity'),
(25, 29, 'Mark on the following line your level of pain');

-- --------------------------------------------------------

--
-- Table structure for table `ques_post`
--

CREATE TABLE IF NOT EXISTS `ques_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ques_post`
--

INSERT INTO `ques_post` (`id`, `num`, `question`) VALUES
(1, 4, 'Date of exam'),
(2, 5, 'Number of days pain medication used'),
(3, 6, 'Total number of doses pain medication used'),
(4, 7, 'P.O.NSAIDS''s'),
(5, 8, 'Weightbearing status following surgery'),
(6, 9, 'Edema'),
(7, 10, 'Erythema'),
(8, 11, 'Ecchymosis'),
(9, 12, 'Bleeding'),
(10, 13, 'Dehiscence'),
(11, 14, 'Infection');

-- --------------------------------------------------------

--
-- Table structure for table `ques_sf36`
--

CREATE TABLE IF NOT EXISTS `ques_sf36` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `ques_sf36`
--

INSERT INTO `ques_sf36` (`id`, `num`, `question`) VALUES
(1, 4, 'In general, would you say your health is'),
(2, 5, 'Compared to one year ago, how would you rate your health in general'),
(3, 7, '<b>Vigorous activities</b>, such as running, lifting heavy objects, participating in strenuous sports'),
(4, 8, '<b>Moderate activities</b>, such as moving a table, pushing a vacuum cleaner, bowling or playing golf'),
(5, 9, 'Lifing or carrying groceries'),
(6, 10, 'Climbing <b>several</b> flights of stairs'),
(7, 11, 'Climbing <b>one</b> flight of stairs'),
(8, 12, 'Bending, kneeling, or stooping'),
(9, 13, 'Walking <b>more than a mile</b>'),
(10, 14, 'Walking <b>several blocks</b>'),
(11, 15, 'Walking <b>one block</b>'),
(12, 16, 'Bathing or dressing yourself'),
(13, 18, 'Cut down on the <b>amount of time</b> you spent on work or other activities'),
(14, 19, '<b>Accomplished less</b> than you would like'),
(15, 20, 'Were limited in the <b>kind</b> of work or other activities'),
(16, 21, 'Had <b>difficulty</b> performing the work or other activities (for example, it took extra effort)'),
(17, 23, 'Cut down on the <b>amount of time</b> you spent on work or other activities'),
(18, 24, '<b>Acomplished less</b> than you would like'),
(19, 25, 'Didn''t do work or other activities as carefully as usual'),
(20, 26, '<b>During the <u>past 4 weeks</u>, to what extent has your physical health or emotional problems interfered with your normal social activities with family, friends, neighbors, or groups?</b>'),
(21, 27, '<b>How much <u>bodily</u> pain have you had during <u>the past 4 weeks</u></b>'),
(22, 28, '<b>During the <u>past 4 weeks</u>, how much did pain interfere with your normal work (including both work outside the home and housework)?</b>'),
(23, 31, 'Did you feel full of pep?'),
(24, 32, 'Have you been a very nervous person?'),
(25, 33, 'Have you felt so down in the dumps <br />that nothing could cheer you up?'),
(26, 34, 'Have you felt calm and peaceful?'),
(27, 35, 'Did you have a lot of energy?'),
(28, 36, 'Have you felt downhearted and blue?'),
(29, 37, 'Did you feel worn out?'),
(30, 38, 'Have you been a happy person?'),
(31, 39, 'Did you feel tired?'),
(32, 40, '<b>DURING THE <u>PAST 4 WEEKS</u>, HOW MUCH OF THE TIME HAS YOUR PHYSICAL HEALTH OR EMOTIONAL PROBLEMS INTERFERED WITH YOUR SOCIAL ACTIVITIES (LIKE VISITING FRIENDS, RELATIVES, ETC.)?'),
(33, 42, 'I seem to get sick a little easier than other people'),
(34, 43, 'I am as healthy as anybody I know'),
(35, 44, 'I expect my health to get worse'),
(36, 45, 'My health is excellent');

-- --------------------------------------------------------

--
-- Table structure for table `ques_surgical`
--

CREATE TABLE IF NOT EXISTS `ques_surgical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `ques_surgical`
--

INSERT INTO `ques_surgical` (`id`, `num`, `question`) VALUES
(1, 4, 'Date of surgery'),
(2, 5, 'PROCEDURE (select all appropriate)'),
(3, 6, 'Adductor tendon release'),
(4, 7, 'Fib. ses. ligament'),
(5, 8, 'Tenotomy FHB (lateral)'),
(6, 9, 'Lateral capsule release'),
(7, 10, 'Excise fibular. sesamoid'),
(8, 11, 'Adductor tendon transfer'),
(9, 12, 'Medial capsulorraphy'),
(10, 13, 'Subchondral drilling'),
(11, 14, 'EHB tenotomy'),
(12, 15, 'EHL lengthening'),
(13, 16, 'Condition of cartilage'),
(14, 17, 'Fixation'),
(15, 18, 'Points of fixation'),
(16, 19, 'Adjunct procedure'),
(17, 20, 'Tourniquet'),
(18, 21, 'Epinephrine'),
(19, 22, 'Anethesia'),
(20, 23, 'Pre-op antibiotics'),
(21, 24, 'Post-op antibiotics'),
(22, 25, 'Post-op local anesthetic (select all used)'),
(23, 26, 'Post op injection (select all used)');

-- --------------------------------------------------------

--
-- Table structure for table `ques_xrays`
--

CREATE TABLE IF NOT EXISTS `ques_xrays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `ques_xrays`
--

INSERT INTO `ques_xrays` (`id`, `num`, `question`) VALUES
(1, 4, 'Date of Xrays'),
(2, 5, 'Intermetatarsal angle'),
(3, 6, 'Tibial sesamoid position'),
(4, 7, 'Hallux abdutux angle'),
(5, 8, 'Hallux interphalangeus angle'),
(6, 9, '1st metatarsal protrusion'),
(7, 10, 'Tibial sesamoid second metatarsal distance'),
(8, 11, 'PASA'),
(9, 12, 'Metatarsus adductus'),
(10, 13, 'Kites angle'),
(11, 14, 'DASA'),
(12, 15, 'TASA'),
(13, 16, 'Relative IM Angle'),
(14, 17, 'True IM angle'),
(15, 18, 'Engle''s angle'),
(16, 19, 'Metatarsal break angle'),
(17, 20, 'Joint position'),
(18, 21, 'Relative tibial ses.position'),
(19, 22, 'Met. deformaition angle'),
(20, 23, 'Met. Cuneinform angle'),
(21, 24, 'Metartasus varus angle'),
(22, 25, '1st met cun/2nd axis'),
(23, 26, 'Met head split dist'),
(24, 27, 'Met base split dist'),
(25, 28, 'Forefoot width'),
(26, 29, 'Cortical angle'),
(27, 30, 'First met decl angle'),
(28, 31, 'lateral talocalc angle'),
(29, 32, 'Calc inclinatioin angle'),
(30, 33, 'Seiberg index'),
(31, 34, 'Talar decl angle'),
(32, 35, 'Lat talo 1st met angle'),
(33, 36, 'Fowler Philip angle'),
(34, 37, 'Total angle'),
(35, 38, 'Parallel pitch lines');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Patient'),
(2, 'Doctor'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `sf36_answers`
--

CREATE TABLE IF NOT EXISTS `sf36_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `patientid` int(11) NOT NULL,
  `Q4` int(2) NOT NULL,
  `Q5` int(2) NOT NULL,
  `Q7` int(2) NOT NULL,
  `Q8` int(2) NOT NULL,
  `Q9` int(2) NOT NULL,
  `Q10` int(2) NOT NULL,
  `Q11` int(2) NOT NULL,
  `Q12` int(2) NOT NULL,
  `Q13` int(2) NOT NULL,
  `Q14` int(2) NOT NULL,
  `Q15` int(2) NOT NULL,
  `Q16` int(2) NOT NULL,
  `Q18` int(2) NOT NULL,
  `Q19` int(2) NOT NULL,
  `Q20` int(2) NOT NULL,
  `Q21` int(2) NOT NULL,
  `Q23` int(2) NOT NULL,
  `Q24` int(2) NOT NULL,
  `Q25` int(2) NOT NULL,
  `Q26` int(2) NOT NULL,
  `Q27` int(2) NOT NULL,
  `Q28` int(2) NOT NULL,
  `Q31` int(2) NOT NULL,
  `Q32` int(2) NOT NULL,
  `Q33` int(2) NOT NULL,
  `Q34` int(2) NOT NULL,
  `Q35` int(2) NOT NULL,
  `Q36` int(2) NOT NULL,
  `Q37` int(2) NOT NULL,
  `Q38` int(2) NOT NULL,
  `Q39` int(2) NOT NULL,
  `Q40` int(2) NOT NULL,
  `Q42` int(2) NOT NULL,
  `Q43` int(2) NOT NULL,
  `Q44` int(2) NOT NULL,
  `Q45` int(2) NOT NULL,
  `type` int(1) DEFAULT '0',
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `sf36_answers`
--

INSERT INTO `sf36_answers` (`id`, `dateof`, `patientid`, `Q4`, `Q5`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `Q15`, `Q16`, `Q18`, `Q19`, `Q20`, `Q21`, `Q23`, `Q24`, `Q25`, `Q26`, `Q27`, `Q28`, `Q31`, `Q32`, `Q33`, `Q34`, `Q35`, `Q36`, `Q37`, `Q38`, `Q39`, `Q40`, `Q42`, `Q43`, `Q44`, `Q45`, `type`, `extremity`) VALUES
(6, 1377752400, 1, 5, 5, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 5, 6, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 5, 5, 5, 5, 5, 1, 2),
(7, 1377752400, 1, 4, 4, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 2, 1, 1, 2, 2, 1, 2, 4, 5, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 4, 4, 4, 4, 4, 3, 2),
(8, 1377752400, 1, 3, 0, 1, 1, 1, 1, 1, 1, 1, 1, 3, 3, 1, 1, 2, 2, 1, 1, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 3, 3, 3, 3, 3, 4, 2),
(9, 1377752400, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 2),
(11, 1379048400, 1, 5, 5, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 5, 6, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 5, 5, 5, 5, 5, 1, 1),
(12, 1379048400, 1, 4, 0, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 5, 6, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 5, 5, 5, 5, 5, 5, 1),
(13, 1379048400, 1, 5, 5, 3, 3, 3, 3, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 5, 6, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 5, 5, 5, 5, 5, 3, 1),
(14, 1379048400, 1, 4, 4, 1, 1, 3, 3, 3, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 5, 5, 5, 4, 4, 4, 4, 4, 4, 4, 4, 4, 3, 3, 3, 3, 3, 4, 1),
(15, 977806800, 16, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 1, 2, 1, 2, 6, 6, 2, 2, 6, 6, 3, 5, 5, 4, 3, 5, 2, 1, 2),
(16, 985582800, 16, 2, 3, 1, 1, 1, 1, 2, 2, 1, 2, 2, 3, 2, 2, 1, 1, 2, 2, 2, 1, 2, 1, 2, 6, 6, 2, 2, 6, 5, 2, 5, 5, 5, 2, 5, 2, 3, 2),
(17, 975992400, 18, 4, 4, 2, 3, 3, 1, 2, 3, 1, 1, 2, 3, 1, 1, 1, 1, 2, 2, 2, 3, 4, 2, 5, 6, 6, 2, 5, 6, 2, 4, 2, 3, 1, 3, 2, 4, 1, 1),
(18, 959058000, 19, 3, 3, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 1, 3, 2, 3, 4, 6, 3, 3, 5, 5, 2, 4, 5, 5, 2, 4, 2, 1, 2),
(19, 953010000, 21, 2, 3, 1, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 1, 0, 2, 2, 5, 5, 2, 2, 5, 5, 2, 5, 4, 5, 2, 4, 2, 1, 1),
(20, 960526800, 21, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2, 2, 2, 2, 2, 2, 1, 2, 1, 2, 5, 6, 1, 2, 5, 6, 1, 5, 5, 5, 2, 5, 2, 3, 1),
(21, 975992400, 22, 4, 4, 2, 3, 3, 1, 2, 3, 1, 1, 2, 3, 1, 1, 1, 1, 2, 2, 2, 3, 4, 2, 5, 6, 6, 2, 5, 6, 2, 4, 2, 3, 1, 3, 2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `surgical_answers`
--

CREATE TABLE IF NOT EXISTS `surgical_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofsurgery` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `Q5` varchar(48) DEFAULT NULL,
  `Q6` int(2) DEFAULT NULL,
  `Q7` int(2) DEFAULT NULL,
  `Q8` int(2) DEFAULT NULL,
  `Q9` int(2) DEFAULT NULL,
  `Q10` int(2) DEFAULT NULL,
  `Q11` int(2) DEFAULT NULL,
  `Q12` int(2) DEFAULT NULL,
  `Q13` int(2) DEFAULT NULL,
  `Q14` int(2) DEFAULT NULL,
  `Q15` int(2) DEFAULT NULL,
  `Q16` int(2) DEFAULT NULL,
  `Q17` int(2) DEFAULT NULL,
  `Q18` int(2) DEFAULT NULL,
  `Q19` int(2) DEFAULT NULL,
  `Q20` int(2) DEFAULT NULL,
  `Q21` int(2) DEFAULT NULL,
  `Q22` int(2) DEFAULT NULL,
  `Q23` int(2) DEFAULT NULL,
  `Q24` int(2) DEFAULT NULL,
  `Q25` int(2) DEFAULT NULL,
  `Q26` int(2) DEFAULT NULL,
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `surgical_answers`
--

INSERT INTO `surgical_answers` (`id`, `dateof`, `dateofsurgery`, `pat_id`, `sur_id`, `Q5`, `Q6`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `Q15`, `Q16`, `Q17`, `Q18`, `Q19`, `Q20`, `Q21`, `Q22`, `Q23`, `Q24`, `Q25`, `Q26`, `extremity`) VALUES
(2, 1377752400, 1377752400, 1, 1, '3', 2, 1, 1, 1, 1, 2, 2, 2, 1, 1, 2, 2, 1, 1, 2, 2, 1, 2, 1, 3, 2, 2),
(3, 1379048400, 1379048400, 1, 1, '1', 2, 2, 2, 2, 2, NULL, 2, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1),
(4, 1383886800, 975474000, 14, 5, '4|6|16', 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 3, 2, 1, 2, 1, 2, 2, 2, 1, 1, 2),
(5, 1384059600, 977806800, 16, 6, '2', 1, 1, 1, 2, 2, 1, 1, 2, 2, 2, 2, 2, NULL, 2, 2, 1, 2, 2, 2, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vals_demo`
--

CREATE TABLE IF NOT EXISTS `vals_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `vals_demo`
--

INSERT INTO `vals_demo` (`id`, `val`, `ques_num`) VALUES
(1, 'White', 1),
(2, 'Black', 1),
(3, 'Asian/Pacific Islander', 1),
(4, 'Other', 1),
(5, 'European - American (Hispanic)', 2),
(6, 'African American', 2),
(7, 'European - American (not Hispanic)', 2),
(8, 'Asian American', 2),
(9, 'Other', 2),
(10, 'Less than high school', 3),
(11, 'Associate degree', 3),
(12, 'High school graduate', 3),
(13, 'Bachelor''s degree', 3),
(14, 'Some college', 3),
(15, 'Graduate or professional degree', 3),
(16, 'Professional and technical (e.g., doctor, teacher engineer, artist, accountant)', 4),
(17, 'Administrator or manager (e.g., banker, executive, high government official)', 4),
(18, 'Clerical (e.g., clear, office manager, secretary, bookkeeper)', 4),
(19, 'Sales (e.g., sales manager, shop owner or asssistant, buyer, insurance agent)', 4),
(20, 'Service (e.g., restaurant owner, policeman, barber, janitor)', 4),
(21, 'Skilled worker (e.g., foreman, motor mechanic, printer, seamstress, electrician)', 4),
(22, 'Less skilled (e.g., laborer, porter, unskilled factory worker)', 4),
(23, 'Farm (e.g., farmer, farm laborer, tractor driver)', 4),
(24, 'Never had a job', 4),
(25, 'Under $10,1000', 5),
(26, '$10,000 to $19,000', 5),
(27, '$20,000 to $29,999', 5),
(28, '$30,000 to $39,999', 5),
(29, '$40,000 to $40,999', 5),
(30, '$50,000 to $74,999', 5),
(31, '$75,000 to $99,999', 5),
(32, 'Over $100,000', 5),
(33, 'Lower class', 6),
(34, 'Upper class', 6),
(35, 'Working class', 6),
(36, 'Middle class', 6);

-- --------------------------------------------------------

--
-- Table structure for table `vals_eval`
--

CREATE TABLE IF NOT EXISTS `vals_eval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `vals_eval`
--

INSERT INTO `vals_eval` (`id`, `val`, `ques_num`) VALUES
(1, 'Bump pain', 10),
(2, 'Joint pain', 10),
(3, 'Limitus', 10),
(4, 'Neurtic', 10),
(5, 'Other', 10),
(6, 'Bump pain', 11),
(7, 'Joint pain', 11),
(8, 'Limitus', 11),
(9, 'Neurtic', 11),
(10, 'Other', 11),
(11, 'Y', 12),
(12, 'N', 12),
(13, 'Y', 13),
(14, 'N', 13),
(15, 'Y', 14),
(16, 'N', 14),
(17, 'Y', 16),
(18, 'N', 16),
(19, 'Diabetes', 17),
(20, 'PVD', 17),
(21, 'Rheumatoid', 17),
(22, 'Osteoarthritis', 17),
(23, 'Osteoporosis', 17),
(24, 'Depression', 17),
(25, 'Anxiety', 17),
(26, 'Heart Dx.', 17),
(27, 'Back pain', 17),
(28, 'Knee pain', 17),
(29, 'Other', 17),
(30, 'Hormone replacement', 17),
(31, 'Steroids', 18),
(32, 'ASA', 18),
(33, 'NSAID''s', 18),
(34, 'COX2', 18),
(35, 'Antibiotics', 18),
(36, 'Other', 18),
(37, 'None', 21),
(38, 'NSAID''s', 21),
(39, 'Orthotics', 21),
(40, 'Injection', 21),
(41, 'PT', 21),
(42, 'Shoe modification', 21),
(43, 'Y', 22),
(44, 'N', 22),
(45, 'Y', 23),
(46, 'N', 23),
(47, 'None', 24),
(48, 'Father', 24),
(49, 'Mother', 24),
(50, 'Siblings', 24),
(51, 'Children', 24),
(52, 'Grandparents', 24),
(53, 'None', 25),
(54, 'Desk/Sitting', 25),
(55, 'Light duty', 25),
(56, 'Standing', 25),
(57, 'Walking', 25),
(58, 'Heavy duty', 25),
(59, 'None', 26),
(60, 'Occasional', 26),
(61, 'Regular (>= 3x / week)', 26),
(62, 'None', 27),
(63, 'Walking', 27),
(64, 'Running', 27),
(65, 'Aerobics', 27),
(66, 'Swim', 27),
(67, 'Game sports', 27);

-- --------------------------------------------------------

--
-- Table structure for table `vals_foot`
--

CREATE TABLE IF NOT EXISTS `vals_foot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `vals_foot`
--

INSERT INTO `vals_foot` (`id`, `val`, `ques_num`) VALUES
(1, 'None', 4),
(2, 'Very Mild', 4),
(3, 'Mild', 4),
(4, 'Moderate', 4),
(5, 'Severe', 4),
(6, 'Never', 6),
(7, 'Occasionally', 6),
(8, 'Fairly Many Times', 6),
(9, 'Very Often', 6),
(10, 'Always', 6),
(11, 'Never', 7),
(12, 'Occasionally', 7),
(13, 'Fairly Many Times', 7),
(14, 'Very Often', 7),
(15, 'Always', 7),
(16, 'Never', 8),
(17, 'Occasionally', 8),
(18, 'Fairly Many Times', 8),
(19, 'Very Often', 8),
(20, 'Always', 8),
(21, 'Not at All', 10),
(22, 'Slightly', 10),
(23, 'Moderately', 10),
(24, 'Quite a Bit', 10),
(25, 'Extremely', 10),
(26, 'Not at All', 11),
(27, 'Slightly', 11),
(28, 'Moderately', 11),
(29, 'Quite a Bit', 11),
(30, 'Extremely', 11),
(31, 'Not at All', 13),
(32, 'Slightly', 13),
(33, 'Moderately', 13),
(34, 'Quite a Bit', 13),
(35, 'Extremely', 13),
(36, 'Not at All', 14),
(37, 'Slightly', 14),
(38, 'Moderately', 14),
(39, 'Quite a Bit', 14),
(40, 'Extremely', 14),
(41, 'Excellent', 15),
(42, 'Very Good', 15),
(43, 'Good', 15),
(44, 'Fair', 15),
(45, 'Poor', 15),
(46, 'Strongly Agree', 17),
(47, 'Agree', 17),
(48, 'Neither agree or Disagree', 17),
(49, 'Disagree', 17),
(50, 'Strongly Disagree', 17),
(51, 'Strongly Agree', 18),
(52, 'Agree', 18),
(53, 'Neither agree or Disagree', 18),
(54, 'Disagree', 18),
(55, 'Strongly Disagree', 18),
(56, 'Strongly Agree', 19),
(57, 'Agree', 19),
(58, 'Neither agree or Disagree', 19),
(59, 'Disagree', 19),
(60, 'Strongly Disagree', 19),
(61, 'Excellent', 20),
(62, 'Very Good', 20),
(63, 'Good', 20),
(64, 'Fair', 20),
(65, 'Poor', 20);

-- --------------------------------------------------------

--
-- Table structure for table `vals_mcgillpain`
--

CREATE TABLE IF NOT EXISTS `vals_mcgillpain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `vals_mcgillpain`
--

INSERT INTO `vals_mcgillpain` (`id`, `val`, `ques_num`) VALUES
(1, 'None', 5),
(2, 'Limits exercise', 5),
(3, 'Limits activity after 4 hours', 5),
(4, 'Limits activity all the time', 5),
(5, 'None', 6),
(6, 'Reduced performance', 6),
(7, 'Limits duties', 6),
(8, 'Changed jobs due to foot pain', 6),
(9, 'None', 7),
(10, 'Restricted to sneakers/wide shoes', 7),
(11, 'Very limited in shoes', 7),
(12, 'Sandals/surgical shoe only', 7),
(13, 'Satisfied', 8),
(14, 'Limited motion without pain', 8),
(15, 'Pain with restricted motion', 8),
(16, 'Good, pleased', 9),
(17, 'Fair', 9),
(18, 'Poor, unhappy', 9),
(19, 'No pain', 10),
(20, 'Mild on occasion', 10),
(21, 'Moderate daily', 10),
(22, 'Severe daily', 10),
(23, 'Y', 11),
(24, 'N', 11),
(25, 'None', 12),
(26, 'Slight', 12),
(27, 'Constant', 12),
(28, 'None', 13),
(29, 'Mild', 13),
(30, 'Moderate', 13),
(31, 'Severe', 13),
(32, 'None', 14),
(33, 'Mild', 14),
(34, 'Moderate', 14),
(35, 'Severe', 14),
(36, 'None', 15),
(37, 'Mild', 15),
(38, 'Moderate', 15),
(39, 'Severe', 15),
(40, 'None', 16),
(41, 'Mild', 16),
(42, 'Moderate', 16),
(43, 'Severe', 16),
(44, 'None', 17),
(45, 'Mild', 17),
(46, 'Moderate', 17),
(47, 'Severe', 17),
(48, 'None', 18),
(49, 'Mild', 18),
(50, 'Moderate', 18),
(51, 'Severe', 18),
(52, 'None', 19),
(53, 'Mild', 19),
(54, 'Moderate', 19),
(55, 'Severe', 19),
(56, 'None', 20),
(57, 'Mild', 20),
(58, 'Moderate', 20),
(59, 'Severe', 20),
(60, 'None', 21),
(61, 'Mild', 21),
(62, 'Moderate', 21),
(63, 'Severe', 21),
(64, 'None', 22),
(65, 'Mild', 22),
(66, 'Moderate', 22),
(67, 'Severe', 22),
(68, 'None', 23),
(69, 'Mild', 23),
(70, 'Moderate', 23),
(71, 'Severe', 23),
(72, 'None', 24),
(73, 'Mild', 24),
(74, 'Moderate', 24),
(75, 'Severe', 24),
(76, 'None', 25),
(77, 'Mild', 25),
(78, 'Moderate', 25),
(79, 'Severe', 25),
(80, 'None', 26),
(81, 'Mild', 26),
(82, 'Moderate', 26),
(83, 'Severe', 26),
(84, 'None', 27),
(85, 'Mild', 27),
(86, 'Moderate', 27),
(87, 'Severe', 27),
(88, 'No Pain', 28),
(89, 'Mild', 28),
(90, 'Discomforting', 28),
(91, 'Distressing', 28),
(92, 'Horrible', 28),
(93, 'Excruciating', 28),
(94, '1', 29),
(95, '2', 29),
(96, '3', 29),
(97, '4', 29),
(98, '5', 29),
(99, '6', 29),
(100, '7', 29),
(101, '8', 29),
(102, '9', 29),
(103, '10', 29);

-- --------------------------------------------------------

--
-- Table structure for table `vals_post`
--

CREATE TABLE IF NOT EXISTS `vals_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `vals_post`
--

INSERT INTO `vals_post` (`id`, `val`, `ques_num`) VALUES
(1, 'Y', 7),
(2, 'N', 7),
(3, 'NWB', 8),
(4, 'FWB', 8),
(5, 'PWB', 8),
(6, 'None', 9),
(7, 'Periwound', 9),
(8, 'Dorso-Medial', 9),
(9, 'Entire Dorsum', 9),
(10, 'Circumferential', 9),
(11, 'None', 10),
(12, 'Periwound', 10),
(13, 'Dorso-Medial', 10),
(14, 'Entire Dorsum', 10),
(15, 'Circumferential', 10),
(16, 'None', 11),
(17, 'Periwound', 11),
(18, 'Dorso-Medial', 11),
(19, 'Entire Dorsum', 11),
(20, 'Circumferential', 11),
(21, 'None', 12),
(22, 'Seeping part of incision', 12),
(23, 'Seeping whole incision', 12),
(24, 'Hematoma', 12),
(25, 'Active bleeding', 12),
(26, 'None', 13),
(27, '< half incision', 13),
(28, '> half incision', 13),
(29, 'Whole incision', 13),
(30, 'Necrosis', 13),
(31, 'None', 14),
(32, 'Suture abscess', 14),
(33, 'Local cellulitis', 14),
(34, 'Abscess', 14),
(35, 'Osteomyelitis', 14);

-- --------------------------------------------------------

--
-- Table structure for table `vals_sf36`
--

CREATE TABLE IF NOT EXISTS `vals_sf36` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `pre_val` int(11) NOT NULL,
  `fin_val` double NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

--
-- Dumping data for table `vals_sf36`
--

INSERT INTO `vals_sf36` (`id`, `val`, `pre_val`, `fin_val`, `ques_num`) VALUES
(1, 'Excellent', 1, 0, 4),
(2, 'Very Good', 2, 0, 4),
(3, 'Good', 3, 0, 4),
(4, 'Fair', 4, 0, 4),
(6, 'Poor', 5, 0, 4),
(7, 'Much better now', 1, 0, 5),
(8, 'Somewhat better', 2, 0, 5),
(9, 'About the same', 3, 0, 5),
(10, 'Somewhat worse', 4, 0, 5),
(11, 'Much worse', 5, 0, 5),
(13, '', 2, 2, 7),
(14, '', 1, 1, 7),
(15, '', 2, 2, 8),
(17, '', 2, 2, 9),
(19, '', 2, 2, 10),
(21, '', 2, 2, 11),
(23, '', 2, 2, 12),
(25, '', 2, 2, 13),
(27, '', 2, 2, 14),
(28, '', 3, 3, 7),
(29, '', 2, 2, 15),
(32, '', 1, 1, 8),
(33, '', 3, 3, 8),
(34, '', 1, 1, 9),
(35, '', 3, 3, 9),
(36, '', 1, 1, 10),
(37, '', 3, 3, 10),
(38, '', 1, 1, 11),
(39, '', 3, 3, 11),
(40, '', 1, 1, 12),
(41, '', 3, 3, 12),
(42, '', 1, 1, 13),
(43, '', 3, 3, 13),
(44, '', 1, 1, 14),
(45, '', 3, 3, 14),
(46, '', 1, 1, 15),
(47, '', 3, 3, 15),
(48, '', 1, 1, 16),
(49, '', 3, 3, 16),
(50, '', 2, 2, 16),
(51, '', 1, 0, 18),
(52, '', 2, 0, 18),
(53, '', 1, 0, 19),
(54, '', 2, 0, 19),
(55, '', 1, 0, 20),
(56, '', 2, 0, 20),
(57, '', 1, 0, 21),
(58, '', 2, 0, 21),
(59, '', 1, 0, 23),
(60, '', 2, 0, 23),
(61, '', 1, 0, 24),
(62, '', 2, 0, 24),
(63, '', 1, 0, 25),
(64, '', 2, 0, 25),
(65, 'Not at all', 1, 0, 26),
(66, 'Slightly', 2, 0, 26),
(67, 'Moderately', 3, 0, 26),
(68, 'Quite a bit', 4, 0, 26),
(69, 'Extremely', 5, 0, 26),
(70, 'Mild', 3, 0, 27),
(71, 'None', 1, 0, 27),
(72, 'Very mild', 2, 0, 27),
(73, 'Moderate', 4, 0, 27),
(74, 'Severe', 5, 0, 27),
(75, 'Moderately', 3, 0, 28),
(76, 'Not al all', 1, 0, 28),
(77, 'A little bit', 2, 0, 28),
(78, 'Quite a bit', 4, 0, 28),
(79, 'Extremely', 5, 0, 28),
(80, 'Very severe', 6, 0, 27),
(85, '', 1, 0, 31),
(86, '', 2, 0, 31),
(87, '', 3, 0, 31),
(88, '', 4, 0, 31),
(89, '', 5, 0, 31),
(90, '', 1, 0, 32),
(91, '', 2, 0, 32),
(92, '', 3, 0, 32),
(93, '', 4, 0, 32),
(94, '', 5, 0, 32),
(95, '', 1, 0, 33),
(96, '', 2, 0, 33),
(97, '', 3, 0, 33),
(98, '', 4, 0, 33),
(99, '', 5, 0, 33),
(100, '', 1, 0, 34),
(101, '', 2, 0, 34),
(102, '', 3, 0, 34),
(103, '', 4, 0, 34),
(104, '', 5, 0, 34),
(105, '', 1, 0, 35),
(106, '', 2, 0, 35),
(107, '', 3, 0, 35),
(108, '', 4, 0, 35),
(109, '', 5, 0, 35),
(110, '', 1, 0, 36),
(111, '', 2, 0, 36),
(112, '', 3, 0, 36),
(113, '', 4, 0, 36),
(114, '', 5, 0, 36),
(115, '', 1, 0, 37),
(116, '', 2, 0, 37),
(117, '', 3, 0, 37),
(118, '', 4, 0, 37),
(119, '', 5, 0, 37),
(120, '', 1, 0, 38),
(121, '', 2, 0, 38),
(122, '', 3, 0, 38),
(123, '', 4, 0, 38),
(124, '', 5, 0, 38),
(125, '', 1, 0, 39),
(126, '', 2, 0, 39),
(127, '', 3, 0, 39),
(128, '', 4, 0, 39),
(129, '', 5, 0, 39),
(130, '', 6, 0, 39),
(131, '', 6, 0, 38),
(132, '', 6, 0, 37),
(133, '', 6, 0, 36),
(134, '', 6, 0, 35),
(135, '', 6, 0, 31),
(136, '', 6, 0, 32),
(137, '', 6, 0, 33),
(138, '', 6, 0, 34),
(145, '', 1, 0, 40),
(146, '', 2, 0, 40),
(147, '', 3, 0, 40),
(148, '', 4, 0, 40),
(149, '', 5, 0, 40),
(150, '', 1, 0, 42),
(151, '', 2, 0, 42),
(152, '', 3, 0, 42),
(153, '', 4, 0, 42),
(154, '', 5, 0, 42),
(155, '', 1, 0, 43),
(156, '', 2, 0, 43),
(157, '', 3, 0, 43),
(158, '', 4, 0, 43),
(159, '', 5, 0, 43),
(160, '', 1, 0, 44),
(161, '', 2, 0, 44),
(162, '', 3, 0, 44),
(163, '', 4, 0, 44),
(164, '', 5, 0, 44),
(165, '', 1, 0, 45),
(166, '', 2, 0, 45),
(167, '', 3, 0, 45),
(168, '', 4, 0, 45),
(169, '', 5, 0, 45);

-- --------------------------------------------------------

--
-- Table structure for table `vals_surgical`
--

CREATE TABLE IF NOT EXISTS `vals_surgical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(200) NOT NULL,
  `ques_num` int(11) NOT NULL,
  PRIMARY KEY (`id`,`ques_num`),
  UNIQUE KEY `id` (`id`),
  KEY `ques_num` (`ques_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `vals_surgical`
--

INSERT INTO `vals_surgical` (`id`, `val`, `ques_num`) VALUES
(1, 'Silver', 5),
(2, 'Austin', 5),
(3, 'Scarf', 5),
(4, 'Base Wedge', 5),
(5, 'Keller', 5),
(6, 'McBride', 5),
(7, 'Kalish', 5),
(8, 'Mau', 5),
(9, 'Lapidus', 5),
(10, 'Implant', 5),
(11, 'Akin', 5),
(12, 'Sagittal Z', 5),
(13, 'Crescentic', 5),
(14, 'Arthrodesis', 5),
(15, 'Reverdin-Green-Laird', 5),
(16, 'Other', 5),
(17, 'Y', 6),
(18, 'N', 6),
(19, 'Y', 7),
(20, 'N', 7),
(21, 'Y', 8),
(22, 'N', 8),
(23, 'Y', 9),
(24, 'N', 9),
(25, 'Y', 10),
(26, 'N', 10),
(27, 'Y', 11),
(28, 'N', 11),
(29, 'Y', 12),
(30, 'N', 12),
(31, 'Y', 13),
(32, 'N', 13),
(33, 'Y', 14),
(34, 'N', 14),
(35, 'Y', 15),
(36, 'N', 15),
(37, 'Intact', 16),
(38, 'Partial degeneration', 16),
(39, 'Full degeneration', 16),
(40, 'Smooth K-wire', 17),
(41, 'Threaded K-wire', 17),
(42, 'Screw', 17),
(43, 'Absorbable', 17),
(44, 'Cerclage', 17),
(45, 'Other', 17),
(46, '1', 18),
(47, '2', 18),
(48, '3+', 18),
(49, 'Y', 19),
(50, 'N', 19),
(51, 'Y', 20),
(52, 'N', 20),
(53, 'Y', 21),
(54, 'N', 21),
(55, 'General', 22),
(56, 'MAC', 22),
(57, 'Spinal', 22),
(58, 'Local', 22),
(59, 'Y', 23),
(60, 'N', 23),
(61, 'Y', 24),
(62, 'N', 24),
(63, 'None', 25),
(64, 'Lidocaine', 25),
(65, 'Marcaine', 25),
(66, 'Dexmethasone', 26),
(67, 'Toradol', 26),
(68, 'Other', 26);

-- --------------------------------------------------------

--
-- Table structure for table `xrays_answers`
--

CREATE TABLE IF NOT EXISTS `xrays_answers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `dateof` int(10) DEFAULT NULL,
  `dateofxrays` int(10) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `sur_id` int(11) NOT NULL,
  `Q4` varchar(100) DEFAULT NULL,
  `Q5` varchar(100) DEFAULT NULL,
  `Q6` varchar(100) DEFAULT NULL,
  `Q7` varchar(100) DEFAULT NULL,
  `Q8` varchar(100) DEFAULT NULL,
  `Q9` varchar(100) DEFAULT NULL,
  `Q10` varchar(100) DEFAULT NULL,
  `Q11` varchar(100) DEFAULT NULL,
  `Q12` varchar(100) DEFAULT NULL,
  `Q13` varchar(100) DEFAULT NULL,
  `Q14` varchar(100) DEFAULT NULL,
  `Q15` varchar(100) DEFAULT NULL,
  `Q16` varchar(100) DEFAULT NULL,
  `Q17` varchar(100) DEFAULT NULL,
  `Q18` varchar(100) DEFAULT NULL,
  `Q19` varchar(100) DEFAULT NULL,
  `Q20` varchar(100) DEFAULT NULL,
  `Q21` varchar(100) DEFAULT NULL,
  `Q22` varchar(100) DEFAULT NULL,
  `Q23` varchar(100) DEFAULT NULL,
  `Q24` varchar(100) DEFAULT NULL,
  `Q25` varchar(100) DEFAULT NULL,
  `Q26` varchar(100) DEFAULT NULL,
  `Q27` varchar(100) DEFAULT NULL,
  `Q28` varchar(100) DEFAULT NULL,
  `Q29` varchar(100) DEFAULT NULL,
  `Q30` varchar(100) DEFAULT NULL,
  `Q31` varchar(100) DEFAULT NULL,
  `Q32` varchar(100) DEFAULT NULL,
  `Q33` varchar(100) DEFAULT NULL,
  `Q34` varchar(100) DEFAULT NULL,
  `Q35` varchar(100) DEFAULT NULL,
  `Q36` varchar(100) DEFAULT NULL,
  `Q37` varchar(100) DEFAULT NULL,
  `Q38` varchar(100) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `extremity` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `xrays_answers`
--

INSERT INTO `xrays_answers` (`id`, `dateof`, `dateofxrays`, `pat_id`, `sur_id`, `Q4`, `Q5`, `Q6`, `Q7`, `Q8`, `Q9`, `Q10`, `Q11`, `Q12`, `Q13`, `Q14`, `Q15`, `Q16`, `Q17`, `Q18`, `Q19`, `Q20`, `Q21`, `Q22`, `Q23`, `Q24`, `Q25`, `Q26`, `Q27`, `Q28`, `Q29`, `Q30`, `Q31`, `Q32`, `Q33`, `Q34`, `Q35`, `Q36`, `Q37`, `Q38`, `type`, `extremity`) VALUES
(1, 1375419600, 1375419600, 1, 1, '', '90', '77', '-2', '1', '123', '99.1', '1.0', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '1111', '1', 1, 2),
(2, 1377752400, 1377752400, 1, 1, NULL, '11', '1', '1', '1', '1', '1', '1.0', '2', '3', '4', '11', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', 'as', '-1', 3, 2),
(3, 1377752400, 1377752400, 1, 1, NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '11', 'asdf', 4, 2),
(4, 1377752400, 1377752400, 1, 1, NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '', '1', '1', '1', '1', '11', 'fdsa', 5, 2),
(6, 1379048400, 1379048400, 1, 1, NULL, '', '12', '', '1212', '', '', '', '', '12', '', '', '', '', '', '', '', '', '12', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1),
(7, 1379048400, 1379048400, 1, 1, NULL, '12', '12', '', '12', '', 'aa', '12', '', '', '', '', '', '', '12', '', '', '', 'asd', '', '', '%$$!#', '', '', 'as34', '', '', 'SELECT * FROM xray_ans', '', '', '', '', '', '', '', 3, 1),
(8, 1379048400, 1379048400, 1, 1, NULL, '1', 'a', '1', '1', 's', 'a', '11', '1', '1', '1', '1', '12', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 4, 1),
(9, 1379048400, 1379048400, 1, 1, NULL, '', '', 'a', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 5, 1),
(10, 1384059600, 977806800, 16, 6, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ans_demo`
--
ALTER TABLE `ans_demo`
  ADD CONSTRAINT `ans_demo_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `vals_demo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_demo_ibfk_2` FOREIGN KEY (`ques_num`) REFERENCES `ques_demo` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_demo_ibfk_3` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_eval`
--
ALTER TABLE `ans_eval`
  ADD CONSTRAINT `ans_eval_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_eval` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_eval_ibfk_2` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_eval_ibfk_3` FOREIGN KEY (`sur_id`) REFERENCES `physicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_eval_ibfk_4` FOREIGN KEY (`answer`) REFERENCES `vals_eval` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_foot`
--
ALTER TABLE `ans_foot`
  ADD CONSTRAINT `ans_foot_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `vals_foot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_foot_ibfk_2` FOREIGN KEY (`ques_num`) REFERENCES `ques_foot` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_foot_ibfk_3` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_mcgillpain`
--
ALTER TABLE `ans_mcgillpain`
  ADD CONSTRAINT `ans_mcgillpain_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `vals_mcgillpain` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_mcgillpain_ibfk_2` FOREIGN KEY (`ques_num`) REFERENCES `ques_mcgillpain` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_mcgillpain_ibfk_3` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_mcgillpain_ibfk_4` FOREIGN KEY (`sur_id`) REFERENCES `physicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_post`
--
ALTER TABLE `ans_post`
  ADD CONSTRAINT `ans_post_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_post` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_post_ibfk_2` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_post_ibfk_3` FOREIGN KEY (`sur_id`) REFERENCES `physicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_post_ibfk_4` FOREIGN KEY (`answer`) REFERENCES `vals_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_sf36`
--
ALTER TABLE `ans_sf36`
  ADD CONSTRAINT `ans_sf36_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `vals_sf36` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_sf36_ibfk_2` FOREIGN KEY (`ques_num`) REFERENCES `ques_sf36` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_sf36_ibfk_3` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_surgical`
--
ALTER TABLE `ans_surgical`
  ADD CONSTRAINT `ans_surgical_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `vals_surgical` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_surgical_ibfk_2` FOREIGN KEY (`ques_num`) REFERENCES `ques_surgical` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_surgical_ibfk_3` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_surgical_ibfk_4` FOREIGN KEY (`sur_id`) REFERENCES `physicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ans_xrays`
--
ALTER TABLE `ans_xrays`
  ADD CONSTRAINT `ans_xrays_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_xrays` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_xrays_ibfk_2` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ans_xrays_ibfk_3` FOREIGN KEY (`sur_id`) REFERENCES `physicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`sex`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_ibfk_2` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pre_opscore`
--
ALTER TABLE `pre_opscore`
  ADD CONSTRAINT `pre_opscore_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_opscore_ibfk_2` FOREIGN KEY (`dateof`) REFERENCES `ans_sf36` (`dateof`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_demo`
--
ALTER TABLE `vals_demo`
  ADD CONSTRAINT `vals_demo_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_demo` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_eval`
--
ALTER TABLE `vals_eval`
  ADD CONSTRAINT `vals_eval_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_eval` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_foot`
--
ALTER TABLE `vals_foot`
  ADD CONSTRAINT `vals_foot_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_foot` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_mcgillpain`
--
ALTER TABLE `vals_mcgillpain`
  ADD CONSTRAINT `vals_mcgillpain_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_mcgillpain` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_post`
--
ALTER TABLE `vals_post`
  ADD CONSTRAINT `vals_post_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_post` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_sf36`
--
ALTER TABLE `vals_sf36`
  ADD CONSTRAINT `vals_sf36_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_sf36` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vals_surgical`
--
ALTER TABLE `vals_surgical`
  ADD CONSTRAINT `vals_surgical_ibfk_1` FOREIGN KEY (`ques_num`) REFERENCES `ques_surgical` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
