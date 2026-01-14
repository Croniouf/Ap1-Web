-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2026 at 02:33 PM
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
-- Database: `ap2_bdd`
--

-- --------------------------------------------------------

--
-- Table structure for table `adherent`
--

CREATE TABLE `adherent` (
  `num` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adherent`
--

INSERT INTO `adherent` (`num`, `nom`, `prenom`, `email`) VALUES
('A001', 'Duran', 'Lina', 'test@lar'),
('A002', 'Martin', 'Noah', 'noah.martin@sio.example'),
('A003', 'Nguyen', 'Chloé', 'chloe.nguyen@sio.example'),
('A004', 'Fernandez', 'Eliott', 'eliott.fernandez@sio.example'),
('A005', 'Kone', 'Maya', 'maya.kone@sio.example'),
('A006', 'Bernard', 'Yanis', 'yanis.bernard@sio.example');

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `num` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`num`, `nom`, `prenom`, `date_naissance`, `description`) VALUES
('AU001', 'Delannoy', 'Claude', '1950-01-01', 'Auteur de nombreux ouvrages pédagogiques en programmation.'),
('AU002', 'Nebra', 'Mathieu', '1985-08-24', 'Co-fondateur d’OpenClassrooms, vulgarisation web.'),
('AU003', 'Potencier', 'Fabien', '1978-12-31', 'Créateur de Symfony, écosystème PHP.'),
('AU004', 'Martin', 'Robert C.', '1952-12-05', '“Uncle Bob”, pratiques de code propre.'),
('AU005', 'Fowler', 'Martin', '1963-12-18', 'Architecture logicielle, refactoring.'),
('AU006', 'Stroustrup', 'Bjarne', '1950-12-30', 'Créateur du C++; ouvrages de conception.'),
('AU007', 'Tanenbaum', 'Andrew S.', '1944-03-16', 'Systèmes d’exploitation et réseaux.'),
('AU008', 'Géron', 'Aurélien', '1973-01-01', 'Machine Learning appliqué.'),
('AU009', 'Pesquet', 'Baptiste', NULL, 'Développeur et pédagogue web.'),
('AU010', 'Roques', 'Pascal', NULL, 'UML et modélisation.'),
('AU011', 'Meyer', 'Bertrand', '1950-11-21', 'Qualité logicielle, Design by Contract.');

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

CREATE TABLE `livre` (
  `ISBN` varchar(20) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `prix` float NOT NULL,
  `adherent` varchar(20) DEFAULT NULL,
  `auteur` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `livre`
--

INSERT INTO `livre` (`ISBN`, `titre`, `prix`, `adherent`, `auteur`) VALUES
('1111112002146', 'Comment tuer un éceureil', 22.1, NULL, NULL),
('9782210000001', 'Java pour BTS SIO SLAM (Java 17)', 39.9, 'A001', 'AU001'),
('9782210000002', 'Algorithmique en Java – 120 exercices corrigés', 34.5, NULL, 'AU001'),
('9782210000003', 'Développement Web : HTML/CSS/JS pour SIO', 32, 'A003', 'AU009'),
('9782210000004', 'PHP moderne & PDO – POO, MVC et sécurité', 36, NULL, 'AU009'),
('9782210000005', 'MySQL & SQL pour SIO – Requêtes, vues et index', 29.9, 'A002', 'AU001'),
('9782210000006', 'Concevoir une base de données : MERISE → SQL', 31, NULL, 'AU010'),
('9782210000007', 'UML pour les développeurs – du besoin au code', 33, 'A005', 'AU010'),
('9782210000008', 'Symfony 6 – Démarrer et structurer une appli', 42, NULL, 'AU003'),
('9782210000009', 'Clean Code – les bases indispensables', 44, NULL, 'AU004'),
('9782210000010', 'Refactoring – améliorer le design du code existant', 47, NULL, 'AU005'),
('9782210000011', 'Qualité logicielle & tests unitaires en Java', 35, 'A004', 'AU011'),
('9782210000012', 'Réseaux pour développeurs – l’essentiel SIO', 30, NULL, 'AU007'),
('9782210000013', 'Conception orientée objet – principes SOLID', 38, NULL, 'AU004'),
('9782210000014', 'APIs REST en PHP/Symfony – bonnes pratiques', 41, NULL, 'AU003'),
('9782210000015', 'Introduction au Machine Learning pour dev SIO', 37, 'A006', 'AU008');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`num`),
  ADD UNIQUE KEY `uq_adherent_email` (`email`);

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `fk_livre_auteur` (`auteur`),
  ADD KEY `fk_livre_adherent` (`adherent`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `fk_livre_adherent` FOREIGN KEY (`adherent`) REFERENCES `adherent` (`num`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livre_auteur` FOREIGN KEY (`auteur`) REFERENCES `auteur` (`num`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
