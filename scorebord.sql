-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 25 Nov 2010 om 19:05
-- Serverversie: 5.1.49
-- PHP-Versie: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `net3-nl-mysql-13.vevida.net_hemurengenl`
--

-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `scorebord`
--

CREATE TABLE IF NOT EXISTS `scorebord` (
  `clubthuis` varchar(50) NOT NULL,
  `clubuit` varchar(50) NOT NULL,
  `scorethuis` int(2) NOT NULL DEFAULT '0',
  `scoreuit` int(2) NOT NULL DEFAULT '0',
  `lastModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT NULL COMMENT 'NULL = moet nog starten, 0 = einde, 1 = start',
  UNIQUE KEY `clubthuis` (`clubthuis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `scorebord`
--

INSERT INTO `scorebord` (`clubthuis`, `clubuit`, `scorethuis`, `scoreuit`, `lastModified`, `status`) VALUES
('VIKO', 'Hemur Enge', 12, 10, '2013-12-14 19:05:02', 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wedstrijden`
--

CREATE TABLE IF NOT EXISTS `wedstrijden` (
  `wedstrijd_id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `clubthuis` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `clubuit` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `tijd` time NOT NULL,
  PRIMARY KEY (`wedstrijd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=111 ;

--
-- Gegevens worden uitgevoerd voor tabel `wedstrijden`
--

INSERT INTO `wedstrijden` (`wedstrijd_id`, `datum`, `clubthuis`, `clubuit`, `tijd`) VALUES
(110, '2013-12-14', 'VIKO', 'Hemur Enge', '18:45:00'),
(109, '2013-12-07', 'Nikantes', 'Hemur Enge', '15:15:00'),
(108, '2013-11-30', 'Hemur Enge', 'Harga/ODI', '11:15:00'),
(107, '2013-11-23', 'Triade', 'Hemur Enge', '15:30:00'),
(106, '2013-11-16', 'Hemur Enge', 'Oranje Nassau', '18:45:00'),
(105, '2013-11-09', 'NIO', 'Hemur Enge', '18:30:00'),
(104, '2013-10-12', 'Kesteren', 'Hemur Enge', '15:30:00'),
(103, '2013-10-05', 'Hemur Enge', 'd Ommerdieck', '16:00:00'),
(102, '2013-09-28', 'SEV', 'Hemur Enge', '15:30:00'),
(101, '2013-09-21', 'Mélynas', 'Hemur Enge', '15:30:00'),
(100, '2013-09-14', 'Hemur Enge', 'Wesstar', '16:00:00'),
(99, '2013-09-10', 'Hemur Enge', 'Reehorst', '20:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
