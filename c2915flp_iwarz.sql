-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 30 mrt 2020 om 16:41
-- Serverversie: 10.2.26-MariaDB-cll-lve
-- PHP-versie: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c2915flp_iwarz`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `accounts`
--

CREATE TABLE `accounts` (
  `userId` int(10) NOT NULL,
  `activationkey` int(10) NOT NULL,
  `team` int(1) NOT NULL,
  `resources` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lastShowup` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `airplanes`
--

CREATE TABLE `airplanes` (
  `fleetId` int(10) NOT NULL,
  `airplanes` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `locationId` varchar(3) NOT NULL,
  `team` int(1) NOT NULL,
  `lastTimeGathered` int(10) NOT NULL,
  `lastAirstrike` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `airplanes`
--

INSERT INTO `airplanes` (`fleetId`, `airplanes`, `userId`, `locationId`, `team`, `lastTimeGathered`, `lastAirstrike`) VALUES
(0, 2, 1, 'C05', 2, 0, 0),
(0, 1, 18, 'C02', 2, 0, 0),
(0, 3, 25, 'F08', 4, 0, 0),
(0, 1, 27, 'A06', 1, 0, 0),
(0, 1, 52, 'L06', 3, 0, 1322348748),
(0, 2, 49, 'A01', 2, 0, 0),
(0, 3, 28, 'F08', 4, 0, 0),
(0, 1, 32, 'F08', 4, 0, 0),
(0, 2, 23, 'G04', 1, 0, 1322319361),
(0, 71, 26, 'A03', 3, 1322336888, 1322332203),
(0, 3, 68, 'K02', 4, 0, 1322320177),
(0, 1, 25, 'C02', 2, 0, 1322320295),
(0, 1, 78, 'A01', 1, 0, 0),
(0, 1, 79, 'D01', 4, 0, 1330614788),
(0, 1, 96, 'J06', 3, 0, 1415287349),
(0, 1, 97, 'G01', 2, 0, 1433510157),
(0, 1, 98, 'C07', 2, 0, 1434718540);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bases`
--

CREATE TABLE `bases` (
  `baseId` int(11) NOT NULL,
  `locationId` varchar(3) NOT NULL,
  `userId` int(10) NOT NULL,
  `team` int(1) NOT NULL,
  `condition` int(3) NOT NULL DEFAULT 100,
  `lastTimeTakingResources` int(10) NOT NULL,
  `lastTimeBuilding` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `bases`
--

INSERT INTO `bases` (`baseId`, `locationId`, `userId`, `team`, `condition`, `lastTimeTakingResources`, `lastTimeBuilding`) VALUES
(2, 'C02', 25, 2, 99, 1321207248, 838),
(3, 'G04', 23, 1, 0, 1322319739, 1322074945),
(4, 'A06', 24, 1, 100, 1321195930, 1321195937),
(5, 'F08', 25, 4, 100, 1321198741, 1321197802),
(20, 'H08', 69, 2, 100, 0, 0),
(6, 'A03', 26, 3, 100, 1338896391, 1338896360),
(7, 'A06', 27, 1, 100, 1321273516, 1321271425),
(8, 'J06', 26, 3, 100, 1322336873, 1322227288),
(19, 'K02', 68, 4, 100, 1322320215, 1322320140),
(10, 'C02', 50, 2, 100, 1321524184, 1321524193),
(21, 'L12', 71, 3, 100, 1322567230, 1322567240),
(12, 'C12', 29, 1, 100, 1321733811, 1321733966),
(13, 'L06', 52, 3, 100, 1321740774, 1322348731),
(14, 'J06', 35, 3, 100, 1321967784, 1321967788),
(15, 'B01', 54, 1, 100, 1321759437, 1321759554),
(16, 'F08', 36, 4, 100, 1321773639, 0),
(17, 'I11', 30, 2, 100, 0, 1321775861),
(18, 'F08', 32, 4, 100, 1321965884, 1321965901),
(22, 'G04', 70, 1, 100, 0, 0),
(23, 'E01', 72, 2, 100, 1322668811, 1322668832),
(24, 'F05', 74, 1, 100, 0, 1325599317),
(25, 'F08', 75, 4, 100, 0, 1325975225),
(26, 'F05', 77, 1, 99, 0, 0),
(27, 'A01', 78, 1, 100, 1329601814, 1329601805),
(28, 'D01', 79, 4, 100, 1330614609, 1330614836),
(29, 'L01', 82, 2, 100, 0, 0),
(30, 'K06', 83, 4, 99, 0, 1337311024),
(31, 'A01', 86, 1, 100, 1340543597, 0),
(32, 'G01', 89, 2, 100, 1363917249, 0),
(33, 'D05', 90, 3, 100, 0, 0),
(34, 'F05', 91, 1, 100, 0, 0),
(35, 'F08', 93, 4, 100, 0, 0),
(36, 'I11', 95, 2, 100, 0, 0),
(37, 'J06', 96, 3, 100, 1415287253, 1415287273),
(38, 'G01', 97, 2, 100, 1433510136, 1433510144),
(39, 'C07', 98, 2, 100, 1434718505, 1434718514);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `buildings`
--

CREATE TABLE `buildings` (
  `buildingId` int(11) NOT NULL,
  `baseId` int(10) NOT NULL,
  `buildingType` int(2) NOT NULL,
  `lastTimeUsed` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `buildings`
--

INSERT INTO `buildings` (`buildingId`, `baseId`, `buildingType`, `lastTimeUsed`) VALUES
(6, 1, 1, 0),
(5, 1, 2, 0),
(4, 1, 1, 0),
(7, 1, 1, 0),
(8, 1, 1, 0),
(9, 1, 1, 0),
(10, 2, 1, 1321207236),
(11, 2, 2, 1322320287),
(12, 1, 1, 1321201986),
(13, 1, 1, 0),
(14, 1, 1, 1321207124),
(15, 1, 1, 0),
(16, 1, 1, 1321201983),
(17, 1, 2, 0),
(18, 1, 2, 0),
(19, 1, 2, 0),
(20, 3, 1, 1321195816),
(21, 3, 1, 1321195728),
(22, 3, 1, 1322319820),
(23, 4, 1, 1321195941),
(24, 5, 1, 1321198790),
(25, 5, 2, 1321198789),
(26, 6, 1, 1338896386),
(27, 6, 2, 1322332135),
(28, 7, 1, 1321271098),
(29, 7, 2, 1321271428),
(30, 6, 1, 1321703784),
(31, 6, 2, 1321786337),
(32, 8, 2, 1321703765),
(33, 8, 2, 1322227306),
(34, 6, 2, 1321703775),
(35, 9, 2, 1321521303),
(36, 9, 2, 1321521307),
(37, 6, 2, 1321703777),
(38, 10, 1, 1321524209),
(39, 6, 1, 1321703786),
(40, 6, 2, 1321703780),
(41, 8, 1, 1321726248),
(42, 8, 1, 1322258998),
(43, 6, 1, 1321703792),
(44, 6, 1, 1322138641),
(45, 6, 1, 1321703788),
(46, 6, 1, 1321703783),
(47, 8, 1, 1321703761),
(48, 6, 1, 1321703785),
(49, 6, 1, 1321703803),
(50, 8, 1, 1321726250),
(51, 6, 1, 1321703803),
(52, 8, 1, 1321703748),
(53, 6, 1, 1321703799),
(54, 8, 1, 1322307059),
(55, 6, 1, 1321884959),
(56, 8, 1, 1322332281),
(57, 6, 1, 1321884961),
(58, 6, 1, 1321703798),
(59, 8, 1, 1322332287),
(60, 6, 1, 1321703797),
(61, 8, 1, 1322332286),
(62, 6, 1, 1321703796),
(63, 6, 1, 1322138643),
(64, 8, 1, 1322332284),
(65, 6, 1, 1321703795),
(66, 8, 1, 1322332282),
(67, 6, 1, 1322139585),
(68, 6, 1, 1321703793),
(69, 8, 1, 1321703757),
(70, 6, 1, 1323445059),
(71, 6, 1, 1321703781),
(72, 8, 1, 1321726252),
(73, 8, 1, 1322062653),
(74, 6, 1, 1322336898),
(75, 6, 1, 1321703939),
(76, 11, 1, 1321746362),
(77, 11, 2, 1321746373),
(78, 11, 1, 1321746370),
(79, 11, 1, 1321727628),
(80, 11, 1, 1321727622),
(81, 12, 1, 1321733977),
(82, 12, 1, 1321733973),
(83, 13, 1, 1322348733),
(84, 15, 1, 1321759558),
(85, 15, 1, 0),
(86, 17, 1, 1321775865),
(87, 18, 1, 1321965958),
(88, 18, 2, 1321965903),
(89, 14, 1, 1321967793),
(90, 3, 2, 1322075340),
(91, 8, 2, 0),
(92, 6, 2, 0),
(93, 19, 2, 1322319893),
(94, 19, 1, 1322320137),
(95, 19, 1, 1322320141),
(96, 13, 2, 1322348734),
(97, 21, 1, 1322567247),
(98, 23, 1, 0),
(99, 6, 1, 0),
(100, 24, 1, 0),
(101, 25, 1, 1325975246),
(102, 27, 2, 1329601727),
(103, 27, 2, 0),
(104, 28, 1, 1330614832),
(105, 28, 2, 1330614762),
(106, 28, 2, 0),
(107, 30, 1, 1337311032),
(108, 6, 1, 0),
(109, 37, 2, 1415287288),
(110, 38, 2, 1433510146),
(111, 39, 2, 1434718518);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE `locations` (
  `locationId` varchar(3) NOT NULL,
  `resources` int(3) NOT NULL,
  `dominatingTeam` int(1) NOT NULL,
  `lastTakenShare` int(10) NOT NULL,
  `share1` int(10) NOT NULL,
  `share2` int(10) NOT NULL,
  `share3` int(10) NOT NULL,
  `part1Ends` int(10) NOT NULL,
  `part2Ends` int(10) NOT NULL,
  `part3Ends` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `locations`
--

INSERT INTO `locations` (`locationId`, `resources`, `dominatingTeam`, `lastTakenShare`, `share1`, `share2`, `share3`, `part1Ends`, `part2Ends`, `part3Ends`) VALUES
('A01', 116, 1, 0, 70, 35, 35, 1, 2, 2),
('A02', 37, 0, 0, 37, 37, 37, 0, 0, 0),
('A03', 135, 3, 0, 135, 135, 135, 1, 1, 1),
('A04', 26, 0, 0, 26, 26, 26, 0, 0, 0),
('A05', 337, 0, 0, 337, 337, 337, 0, 0, 0),
('A06', 186, 1, 0, 112, 56, 56, 1, 2, 2),
('A07', 95, 0, 0, 95, 95, 95, 0, 0, 0),
('A08', 110, 0, 0, 110, 110, 110, 0, 0, 0),
('A09', 222, 0, 0, 222, 222, 222, 0, 0, 0),
('A10', 348, 0, 0, 348, 348, 348, 0, 0, 0),
('A11', 103, 0, 0, 103, 103, 103, 0, 0, 0),
('A12', 286, 0, 0, 286, 286, 286, 0, 0, 0),
('B01', 185, 1, 0, 185, 185, 185, 1, 1, 1),
('B02', 47, 0, 0, 47, 47, 47, 0, 0, 0),
('B03', 338, 0, 0, 338, 338, 338, 0, 0, 0),
('B04', 86, 0, 0, 86, 86, 86, 0, 0, 0),
('B05', 77, 0, 0, 77, 77, 77, 0, 0, 0),
('B06', 71, 0, 0, 71, 71, 71, 0, 0, 0),
('B07', 389, 0, 0, 389, 389, 389, 0, 0, 0),
('B08', 12, 0, 0, 12, 12, 12, 0, 0, 0),
('B09', 306, 0, 0, 306, 306, 306, 0, 0, 0),
('B10', 56, 0, 0, 56, 56, 56, 0, 0, 0),
('B11', 342, 0, 0, 342, 342, 342, 0, 0, 0),
('B12', 397, 0, 0, 397, 397, 397, 0, 0, 0),
('C01', 183, 0, 0, 183, 183, 183, 0, 0, 0),
('C02', 208, 2, 0, 125, 62, 62, 1, 2, 2),
('C03', 127, 0, 0, 127, 127, 127, 0, 0, 0),
('C04', 353, 0, 0, 353, 353, 353, 0, 0, 0),
('C05', 197, 0, 0, 197, 197, 197, 0, 0, 0),
('C06', 57, 0, 0, 57, 57, 57, 0, 0, 0),
('C07', 384, 0, 1, 384, 384, 384, 0, 0, 1),
('C08', 283, 0, 0, 283, 283, 283, 0, 0, 0),
('C09', 333, 0, 0, 333, 333, 333, 0, 0, 0),
('C10', 228, 0, 0, 228, 228, 228, 0, 0, 0),
('C11', 336, 0, 0, 336, 336, 336, 0, 0, 0),
('C12', 44, 1, 0, 44, 44, 44, 1, 1, 1),
('D01', 258, 4, 0, 258, 258, 258, 1, 1, 1),
('D02', 268, 0, 0, 268, 268, 268, 0, 0, 0),
('D03', 9, 0, 0, 9, 9, 9, 0, 0, 0),
('D04', 148, 0, 0, 148, 148, 148, 0, 0, 0),
('D05', 225, 3, 0, 225, 225, 225, 1, 1, 1),
('D06', 309, 0, 0, 309, 309, 309, 0, 0, 0),
('D07', 29, 0, 0, 29, 29, 29, 0, 0, 0),
('D08', 211, 0, 0, 211, 211, 211, 0, 0, 0),
('D09', 290, 0, 0, 290, 290, 290, 0, 0, 0),
('D10', 250, 0, 0, 250, 250, 250, 0, 0, 0),
('D11', 332, 0, 0, 332, 332, 332, 0, 0, 0),
('D12', 58, 0, 0, 58, 58, 58, 0, 0, 0),
('E01', 6, 2, 0, 6, 6, 6, 1, 1, 1),
('E02', 337, 0, 0, 337, 337, 337, 0, 0, 0),
('E03', 291, 0, 0, 291, 291, 291, 0, 0, 0),
('E04', 154, 0, 0, 154, 154, 154, 0, 0, 0),
('E05', 35, 0, 0, 35, 35, 35, 0, 0, 0),
('E06', 55, 0, 0, 55, 55, 55, 0, 0, 0),
('E07', 266, 0, 0, 266, 266, 266, 0, 0, 0),
('E08', 110, 0, 0, 110, 110, 110, 0, 0, 0),
('E09', 231, 0, 0, 231, 231, 231, 0, 0, 0),
('E10', 262, 0, 0, 262, 262, 262, 0, 0, 0),
('E11', 351, 0, 0, 351, 351, 351, 0, 0, 0),
('E12', 384, 0, 0, 384, 384, 384, 0, 0, 0),
('F01', 224, 0, 0, 224, 224, 224, 0, 0, 0),
('F02', 352, 0, 0, 352, 352, 352, 0, 0, 0),
('F03', 312, 0, 0, 312, 312, 312, 0, 0, 0),
('F04', 27, 0, 0, 27, 27, 27, 0, 0, 0),
('F05', 18, 1, 0, 11, 5, 2, 1, 2, 3),
('F06', 14, 0, 0, 14, 14, 14, 0, 0, 0),
('F07', 302, 0, 0, 302, 302, 302, 0, 0, 0),
('F08', 183, 4, 0, 110, 55, 9, 2, 3, 5),
('F09', 194, 0, 0, 194, 194, 194, 0, 0, 0),
('F10', 227, 0, 0, 227, 227, 227, 0, 0, 0),
('F11', 125, 0, 0, 125, 125, 125, 0, 0, 0),
('F12', 53, 0, 0, 53, 53, 53, 0, 0, 0),
('G01', 79, 2, 2, 79, 79, 79, 1, 1, 2),
('G02', 366, 0, 0, 366, 366, 366, 0, 0, 0),
('G03', 258, 0, 0, 258, 258, 258, 0, 0, 0),
('G04', 52, 1, 0, 31, 16, 16, 1, 2, 2),
('G05', 271, 0, 0, 271, 271, 271, 0, 0, 0),
('G06', 122, 0, 0, 122, 122, 122, 0, 0, 0),
('G07', 208, 0, 0, 208, 208, 208, 0, 0, 0),
('G08', 259, 0, 0, 259, 259, 259, 0, 0, 0),
('G09', 60, 0, 0, 60, 60, 60, 0, 0, 0),
('G10', 359, 0, 0, 359, 359, 359, 0, 0, 0),
('G11', 395, 0, 0, 395, 395, 395, 0, 0, 0),
('G12', 179, 0, 0, 179, 179, 179, 0, 0, 0),
('H01', 374, 0, 0, 374, 374, 374, 0, 0, 0),
('H02', 330, 0, 0, 330, 330, 330, 0, 0, 0),
('H03', 338, 0, 0, 338, 338, 338, 0, 0, 0),
('H04', 315, 0, 0, 315, 315, 315, 0, 0, 0),
('H05', 332, 0, 0, 332, 332, 332, 0, 0, 0),
('H06', 273, 0, 0, 273, 273, 273, 0, 0, 0),
('H07', 92, 0, 0, 92, 92, 92, 0, 0, 0),
('H08', 12, 2, 0, 12, 12, 12, 1, 1, 1),
('H09', 195, 0, 0, 195, 195, 195, 0, 0, 0),
('H10', 297, 0, 0, 297, 297, 297, 0, 0, 0),
('H11', 66, 0, 0, 66, 66, 66, 0, 0, 0),
('H12', 14, 0, 0, 14, 14, 14, 0, 0, 0),
('I01', 337, 0, 0, 337, 337, 337, 0, 0, 0),
('I02', 100, 0, 0, 100, 100, 100, 0, 0, 0),
('I03', 257, 0, 0, 257, 257, 257, 0, 0, 0),
('I04', 343, 0, 0, 343, 343, 343, 0, 0, 0),
('I05', 211, 0, 0, 211, 211, 211, 0, 0, 0),
('I06', 287, 0, 0, 287, 287, 287, 0, 0, 0),
('I07', 5, 0, 0, 5, 5, 5, 0, 0, 0),
('I08', 198, 0, 0, 198, 198, 198, 0, 0, 0),
('I09', 237, 0, 0, 237, 237, 237, 0, 0, 0),
('I10', 354, 0, 0, 354, 354, 354, 0, 0, 0),
('I11', 258, 2, 0, 258, 258, 258, 1, 1, 2),
('I12', 324, 0, 0, 324, 324, 324, 0, 0, 0),
('J01', 248, 0, 0, 248, 248, 248, 0, 0, 0),
('J02', 108, 0, 0, 108, 108, 108, 0, 0, 0),
('J03', 108, 0, 0, 108, 108, 108, 0, 0, 0),
('J04', 248, 0, 0, 248, 248, 248, 0, 0, 0),
('J05', 17, 0, 0, 17, 17, 17, 0, 0, 0),
('J06', 322, 3, 1, 193, 97, 97, 1, 2, 3),
('J07', 270, 0, 0, 270, 270, 270, 0, 0, 0),
('J08', 18, 0, 0, 18, 18, 18, 0, 0, 0),
('J09', 137, 0, 0, 137, 137, 137, 0, 0, 0),
('J10', 353, 0, 0, 353, 353, 353, 0, 0, 0),
('J11', 365, 0, 0, 365, 365, 365, 0, 0, 0),
('J12', 370, 0, 0, 370, 370, 370, 0, 0, 0),
('K01', 137, 0, 0, 137, 137, 137, 0, 0, 0),
('K02', 372, 4, 0, 372, 372, 372, 1, 1, 1),
('K03', 340, 0, 0, 340, 340, 340, 0, 0, 0),
('K04', 265, 0, 0, 265, 265, 265, 0, 0, 0),
('K05', 72, 0, 0, 72, 72, 72, 0, 0, 0),
('K06', 386, 4, 0, 386, 386, 386, 1, 1, 1),
('K07', 21, 0, 0, 21, 21, 21, 0, 0, 0),
('K08', 94, 0, 0, 94, 94, 94, 0, 0, 0),
('K09', 365, 0, 0, 365, 365, 365, 0, 0, 0),
('K10', 51, 0, 0, 51, 51, 51, 0, 0, 0),
('K11', 207, 0, 0, 207, 207, 207, 0, 0, 0),
('K12', 40, 0, 0, 40, 40, 40, 0, 0, 0),
('L01', 137, 2, 0, 137, 137, 137, 1, 1, 1),
('L02', 174, 0, 0, 174, 174, 174, 0, 0, 0),
('L03', 231, 0, 0, 231, 231, 231, 0, 0, 0),
('L04', 286, 0, 0, 286, 286, 286, 0, 0, 0),
('L05', 250, 0, 0, 250, 250, 250, 0, 0, 0),
('L06', 312, 3, 0, 312, 312, 312, 1, 1, 1),
('L07', 82, 0, 0, 82, 82, 82, 0, 0, 0),
('L08', 28, 0, 0, 28, 28, 28, 0, 0, 0),
('L09', 319, 0, 0, 319, 319, 319, 0, 0, 0),
('L10', 110, 0, 0, 110, 110, 110, 0, 0, 0),
('L11', 303, 0, 0, 303, 303, 303, 0, 0, 0),
('L12', 108, 3, 0, 108, 108, 108, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tanks`
--

CREATE TABLE `tanks` (
  `tankId` int(10) NOT NULL,
  `tanks` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `locationId` varchar(3) NOT NULL,
  `team` int(1) NOT NULL,
  `lastTimeGathered` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tanks`
--

INSERT INTO `tanks` (`tankId`, `tanks`, `userId`, `locationId`, `team`, `lastTimeGathered`) VALUES
(33, 9, 1, 'B04', 2, 1321206801),
(34, 7, 1, 'C02', 2, 1321206992),
(11, 2, 18, 'C04', 2, 838),
(22, 12, 23, 'G04', 1, 1321196389),
(24, 1, 24, 'B06', 1, 1321195957),
(26, 1, 25, 'E07', 4, 1321197680),
(28, 1, 25, 'G09', 4, 1321198190),
(29, 1, 25, 'F08', 4, 0),
(35, 1, 1, 'C05', 2, 0),
(36, 1, 18, 'C02', 2, 0),
(112, 1, 26, 'I01', 3, 1321703055),
(44, 1, 27, 'A03', 1, 1321271404),
(42, 1, 27, 'B07', 1, 1321271105),
(147, 3, 26, 'D02', 3, 1322139036),
(193, 5, 26, 'B02', 3, 1338896534),
(68, 1, 50, 'C02', 2, 0),
(111, 1, 26, 'J02', 3, 1321703051),
(204, 4, 26, 'E01', 3, 1322495451),
(170, 1, 28, 'E06', 4, 1321745428),
(159, 2, 26, 'K07', 3, 1321726257),
(145, 5, 26, 'B04', 3, 1338896537),
(209, 1, 26, 'A04', 3, 1338896545),
(146, 129, 26, 'B03', 3, 1321884969),
(91, 1, 26, 'A06', 3, 1321702272),
(185, 1, 32, 'F07', 4, 1321965865),
(210, 1, 26, 'G01', 3, 1338896555),
(95, 1, 26, 'A07', 3, 1321702362),
(97, 2, 26, 'A08', 3, 1322139043),
(138, 3, 26, 'G03', 3, 1322307066),
(201, 5, 26, 'K05', 3, 1322332291),
(168, 1, 28, 'H07', 4, 1321740891),
(152, 1, 26, 'F01', 3, 1322495459),
(205, 1, 71, 'L12', 3, 0),
(149, 1, 26, 'F02', 3, 1321708952),
(109, 1, 26, 'H01', 3, 1321702901),
(199, 1, 68, 'J02', 4, 1322320163),
(115, 1, 26, 'J01', 3, 1321703138),
(181, 1, 26, 'I03', 3, 1321792710),
(121, 1, 26, 'K01', 3, 1321703202),
(122, 1, 26, 'H02', 3, 1321703207),
(123, 1, 26, 'L01', 3, 1321703279),
(126, 1, 26, 'L02', 3, 1321703404),
(130, 1, 26, 'K02', 3, 1321703493),
(135, 1, 26, 'G02', 3, 1321703586),
(180, 42, 26, 'K03', 3, 1321907838),
(141, 60, 26, 'L08', 3, 1321703903),
(157, 1, 28, 'G06', 4, 1321724528),
(142, 138, 26, 'H04', 3, 1321703917),
(164, 1, 29, 'C11', 1, 1321733835),
(165, 2, 29, 'C12', 1, 0),
(167, 1, 52, 'L07', 3, 1321740790),
(171, 2, 28, 'F08', 4, 0),
(172, 6, 28, 'D05', 4, 1321746421),
(174, 2, 54, 'C01', 1, 1321759562),
(177, 1, 30, 'H10', 2, 1321775868),
(198, 2, 68, 'J03', 4, 1322320145),
(186, 1, 32, 'F08', 4, 0),
(188, 1, 35, 'I06', 3, 1321967797),
(191, 6, 26, 'I05', 3, 1322307062),
(190, 1, 26, 'J05', 3, 1322062790),
(203, 1, 52, 'L06', 3, 0),
(206, 1, 75, 'F08', 4, 0),
(207, 3, 79, 'D01', 4, 0),
(208, 1, 83, 'K06', 4, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vars`
--

CREATE TABLE `vars` (
  `lastShowupCheck` int(11) NOT NULL,
  `lastResourcesUpdate` int(11) NOT NULL,
  `cronjobip` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `vars`
--

INSERT INTO `vars` (`lastShowupCheck`, `lastResourcesUpdate`, `cronjobip`) VALUES
(0, 18, '84.35.166.14');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`userId`);

--
-- Indexen voor tabel `bases`
--
ALTER TABLE `bases`
  ADD PRIMARY KEY (`baseId`);

--
-- Indexen voor tabel `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`buildingId`);

--
-- Indexen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`locationId`);

--
-- Indexen voor tabel `tanks`
--
ALTER TABLE `tanks`
  ADD PRIMARY KEY (`tankId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `accounts`
--
ALTER TABLE `accounts`
  MODIFY `userId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `bases`
--
ALTER TABLE `bases`
  MODIFY `baseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT voor een tabel `buildings`
--
ALTER TABLE `buildings`
  MODIFY `buildingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT voor een tabel `tanks`
--
ALTER TABLE `tanks`
  MODIFY `tankId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
