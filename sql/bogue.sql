-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : ven. 13 mars 2026 à 10:43
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
-- Base de données : `bogue`
--
CREATE DATABASE IF NOT EXISTS `bogue` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `bogue`;

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
(2, 'TEACHER_UPDATE', 'Mise à jour d\'un enseignant');

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
  `contact_name` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `zip_code`, `city`, `contact_name`, `phone`, `email`) VALUES
(1, 'Lefebvre et Fils', '88, rue de Langlois', '19805', 'Raynaud-les-Bains', 'Suzanne Guillet', '+33 (0)1 49 31 39 25', 'matthieu.vasseur@martineau.com'),
(2, 'Gonzalez SA', '3, chemin Guy Petitjean', '28516', 'DupreVille', 'Roger Leblanc', '+33 (0)1 43 07 30 59', 'marion.brigitte@delattre.fr'),
(3, 'Lelievre', '5, rue de Didier', '96678', 'Loiseau-les-Bains', 'François Renaud', '09 63 63 66 78', 'mmorel@bernier.org'),
(4, 'Paris', '56, rue de Charles', '53575', 'Bruneau', 'Éléonore Carre-Fernandez', '+33 (0)4 52 08 84 78', 'pires.gerard@mary.fr'),
(5, 'Fournier', '909, rue de Ledoux', '76642', 'Regnier-les-Bains', 'Charles Guibert', '0156754240', 'xavier38@descamps.fr'),
(6, 'Couturier et Fils', '86, rue Gaudin', '17274', 'Chartier', 'Aurore Bourdon', '+33 4 15 63 60 77', 'gregoire.michel@gilbert.fr'),
(7, 'Morin Guerin et Fils', '24, rue de Brunel', '48109', 'De Oliveira', 'Aurore Breton', '08 98 08 34 46', 'alesage@fleury.com'),
(8, 'Huet Martel SA', '468, impasse Céline Ruiz', '43214', 'Camus-sur-Barbier', 'Joseph Guyot', '+33 (0)3 25 08 72 82', 'robert.rossi@breton.fr'),
(9, 'Faivre', '804, boulevard Franck Pierre', '75345', 'Dumas-sur-Dos Santos', 'Catherine Cordier', '+33 4 07 00 91 21', 'guibert.christophe@rodrigues.com'),
(10, 'Traore', '83, impasse Thibault Vaillant', '93268', 'Maurice-sur-Mer', 'Frédérique Chauvet', '0130650013', 'ylebon@leconte.com'),
(11, 'Riviere Jacquot et Fils', '45, chemin Élodie Alves', '09835', 'Leduc', 'Hugues Martin', '+33 3 05 21 86 06', 'benjamin21@guilbert.org'),
(12, 'Guyot', '8, chemin Christine Delmas', '15129', 'Launaydan', 'Céline Baudry', '+33 (0)4 72 72 73 33', 'gomes.franck@nicolas.net'),
(13, 'Diallo', 'rue de Leroux', '41447', 'Morvannec', 'Marine du Brunel', '05 12 97 28 50', 'plelievre@rolland.com'),
(14, 'Hernandez', 'boulevard de Bazin', '16053', 'Martel', 'Philippe Pages', '+33 (0)6 52 14 36 57', 'richard.gilbert@lemoine.com'),
(15, 'Millet', '96, boulevard Grondin', '00198', 'CousinBourg', 'Arnaude-Manon Boucher', '+33 (0)8 12 81 37 97', 'patrick.camus@collet.fr'),
(16, 'Perrin', 'chemin Simone Francois', '69124', 'Foucher', 'Jérôme Carre-Lebreton', '+33 6 31 84 79 01', 'imbert.elise@pascal.fr'),
(17, 'Auger Devaux S.A.S.', '14, rue Aubert', '59681', 'Petit', 'Richard du Costa', '+33 6 34 82 53 53', 'eleonore06@lamy.com'),
(18, 'Mahe', '34, rue Maurice Chevallier', '74692', 'Durandnec', 'Pénélope du Mahe', '+33 (0)5 38 43 06 71', 'esamson@gosselin.net'),
(19, 'Leconte Olivier S.A.S.', '78, impasse de Bouvet', '34159', 'Richard', 'Cécile Blondel', '0985563477', 'gchauvet@sanchez.com'),
(20, 'Seguin', '602, boulevard Laetitia Valette', '47759', 'Renard', 'Michelle Bonnin', '05 08 56 86 87', 'bertrand77@raynaud.fr'),
(21, 'Leroux', '31, place Meyer', '44467', 'Lagarde', 'Anouk Navarro', '+33 (0)2 54 04 45 94', 'claire.guichard@lelievre.fr'),
(22, 'Ferrand', '6, chemin de Guillon', '49034', 'Foucher', 'Corinne Lacombe', '0305159390', 'alain.mercier@besnard.fr'),
(23, 'Lacroix S.A.R.L.', '797, place de Rossi', '84350', 'Gauthier', 'Henriette Bonnin-Goncalves', '0271029225', 'vlemaire@lefevre.fr'),
(24, 'Leconte', '80, boulevard Franck Humbert', '58067', 'Guichard-les-Bains', 'Emmanuelle Monnier', '+33 (0)3 61 61 19 30', 'iperrin@noel.net'),
(25, 'Lamy Valentin SARL', '53, rue Marguerite Schmitt', '72053', 'Regniernec', 'Virginie Legros-Perez', '03 73 82 98 08', 'raymond.garnier@guerin.net'),
(26, 'Weiss S.A.', '74, place Briand', '68570', 'Lecomte', 'Margaux Moreau', '09 43 86 16 82', 'moulin.thomas@tanguy.fr'),
(27, 'Aubry', '3, rue Arthur Laine', '28331', 'Maury', 'Patrick Maillard', '+33 (0)2 79 61 32 59', 'marc.leger@berthelot.com'),
(28, 'Camus Pelletier SAS', '60, boulevard de Joly', '80926', 'Hoareau', 'Marcel Poulain', '+33 (0)3 04 25 86 71', 'kmace@georges.com'),
(29, 'Le Goff', 'place Bernier', '19286', 'Reydan', 'Étienne Marques', '+33 (0)2 65 73 62 50', 'laetitia48@godard.net'),
(30, 'Fischer et Fils', '79, chemin Duhamel', '02458', 'Baudrydan', 'Léon Levy', '02 86 22 31 39', 'andree.boucher@petit.com');

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
('DoctrineMigrations\\Version20260313103225', '2026-03-13 10:32:34', 3811);

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

