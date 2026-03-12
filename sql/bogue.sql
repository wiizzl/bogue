-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Mar 12, 2026 at 07:12 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bogue`
--
CREATE DATABASE IF NOT EXISTS `bogue` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `bogue`;

-- --------------------------------------------------------

--
-- Table structure for table `action_type`
--

CREATE TABLE `action_type` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `action_type`
--

INSERT INTO `action_type` (`id`, `code`, `label`) VALUES
(1, 'STATUS_UPDATE', 'Mise à jour d\'un statut');

-- --------------------------------------------------------

--
-- Table structure for table `company`
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
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `zip_code`, `city`, `contact_name`, `phone`, `email`) VALUES
(1, 'Louis S.A.R.L.', '26, chemin Nicole Lemonnier', '71793', 'Lacombe', 'Adrien Boulanger', '04 84 86 71 05', 'ibertrand@hoarau.net'),
(2, 'Didier', '96, rue Thibault Ruiz', '66827', 'Tessier', 'Gabrielle-Pénélope Bourgeois', '+33 4 75 88 30 44', 'laure.ferrand@maillard.org'),
(3, 'Lebrun', 'place Texier', '95637', 'Rolland-la-Forêt', 'Laurence-Margaux Lombard', '+33 8 99 95 72 99', 'ecousin@bouchet.fr'),
(4, 'Richard S.A.R.L.', '94, chemin Hamel', '23572', 'Imbert-la-Forêt', 'Sophie Laine', '+33 (0)1 01 89 89 88', 'susanne.mace@fabre.fr'),
(5, 'Petitjean Hamel S.A.R.L.', '46, rue Charles Alves', '00226', 'Schneider-sur-Mer', 'Xavier Chevalier-Lambert', '+33 (0)9 06 37 52 28', 'uduhamel@dacosta.fr'),
(6, 'Letellier SARL', '62, avenue Hoarau', '50322', 'Guyon', 'Émile Bertrand', '+33 3 74 62 58 52', 'graynaud@coulon.net'),
(7, 'Courtois', '9, boulevard de Pruvost', '65339', 'Hamonnec', 'Guy-Xavier Pasquier', '06 31 50 45 10', 'bourgeois.louise@dupuis.com'),
(8, 'Etienne SA', '18, rue Thibaut Barthelemy', '11580', 'Dupont', 'Thibaut Marchand', '05 43 14 75 70', 'bpons@germain.com'),
(9, 'Roche', '98, boulevard Laurent Costa', '30328', 'DumasBourg', 'Éric Coste-Becker', '+33 3 65 53 63 29', 'carre.emmanuel@bouchet.fr'),
(10, 'Gimenez et Fils', '76, impasse Guillaume Jacques', '13937', 'Tessier', 'Jeanne Rossi', '+33 2 56 73 02 41', 'christelle.martinez@gilbert.com'),
(11, 'Germain', '243, boulevard Susanne Martins', '41763', 'Hubert-sur-Mer', 'Laurent de la Daniel', '01 28 89 22 37', 'fleury.julie@bonneau.fr'),
(12, 'Perrin', '6, rue de Merle', '01094', 'Herve', 'Maurice Boucher', '+33 (0)8 14 68 92 98', 'laure79@simon.fr'),
(13, 'Devaux', '273, boulevard Dupont', '61549', 'Dupuis-sur-Mer', 'Joseph Le Noel', '07 86 33 20 93', 'martin.bertrand@boulay.com'),
(14, 'Chevalier Moulin SA', 'rue Godard', '87736', 'CourtoisBourg', 'Isaac Louis', '+33 (0)1 73 32 98 25', 'henri.delattre@monnier.com'),
(15, 'Pruvost', '380, avenue William Moreau', '85882', 'Martin-sur-Mer', 'Roger Poirier', '+33 8 20 05 23 07', 'maillard.andre@hoareau.net'),
(16, 'Leroy SA', '10, impasse de Louis', '27382', 'Traore', 'Thibaut Jacquet', '+33 3 84 09 66 85', 'zroger@lebrun.fr'),
(17, 'Collin S.A.R.L.', '489, place Bodin', '01354', 'Pereira-sur-Legrand', 'Renée Albert', '01 70 81 50 46', 'rbazin@daniel.org'),
(18, 'Didier', '806, avenue de Blin', '39192', 'Colas-sur-Mer', 'Victoire Laporte', '02 16 45 68 93', 'anouk17@vallet.org'),
(19, 'Antoine', 'boulevard Valentine Boulanger', '70988', 'EtienneBourg', 'Cécile Perret', '+33 7 89 44 00 17', 'paul.aurore@guerin.org'),
(20, 'Vaillant SA', '382, rue Marine Weber', '52023', 'Boucher', 'Maggie Blondel-Charpentier', '05 15 15 50 65', 'luc62@goncalves.com'),
(21, 'Chauvin SAS', '12, chemin Tristan Lefebvre', '14793', 'De Sousa-les-Bains', 'Olivie Rousseau', '02 98 57 06 80', 'marchal.alain@leduc.fr'),
(22, 'Fischer', '336, place Guillaume Aubry', '62599', 'Humbert-la-Forêt', 'Eugène Denis', '09 20 50 13 13', 'constance.dias@pires.fr'),
(23, 'Faivre', '831, boulevard de Ferrand', '59750', 'Diallo', 'Audrey Hamel-Laurent', '+33 (0)9 80 02 99 06', 'marcel61@langlois.fr'),
(24, 'Leroux', '54, boulevard de Gimenez', '16714', 'Raynaud-sur-Mer', 'Nathalie Ferrand', '+33 3 62 74 17 75', 'nicole.ruiz@lefort.com'),
(25, 'Marie SA', '22, avenue Adèle Bertin', '24168', 'CohenVille', 'Agnès-Susan Peron', '+33 1 10 22 02 82', 'pruvost.adrien@meunier.com'),
(26, 'Coulon', '562, place Perrin', '36941', 'Pruvost', 'Paulette Benard', '+33 1 34 29 09 97', 'franck.mallet@bonnet.com'),
(27, 'Michaud', '58, rue Édouard Reynaud', '11787', 'Gallet', 'Lorraine Lucas', '09 12 77 52 18', 'ines56@didier.com'),
(28, 'Caron Descamps SARL', '19, impasse de Delannoy', '50828', 'Blondel', 'Célina Leclercq', '01 64 55 04 82', 'manon.masse@hernandez.org'),
(29, 'Merle', '55, rue Franck Regnier', '55064', 'Gosselin', 'Tristan Potier', '+33 1 39 56 78 99', 'rossi.andree@dubois.com'),
(30, 'Reynaud Parent SARL', '95, rue Margaret Lopez', '09179', 'Boucher-sur-Berger', 'Hélène Dupre', '+33 2 52 53 66 67', 'peron.pierre@gaudin.fr');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260312191047', '2026-03-12 19:10:50', 2467);

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
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
-- Table structure for table `internship`
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
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`id`, `start_date`, `end_date`, `remarks`, `student_id`, `company_id`, `tracking_teacher_id`, `visiting_teacher_id`) VALUES
(1, '2026-01-22', '2026-03-05', NULL, 1, 18, 6, 9),
(2, '2026-01-05', '2026-02-16', NULL, 2, 5, 5, 11),
(3, '2026-01-27', '2026-03-10', NULL, 3, 29, 4, 6),
(4, '2026-01-26', '2026-03-09', NULL, 4, 27, 11, 4),
(5, '2026-01-19', '2026-03-02', NULL, 5, 9, 3, 12),
(6, '2026-01-07', '2026-02-18', NULL, 6, 26, 11, 12),
(7, '2026-01-24', '2026-03-07', NULL, 7, 27, 10, 9),
(8, '2026-01-06', '2026-02-17', NULL, 8, 4, 6, 9),
(9, '2026-01-13', '2026-02-24', NULL, 9, 27, 7, 10),
(10, '2026-01-22', '2026-03-05', NULL, 10, 23, 3, 7),
(11, '2026-01-07', '2026-02-18', NULL, 11, 24, 7, 3),
(12, '2026-01-26', '2026-03-09', NULL, 12, 1, 3, 11),
(13, '2026-01-24', '2026-03-07', NULL, 13, 6, 4, 8),
(14, '2026-01-18', '2026-03-01', NULL, 14, 23, 10, 11),
(15, '2026-01-25', '2026-03-08', NULL, 15, 20, 11, 6),
(16, '2026-01-09', '2026-02-20', NULL, 16, 4, 11, 7),
(17, '2026-01-26', '2026-03-09', NULL, 17, 24, 4, 8),
(18, '2026-01-01', '2026-02-12', NULL, 18, 5, 11, 10),
(19, '2026-01-18', '2026-03-01', NULL, 19, 21, 4, 9),
(20, '2026-01-25', '2026-03-08', NULL, 20, 24, 10, 3),
(21, '2026-01-01', '2026-02-12', NULL, 21, 16, 3, 11),
(22, '2026-01-02', '2026-02-13', NULL, 22, 19, 6, 6),
(23, '2026-01-05', '2026-02-16', NULL, 23, 30, 3, 11),
(24, '2026-01-15', '2026-02-26', NULL, 24, 29, 9, 5),
(25, '2026-01-01', '2026-02-12', NULL, 25, 17, 7, 10),
(26, '2026-01-11', '2026-02-22', NULL, 26, 24, 11, 3),
(27, '2026-01-09', '2026-02-20', NULL, 27, 15, 4, 10),
(28, '2026-01-28', '2026-03-11', NULL, 28, 18, 9, 3),
(29, '2026-01-31', '2026-03-14', NULL, 29, 4, 7, 10),
(30, '2026-01-05', '2026-02-16', NULL, 30, 19, 7, 9),
(31, '2026-01-14', '2026-02-25', NULL, 31, 2, 9, 9),
(32, '2026-01-12', '2026-02-23', NULL, 32, 29, 5, 3),
(33, '2026-01-15', '2026-02-26', NULL, 33, 15, 9, 9),
(34, '2026-01-04', '2026-02-15', NULL, 34, 2, 8, 6),
(35, '2026-01-26', '2026-03-09', NULL, 35, 9, 4, 4),
(36, '2026-01-05', '2026-02-16', NULL, 36, 11, 10, 9),
(37, '2026-01-27', '2026-03-10', NULL, 37, 22, 5, 4),
(38, '2026-01-31', '2026-03-14', NULL, 38, 16, 12, 4),
(39, '2026-01-20', '2026-03-03', NULL, 39, 30, 3, 12),
(40, '2026-01-10', '2026-02-21', NULL, 40, 4, 10, 12);

-- --------------------------------------------------------

--
-- Table structure for table `internship_milestone`
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
-- Dumping data for table `internship_milestone`
--

INSERT INTO `internship_milestone` (`id`, `validated_at`, `comment`, `internship_id`, `status_id`, `milestone_id`) VALUES
(1, NULL, NULL, 1, 3, 1),
(2, NULL, NULL, 1, 3, 2),
(3, NULL, NULL, 1, 3, 3),
(4, NULL, NULL, 1, 1, 4),
(5, NULL, NULL, 2, 2, 1),
(6, NULL, NULL, 2, 2, 4),
(7, NULL, NULL, 3, 1, 1),
(8, NULL, NULL, 3, 3, 2),
(9, NULL, NULL, 3, 1, 3),
(10, NULL, NULL, 4, 2, 1),
(11, NULL, NULL, 4, 3, 2),
(12, NULL, NULL, 4, 2, 3),
(13, NULL, NULL, 4, 2, 4),
(14, NULL, NULL, 5, 2, 1),
(15, NULL, NULL, 5, 1, 2),
(16, NULL, NULL, 5, 2, 3),
(17, NULL, NULL, 6, 1, 2),
(18, NULL, NULL, 6, 1, 3),
(19, NULL, NULL, 6, 2, 4),
(20, NULL, NULL, 7, 2, 1),
(21, NULL, NULL, 7, 1, 2),
(22, NULL, NULL, 7, 2, 3),
(23, NULL, NULL, 7, 2, 4),
(24, NULL, NULL, 8, 2, 1),
(25, NULL, NULL, 8, 3, 2),
(26, NULL, NULL, 8, 1, 3),
(27, NULL, NULL, 9, 1, 2),
(28, NULL, NULL, 9, 3, 3),
(29, NULL, NULL, 10, 1, 1),
(30, NULL, NULL, 10, 2, 2),
(31, NULL, NULL, 10, 1, 4),
(32, NULL, NULL, 11, 2, 1),
(33, NULL, NULL, 11, 1, 2),
(34, NULL, NULL, 12, 3, 1),
(35, NULL, NULL, 12, 3, 3),
(36, NULL, NULL, 12, 2, 4),
(37, NULL, NULL, 13, 1, 3),
(38, NULL, NULL, 13, 1, 4),
(39, NULL, NULL, 14, 3, 1),
(40, NULL, NULL, 14, 3, 2),
(41, NULL, NULL, 14, 2, 3),
(42, NULL, NULL, 15, 2, 1),
(43, NULL, NULL, 15, 3, 2),
(44, NULL, NULL, 15, 1, 3),
(45, NULL, NULL, 15, 1, 4),
(46, NULL, NULL, 16, 3, 1),
(47, NULL, NULL, 16, 2, 2),
(48, NULL, NULL, 16, 1, 3),
(49, NULL, NULL, 16, 1, 4),
(50, NULL, NULL, 17, 2, 3),
(51, NULL, NULL, 18, 2, 1),
(52, NULL, NULL, 18, 3, 2),
(53, NULL, NULL, 18, 2, 3),
(54, NULL, NULL, 18, 3, 4),
(55, NULL, NULL, 19, 2, 1),
(56, NULL, NULL, 19, 2, 3),
(57, NULL, NULL, 19, 3, 4),
(58, NULL, NULL, 20, 3, 1),
(59, NULL, NULL, 20, 1, 2),
(60, NULL, NULL, 20, 1, 3),
(61, NULL, NULL, 20, 2, 4),
(62, NULL, NULL, 21, 1, 1),
(63, NULL, NULL, 21, 1, 2),
(64, NULL, NULL, 22, 1, 2),
(65, NULL, NULL, 22, 2, 3),
(66, NULL, NULL, 22, 3, 4),
(67, NULL, NULL, 23, 1, 1),
(68, NULL, NULL, 23, 3, 2),
(69, NULL, NULL, 23, 3, 4),
(70, NULL, NULL, 24, 3, 1),
(71, NULL, NULL, 24, 1, 2),
(72, NULL, NULL, 24, 1, 3),
(73, NULL, NULL, 24, 2, 4),
(74, NULL, NULL, 25, 1, 3),
(75, NULL, NULL, 26, 1, 1),
(76, NULL, NULL, 26, 1, 2),
(77, NULL, NULL, 26, 2, 3),
(78, NULL, NULL, 26, 2, 4),
(79, NULL, NULL, 27, 1, 1),
(80, NULL, NULL, 27, 1, 2),
(81, NULL, NULL, 27, 1, 3),
(82, NULL, NULL, 27, 3, 4),
(83, NULL, NULL, 28, 3, 1),
(84, NULL, NULL, 28, 3, 2),
(85, NULL, NULL, 28, 2, 3),
(86, NULL, NULL, 28, 3, 4),
(87, NULL, NULL, 29, 3, 1),
(88, NULL, NULL, 29, 1, 2),
(89, NULL, NULL, 29, 2, 4),
(90, NULL, NULL, 30, 1, 2),
(91, NULL, NULL, 30, 2, 3),
(92, NULL, NULL, 30, 1, 4),
(93, NULL, NULL, 31, 2, 1),
(94, NULL, NULL, 31, 1, 2),
(95, NULL, NULL, 31, 3, 3),
(96, NULL, NULL, 32, 1, 1),
(97, NULL, NULL, 32, 1, 2),
(98, NULL, NULL, 32, 3, 4),
(99, NULL, NULL, 33, 2, 3),
(100, NULL, NULL, 34, 2, 1),
(101, NULL, NULL, 34, 2, 2),
(102, NULL, NULL, 34, 1, 3),
(103, NULL, NULL, 35, 2, 1),
(104, NULL, NULL, 35, 2, 4),
(105, NULL, NULL, 36, 2, 1),
(106, NULL, NULL, 36, 3, 3),
(107, NULL, NULL, 37, 3, 1),
(108, NULL, NULL, 37, 2, 2),
(109, NULL, NULL, 37, 3, 3),
(110, NULL, NULL, 37, 1, 4),
(111, NULL, NULL, 38, 1, 1),
(112, NULL, NULL, 39, 1, 2),
(113, NULL, NULL, 39, 3, 4),
(114, NULL, NULL, 40, 2, 1),
(115, NULL, NULL, 40, 1, 2),
(116, NULL, NULL, 40, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `code`, `label`) VALUES
(1, 'SLAM', 'Solutions Logicielles et Applications Métier'),
(2, 'SISR', 'Solutions d\'Infrastructure, Systèmes et Réseaux');

-- --------------------------------------------------------

--
-- Table structure for table `milestone`
--

CREATE TABLE `milestone` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `milestone`
--

INSERT INTO `milestone` (`id`, `code`, `label`) VALUES
(1, 'THANK_YOU_LETTER', 'Remerciement'),
(2, 'REPORT', 'Bilan / Suivi'),
(3, 'JURY', 'Jury'),
(4, 'CERTIFICATE', 'Attestation');

-- --------------------------------------------------------

--
-- Table structure for table `milestone_status`
--

CREATE TABLE `milestone_status` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `milestone_status`
--

INSERT INTO `milestone_status` (`id`, `code`, `label`) VALUES
(1, 'OK', 'Validé'),
(2, 'NOK', 'Non validé'),
(3, 'PENDING', 'En attente');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `id` int NOT NULL,
  `year` int NOT NULL,
  `is_archived` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `year`, `is_archived`) VALUES
(1, 2026, 0),
(2, 2025, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `label`, `code`) VALUES
(1, 'Administrateur', 'ROLE_ADMIN'),
(2, 'Enseignant', 'ROLE_TEACHER'),
(3, 'Secrétariat', 'ROLE_SECRETARY');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `major_id` int NOT NULL,
  `promotion_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `major_id`, `promotion_id`) VALUES
