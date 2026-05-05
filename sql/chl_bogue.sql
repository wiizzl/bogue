-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : jeu. 30 avr. 2026 à 07:00
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chl_bogue`
--
CREATE DATABASE IF NOT EXISTS `chl_bogue` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `chl_bogue`;

-- --------------------------------------------------------

--
-- Structure de la table `action_type`
--

CREATE TABLE `action_type` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `action_type`
--

INSERT INTO `action_type` (`id`, `code`, `label`) VALUES
(1, 'STATUS_UPDATE', 'Mise à jour d\'un statut'),
(2, 'TEACHER_UPDATE', 'Mise à jour d\'un enseignant'),
(3, 'DATE_UPDATE', 'Mise à jour des dates');

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `tutor_name` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260316093941', '2026-04-30 06:59:37', 1579);

-- --------------------------------------------------------

--
-- Structure de la table `history_log`
--

CREATE TABLE `history_log` (
  `id` int NOT NULL,
  `old_value` longtext,
  `new_value` longtext,
  `created_at` datetime NOT NULL,
  `action_type_id` int NOT NULL,
  `author_id` int NOT NULL,
  `internship_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `internship`
--

CREATE TABLE `internship` (
  `id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `remarks` longtext,
  `student_id` int NOT NULL,
  `company_id` int NOT NULL,
  `tracking_teacher_id` int DEFAULT NULL,
  `visiting_teacher_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `internship_milestone`
--

CREATE TABLE `internship_milestone` (
  `id` int NOT NULL,
  `validated_at` date DEFAULT NULL,
  `comment` longtext,
  `internship_id` int NOT NULL,
  `status_id` int NOT NULL,
  `milestone_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `major`
--

CREATE TABLE `major` (
  `id` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `major`
--

INSERT INTO `major` (`id`, `code`, `label`) VALUES
(1, 'SLAM', 'Solutions Logicielles et Applications Métier'),
(2, 'SISR', 'Solutions d\'Infrastructure, Systèmes et Réseaux');

-- --------------------------------------------------------

--
-- Structure de la table `milestone`
--

CREATE TABLE `milestone` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `milestone`
--

INSERT INTO `milestone` (`id`, `code`, `label`) VALUES
(1, 'THANK_YOU', 'Remerciement'),
(2, 'REPORT', 'Bilan'),
(3, 'JURY', 'Jury'),
(4, 'CERTIFICATE', 'Attestation');

-- --------------------------------------------------------

--
-- Structure de la table `milestone_status`
--

CREATE TABLE `milestone_status` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `milestone_status`
--

INSERT INTO `milestone_status` (`id`, `code`, `label`) VALUES
(1, 'OK', 'Validé'),
(2, 'NOK', 'Non validé'),
(3, 'PENDING', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id` int NOT NULL,
  `year` int NOT NULL,
  `is_archived` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id`, `year`, `is_archived`) VALUES
(1, 2026, 0),
(2, 2027, 0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `label`, `code`) VALUES
(1, 'Administrateur', 'ROLE_ADMIN'),
(2, 'Enseignant', 'ROLE_TEACHER'),
(3, 'Secrétariat', 'ROLE_SECRETARY');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `major_id` int NOT NULL,
  `promotion_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `role_id`) VALUES
(1, 'bocba@cba.fr', '$2y$13$x7QU4jJ3VQo92kwLzADe5.8ccglLG503eW2NXp9yvAY/ohSWf8Pqe', 'Back', 'Office', 1),
(2, 'focba@cba.fr', '$2y$13$f6i5bj/19BAs890zNARlGuqJ.GCs6ZxAAu0nNjG5kU9d9UZM0kG9i', 'Front', 'Office', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `action_type`
--
ALTER TABLE `action_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6190350A1FEE0472` (`action_type_id`),
  ADD KEY `IDX_6190350AF675F31B` (`author_id`),
  ADD KEY `IDX_6190350A7A4A70BE` (`internship_id`),
  ADD KEY `idx_history_internship_date` (`internship_id`,`created_at`),
  ADD KEY `idx_history_author_date` (`author_id`,`created_at`);

--
-- Index pour la table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_10D1B00C979B1AD6` (`company_id`),
  ADD KEY `IDX_10D1B00C3C0AC0DC` (`tracking_teacher_id`),
  ADD KEY `IDX_10D1B00CBCFE061F` (`visiting_teacher_id`),
  ADD KEY `idx_internship_teachers` (`tracking_teacher_id`,`visiting_teacher_id`),
  ADD KEY `idx_internship_student` (`student_id`),
  ADD KEY `idx_internship_dates` (`start_date`,`end_date`);

--
-- Index pour la table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_internship_milestone_pair` (`internship_id`,`milestone_id`),
  ADD KEY `IDX_FD01E8C07A4A70BE` (`internship_id`),
  ADD KEY `IDX_FD01E8C06BF700BD` (`status_id`),
  ADD KEY `IDX_FD01E8C04B3E2EDA` (`milestone_id`);

--
-- Index pour la table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `milestone`
--
ALTER TABLE `milestone`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `milestone_status`
--
ALTER TABLE `milestone_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B723AF33E93695C7` (`major_id`),
  ADD KEY `IDX_B723AF33139DF194` (`promotion_id`),
  ADD KEY `idx_student_promotion_major` (`promotion_id`,`major_id`),
  ADD KEY `idx_student_name` (`last_name`,`first_name`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  ADD KEY `IDX_8D93D649D60322AC` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action_type`
--
ALTER TABLE `action_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `internship`
--
ALTER TABLE `internship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `major`
--
ALTER TABLE `major`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `milestone`
--
ALTER TABLE `milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `milestone_status`
--
ALTER TABLE `milestone_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `history_log`
--
ALTER TABLE `history_log`
  ADD CONSTRAINT `FK_6190350A1FEE0472` FOREIGN KEY (`action_type_id`) REFERENCES `action_type` (`id`),
  ADD CONSTRAINT `FK_6190350A7A4A70BE` FOREIGN KEY (`internship_id`) REFERENCES `internship` (`id`),
  ADD CONSTRAINT `FK_6190350AF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `FK_10D1B00C3C0AC0DC` FOREIGN KEY (`tracking_teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10D1B00C979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_10D1B00CBCFE061F` FOREIGN KEY (`visiting_teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10D1B00CCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  ADD CONSTRAINT `FK_FD01E8C04B3E2EDA` FOREIGN KEY (`milestone_id`) REFERENCES `milestone` (`id`),
  ADD CONSTRAINT `FK_FD01E8C06BF700BD` FOREIGN KEY (`status_id`) REFERENCES `milestone_status` (`id`),
  ADD CONSTRAINT `FK_FD01E8C07A4A70BE` FOREIGN KEY (`internship_id`) REFERENCES `internship` (`id`);

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF33139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`),
  ADD CONSTRAINT `FK_B723AF33E93695C7` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
