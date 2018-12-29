-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1:3306
-- Genereringstid: 29. 12 2018 kl. 22:56:37
-- Serverversion: 5.7.19
-- PHP-version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esbjerg-klinik`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `behandling`
--

DROP TABLE IF EXISTS `behandling`;
CREATE TABLE IF NOT EXISTS `behandling` (
  `behandlingID` int(255) NOT NULL AUTO_INCREMENT,
  `behandlingname` varchar(2500) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `dato` date NOT NULL,
  `betaling` varchar(255) NOT NULL,
  `CPR` varchar(255) NOT NULL,
  PRIMARY KEY (`behandlingID`),
  KEY `CPR` (`CPR`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `behandling`
--

INSERT INTO `behandling` (`behandlingID`, `behandlingname`, `description`, `dato`, `betaling`, `CPR`) VALUES
(20, 'PRP', 'Platelet-rich plasma, also known as autologous conditioned plasma, is a concentrate of platelet-rich plasma protein derived from whole blood, centrifuged to remove red blood cells. Evidence for benefit is poor.', '2018-11-20', '4200', 'R25YbitOM3RVWXBhVjRGSTU5QzhBQT09'),
(18, 'face meso', 'Mesotherapy employs multiple injections of pharmaceutical and homeopathic medications, plant extracts, vitamins, and other ingredients into subcutaneous fat.', '2018-11-26', '3700', 'alhXSmFXcExrTytjbkx0NlgzOWkvUT09'),
(21, 'PRP', 'Ved en PRP-behandling anvendes patientens eget blod. Behandlingen vinder frem herhjemme, hvor der er sket skader i bevægeapparatet, f. eks. muskel- og ledbåndsskader, bruskskader og sene-overbelastninger.', '2018-11-27', '3900', 'R25YbitOM3RVWXBhVjRGSTU5QzhBQT09'),
(22, 'Hair mesotherapy', 'Mesotherapy is a baldness treatment that triggers hair re-growth for both men and women. It can also delay the pattern of balding in men. ... The vitamin boost to your scalp allows you to have better blood circulation in your scalp and hair follicles, which results in better hair re-growth', '2018-07-04', '3200', 'bElSV1BIS2tzYzNjbmZ1b0Y5R25TQT09'),
(23, 'mesotherapy 2', 'Alopecia, commonly termed as hair loss or baldness, is the problem of loss of hair from the scalp and the body. It is experienced by people throughout the world. This issue is faced by both genders but the intensity and pattern of hair fall is different. The word baldness is however, generally used to describe male pattern baldness in specific – partial or total lack of hair on the scalp with limited or no hair growth at all.', '2018-11-27', '3500', 'bElSV1BIS2tzYzNjbmZ1b0Y5R25TQT09'),
(24, 'Hifu 1', 'High-intensity focused ultrasound (HIFU) is a non-invasive therapeutic technique that uses non-ionizing ultrasonic waves to heat tissue.', '2018-11-17', '2300', 'YyszR0puUTJUQitRK2srSlpDSXBldz09'),
(25, 'face meso', 'In the above query, the string $query is built using textbox input from the user labeled user_id. It retrieves the username and password for the user, but it leaves the door wide open to attackers. Using this query with SQLi, an attacker could potentially gain access to the administrator&amp;#39;s credentials. Let&amp;#39;s see how it can be done.', '2018-12-03', '2300', 'bi9BQklFaURCSzZwY1dkYVVkaVZhUT09'),
(26, 'face meso', 'The result is that the entire contents of the User database are given to the attacker. The &amp;#39;--&amp;#39; comments out any other commands that you might have in the statement. It&amp;#39;s a protective measure the attacker uses to avoid any syntax errors.', '2019-01-03', '2300', 'bi9BQklFaURCSzZwY1dkYVVkaVZhUT09'),
(27, 'Face meso', 'dfsdsdf', '2018-12-14', '100', 'YXpibk9PR3lSalZjWWZFTHdtdTFXQT09'),
(28, 'mesotherapy', 'test', '2018-12-28', '500', 'dUlXYnkwRU1rbkkrUU5EaU1VM2pnUT09');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `fornavn` varchar(2500) NOT NULL,
  `efternavn` varchar(2500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `tlf` int(255) NOT NULL,
  `CPR` varchar(255) NOT NULL,
  `alder` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  PRIMARY KEY (`CPR`),
  UNIQUE KEY `CPR` (`CPR`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `patient`
--

INSERT INTO `patient` (`fornavn`, `efternavn`, `email`, `tlf`, `CPR`, `alder`, `gender`) VALUES
('mani', 'Vazirian', 'mani@gmail.com', 22745243, 'cE4zcklldHVFb0FvOFNUbzJYYXhmQT09', 27, 'male'),
('Jesper', 'Dalsgaard', 'post@jdanet.dk', 23355159, 'YXpibk9PR3lSalZjWWZFTHdtdTFXQT09', 34, 'Mand'),
('Azin', 'Yazdi', 'Azinj@gmail.com', 91673454, 'TURGaWtvbitvKzNWazFkTG0zVlMyUT09', 34, 'female'),
('Danial', 'Falah', 'danialfalah@gmail.com', 45735436, 'R25YbitOM3RVWXBhVjRGSTU5QzhBQT09', 20, 'male'),
('Behdin', 'Bagheri', 'behdin2010@gmail.com', 53525239, 'bElSV1BIS2tzYzNjbmZ1b0Y5R25TQT09', 19, 'male'),
('Arash', 'Bagheri', 'dr_arash_bagheri@yahoo.com', 50376302, 'alhXSmFXcExrTytjbkx0NlgzOWkvUT09', 49, 'male'),
('Anita', 'larsen', 'anita@gmail.com', 71703568, 'QkZjaGE1R3ZMSHVkL2wrTkNPMEthUT09', 35, 'female'),
('Shirin', 'Vazirian', 'shirin1268@gmail.com', 52735242, 'YyszR0puUTJUQitRK2srSlpDSXBldz09', 33, 'female'),
('mina', 'taheri', 'mina@yahoo.com', 45735436, 'TWtqYnY1TnFLNi9UZmx3bFAzOGEyUT09', 55, 'female'),
('hamid', 'pedersen', 'hamid.pedersen@gmail.com', 43424546, 'dUlXYnkwRU1rbkkrUU5EaU1VM2pnUT09', 20, 'Male');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE IF NOT EXISTS `picture` (
  `pictureID` int(255) NOT NULL AUTO_INCREMENT,
  `picture` varchar(2500) NOT NULL,
  `picturekategori` varchar(255) NOT NULL,
  `CPR` varchar(255) NOT NULL,
  `dato` date NOT NULL,
  `picturetitle` varchar(1000) NOT NULL,
  PRIMARY KEY (`pictureID`),
  KEY `CPR` (`CPR`),
  KEY `dato` (`dato`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `picture`
--

INSERT INTO `picture` (`pictureID`, `picture`, `picturekategori`, `CPR`, `dato`, `picturetitle`) VALUES
(31, '5bfda70925a46_DSC_0307.JPG', 'Hifu', 'YyszR0puUTJUQitRK2srSlpDSXBldz09', '2018-11-20', 'efter hifu 1'),
(30, '5bfda6d6e65f0_DSC_0309.JPG', 'Før behandling', 'YyszR0puUTJUQitRK2srSlpDSXBldz09', '2018-11-17', 'før behandling'),
(26, '5bfd2d69505cd_IMG_0134.JPG', 'Efter PRP nr.2', 'alhXSmFXcExrTytjbkx0NlgzOWkvUT09', '2018-11-27', 'prp behandling2'),
(25, '5bfd2d524ed8b_IMG_0133.JPG', 'Efter PRP nr.2', 'alhXSmFXcExrTytjbkx0NlgzOWkvUT09', '2018-11-27', 'PRP behandling'),
(23, '5bfc64b2bc056_DSC_0188.JPG', 'Før behandling', 'bElSV1BIS2tzYzNjbmZ1b0Y5R25TQT09', '2018-11-26', 'behandling for første gang'),
(24, '5bfc64d193e15_DSC_0161.JPG', 'Efter behandling', 'bElSV1BIS2tzYzNjbmZ1b0Y5R25TQT09', '2018-11-26', 'test af opdatering af billedet'),
(38, '5c0c24e2b9a97_IMG_0135.JPG', 'Efter behandling', 'alhXSmFXcExrTytjbkx0NlgzOWkvUT09', '2018-11-30', 'Hannover'),
(39, '5c1268c27a027_computer_pc_PNG17485.png', 'Før behandling', 'QkZjaGE1R3ZMSHVkL2wrTkNPMEthUT09', '2019-01-02', 'Anita picture'),
(42, '5c27763a862a0_IMG_0026.JPG', 'Før behandling', 'dUlXYnkwRU1rbkkrUU5EaU1VM2pnUT09', '2018-12-19', 'Hamid picture');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `picturekategori`
--

DROP TABLE IF EXISTS `picturekategori`;
CREATE TABLE IF NOT EXISTS `picturekategori` (
  `kategoriID` int(255) NOT NULL AUTO_INCREMENT,
  `picturekategori` varchar(255) NOT NULL,
  PRIMARY KEY (`kategoriID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `picturekategori`
--

INSERT INTO `picturekategori` (`kategoriID`, `picturekategori`) VALUES
(1, 'Før behandling'),
(3, 'Efter behandling'),
(5, 'Efter meso nr.2'),
(7, 'Efter meso nr.3'),
(9, 'Efter PRP nr.2'),
(10, 'Hifu');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `fornavn` varchar(2500) NOT NULL,
  `efternavn` varchar(2500) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(5000) NOT NULL,
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `Adminlevel` varchar(100) NOT NULL,
  PRIMARY KEY (`adminID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`fornavn`, `efternavn`, `email`, `username`, `password`, `adminID`, `Adminlevel`) VALUES
('Shirin', 'Vazirian', 'shirin1268@gmail.com', 'shirin', '$2y$15$KCSNfr.1EqBQ/L.8fGtsC.FH6./EwNXPkbdEu98ubrYoE4YAdpcSq', 27, 'administrator'),
('Admin', 'Admin', 'Admin@gmail.com', 'admin', '$2y$15$nZ3bb5GwfGdNhU1XsGeU0.CfV2bQfijU/DqMjcF2ZtGzejgFMX0sO', 26, 'owner');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