(1, 'Antoinette', 'Lesage', 2, 1),
(2, 'Alfred', 'Prevost', 1, 2),
(3, 'Emmanuel', 'Lebon', 1, 2),
(4, 'Élisabeth', 'Clerc', 2, 2),
(5, 'Noël', 'Peltier', 1, 2),
(6, 'Timothée', 'Gonzalez', 1, 1),
(7, 'Caroline', 'Traore', 1, 2),
(8, 'Auguste', 'Verdier', 2, 1),
(9, 'Étienne', 'Roux', 2, 2),
(10, 'Aurore', 'Verdier', 2, 2),
(11, 'Aurore', 'Germain', 1, 2),
(12, 'Alexandre', 'Delannoy', 2, 1),
(13, 'Alphonse', 'Riviere', 1, 1),
(14, 'Victoire', 'Garnier', 2, 2),
(15, 'Alexandria', 'Parent', 2, 2),
(16, 'Honoré', 'Delannoy', 1, 1),
(17, 'Lorraine', 'Marechal', 1, 1),
(18, 'Pauline', 'Voisin', 1, 1),
(19, 'Constance', 'Lombard', 1, 1),
(20, 'Zacharie', 'Jourdan', 2, 2),
(21, 'Anastasie', 'Letellier', 2, 2),
(22, 'Émile', 'Letellier', 1, 1),
(23, 'André', 'Bousquet', 2, 1),
(24, 'René', 'Gaillard', 1, 2),
(25, 'Dominique', 'Letellier', 2, 2),
(26, 'Jacqueline', 'Giraud', 1, 2),
(27, 'Suzanne', 'Germain', 1, 2),
(28, 'Georges', 'Lelievre', 1, 1),
(29, 'Élise', 'Lelievre', 2, 1),
(30, 'Pierre', 'Ribeiro', 1, 1),
(31, 'Margaux', 'Remy', 2, 2),
(32, 'Marcelle', 'Cordier', 1, 1),
(33, 'Christophe', 'Mallet', 1, 1),
(34, 'Jérôme', 'Leger', 2, 1),
(35, 'Alfred', 'Weber', 2, 1),
(36, 'Rémy', 'Gilbert', 2, 2),
(37, 'William', 'Jourdan', 1, 2),
(38, 'Claude', 'Jacob', 1, 2),
(39, 'Clémence', 'Collin', 1, 2),
(40, 'Henriette', 'Ferreira', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`) VALUES
(1, 'admin@campus-la-chataigneraie.org', '$2y$13$pZrZDZTQ.c/S9VZVrQ24bun2sovJoYM5ecVB2j2qYR8t.cy0vgxY.', 'Admin', 'Lycée'),
(2, 'secretaire@campus-la-chataigneraie.org', '$2y$13$PFSh1HC9li6JenZAEz7IwO8xQXKU5Vr4SWR5hl1d2SD5yoBaqwWni', 'Secrétaire', 'Lycée'),
(3, 'catherine.baranger@campus-la-chataigneraie.org', '$2y$13$fbCFEkZUjaEHDdHXTBtgLODn37QRf5.BgZFjwsrpp5IG9/TV3LMXy', 'Catherine', 'Baranger'),
(4, 'rejane.boursier@campus-la-chataigneraie.org', '$2y$13$GVkr/SrAzCkmN0Ak8mgi5Owt.OyPTULdfs.m7.9mRdEXaKYmokZzi', 'Réjane', 'Boursier'),
(5, 'sandrine.ternisien@campus-la-chataigneraie.org', '$2y$13$hhLWfu5o0h8DehtW1KxHBOemNzt36aTfrLKzGqwHRK3owWv9osLaG', 'Sandrine', 'Ternisien'),
(6, 'nathalie.grandin@campus-la-chataigneraie.org', '$2y$13$ZeX5wJbfF/89XoLraDXicuXN.fwF2vHJfgHVvXD5j/R.GN0TvaIlS', 'Nathalie', 'Grandin'),
(7, 'marie.serrault@campus-la-chataigneraie.org', '$2y$13$GEZxdPQYo50XN0BvFoquuOH8/BPJZLtjjz.kDSWBfALfrsuSvraB.', 'Marie', 'Serrault'),
(8, 'christophe.baudoux@campus-la-chataigneraie.org', '$2y$13$sg0BYQo2KH6ZWcgjCaA/N.49G3/mJFbSh.X39Ifb6sefRr.VXWVeC', 'Christophe', 'Baudoux'),
(9, 'antoine.bloyet@campus-la-chataigneraie.org', '$2y$13$0Go3TEGebYTYZr2qLm7zxu5PnQGnOnFgEDtLQnU1OnVNuvN.T3xM6', 'Antoine', 'Bloyet'),
(10, 'kevin.bayeul@campus-la-chataigneraie.org', '$2y$13$W.BAxwkLuIyNJUWfLAv.Zust2GmyftUasVT8CaHT2N.dgVOeqGVGq', 'Kévin', 'Bayeul'),
(11, 'laurent.maurice@campus-la-chataigneraie.org', '$2y$13$PWYr/9niqdpMBM4PId6DmeFGE4jJe8he7ZEKprTuXawebR18fLyFG', 'Laurent', 'Maurice'),
(12, 'robin.szylobryt@campus-la-chataigneraie.org', '$2y$13$cWvqsxumqSvnZPLZEp/8ceotBspGyxzO8aiYD1Wgi296H7XD5r.UO', 'Robin', 'Szylobryt');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_role`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `action_type`
--
ALTER TABLE `action_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6190350A1FEE0472` (`action_type_id`),
  ADD KEY `IDX_6190350AF675F31B` (`author_id`),
  ADD KEY `IDX_6190350A7A4A70BE` (`internship_id`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_10D1B00CCB944F1A` (`student_id`),
  ADD KEY `IDX_10D1B00C979B1AD6` (`company_id`),
  ADD KEY `IDX_10D1B00C3C0AC0DC` (`tracking_teacher_id`),
  ADD KEY `IDX_10D1B00CBCFE061F` (`visiting_teacher_id`);

--
-- Indexes for table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD01E8C07A4A70BE` (`internship_id`),
  ADD KEY `IDX_FD01E8C06BF700BD` (`status_id`),
  ADD KEY `IDX_FD01E8C04B3E2EDA` (`milestone_id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestone`
--
ALTER TABLE `milestone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestone_status`
--
ALTER TABLE `milestone_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B723AF33E93695C7` (`major_id`),
  ADD KEY `IDX_B723AF33139DF194` (`promotion_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  ADD KEY `IDX_2DE8C6A3D60322AC` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_type`
--
ALTER TABLE `action_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milestone`
--
ALTER TABLE `milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `milestone_status`
--
ALTER TABLE `milestone_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_log`
--
ALTER TABLE `history_log`
  ADD CONSTRAINT `FK_6190350A1FEE0472` FOREIGN KEY (`action_type_id`) REFERENCES `action_type` (`id`),
  ADD CONSTRAINT `FK_6190350A7A4A70BE` FOREIGN KEY (`internship_id`) REFERENCES `internship` (`id`),
  ADD CONSTRAINT `FK_6190350AF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `FK_10D1B00C3C0AC0DC` FOREIGN KEY (`tracking_teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10D1B00C979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_10D1B00CBCFE061F` FOREIGN KEY (`visiting_teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10D1B00CCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  ADD CONSTRAINT `FK_FD01E8C04B3E2EDA` FOREIGN KEY (`milestone_id`) REFERENCES `milestone` (`id`),
  ADD CONSTRAINT `FK_FD01E8C06BF700BD` FOREIGN KEY (`status_id`) REFERENCES `milestone_status` (`id`),
  ADD CONSTRAINT `FK_FD01E8C07A4A70BE` FOREIGN KEY (`internship_id`) REFERENCES `internship` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF33139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`),
  ADD CONSTRAINT `FK_B723AF33E93695C7` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