--
-- Déchargement des données de la table `internship`
--

INSERT INTO `internship` (`id`, `start_date`, `end_date`, `remarks`, `student_id`, `company_id`, `tracking_teacher_id`, `visiting_teacher_id`) VALUES
(1, '2026-01-14', '2026-02-25', NULL, 1, 3, 6, 7),
(2, '2026-01-26', '2026-03-09', NULL, 2, 6, 5, 3),
(3, '2026-01-27', '2026-03-10', NULL, 3, 26, 6, 9),
(4, '2026-01-13', '2026-02-24', NULL, 4, 20, 8, 3),
(5, '2026-01-12', '2026-02-23', NULL, 5, 20, 8, 5),
(6, '2026-01-23', '2026-03-06', NULL, 6, 14, 8, 7),
(7, '2026-01-04', '2026-02-15', NULL, 7, 5, 8, 12),
(8, '2026-01-06', '2026-02-17', NULL, 8, 25, 8, 4),
(9, '2026-01-10', '2026-02-21', NULL, 9, 29, 8, 4),
(10, '2026-01-21', '2026-03-04', NULL, 10, 21, 4, 7),
(11, '2026-01-23', '2026-03-06', NULL, 11, 25, 4, 5),
(12, '2026-01-31', '2026-03-14', NULL, 12, 19, 7, 11),
(13, '2026-01-19', '2026-03-02', NULL, 13, 5, 12, 8),
(14, '2026-01-08', '2026-02-19', NULL, 14, 25, 9, 8),
(15, '2026-01-31', '2026-03-14', NULL, 15, 14, 3, 3),
(16, '2026-01-22', '2026-03-05', NULL, 16, 20, 7, 9),
(17, '2026-01-02', '2026-02-13', NULL, 17, 23, 4, 10),
(18, '2026-01-28', '2026-03-11', NULL, 18, 11, 11, 3),
(19, '2026-01-28', '2026-03-11', NULL, 19, 25, 7, 5),
(20, '2026-01-24', '2026-03-07', NULL, 20, 1, 7, 7),
(21, '2026-01-08', '2026-02-19', NULL, 21, 7, 11, 3),
(22, '2026-01-05', '2026-02-16', NULL, 22, 26, 3, 4),
(23, '2026-01-24', '2026-03-07', NULL, 23, 16, 11, 11),
(24, '2026-01-20', '2026-03-03', NULL, 24, 10, 9, 10),
(25, '2026-01-13', '2026-02-24', NULL, 25, 22, 12, 5),
(26, '2026-01-10', '2026-02-21', NULL, 26, 21, 7, 3),
(27, '2026-01-21', '2026-03-04', NULL, 27, 17, 11, 10),
(28, '2026-01-09', '2026-02-20', NULL, 28, 30, 8, 7),
(29, '2026-01-09', '2026-02-20', NULL, 29, 14, 7, 12),
(30, '2026-01-29', '2026-03-12', NULL, 30, 5, 7, 8),
(31, '2026-01-12', '2026-02-23', NULL, 31, 5, 6, 7),
(32, '2026-01-21', '2026-03-04', NULL, 32, 8, 6, 4),
(33, '2026-01-29', '2026-03-12', NULL, 33, 8, 8, 12),
(34, '2026-01-12', '2026-02-23', NULL, 34, 10, 5, 5),
(35, '2026-01-24', '2026-03-07', NULL, 35, 7, 9, 4),
(36, '2026-01-13', '2026-02-24', NULL, 36, 6, 12, 5),
(37, '2026-01-24', '2026-03-07', NULL, 37, 21, 5, 5),
(38, '2026-01-09', '2026-02-20', NULL, 38, 16, 6, 11),
(39, '2026-01-30', '2026-03-13', NULL, 39, 29, 5, 11),
(40, '2026-01-02', '2026-02-13', NULL, 40, 19, 9, 9);

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

