-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2011 at 01:01 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bc_11`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_event`
--

CREATE TABLE IF NOT EXISTS `booking_event` (
  `event_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(150) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `location` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `starting_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ending_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recur_interval` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'none',
  `recur_freq` tinyint(4) NOT NULL DEFAULT '0',
  `recur_until_date` date NOT NULL DEFAULT '0000-00-00',
  `description` text CHARACTER SET latin1 NOT NULL,
  `date_time_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_mod_by_id` smallint(6) NOT NULL DEFAULT '0',
  `last_mod_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `booking_event`
--


-- --------------------------------------------------------

--
-- Table structure for table `booking_schedule`
--

CREATE TABLE IF NOT EXISTS `booking_schedule` (
  `date_time_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `day_of_the_week_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `event_id_location_1` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `event_id_location_2` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `event_id_location_3` mediumint(9) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date_time_id`),
  UNIQUE KEY `starting_date_time` (`schedule_date_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `booking_schedule`
--


-- --------------------------------------------------------

--
-- Table structure for table `booking_user`
--

CREATE TABLE IF NOT EXISTS `booking_user` (
  `user_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `passwd` varchar(36) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `firstname` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `lastname` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `groups` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `booking_user`
--

