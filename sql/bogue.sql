-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Mar 11, 2026 at 09:31 PM
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
(1, 'Rossi S.A.S.', '51, boulevard de Fleury', '68497', 'Jean', 'Gabrielle Sanchez', '0175299481', 'guy.verdier@laurent.com'),
(2, 'Pichon S.A.R.L.', 'rue de Tanguy', '25382', 'Jacquet', 'Margaud Langlois', '0457210907', 'alice.gauthier@jacquot.net'),
(3, 'Benard', '45, rue de Potier', '13980', 'Schneider', 'Louis de la Schmitt', '+33 9 83 10 34 68', 'dorothee74@delattre.fr'),
(4, 'Lemaire SAS', '31, boulevard Rousset', '60356', 'Juliennec', 'Claudine Lopes', '+33 7 78 49 50 05', 'celine.laroche@auger.fr'),
(5, 'Mahe Ruiz SARL', '7, impasse Delattre', '13817', 'Charles-sur-Humbert', 'Marie Georges', '0397824470', 'alix87@gros.com'),
(6, 'Chauveau', '66, impasse Bodin', '52348', 'Gilbert', 'Aimé Bonneau', '0777164817', 'theodore39@martinez.com'),
(7, 'Besson', '60, impasse Élise Lebon', '06038', 'Pelletier-sur-Renault', 'Cécile-Brigitte Salmon', '+33 1 14 15 49 48', 'rodriguez.jerome@besnard.com'),
(8, 'Baron', '32, chemin de Breton', '53260', 'Mendes-les-Bains', 'Agnès Turpin', '0128441092', 'joubert.hugues@marie.fr'),
(9, 'Charpentier SA', '190, boulevard Pires', '27909', 'Jacques-la-Forêt', 'Lucy Begue', '+33 6 15 54 57 46', 'theophile.jacques@letellier.fr'),
(10, 'De Oliveira', '25, impasse de Aubry', '10870', 'Costa-les-Bains', 'Marie-Stéphanie Tanguy', '+33 9 13 55 76 60', 'roland.laporte@barbe.com'),
(11, 'Remy', '846, rue de Hardy', '72693', 'Martin-les-Bains', 'Georges-Georges Duhamel', '+33 (0)3 06 32 72 40', 'guillot.remy@morel.com'),
(12, 'Moulin', '24, impasse Gilbert', '81743', 'Collet', 'Isabelle Texier', '+33 8 12 59 10 05', 'guilbert.corinne@bourdon.net'),
(13, 'Colin SARL', 'chemin de Lemaitre', '61510', 'Bernard', 'Isaac Michaud', '07 35 01 57 37', 'richard.rocher@dumas.com'),
(14, 'Fournier S.A.S.', '33, rue de Thierry', '66007', 'Charrier-la-Forêt', 'Margot Guillot', '+33 8 95 19 62 08', 'perret.alix@dijoux.fr'),
(15, 'Rodrigues', '5, rue Sébastien Boulay', '43679', 'Colindan', 'Claudine du Guyon', '05 96 41 73 41', 'meunier.aurore@blanchard.com'),
(16, 'Jacob Morin S.A.', 'impasse de Marion', '53915', 'LecomteBourg', 'Benjamin Rousseau', '0119475721', 'riou.laurent@barthelemy.net'),
(17, 'Leblanc SA', 'chemin François Chauvet', '14364', 'Lopes', 'Élise Devaux', '06 95 15 41 61', 'ngomez@fouquet.fr'),
(18, 'Costa S.A.R.L.', '99, avenue de Clerc', '48899', 'Camus', 'Thierry Boutin', '01 83 30 44 06', 'becker.olivie@didier.org'),
(19, 'Poirier', '62, avenue Jean', '20970', 'Delattre', 'Léon Blondel', '+33 (0)2 54 63 94 31', 'marion.constance@baron.org'),
(20, 'Gaudin', '25, rue Bourgeois', '84192', 'Fouquet', 'Emmanuel Fontaine', '+33 (0)4 31 35 23 53', 'michel.weber@bonneau.com'),
(21, 'Marchal Garcia S.A.', '715, chemin de Lebrun', '51362', 'Lemaitre', 'Guillaume Dufour', '+33 (0)9 56 75 41 85', 'eleonore.chauveau@munoz.com'),
(22, 'Marchal', '73, rue Agnès Leclercq', '82377', 'Petit', 'Michel Loiseau', '0522454990', 'verdier.helene@barbe.fr'),
(23, 'Denis Fabre SAS', 'place de Chevalier', '78907', 'Moreau', 'Valérie Legendre-Buisson', '+33 6 98 51 70 87', 'jeannine.leveque@blanchet.com'),
(24, 'Pires', 'place de Alves', '59394', 'Martelboeuf', 'Arnaude-Dominique Girard', '+33 (0)6 38 86 73 82', 'genevieve93@robin.fr'),
(25, 'Potier', 'place Roland Laurent', '61932', 'Petitjean', 'Alfred Bonneau', '+33 6 95 52 83 53', 'amuller@delorme.net'),
(26, 'Samson S.A.S.', '37, chemin Caron', '90546', 'Barthelemy', 'Virginie Vallee', '08 04 16 36 03', 'dperrin@collet.fr'),
(27, 'Thomas', '82, rue Émilie Pires', '78965', 'Boucherboeuf', 'Luc Delannoy', '08 12 87 36 37', 'bdevaux@delorme.com'),
(28, 'Lemaire Martineau S.A.R.L.', 'place de Prevost', '65741', 'Collet-sur-Lemoine', 'Simone Pelletier', '+33 4 28 04 56 08', 'monnier.jean@gillet.fr'),
(29, 'Merle Delahaye SARL', 'avenue Anne Regnier', '33418', 'GayBourg', 'Édith Bertin', '+33 5 21 29 60 80', 'xmillet@legall.org'),
(30, 'Mercier et Fils', '946, rue de Dupont', '09110', 'Mendes-sur-Hernandez', 'Jean Durand', '+33 (0)6 33 64 54 24', 'suzanne65@toussaint.org');

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
('DoctrineMigrations\\Version20260311201823', '2026-03-11 21:29:16', 2380);

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
(1, '2026-01-09', '2026-02-20', NULL, 1, 17, 9, 10),
(2, '2026-01-16', '2026-02-27', 'Léon avait peur d\'être aperçu; il entra dans la cuisine. Les enfants en chaussons couraient là.', 2, 21, 10, 11),
(3, '2026-01-24', '2026-03-07', NULL, 3, 6, 5, 6),
(4, '2026-01-06', '2026-02-17', NULL, 4, 7, 7, 12),
(5, '2026-01-16', '2026-02-27', NULL, 5, 13, 11, 10),
(6, '2026-01-08', '2026-02-19', NULL, 6, 24, 6, 6),
(7, '2026-01-17', '2026-02-28', 'Cependant le fiacre du Conseiller qui psalmodiait ses phrases. Il disait: -- C\'est vrai! répliqua.', 7, 14, 7, 11),
(8, '2026-01-10', '2026-02-21', 'Il resta sur le sable, vous apportant un nid d\'oiseau. Lorsqu\'elle eut treize ans, son père se.', 8, 2, 5, 12),
(9, '2026-01-04', '2026-02-15', 'Larivière se détourna. -- Vous étiez en bas, dans l\'ombre, sous la visière brillait.', 9, 11, 10, 5),
(10, '2026-01-03', '2026-02-14', 'Restauration, le Marquis, cherchant à cacheter la lettre, l\'ouvrit, et, comme il vit la carriole.', 10, 2, 10, 12),
(11, '2026-01-08', '2026-02-19', 'Rodolphe galopait à côté d\'eux, ne soufflant mot dans la cuisine. Il guetta son ombre derrière la.', 11, 6, 4, 7),
(12, '2026-01-28', '2026-03-11', NULL, 12, 4, 5, 10),
(13, '2026-01-28', '2026-03-11', 'Génie du christianisme, par récréation. Comme elle était avec eux. Ils se regardaient. Un désir.', 13, 5, 10, 5),
(14, '2026-01-23', '2026-03-06', 'Charles n\'eût osé en souhaiter de plus un petit R au bas de leur gilet, leur cravate rose ou vert.', 14, 13, 8, 3),
(15, '2026-01-04', '2026-02-15', NULL, 15, 16, 9, 9),
(16, '2026-01-19', '2026-03-02', NULL, 16, 6, 5, 8),
(17, '2026-01-31', '2026-03-14', NULL, 17, 25, 9, 10),
(18, '2026-01-27', '2026-03-10', 'Ils venaient se délasser dans les Bertaux, madame Bovary à un écuyer vert. Elle resta perdue de.', 18, 2, 8, 10),
(19, '2026-01-25', '2026-03-08', NULL, 19, 29, 5, 7),
(20, '2026-01-21', '2026-03-04', NULL, 20, 1, 6, 8),
(21, '2026-01-07', '2026-02-18', 'Par terre, dans un chemin creux, ils s\'allaient réfugier dans le dos et ronflait. Comme il eut.', 21, 14, 12, 4),
(22, '2026-01-28', '2026-03-11', NULL, 22, 17, 11, 10),
(23, '2026-01-19', '2026-03-02', 'Ainsi, tu m\'affirmes que tout était perdu. Puis l\'orgueil, la joie de se rendre à l\'église, et.', 23, 8, 12, 8),
(24, '2026-01-23', '2026-03-06', 'On est si fastidieuse avec ses pantoufles de lisière qu\'elle portait sur sa chevelure dénouée.', 24, 22, 10, 12),
(25, '2026-01-26', '2026-03-09', 'Au haut de sa poche une liste de fournitures non soldées, à savoir: les rideaux, le tapis.', 25, 22, 9, 3),
(26, '2026-01-25', '2026-03-08', 'Elle allait entrer; mais, au bout du village sur le jardin la plate- bande dont elle connaissait.', 26, 9, 6, 3),
(27, '2026-01-21', '2026-03-04', NULL, 27, 27, 3, 6),
(28, '2026-01-13', '2026-02-24', NULL, 28, 4, 11, 6),
(29, '2026-01-25', '2026-03-08', NULL, 29, 16, 8, 3),
(30, '2026-01-17', '2026-02-28', NULL, 30, 27, 3, 10),
(31, '2026-01-10', '2026-02-21', 'Il fallait, pensa-t-il, se résoudre enfin à sa mère, ses cousins, pleurant aux murs pour pleurer.', 31, 8, 4, 9),
(32, '2026-01-12', '2026-02-23', NULL, 32, 16, 4, 9),
(33, '2026-01-07', '2026-02-18', NULL, 33, 28, 8, 6),
(34, '2026-01-10', '2026-02-21', NULL, 34, 12, 9, 6),
(35, '2026-01-22', '2026-03-05', NULL, 35, 9, 12, 10);

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
(1, NULL, NULL, 1, 1, 2),
(2, '2026-02-15', 'Quas aspernatur molestias delectus suscipit modi rem quae.', 1, 2, 3),
(3, NULL, 'Vel consequatur rem suscipit.', 1, 3, 4),
(4, '2026-03-03', NULL, 2, 3, 2),
(5, NULL, NULL, 2, 1, 4),
(6, NULL, NULL, 3, 3, 1),
(7, NULL, NULL, 3, 2, 2),
(8, NULL, NULL, 4, 1, 2),
(9, '2026-02-09', NULL, 4, 3, 3),
(10, NULL, NULL, 4, 1, 4),
(11, '2026-01-27', 'Dolores minus sit natus enim dolore placeat.', 5, 2, 2),
(12, '2026-03-04', NULL, 6, 3, 1),
(13, NULL, 'Consequuntur iusto sint eaque asperiores quas.', 6, 2, 3),
(14, '2026-01-22', NULL, 7, 2, 3),
(15, '2026-03-06', NULL, 7, 1, 4),
(16, NULL, NULL, 8, 3, 2),
(17, NULL, NULL, 8, 1, 3),
(18, NULL, NULL, 8, 3, 4),
(19, '2026-01-19', NULL, 9, 1, 2),
(20, '2026-02-05', 'Corporis tempora doloribus esse aut.', 9, 1, 3),
(21, '2026-01-12', NULL, 10, 3, 3),
(22, '2026-03-05', NULL, 11, 1, 2),
(23, '2026-02-07', NULL, 11, 1, 3),
(24, NULL, NULL, 11, 3, 4),
(25, '2026-02-01', NULL, 12, 3, 2),
(26, '2026-02-19', NULL, 12, 1, 4),
(27, '2026-02-04', NULL, 13, 3, 1),
(28, '2026-03-04', NULL, 13, 3, 2),
(29, '2026-03-02', NULL, 13, 3, 3),
(30, '2026-03-04', 'Molestiae odio et perspiciatis vel qui sed.', 14, 3, 1),
(31, '2026-02-21', 'Sit eaque sit quod incidunt.', 14, 3, 2),
(32, '2026-01-31', 'Beatae itaque illo iste qui nulla labore qui.', 14, 2, 3),
(33, '2026-03-07', NULL, 14, 1, 4),
(34, NULL, NULL, 15, 2, 1),
(35, NULL, NULL, 15, 1, 2),
(36, '2026-02-17', 'Aut maiores est consectetur vel itaque.', 15, 1, 3),
(37, NULL, NULL, 16, 2, 1),
(38, '2026-02-22', NULL, 16, 1, 2),
(39, '2026-02-26', 'Perspiciatis occaecati animi excepturi repellat voluptas architecto sunt necessitatibus.', 16, 3, 4),
(40, NULL, NULL, 17, 2, 1),
(41, NULL, 'Ipsam accusamus totam incidunt ducimus quae.', 17, 3, 2),
(42, '2026-01-31', NULL, 17, 3, 3),
(43, NULL, NULL, 17, 2, 4),
(44, NULL, NULL, 18, 1, 2),
(45, NULL, NULL, 18, 2, 3),
(46, NULL, NULL, 19, 1, 1),
(47, '2026-01-28', NULL, 19, 1, 2),
(48, '2026-02-23', NULL, 19, 1, 3),
(49, NULL, NULL, 19, 2, 4),
(50, '2026-03-05', NULL, 20, 1, 1),
(51, NULL, NULL, 20, 2, 2),
(52, NULL, 'Autem provident minus enim ut et.', 20, 3, 3),
(53, NULL, NULL, 20, 2, 4),
(54, NULL, NULL, 21, 2, 1),
(55, '2026-03-01', NULL, 21, 1, 4),
(56, NULL, NULL, 22, 2, 1),
(57, NULL, NULL, 22, 2, 2),
(58, NULL, NULL, 22, 2, 3),
(59, NULL, NULL, 22, 3, 4),
(60, NULL, NULL, 23, 1, 1),
(61, NULL, NULL, 23, 1, 2),
(62, NULL, NULL, 23, 1, 3),
(63, NULL, NULL, 23, 3, 4),
(64, '2026-02-11', NULL, 24, 2, 1),
(65, NULL, 'Velit dolores maiores esse expedita qui deleniti inventore saepe.', 24, 3, 2),
(66, '2026-01-26', NULL, 24, 3, 3),
(67, NULL, NULL, 25, 3, 1),
(68, '2026-03-04', 'Eius veniam fugit aut eaque.', 25, 2, 2),
(69, NULL, NULL, 25, 1, 3),
(70, NULL, NULL, 26, 2, 2),
(71, '2026-01-27', NULL, 26, 2, 3),
(72, NULL, NULL, 26, 1, 4),
(73, NULL, NULL, 27, 1, 1),
(74, '2026-02-09', NULL, 27, 3, 2),
(75, NULL, 'Fugiat officia est eius blanditiis alias quo nihil corrupti.', 27, 2, 3),
(76, '2026-01-13', NULL, 28, 1, 2),
(77, NULL, NULL, 28, 3, 3),
(78, '2026-02-05', 'Quo dolorem voluptas voluptatibus fugiat dicta in.', 28, 2, 4),
(79, NULL, NULL, 29, 3, 1),
(80, NULL, NULL, 29, 2, 2),
(81, NULL, NULL, 29, 3, 3),
(82, NULL, NULL, 30, 3, 1),
(83, NULL, NULL, 30, 3, 3),
(84, '2026-03-09', NULL, 30, 3, 4),
(85, NULL, 'Voluptatem sapiente iusto totam esse quo magni voluptatem.', 31, 2, 2),
(86, '2026-02-09', NULL, 31, 1, 3),
(87, '2026-01-16', NULL, 31, 2, 4),
(88, '2026-02-23', NULL, 32, 1, 1),
(89, NULL, NULL, 32, 2, 2),
(90, NULL, NULL, 32, 1, 4),
(91, '2026-02-11', NULL, 33, 1, 1),
(92, '2026-01-30', NULL, 33, 2, 2),
(93, '2026-01-08', NULL, 33, 1, 3),
(94, NULL, NULL, 33, 1, 4),
(95, NULL, NULL, 34, 3, 1),
(96, NULL, 'Eligendi quae optio eos.', 34, 3, 3),
(97, NULL, NULL, 35, 3, 1),
(98, '2026-02-17', NULL, 35, 3, 2),
(99, '2026-03-06', 'Porro ut corporis id dicta velit.', 35, 1, 3),
(100, NULL, NULL, 35, 3, 4);

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
  `promotion_year` int NOT NULL,
  `is_archived` tinyint NOT NULL,
  `major_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `promotion_year`, `is_archived`, `major_id`) VALUES
(1, 'Gabrielle', 'Parent', 2026, 0, 1),
(2, 'Patrick', 'Philippe', 2026, 0, 2),
(3, 'Maurice', 'Vasseur', 2026, 0, 2),
(4, 'Thibault', 'Roger', 2026, 0, 2),
(5, 'Noémi', 'Barre', 2026, 0, 2),
(6, 'Timothée', 'Renault', 2026, 0, 2),
(7, 'Nathalie', 'Torres', 2026, 0, 1),
(8, 'Bertrand', 'Ramos', 2026, 0, 1),
(9, 'Margaret', 'Ferreira', 2026, 0, 2),
(10, 'Gilbert', 'Ramos', 2026, 0, 2),
(11, 'Marie', 'Leclercq', 2026, 0, 1),
(12, 'Jeannine', 'Riou', 2026, 0, 1),
(13, 'Susanne', 'Navarro', 2026, 0, 2),
(14, 'Alfred', 'Brunet', 2026, 0, 2),
(15, 'Audrey', 'Julien', 2026, 0, 2),
(16, 'Nathalie', 'Gonzalez', 2026, 0, 1),
(17, 'Marguerite', 'De Sousa', 2026, 0, 2),
(18, 'Denise', 'Bernier', 2026, 0, 1),
(19, 'Arnaude', 'Dias', 2026, 0, 2),
(20, 'Nathalie', 'Klein', 2026, 0, 1),
(21, 'Anouk', 'Bigot', 2026, 0, 1),
(22, 'Alexandre', 'Cohen', 2026, 0, 2),
(23, 'Astrid', 'Duval', 2026, 0, 2),
(24, 'François', 'Pineau', 2026, 0, 2),
(25, 'Michèle', 'Dubois', 2026, 0, 1),
(26, 'Odette', 'Laroche', 2026, 0, 2),
(27, 'Martin', 'Roche', 2026, 0, 2),
(28, 'Nicole', 'Sauvage', 2026, 0, 1),
(29, 'Gilles', 'Masson', 2026, 1, 1),
(30, 'Julien', 'Wagner', 2026, 0, 1),
(31, 'Marie', 'Duval', 2026, 0, 2),
(32, 'Valérie', 'Guyon', 2026, 0, 1),
(33, 'Gabriel', 'Ribeiro', 2026, 0, 2),
(34, 'Jeannine', 'Barthelemy', 2026, 0, 2),
(35, 'François', 'Bertrand', 2026, 0, 1);

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
(1, 'admin@campus-la-chataigneraie.org', '$2y$13$JL2Rik.KbnziMsRz.PCARubH.WG28KSv2Z7jRuPoVAPv6H0eRl.XG', 'Admin', 'Lycée'),
(2, 'secretaire@campus-la-chataigneraie.org', '$2y$13$N.Nv/iBtJKc3aUcaKnu3ruWOeXs5x2q706Y0EOcmaVa081BFgeOmy', 'Secrétaire', 'Lycée'),
(3, 'catherine.baranger@campus-la-chataigneraie.org', '$2y$13$bB67mz6Qxcp8iRlpoyrAjeQIJvmXmK4NOUJzV1f5EIgTeBSzuTXsi', 'Catherine', 'Baranger'),
(4, 'rejane.boursier@campus-la-chataigneraie.org', '$2y$13$7aDhEQ8sDQl9uz3pZ007KO/d2M/lwVm/yXN4FqjtGBDOQVgZQIMbW', 'Réjane', 'Boursier'),
(5, 'sophie.ternisien@campus-la-chataigneraie.org', '$2y$13$23qUZzrh.MZJcnpzTtHX5eq/4LRgDwfyC45JW5jeVYwW1jDbvswLO', 'Sophie', 'Ternisien'),
(6, 'nathalie.grandin@campus-la-chataigneraie.org', '$2y$13$RNlY0sCJ5cdSRRQQsEzo2e9A3lRWCj.Ns9eUxk/0HBLmQWZBV/NMC', 'Nathalie', 'Grandin'),
(7, 'marie.serrault@campus-la-chataigneraie.org', '$2y$13$vpfDS04cFJqNs//SrypkqONe6QzizzjxekiY1Ay4h2uEyqfbsO/Di', 'Marie', 'Serrault'),
(8, 'christophe.baudoux@campus-la-chataigneraie.org', '$2y$13$xDAjfQ/aGhVVwXwCfaDKxOpM4hfLEc2ccCpNDAGvFsqPgIT58km3y', 'Christophe', 'Baudoux'),
(9, 'antoine.bloyet@campus-la-chataigneraie.org', '$2y$13$mT0KVc5dC3Asvh0.w/LE4.d/Q/JaFSQLzIfSStzD2FUjAGJyD0BqG', 'Antoine', 'Bloyet'),
(10, 'kevin.bayeul@campus-la-chataigneraie.org', '$2y$13$OVHIMnV.RWnXBv.djLiiiuX5Bt3yUM5aZJohHXfDbArIOEZ/DrF/i', 'Kévin', 'Bayeul'),
(11, 'laurent.maurice@campus-la-chataigneraie.org', '$2y$13$2nKWRjlezPz8RlGJfTM9BeLIX2d8BM2U9tITgSFYQQ4X8xXk6tzHO', 'Laurent', 'Maurice'),
(12, 'robin.szylobryt@campus-la-chataigneraie.org', '$2y$13$f02vSUw02A64cWkwU/jqzeZ9eiTM263/pxL7np.B5msjsNU685FeW', 'Robin', 'Szylobryt');

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
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B723AF33E93695C7` (`major_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `internship_milestone`
--
ALTER TABLE `internship_milestone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

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
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
