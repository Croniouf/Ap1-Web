-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2026 at 02:56 PM
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
-- Database: `td3.4`
--

-- --------------------------------------------------------

--
-- Table structure for table `acheteur`
--

CREATE TABLE `acheteur` (
  `id` int(5) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `motdepasse` varchar(30) NOT NULL,
  `numeroCB` int(20) NOT NULL,
  `dateNaissance` date NOT NULL,
  `estMalentendant` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acheteur`
--

INSERT INTO `acheteur` (`id`, `nom`, `prenom`, `email`, `motdepasse`, `numeroCB`, `dateNaissance`, `estMalentendant`) VALUES
(1, 'GRAVOUIL', 'benjamin', 'prof.gravouil@gmail.com', 'qsdqsd', 323, '1984-11-16', 0),
(2, 'Dupond', 'jacques', 'jaque@gmail.com', 'qsdqsd', 323, '2010-11-16', 1),
(3, 'Bob', 'leponge', 'bob@gmail.com', 'qsdsqsd', 323, '2010-11-16', 1),
(4, 'Super', 'Man', 'Sman@gmail.com', 'qsd2qsd', 323, '1850-11-16', 0),
(5, 'Foutix', 'Foutix', 'foutix@gmail.com', 'q3sdqsd', 323, '2010-11-16', 0),
(6, 'Bat', 'Man', 'bat@gmail.com', 'qsdqs5d', 323, '2010-11-16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `id` int(5) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `DateNaissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`, `DateNaissance`) VALUES
(1, 'Hugo', 'Victor', '1980-11-08'),
(2, 'Mole', 'Hier', '1980-11-08'),
(3, 'Pat', 'Patrouille', '1930-11-08'),
(4, 'Victor', 'Mobile', '1980-11-08'),
(5, 'Ash', 'Tag', '1950-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `avoir_lieu`
--

CREATE TABLE `avoir_lieu` (
  `idSPECTACLE` int(5) NOT NULL,
  `idSALLE` int(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `avoir_lieu`
--

INSERT INTO `avoir_lieu` (`idSPECTACLE`, `idSALLE`, `date`) VALUES
(1, 1, '2022-11-15'),
(2, 2, '2022-11-15'),
(2, 3, '2022-11-15'),
(3, 2, '2022-11-15'),
(4, 4, '2022-11-15'),
(5, 1, '2022-11-15'),
(5, 5, '2022-11-15');

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `id` int(5) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `capacite` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`id`, `nom`, `capacite`) VALUES
(1, 'Salle Bleu', 100),
(2, 'Salle Rouge', 100),
(3, 'Salle Bleue', 1000),
(4, 'Salle Verte', 50),
(5, 'Salle Jaune', 2500);

-- --------------------------------------------------------

--
-- Table structure for table `spectacle`
--

CREATE TABLE `spectacle` (
  `id` int(5) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `duree` int(5) NOT NULL,
  `dateCreation` date NOT NULL,
  `idAuteur` int(5) NOT NULL,
  `numTYPE` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spectacle`
--

INSERT INTO `spectacle` (`id`, `nom`, `duree`, `dateCreation`, `idAuteur`, `numTYPE`) VALUES
(1, 'Spectacle Humour', 120, '2022-11-15', 5, 1),
(2, 'james Bond', 200, '2022-08-08', 3, 3),
(3, 'james Bond', 200, '2022-08-08', 3, 3),
(4, 'Violon', 200, '2022-08-08', 4, 3),
(5, 'piano', 200, '2022-08-08', 3, 3),
(6, 'trompette', 200, '2022-08-08', 2, 3),
(7, 'romantique', 200, '2022-08-08', 5, 2),
(8, 'danse contemporaine', 200, '2022-08-08', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `num` int(5) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`num`, `nom`) VALUES
(1, 'théatre'),
(2, 'danse'),
(3, 'Concert');

-- --------------------------------------------------------

--
-- Table structure for table `voir`
--

CREATE TABLE `voir` (
  `idSPECTACLE` int(5) NOT NULL,
  `idAcheteur` int(5) NOT NULL,
  `note` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voir`
--

INSERT INTO `voir` (`idSPECTACLE`, `idAcheteur`, `note`) VALUES
(1, 1, 2),
(2, 2, 5),
(3, 3, 2),
(4, 4, 5),
(5, 1, 5),
(5, 5, 0),
(5, 6, 5),
(7, 6, 5),
(8, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acheteur`
--
ALTER TABLE `acheteur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avoir_lieu`
--
ALTER TABLE `avoir_lieu`
  ADD PRIMARY KEY (`idSPECTACLE`,`idSALLE`),
  ADD KEY `FK6` (`idSALLE`);

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spectacle`
--
ALTER TABLE `spectacle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK1` (`idAuteur`),
  ADD KEY `FK2` (`numTYPE`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `voir`
--
ALTER TABLE `voir`
  ADD PRIMARY KEY (`idSPECTACLE`,`idAcheteur`),
  ADD KEY `FK4` (`idAcheteur`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avoir_lieu`
--
ALTER TABLE `avoir_lieu`
  ADD CONSTRAINT `FK5` FOREIGN KEY (`idSPECTACLE`) REFERENCES `spectacle` (`id`),
  ADD CONSTRAINT `FK6` FOREIGN KEY (`idSALLE`) REFERENCES `salle` (`id`);

--
-- Constraints for table `spectacle`
--
ALTER TABLE `spectacle`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`idAuteur`) REFERENCES `auteur` (`id`),
  ADD CONSTRAINT `FK2` FOREIGN KEY (`numTYPE`) REFERENCES `type` (`num`);

--
-- Constraints for table `voir`
--
ALTER TABLE `voir`
  ADD CONSTRAINT `FK3` FOREIGN KEY (`idSPECTACLE`) REFERENCES `spectacle` (`id`),
  ADD CONSTRAINT `FK4` FOREIGN KEY (`idAcheteur`) REFERENCES `acheteur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
