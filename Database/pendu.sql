-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 12 nov. 2026 à 12:21
-- Version du serveur : 8.0.44
-- Version de PHP : 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pendu`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `word_id` int NOT NULL,
  `difficulty` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` int NOT NULL,
  `victory` tinyint(1) NOT NULL,
  `points` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `words`
--

CREATE TABLE `words` (
  `id` int NOT NULL,
  `word` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `difficulty` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `words`
--

INSERT INTO `words` (`id`, `word`, `difficulty`) VALUES
(1, 'MAISON', 'easy'),
(2, 'JARDIN', 'easy'),
(3, 'CHAISE', 'easy'),
(4, 'POMME', 'easy'),
(5, 'TABLE', 'easy'),
(6, 'LAPIN', 'easy'),
(7, 'CHEVAL', 'easy'),
(8, 'BATEAU', 'easy'),
(9, 'NUAGE', 'easy'),
(10, 'FLEUR', 'easy'),
(11, 'ORANGE', 'easy'),
(12, 'SOURIS', 'easy'),
(13, 'CITRON', 'easy'),
(14, 'POISSON', 'easy'),
(15, 'BALLON', 'easy'),
(16, 'CAROTTE', 'easy'),
(17, 'MOUTON', 'easy'),
(18, 'LIVRE', 'easy'),
(19, 'TIGRE', 'easy'),
(20, 'PIANO', 'easy'),
(21, 'CROCODILE', 'medium'),
(22, 'PAPILLON', 'medium'),
(23, 'TOURNESOL', 'medium'),
(24, 'CHOCOLAT', 'medium'),
(25, 'MONTAGNE', 'medium'),
(26, 'PARAPLUIE', 'medium'),
(27, 'DAUPHIN', 'medium'),
(28, 'KANGOUROU', 'medium'),
(29, 'GIRAFE', 'medium'),
(30, 'AVOCAT', 'medium'),
(31, 'CARTABLE', 'medium'),
(32, 'TELEPHONE', 'medium'),
(33, 'VOITURE', 'medium'),
(34, 'PINGOUIN', 'medium'),
(35, 'TRAMPOLINE', 'medium'),
(36, 'ESCARGOT', 'medium'),
(37, 'BOUTEILLE', 'medium'),
(38, 'CHAMPIGNON', 'medium'),
(39, 'MANDARINE', 'medium'),
(40, 'SERPENT', 'medium'),
(41, 'XYLOPHONE', 'hard'),
(42, 'JUKEBOX', 'hard'),
(43, 'ZEPHYR', 'hard'),
(44, 'QUARTZ', 'hard'),
(45, 'SPHINX', 'hard'),
(46, 'LABYRINTHE', 'hard'),
(47, 'ANTICONSTITUTIONNELLEMENT', 'hard'),
(48, 'HIPPOPOTAME', 'hard'),
(49, 'PHOTOSYNTHESE', 'hard'),
(50, 'BYZANTIN', 'hard'),
(51, 'GYMNASE', 'hard'),
(52, 'OXYGENE', 'hard'),
(53, 'JACUZZI', 'hard'),
(54, 'ZIGZAG', 'hard'),
(55, 'RYTHME', 'hard'),
(56, 'FJORD', 'hard'),
(57, 'BLIZZARD', 'hard'),
(58, 'SAXOPHONE', 'hard'),
(59, 'KAYAK', 'hard'),
(60, 'WAGON', 'hard');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `word` (`word`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `words`
--
ALTER TABLE `words`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
