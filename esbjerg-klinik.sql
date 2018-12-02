-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1:3306
-- Genereringstid: 25. 11 2018 kl. 21:26:19
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
  `CPR` varchar(10) NOT NULL,
  PRIMARY KEY (`behandlingID`),
  KEY `CPR` (`CPR`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `behandling`
--

INSERT INTO `behandling` (`behandlingID`, `behandlingname`, `description`, `dato`, `betaling`, `CPR`) VALUES
(1, 'meso', 'mesotherapi', '2018-11-11', '12345', '2209763764'),
(4, 'face meso ', 'It is tested', '2018-11-12', '2500', '2801007719'),
(16, 'mesotherapy', 'bla bla', '2018-11-13', '111111', '2801007719'),
(17, 'mesotherapy', 'bla bla', '2018-11-13', '111111', '2801007719');

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
('shirin', 'vazirian', 'shirin1268@gmail.com', 52735242, '2209763764', 42, 'female'),
('Arash', 'Bagheri', 'arash@gmail.com', 50635702, '2307694411', 45, 'male'),
('Behdin', 'Bagheri', 'behdin2010@gmail.com', 50383940, '2801007719', 19, 'male'),
('mani', 'mani', 'mani@gmail.com', 32659836, '1203921233', 22, 'male');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE IF NOT EXISTS `picture` (
  `pictureID` int(255) NOT NULL AUTO_INCREMENT,
  `picture` varchar(2500) NOT NULL,
  `picturekategori` varchar(255) NOT NULL,
  `CPR` varchar(10) NOT NULL,
  `dato` date NOT NULL,
  `picturetitle` varchar(1000) NOT NULL,
  PRIMARY KEY (`pictureID`),
  KEY `CPR` (`CPR`),
  KEY `dato` (`dato`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `picture`
--

INSERT INTO `picture` (`pictureID`, `picture`, `picturekategori`, `CPR`, `dato`, `picturetitle`) VALUES
(6, '5bf00480b7af3_Karierremesse (180).JPG', 'Efter behandling', '2209763764', '2018-11-12', 'khduiqhwjd qwqw'),
(5, '5bf0046b4f692_Karierremesse (180)SH.jpg', 'Før behandling', '2209763764', '2018-11-11', 'kigfujbjkwefpof'),
(19, '5bf1a63bcd0fd_IMG_2803.JPG', 'Efter meso nr.2', '2209763764', '2018-11-11', 'it is jpg'),
(17, '5bf1a557f0993_IMG_2709.JPG', 'Før behandling', '2307694411', '2018-11-11', 'jhfuehufhiwjndkwms'),
(11, '5bf12bbf8eff1_S1460087.JPG', 'Efter meso nr.3', '2307694411', '2018-11-11', 'it is a test'),
(12, '5bf12f8d4c447_DSC_0206.JPG', 'Efter meso nr.3', '2801007719', '2018-11-13', 'ytyhtnyuynsefwewefdgtyhyujyuiopl'),
(13, '5bf12ff1d3c31_IMG_2610.JPG', 'Efter PRP nr.2', '2801007719', '2018-11-13', 'kjgyrsjåpioælkklnvcdes3wsrvh'),
(18, '5bf1a56fd865d_IMG_2712.JPG', 'Efter behandling', '2307694411', '2018-11-12', 'ubufuwheidqowidkoqmd'),
(20, '5bf1a6e069f2b_IMG_2709.JPG', 'Efter meso nr.3', '2307694411', '2018-11-13', 'tessssssttttttt'),
(21, '5bf1bf5677a51_S1440013.JPG', 'Før behandling', '2801007719', '2018-11-11', 'det var en gang'),
(22, '5bf1c0064a920_IMG_6615.JPG', 'Efter behandling', '2801007719', '2018-11-11', 'asdfghjkll');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `picturekategori`
--

DROP TABLE IF EXISTS `picturekategori`;
CREATE TABLE IF NOT EXISTS `picturekategori` (
  `kategoriID` int(255) NOT NULL AUTO_INCREMENT,
  `picturekategori` varchar(255) NOT NULL,
  PRIMARY KEY (`kategoriID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `picturekategori`
--

INSERT INTO `picturekategori` (`kategoriID`, `picturekategori`) VALUES
(1, 'Før behandling'),
(3, 'Efter behandling'),
(5, 'Efter meso nr.2'),
(7, 'Efter meso nr.3'),
(9, 'Efter PRP nr.2');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`fornavn`, `efternavn`, `email`, `username`, `password`, `adminID`, `Adminlevel`) VALUES
('Shirin', 'Vazirian', 'shirin1268@gmail.com', 'Shirin', '$2y$15$PbGilP29jIObl6HESmj5QOzKBFp/DhVCmYJvE2BIzA1KbVav/5wvC', 1, '1'),
('Arash', 'Bagheri', 'dr_arash@yahoo.com', 'Arash', '$2y$15$oUo1bAfnYL9BEkU/zIB.d./eC3WeLAk0LRvSFjZ9JdKU2D5ilno8e', 2, '1'),
('mani', 'mani', 'mani@gmail.com', 'mani', '$2y$15$SJgn8KP7k54hIVqJprMOQuw1Gppi/k4KC5PLe8rYTItmXHojqJVpS', 24, '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
