-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2025 at 01:56 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appli_web_xavier`
--

-- --------------------------------------------------------

--
-- Table structure for table `compte_rendu`
--

CREATE TABLE `compte_rendu` (
  `num` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `vu` tinyint(1) NOT NULL,
  `datetime` datetime NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `compte_rendu`
--

INSERT INTO `compte_rendu` (`num`, `date`, `description`, `vu`, `datetime`, `email`) VALUES
(10, '2025-11-12', 'CEDRIC \r\nVALORANT', 0, '2025-11-12 15:46:32', 'parisxavier@free.fr'),
(11, '2025-11-17', 'J\'ai enfin terminé le TD6 !!! ouiiii', 0, '2025-11-17 15:57:02', 'parisxavier@free.fr'),
(12, '2025-11-19', 'Bonjour, aujourd\'hui nous allons faire l\'ap3 ok ', 0, '2025-11-19 13:43:18', 'lin.cedric@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE `stage` (
  `num` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `CP` int(10) NOT NULL,
  `ville` varchar(40) NOT NULL,
  `tel` int(30) NOT NULL,
  `libelleStage` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL,
  `num_tuteur` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tuteur`
--

CREATE TABLE `tuteur` (
  `num` int(10) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `tel` int(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `num` int(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `tel` int(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `motdepasse` varchar(200) NOT NULL,
  `type` int(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `option` int(1) NOT NULL,
  `num_stage` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`num`, `nom`, `prenom`, `tel`, `login`, `motdepasse`, `type`, `email`, `option`, `num_stage`) VALUES
(1, 'Paris', 'Xavier', 749470710, 'Xavier Paris', '6e4bfcfa2b9e2730f315096b57dff33142e86c445993c2313f21d6e022f4e71d', 1, 'parisxavier@free.fr', 1, 478638714),
(2, 'Gravouil', 'Benjamin ', 311649498, 'Benjamin Gravouil', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 2, 'prof.gravouil@gmail.com', 1, 464469961),
(3, 'Lin', 'Cedric', 658471021, 'Cedric Lin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 1, 'lin.cedric@gmail.com', 1, 652546444),
(4, 'rbrtb', 'rbrb', 212, 'Marche stp', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 1, 'moi@marche.stp', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `tuteur`
--
ALTER TABLE `tuteur`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stage`
--
ALTER TABLE `stage`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tuteur`
--
ALTER TABLE `tuteur`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