--
-- Déchargement des données de la table `internship_milestone`
--

INSERT INTO `internship_milestone` (`id`, `validated_at`, `comment`, `internship_id`, `status_id`, `milestone_id`) VALUES
(1, NULL, NULL, 1, 2, 1),
(2, NULL, NULL, 1, 2, 3),
(3, NULL, NULL, 1, 3, 4),
(4, NULL, NULL, 2, 2, 1),
(5, NULL, NULL, 2, 1, 2),
(6, NULL, NULL, 2, 2, 4),
(7, NULL, NULL, 3, 2, 2),
(8, NULL, NULL, 3, 3, 4),
(9, NULL, NULL, 4, 1, 1),
(10, NULL, NULL, 4, 3, 2),
(11, NULL, NULL, 4, 1, 4),
(12, NULL, NULL, 5, 1, 1),
(13, NULL, NULL, 5, 2, 2),
(14, NULL, NULL, 5, 2, 3),
(15, NULL, NULL, 5, 2, 4),
(16, NULL, NULL, 6, 3, 2),
(17, NULL, NULL, 6, 3, 4),
(18, NULL, NULL, 7, 3, 2),
(19, NULL, NULL, 8, 1, 1),
(20, NULL, NULL, 8, 1, 2),
(21, NULL, NULL, 8, 1, 4),
(22, NULL, NULL, 9, 3, 2),
(23, NULL, NULL, 9, 3, 3),
(24, NULL, NULL, 9, 1, 4),
(25, NULL, NULL, 10, 3, 1),
(26, NULL, NULL, 10, 3, 2),
(27, NULL, NULL, 10, 2, 3),
(28, NULL, NULL, 10, 2, 4),
(29, NULL, NULL, 11, 3, 1),
(30, NULL, NULL, 11, 1, 2),
(31, NULL, NULL, 11, 1, 3),
(32, NULL, NULL, 11, 2, 4),
(33, NULL, NULL, 12, 1, 1),
(34, NULL, NULL, 12, 3, 2),
(35, NULL, NULL, 12, 3, 3),
(36, NULL, NULL, 12, 2, 4),
(37, NULL, NULL, 13, 2, 1),
(38, NULL, NULL, 13, 3, 3),
(39, NULL, NULL, 13, 3, 4),
(40, NULL, NULL, 14, 3, 1),
(41, NULL, NULL, 14, 2, 3),
(42, NULL, NULL, 14, 2, 4),
(43, NULL, NULL, 15, 1, 1),
(44, NULL, NULL, 15, 2, 2),
(45, NULL, NULL, 15, 1, 4),
(46, NULL, NULL, 16, 3, 3),
(47, NULL, NULL, 16, 2, 4),
(48, NULL, NULL, 17, 2, 1),
(49, NULL, NULL, 17, 1, 2),
(50, NULL, NULL, 17, 2, 3),
(51, NULL, NULL, 17, 1, 4),
(52, NULL, NULL, 18, 3, 1),
(53, NULL, NULL, 18, 3, 2),
(54, NULL, NULL, 18, 2, 4),
(55, NULL, NULL, 19, 3, 1),
(56, NULL, NULL, 19, 3, 2),
(57, NULL, NULL, 19, 3, 4),
(58, NULL, NULL, 20, 2, 1),
(59, NULL, NULL, 20, 3, 2),
(60, NULL, NULL, 20, 3, 3),
(61, NULL, NULL, 20, 3, 4),
(62, NULL, NULL, 21, 1, 1),
(63, NULL, NULL, 21, 1, 2),
(64, NULL, NULL, 21, 1, 4),
(65, NULL, NULL, 22, 1, 1),
(66, NULL, NULL, 22, 3, 3),
(67, NULL, NULL, 22, 1, 4),
(68, NULL, NULL, 23, 2, 1),
(69, NULL, NULL, 23, 2, 3),
(70, NULL, NULL, 23, 3, 4),
(71, NULL, NULL, 24, 2, 3),
(72, NULL, NULL, 24, 1, 4),
(73, NULL, NULL, 25, 1, 3),
(74, NULL, NULL, 25, 2, 4),
(75, NULL, NULL, 26, 3, 2),
(76, NULL, NULL, 26, 2, 3),
(77, NULL, NULL, 26, 1, 4),
(78, NULL, NULL, 27, 3, 1),
(79, NULL, NULL, 27, 2, 2),
(80, NULL, NULL, 27, 2, 3),
(81, NULL, NULL, 28, 2, 1),
(82, NULL, NULL, 28, 3, 2),
(83, NULL, NULL, 28, 1, 3),
(84, NULL, NULL, 28, 3, 4),
(85, NULL, NULL, 29, 2, 2),
(86, NULL, NULL, 29, 1, 3),
(87, NULL, NULL, 30, 3, 1),
(88, NULL, NULL, 30, 1, 2),
(89, NULL, NULL, 30, 2, 3),
(90, NULL, NULL, 30, 1, 4),
(91, NULL, NULL, 31, 2, 1),
(92, NULL, NULL, 32, 1, 1),
(93, NULL, NULL, 32, 2, 2),
(94, NULL, NULL, 32, 3, 3),
(95, NULL, NULL, 32, 3, 4),
(96, NULL, NULL, 33, 1, 1),
(97, NULL, NULL, 33, 1, 2),
(98, NULL, NULL, 33, 3, 4),
(99, NULL, NULL, 34, 1, 1),
(100, NULL, NULL, 34, 1, 3),
(101, NULL, NULL, 34, 3, 4),
(102, NULL, NULL, 35, 3, 2),
(103, NULL, NULL, 35, 2, 4),
(104, NULL, NULL, 36, 1, 2),
(105, NULL, NULL, 36, 2, 4),
(106, NULL, NULL, 37, 3, 1),
(107, NULL, NULL, 37, 2, 2),
(108, NULL, NULL, 37, 3, 3),
(109, NULL, NULL, 38, 3, 2),
(110, NULL, NULL, 38, 3, 3),
(111, NULL, NULL, 38, 1, 4),
(112, NULL, NULL, 39, 2, 1),
(113, NULL, NULL, 39, 1, 2),
(114, NULL, NULL, 39, 1, 3),
(115, NULL, NULL, 40, 1, 3),
(116, NULL, NULL, 40, 1, 4);

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
(1, 'THANK_YOU_LETTER', 'Remerciement'),
(2, 'REPORT', 'Bilan / Suivi'),
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
(2, 2025, 1);

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

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `major_id`, `promotion_id`) VALUES
(1, 'Laurence', 'Barre', 1, 2),
(2, 'Suzanne', 'Guillon', 1, 2),
(3, 'Margaux', 'Faivre', 1, 2),
(4, 'Marguerite', 'Lebon', 1, 2),
(5, 'Nicole', 'Delaunay', 2, 1),
(6, 'Maggie', 'Maillet', 2, 2),
(7, 'René', 'Rossi', 1, 2),
(8, 'Françoise', 'Chretien', 1, 2),
(9, 'Audrey', 'Goncalves', 1, 2),
(10, 'Alexandria', 'Marie', 2, 2),
(11, 'Hélène', 'Bourdon', 1, 2),
(12, 'Suzanne', 'Hoareau', 1, 2),
(13, 'Théophile', 'Collin', 1, 2),
(14, 'Madeleine', 'Techer', 2, 2),
(15, 'Marguerite', 'Baudry', 2, 1),
(16, 'Étienne', 'Chauvin', 1, 2),
(17, 'Laurence', 'Aubry', 1, 2),
(18, 'Gabriel', 'Auger', 1, 1),
(19, 'Noémi', 'Fournier', 1, 1),
(20, 'Laure', 'Evrard', 1, 1),
(21, 'Émile', 'Becker', 2, 1),
(22, 'Alfred', 'Diaz', 2, 2),
(23, 'Jean', 'Pinto', 1, 2),
(24, 'Pierre', 'Charrier', 1, 1),
(25, 'Paul', 'Pruvost', 2, 2),
(26, 'Maurice', 'Renard', 2, 1),
(27, 'Jean', 'Colin', 1, 2),
(28, 'Zoé', 'Pineau', 2, 1),
(29, 'Laurent', 'Pons', 1, 2),
(30, 'Margot', 'Leveque', 2, 1),
(31, 'Élise', 'Dumont', 1, 2),
(32, 'Auguste', 'Adam', 1, 2),
(33, 'Laurence', 'Robert', 1, 2),
(34, 'Patrick', 'Berthelot', 1, 1),
(35, 'Arthur', 'Roussel', 2, 2),
(36, 'Marianne', 'Martel', 2, 2),
(37, 'Alexandre', 'Rolland', 2, 2),
(38, 'Inès', 'Fabre', 1, 1),
(39, 'Emmanuel', 'Letellier', 1, 2),
(40, 'Auguste', 'Gregoire', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`) VALUES
(1, 'admin@campus-la-chataigneraie.org', '$2y$13$74TO7Fqlr3BKVsD0w6xdwenimZJssR7fNBgvETTwvyetKK/ulr3yG', 'Admin', 'Lycée'),
(2, 'secretaire@campus-la-chataigneraie.org', '$2y$13$qJugmpYYx4RJSfLsWPQ/oOBnuqj7tZhUfPk8exNgRwoRd791mBdRm', 'Secrétaire', 'Lycée'),
(3, 'catherine.baranger@campus-la-chataigneraie.org', '$2y$13$9u7xis8fJ1kWwmTUVa/W1O1yJjKbMs.C1d0mfvJ/jhAN2Lj4Pm0y.', 'Catherine', 'Baranger'),
(4, 'rejane.boursier@campus-la-chataigneraie.org', '$2y$13$roWCHOB/v1b2gOa7/cqLVuqbqZ4nc6giEEWSWFIk.ngBwKaEpGqZi', 'Réjane', 'Boursier'),
(5, 'sandrine.ternisien@campus-la-chataigneraie.org', '$2y$13$Hr7lN82JBaFGU06pOIiEUOqY5QppzrrMw7afp3zArSdK7C/wMToIq', 'Sandrine', 'Ternisien'),
(6, 'nathalie.grandin@campus-la-chataigneraie.org', '$2y$13$2aVHu6Gx8zjaITbWpLVh3uuEqofCNfmhFCRLq5HzEF8QJmAlBRqdK', 'Nathalie', 'Grandin'),
(7, 'marie.serrault@campus-la-chataigneraie.org', '$2y$13$rmL70uB/AhiDpBZDaqs7wuFtUiunmv/O8IAuK77Fv1.WwxHmg/5uy', 'Marie', 'Serrault'),
(8, 'christophe.baudoux@campus-la-chataigneraie.org', '$2y$13$sppa6nNgH0.J.w0eLJ/D9eVpdxB6wWBuiFalY0ALHvwdNHhm4hBuC', 'Christophe', 'Baudoux'),
(9, 'antoine.bloyet@campus-la-chataigneraie.org', '$2y$13$DA5h7jVtFO1lvrX/KpR5MO.31/3jEER4yaXdmPZaCaYYxJmlbJX2i', 'Antoine', 'Bloyet'),
(10, 'kevin.bayeul@campus-la-chataigneraie.org', '$2y$13$RpsOFkLn0Hph8yWGLL4V2O.ZgkiaJYzafx3UxdcDkzRK/P/N6gsUi', 'Kévin', 'Bayeul'),
(11, 'laurent.maurice@campus-la-chataigneraie.org', '$2y$13$jJU/uAvlSgUmkhATCWmPXee0mjLqzXTa6nwjYSE/HVUpK4dMilAQG', 'Laurent', 'Maurice'),
(12, 'robin.szylobryt@campus-la-chataigneraie.org', '$2y$13$7UOZe9coVd7Or..0keVQde2VAQriD4Cs7ZaFDyniXpht0jDHrTMBm', 'Robin', 'Szylobryt');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 3),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2);

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
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  ADD KEY `IDX_2DE8C6A3D60322AC` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action_type`
--
ALTER TABLE `action_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `internship`
--
ALTER TABLE `internship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
