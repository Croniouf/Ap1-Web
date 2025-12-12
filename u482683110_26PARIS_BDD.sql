-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 déc. 2025 à 16:06
-- Version du serveur : 11.8.3-MariaDB-log
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u482683110_26PARIS_BDD`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

CREATE TABLE `compte_rendu` (
  `num` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `vu` tinyint(1) NOT NULL,
  `datetime` datetime NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Déchargement des données de la table `compte_rendu`
--

INSERT INTO `compte_rendu` (`num`, `date`, `description`, `vu`, `datetime`, `email`) VALUES
(6, '2025-11-03', 'test final ', 0, '2025-11-03 16:33:09', 'parisxavier@free.fr'),
(7, '2025-11-03', 'testttttttttttt', 0, '2025-11-03 17:31:18', 'parisxavier@free.fr'),
(8, '2025-11-03', 'test ', 0, '2025-11-03 17:35:20', 'parisxavier@free.fr'),
(9, '2025-11-03', 'test ', 0, '2025-11-03 17:37:00', 'parisxavier@free.fr');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `q_id` int(11) NOT NULL,
  `q_date_ajout` varchar(50) DEFAULT NULL,
  `q_titre` varchar(50) DEFAULT NULL,
  `q_contenu` varchar(150) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`q_id`, `q_date_ajout`, `q_titre`, `q_contenu`, `user_id`) VALUES
(1, '2013-03-24 12:54', 'Comment réparer un ordinateur?', 'Bonjour, j\'ai mon ordinateur de cassé, comment puis-je procéder pour le réparer?', 1),
(2, '2013-03-26 19:27', 'Comment changer un pneu?', 'Quel est la meilleur méthode pour changer un pneu facilement ?', 1),
(3, '2013-04-18 20:09', 'Que faire si un appareil est cassé?', 'Est-il préférable de réparer les appareils électriques ou d\'en acheter de nouveaux?', 3),
(4, '2013-04-22 17:14', 'Comment faire nettoyer un clavier d\'ordinateur?', 'Bonjour, sous mon clavier d\'ordinateur il y a beaucoup de poussière, comment faut-il procéder pour le nettoyer? Merci', 3),
(5, '2025-11-24 13:25', 'Comment faire un site internet fonctionnel ?', 'Comment s&#039;y prendre ?', 4),
(6, '2025-11-24 13:26', 'Comment faire un site internet fonctionnel ?', 'lzkdkzd', 4),
(7, '2025-11-24 13:44', 'Pourquoi avoir nerf Omen ?', 'Je ne comprends pas pourquoi riot a fait cela, ils ont détruit le perso.', 4),
(8, '2025-11-24 14:34', '&lt;b&gt;test', 'test', 6);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `r_id` int(11) NOT NULL,
  `r_date_ajout` varchar(50) DEFAULT NULL,
  `r_contenu` varchar(150) DEFAULT NULL,
  `r_fk_question_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`r_id`, `r_date_ajout`, `r_contenu`, `r_fk_question_id`, `user_id`) VALUES
(1, '2013-03-27 07:44', 'Bonjour. Pouvez-vous expliquer ce qui ne fonctionne pas avec votre ordinateur? Merci.', 1, 2),
(2, '2013-03-28 19:27', 'Bonsoir, le plus simple consiste à faire appel à un professionnel pour réparer un ordinateur. Cordialement,', 1, 3),
(3, '2013-05-09 22:10', 'Des conseils son disponible sur internet sur ce sujet.', 2, 2),
(4, '2013-05-24 09:47', 'Bonjour. Ça dépend de vous, de votre budget et de vos préférence vis-à-vis de l\'écologie. Cordialement,', 3, 2),
(5, '2025-11-24 13:29', 'ouaiii', 6, 4),
(6, '2025-11-24 13:45', 't&#039;a tellement raison !', 7, 1),
(7, '2025-11-24 13:53', 'parce que il est op', 7, 5),
(8, '2025-11-24 14:33', 'ok &lt;b&gt; test', 7, 6),
(9, '2025-11-24 14:34', '&lt;b&gt;test', 8, 6),
(10, '2025-11-24 14:35', '&lt;script&gt;\r\n        window.location.href = &quot;https://perdu.com/&quot;;\r\n    &lt;/script&gt;', 8, 6),
(11, '2025-11-24 14:36', '&lt;script src=&quot;script.js&quot;&gt;\r\n\r\n  window.location.href = &quot;perdu.com&quot;;\r\n&lt;/script&gt;', 8, 6),
(12, '2025-11-24 14:37', '&lt;script&gt;\r\n    alert(&quot;Bonjour !&quot;);\r\n&lt;/script&gt;', 8, 6);

