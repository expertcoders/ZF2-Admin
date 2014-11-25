-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2014 at 05:42 PM
-- Server version: 5.5.35
-- PHP Version: 5.4.27-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zend`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `album1`
--

CREATE TABLE IF NOT EXISTS `album1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `post` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `post`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'Nokia N1 Android tablet vs iPad mini 3: A specs faceoff', 'Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.Nokia has made a surprise comeback into the world of consumer tech devices with the launch of its new Android tablet, the Nokia N1.', 19, 0, '2014-11-19 00:00:00', NULL),
(2, 'Specs, Processor and Connectivity ', ' The Nokia N1 comes with a 64-bit Intel Atom Z3580 processor clocked at 2.3GHz and coupled with 2GB of RAM. It also includes PowerVR G6430 GPU. The N1 offers 32GB onboard storage, but there is no microSD card slot to expand it further. The connectivity options include dual channel 802.11a/b/g/n/ac Wi-Fi with MIMO, microUSB 2.0 and Bluetooth 4.0.', 19, 0, '2014-11-19 00:00:00', NULL),
(3, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(4, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 1, '0000-00-00 00:00:00', NULL),
(5, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(6, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(7, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(8, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(9, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(10, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(11, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(12, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(13, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(14, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL),
(16, 'Ebola alert: Government says situation under control', 'Ebola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlEbola alert: Government says situation under controlv', 19, 0, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rememberme` int(11) NOT NULL,
  `email_address` varchar(225) NOT NULL,
  `country` int(11) NOT NULL,
  `passport_image` varchar(225) NOT NULL,
  `is_accept_invitation` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `username`, `password`, `rememberme`, `email_address`, `country`, `passport_image`, `is_accept_invitation`, `status`) VALUES
(19, 'Pradeep', 'Kumar', 'pradeep', 'e10adc3949ba59abbe56e057f20f883e', 0, 'pradeep@gmail.com', 0, '', 0, 0),
(20, 'Rahul', 'Kumar', 'rahul', 'e10adc3949ba59abbe56e057f20f883e', 0, 'sdasd', 0, '', 0, 0),
(21, 'Pradeep', 'kumar', '', '', 0, 'pradeep@gmail.com', 0, '', 0, 0),
(22, 'Pradeep', 'Kumar', '', '', 0, 'pradeep@gmail.com', 0, '', 0, 0),
(23, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(24, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(25, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(26, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(27, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(28, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(29, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(30, 'Pradeep', 'Kumar', '', '', 0, 'asdasd', 0, '', 0, 0),
(31, 'Pradeep', 'Kumar', '', '', 0, 'pradeep@gmail.com', 0, '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