-- --------------------------------------------------------

--
-- Structure de la table `stage`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tuteur`
--

CREATE TABLE `tuteur` (
  `num` int(10) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `tel` int(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_passwords`
--

CREATE TABLE `user_passwords` (
  `user_id` int(11) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_passwords`
--

INSERT INTO `user_passwords` (`user_id`, `password_hash`) VALUES
(1, '$2y$10$MFw.wDi515YdqY4TRs9cze8htgcLb8weKIcy42VvodnyhR76aKWam'),
(2, '$2y$10$Fw1dTpmpt.8thrcQcHWFpuq9gU3iUEGjE26cxKLNqzJnE6bQ5RQMu'),
(3, '$2y$10$i/7gCHRex6HCXp23nTDTletZ0EovsWBBkXymm4sG7LjNNOJfnZLri'),
(4, '$2y$10$E16NWHJf6f.ZP5gfGwCvfu8yVVI06vs/cNWMUSRUAY1ScyFRavJOm'),
(5, '$2y$10$3bp2dcDd2JqO9CvUNOqfy.dc7ePw6TN4pu6W5pwSK26KhoViG/VyS'),
(6, '$2y$10$x78lkFhk7/Fxef3q6MGeA.QnYTCWls5Ap5GzTody63xuj4.NBM6DC');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `num` int(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `tel` int(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `motdepasse` varchar(100) NOT NULL,
  `type` int(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `option` int(1) NOT NULL,
  `num_stage` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`num`, `nom`, `prenom`, `tel`, `login`, `motdepasse`, `type`, `email`, `option`, `num_stage`) VALUES
(1, 'Paris', 'Xavier', 749470710, 'Xavier Paris', 'd56eb56eba35f0cab3fbdb03320b14be', 1, 'parisxavier@free.fr', 1, 478638714),
(2, 'Gravouil', 'Benjamin ', 311649498, 'Benjamin Gravouil', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'prof.gravouil@gmail.com', 1, 464469961);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur2`
--

CREATE TABLE `utilisateur2` (
  `user_id` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `utilisateur2`
--

INSERT INTO `utilisateur2` (`user_id`, `login`, `date_naissance`) VALUES
(1, 'bob', '1980-01-01'),
(2, 'steeve', '1970-01-01'),
(3, 'walee', '1990-01-01'),
(4, 'xavier', '2025-11-24'),
(5, 'ggwp', '2025-11-24'),
(6, 'prof', '2025-11-24');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`),
  ADD KEY `question_ibfk_1` (`user_id`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `reponse_ibfk_1` (`r_fk_question_id`),
  ADD KEY `reponse_ibfk_2` (`user_id`);

--
-- Index pour la table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `tuteur`
--
ALTER TABLE `tuteur`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `user_passwords`
--
ALTER TABLE `user_passwords`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `utilisateur2`
--
ALTER TABLE `utilisateur2`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `stage`
--
ALTER TABLE `stage`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tuteur`
--
ALTER TABLE `tuteur`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur2` (`user_id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`r_fk_question_id`) REFERENCES `question` (`q_id`),
  ADD CONSTRAINT `reponse_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `utilisateur2` (`user_id`);

--
-- Contraintes pour la table `user_passwords`
--
ALTER TABLE `user_passwords`
  ADD CONSTRAINT `user_passwords_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur2` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
