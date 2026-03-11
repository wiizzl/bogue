-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Mar 11, 2026 at 09:40 PM
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
(1, 'Le Gall', '99, avenue de Lejeune', '71103', 'Gauthier-la-Forêt', 'Michelle Caron', '01 55 72 46 36', 'apasquier@bertin.net'),
(2, 'Gosselin SAS', 'avenue de Marchal', '38200', 'Weiss-les-Bains', 'Madeleine Girard', '+33 (0)1 82 45 86 44', 'susanne63@moulin.net'),
(3, 'Garcia Bazin S.A.S.', '5, place de Fournier', '03560', 'Charrier', 'Aimé-Théodore Leveque', '+33 (0)3 45 57 84 31', 'rjulien@royer.fr'),
(4, 'Merle', '2, rue Dos Santos', '54726', 'Munoz', 'Martine Clerc', '0584764713', 'etienne64@lemaire.fr'),
(5, 'Goncalves', '3, rue Alves', '99350', 'ArnaudVille', 'Daniel Marchal', '01 96 17 71 61', 'fraynaud@langlois.fr'),
(6, 'Becker Morin SARL', 'boulevard Dominique Lefebvre', '97753', 'Marechal-sur-Le Goff', 'Thierry-Yves Guillet', '+33 (0)9 29 36 93 18', 'martinez.julien@chauvet.fr'),
(7, 'Noel Ollivier SA', '68, place Hortense Blanchard', '48390', 'Tessierboeuf', 'Olivier Seguin-Petitjean', '04 87 43 38 66', 'jacqueline11@jourdan.org'),
(8, 'Denis', '4, boulevard de Vaillant', '34909', 'Besson-la-Forêt', 'Juliette de Meyer', '+33 (0)6 33 90 40 83', 'francoise.bigot@louis.net'),
(9, 'Courtois', '33, boulevard Marechal', '28693', 'Leleu', 'Grégoire du Wagner', '0265916574', 'oceane.regnier@charles.com'),
(10, 'Dubois Leroux S.A.S.', '4, rue Paul Sauvage', '49864', 'DidierVille', 'Benoît de Morin', '+33 (0)6 30 53 48 78', 'fischer.patricia@merle.com'),
(11, 'Francois', 'rue Théodore Rodrigues', '71631', 'Rousselboeuf', 'Astrid Bourdon', '0695610730', 'hpages@arnaud.com'),
(12, 'Richard Maillet SA', '72, boulevard de Guillot', '21806', 'BerthelotBourg', 'Noémi de Mathieu', '+33 5 54 33 75 56', 'antoine.ferreira@millet.com'),
(13, 'Denis SA', '93, chemin de Hamel', '96910', 'Denisdan', 'Dominique Martineau', '+33 2 24 66 98 25', 'robert.dubois@guillot.com'),
(14, 'Mendes', '91, rue Adrien Martins', '27492', 'Launay-les-Bains', 'Éric Potier', '+33 (0)1 14 61 94 99', 'joseph.laine@grenier.fr'),
(15, 'Laurent', '12, chemin Aurore Jacquet', '94001', 'Leduc-les-Bains', 'Élise Martel', '06 34 83 23 47', 'gimenez.isabelle@guilbert.com'),
(16, 'Andre', '13, place de Schmitt', '02181', 'Michaud-sur-Leroux', 'Georges Texier', '+33 (0)5 29 94 64 83', 'thibault.gerard@rousseau.net'),
(17, 'Lesage', '46, avenue de Francois', '04420', 'MaillardBourg', 'Arnaude Fischer', '0344034311', 'richard.baudry@berger.com'),
(18, 'De Oliveira', '83, rue Matthieu Durand', '91427', 'Vaillant', 'Pénélope Dupuy', '0311391918', 'elevy@diallo.com'),
(19, 'Lebon', 'avenue de Daniel', '00208', 'Leleu', 'David Lamy', '+33 (0)6 95 65 81 33', 'benard.augustin@coste.fr'),
(20, 'Brunet Laine S.A.S.', 'impasse de Fischer', '67902', 'Guichard-sur-Alves', 'Luc Martin', '0372271670', 'dorothee02@pires.fr'),
(21, 'Paris', '615, avenue de Humbert', '50462', 'Bailly-les-Bains', 'Célina-Véronique Begue', '0915205000', 'fernandes.marine@gerard.org'),
(22, 'Grenier SAS', '470, chemin de Boulanger', '35605', 'Thibault', 'Charles Vaillant-Brun', '+33 (0)8 12 08 67 92', 'laurent49@diallo.com'),
(23, 'Giraud et Fils', 'impasse Renaud', '23155', 'Dumontboeuf', 'Élodie Roche', '+33 3 83 11 57 16', 'bouvier.gerard@moreau.net'),
(24, 'Charpentier', '17, impasse Chevalier', '68155', 'Dupont', 'Brigitte Bourgeois', '05 88 00 45 42', 'kbousquet@salmon.com'),
(25, 'Guillot', '3, place de Texier', '73575', 'Bessonnec', 'Pauline Gilles', '05 96 63 06 34', 'imaillet@gomez.com'),
(26, 'Dubois et Fils', '61, chemin de Guibert', '64434', 'Etienne', 'Isabelle Carre', '+33 6 33 82 35 06', 'victoire21@lecoq.com'),
(27, 'Mercier', 'impasse de Faivre', '99068', 'Lefebvre', 'Jules Regnier-Laine', '0490762650', 'xavier.henry@auger.com'),
(28, 'Lemaire', '54, rue de De Oliveira', '21057', 'Michel', 'Julien Marie', '+33 5 14 45 56 47', 'millet.manon@rousseau.org'),
(29, 'Mary Collin SA', '95, boulevard Weber', '26547', 'CollinVille', 'Julie Adam', '0442016878', 'clemence10@delattre.fr'),
(30, 'Laurent S.A.R.L.', '3, rue Garcia', '29846', 'LabbeVille', 'Thierry Dupont', '09 66 53 30 99', 'rleconte@benoit.fr');

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
('DoctrineMigrations\\Version20260311201823', '2026-03-11 21:40:27', 2459);

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
(1, '2026-01-02', '2026-02-13', NULL, 1, 25, 4, 9),
(2, '2026-01-06', '2026-02-17', 'Homais s\'épanouissait dans son coeur, montant toujours des capitaux pour les soigner, outre la.', 2, 19, 5, 9),
(3, '2026-01-13', '2026-02-24', 'Il ne comprenait pas cet entêtement, cet aveuglement à se maudire, lorsque Charles était triste.', 3, 19, 9, 3),
(4, '2026-01-18', '2026-03-01', NULL, 4, 3, 9, 12),
(5, '2026-01-29', '2026-03-12', 'Emma, dès le duo récitatif où Gilbert expose à son attachement. Cette tendresse, en effet, chaque.', 5, 17, 9, 11),
(6, '2026-01-17', '2026-02-28', NULL, 6, 15, 8, 9),
(7, '2026-01-03', '2026-02-14', NULL, 7, 2, 4, 5),
(8, '2026-01-17', '2026-02-28', NULL, 8, 26, 10, 7),
(9, '2026-01-26', '2026-03-09', 'Elle fit revenir la petite. Le dîner n\'était pas fermée. -- Que vous seriez charitable.', 9, 21, 11, 9),
(10, '2026-01-08', '2026-02-19', NULL, 10, 29, 6, 3),
(11, '2026-01-10', '2026-02-21', NULL, 11, 29, 8, 12),
(12, '2026-01-29', '2026-03-12', 'Le jour commençait à se rappeler ainsi toutes les trahisons, les bassesses et les doigts à leurs.', 12, 29, 10, 11),
(13, '2026-01-27', '2026-03-10', 'Dubuc, la vieille femme. Et elle lui dit: -- Que tu es beau! tu es bon, toi! Et elle la petite.', 13, 25, 3, 8),
(14, '2026-01-03', '2026-02-14', NULL, 14, 18, 6, 5),
(15, '2026-01-19', '2026-03-02', 'Bovary tournaient autour d\'Emma, en achevant de le pouvoir aimer. Mais il y en avait tiré hors de.', 15, 7, 4, 3),
(16, '2026-01-12', '2026-02-23', NULL, 16, 5, 4, 3),
(17, '2026-01-20', '2026-03-03', NULL, 17, 18, 3, 6),
(18, '2026-01-18', '2026-03-01', 'Charles, tout à son patron; tout le reste des oiseaux, du soleil arrivant par les mêmes qui.', 18, 5, 12, 9),
(19, '2026-01-30', '2026-03-13', 'Et vous y allez! reprit-il en se reculant. Et Emma se sentait à l\'aise, sûr d\'avance qu\'il.', 19, 29, 10, 11),
(20, '2026-01-04', '2026-02-15', NULL, 20, 23, 7, 11),
(21, '2026-01-26', '2026-03-09', NULL, 21, 18, 8, 5),
(22, '2026-01-22', '2026-03-05', 'Ils vinrent à tomber. Elle noua son mouchoir qu\'il venait de regarder Lestiboudois, le sacristain.', 22, 9, 4, 9),
(23, '2026-01-03', '2026-02-14', NULL, 23, 3, 6, 3),
(24, '2026-01-01', '2026-02-12', NULL, 24, 29, 10, 4),
(25, '2026-01-15', '2026-02-26', NULL, 25, 20, 7, 6),
(26, '2026-01-07', '2026-02-18', NULL, 26, 22, 6, 3),
(27, '2026-01-17', '2026-02-28', NULL, 27, 5, 3, 5),
(28, '2026-01-14', '2026-02-25', NULL, 28, 14, 10, 5),
(29, '2026-01-28', '2026-03-11', 'Laissez donc un peu Cujas et Bartole, que diable! Qui vous inquiète, puisque vous toucherez dans.', 29, 10, 5, 9),
(30, '2026-01-13', '2026-02-24', 'Le ménétrier allait en tête, avec son père, n\'est-ce pas, c\'est impossible! Si vous saviez.', 30, 24, 9, 4),
(31, '2026-01-17', '2026-02-28', NULL, 31, 12, 12, 7),
(32, '2026-01-30', '2026-03-13', NULL, 32, 9, 3, 3),
(33, '2026-01-08', '2026-02-19', NULL, 33, 6, 9, 9),
(34, '2026-01-15', '2026-02-26', 'Oui, adieu..., partez! Ils s\'avancèrent l\'un vers l\'autre. Et il la baisait dans le silence, la.', 34, 27, 12, 10),
(35, '2026-01-08', '2026-02-19', NULL, 35, 24, 8, 3);

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
(1, NULL, NULL, 1, 2, 1),
(2, NULL, NULL, 1, 2, 2),
(3, NULL, NULL, 1, 1, 3),
(4, NULL, 'Sunt et cumque debitis accusantium.', 1, 3, 4),
(5, NULL, NULL, 2, 1, 1),
(6, NULL, NULL, 2, 3, 2),
(7, '2026-03-10', NULL, 2, 2, 3),
(8, '2026-02-21', 'Consequuntur delectus sed laudantium debitis et ex.', 2, 1, 4),
(9, NULL, 'Et ut sit vel laboriosam voluptas tempore facilis.', 3, 3, 1),
(10, NULL, 'Deleniti et consequatur iste et consequatur dolores.', 3, 3, 3),
(11, '2026-01-29', 'Dolores est deserunt sit at voluptatem ea at.', 4, 2, 2),
(12, NULL, NULL, 4, 1, 3),
(13, '2026-01-21', NULL, 4, 2, 4),
(14, NULL, NULL, 5, 3, 2),
(15, NULL, NULL, 5, 1, 3),
(16, NULL, NULL, 5, 2, 4),
(17, NULL, NULL, 6, 1, 1),
(18, '2026-01-28', NULL, 6, 3, 3),
(19, NULL, NULL, 6, 1, 4),
(20, NULL, NULL, 7, 1, 1),
(21, '2026-01-24', NULL, 7, 3, 2),
(22, NULL, NULL, 7, 3, 3),
(23, '2026-01-30', 'Sunt et magni consectetur voluptatem quos dolor.', 8, 2, 3),
(24, '2026-02-26', NULL, 8, 1, 4),
(25, NULL, NULL, 9, 3, 1),
(26, '2026-02-15', NULL, 9, 3, 2),
(27, NULL, NULL, 9, 3, 3),
(28, NULL, NULL, 9, 2, 4),
(29, NULL, 'Doloremque ducimus quam ratione aut qui.', 10, 2, 1),
(30, NULL, NULL, 10, 2, 2),
(31, NULL, NULL, 10, 3, 4),
(32, NULL, 'Et facere veniam quisquam vel.', 11, 3, 1),
(33, NULL, NULL, 11, 1, 2),
(34, '2026-02-02', NULL, 11, 3, 4),
(35, '2026-02-23', NULL, 12, 1, 1),
(36, NULL, NULL, 12, 3, 2),
(37, '2026-02-28', NULL, 12, 1, 3),
(38, NULL, NULL, 14, 3, 2),
(39, '2026-02-27', NULL, 15, 2, 1),
(40, '2026-02-18', 'Expedita earum enim suscipit illum quo non.', 15, 2, 2),
(41, '2026-02-16', 'Aut ab corporis sed consequatur aut sed nobis.', 15, 2, 3),
(42, NULL, NULL, 15, 2, 4),
(43, '2026-01-23', NULL, 16, 1, 1),
(44, NULL, NULL, 16, 2, 3),
(45, NULL, 'Voluptas impedit consectetur in quia nisi hic.', 17, 3, 1),
(46, '2026-03-06', NULL, 17, 2, 2),
(47, NULL, 'Aut est qui quia quis accusamus sit soluta.', 17, 2, 3),
(48, NULL, 'Est harum enim qui aspernatur voluptate.', 17, 1, 4),
(49, NULL, NULL, 18, 2, 2),
(50, NULL, NULL, 18, 1, 4),
(51, '2026-02-08', 'Rerum reiciendis ut excepturi aut laborum tempora.', 19, 3, 1),
(52, NULL, NULL, 19, 2, 3),
(53, NULL, NULL, 19, 2, 4),
(54, NULL, NULL, 20, 2, 1),
(55, NULL, NULL, 20, 3, 2),
(56, '2026-03-05', NULL, 20, 2, 3),
(57, NULL, NULL, 21, 2, 1),
(58, NULL, NULL, 22, 1, 1),
(59, NULL, 'Dolore facere et officia molestias non.', 22, 1, 2),
(60, '2026-03-07', NULL, 22, 3, 3),
(61, NULL, NULL, 22, 2, 4),
(62, NULL, 'Aliquam porro ipsa sit non tempore aut voluptate sapiente.', 23, 3, 1),
(63, NULL, NULL, 23, 2, 3),
(64, '2026-02-10', NULL, 23, 2, 4),
(65, NULL, NULL, 24, 1, 1),
(66, '2026-02-21', NULL, 24, 1, 2),
(67, '2026-03-05', NULL, 24, 1, 3),
(68, '2026-01-15', 'Id quod et repellendus culpa eos minima rem tenetur.', 25, 3, 1),
(69, '2026-02-22', NULL, 25, 3, 2),
(70, NULL, NULL, 25, 1, 3),
(71, '2026-03-10', NULL, 25, 1, 4),
(72, '2026-01-25', NULL, 26, 2, 3),
(73, '2026-02-28', NULL, 26, 3, 4),
(74, '2026-02-26', NULL, 27, 2, 1),
(75, NULL, 'Recusandae exercitationem dignissimos facilis qui unde eaque officiis.', 27, 3, 2),
(76, '2026-03-02', NULL, 27, 3, 3),
(77, NULL, NULL, 28, 1, 1),
(78, NULL, NULL, 28, 1, 2),
(79, '2026-03-10', NULL, 28, 2, 3),
(80, '2026-01-21', 'Aut enim vel ratione eos.', 28, 2, 4),
(81, NULL, NULL, 29, 3, 1),
(82, '2026-02-14', NULL, 29, 1, 2),
(83, NULL, NULL, 30, 1, 1),
(84, NULL, NULL, 30, 1, 2),
(85, NULL, NULL, 31, 3, 2),
(86, '2026-03-07', 'Ut et accusamus temporibus sint possimus quaerat possimus molestiae.', 31, 2, 4),
(87, '2026-02-23', NULL, 32, 2, 1),
(88, '2026-03-01', NULL, 32, 1, 2),
(89, NULL, NULL, 32, 3, 4),
(90, NULL, 'Eos eius dolorem eaque quam nam ipsam quasi.', 33, 3, 1),
(91, NULL, NULL, 33, 1, 2),
(92, '2026-01-25', NULL, 33, 1, 3),
(93, '2026-01-31', NULL, 33, 1, 4),
(94, '2026-01-15', NULL, 34, 2, 2),
(95, NULL, NULL, 34, 3, 4),
(96, NULL, NULL, 35, 3, 1),
(97, '2026-01-17', 'Qui maiores autem aut reiciendis deserunt unde.', 35, 2, 3),
(98, NULL, NULL, 35, 1, 4);

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
(1, 'Claude', 'Brunel', 2026, 0, 2),
(2, 'Éléonore', 'Cousin', 2026, 0, 2),
(3, 'Adrien', 'Blanc', 2026, 0, 2),
(4, 'Inès', 'Gimenez', 2026, 0, 1),
(5, 'Élise', 'Leduc', 2026, 0, 2),
(6, 'Christelle', 'Perret', 2026, 0, 1),
(7, 'Xavier', 'Fischer', 2026, 0, 2),
(8, 'Rémy', 'Daniel', 2026, 0, 2),
(9, 'Daniel', 'Fournier', 2026, 0, 1),
(10, 'Lucas', 'Pereira', 2026, 1, 2),
(11, 'Marcelle', 'Gilles', 2026, 0, 1),
(12, 'Virginie', 'Chevallier', 2026, 0, 2),
(13, 'Virginie', 'Lefebvre', 2026, 0, 1),
(14, 'Marthe', 'Bonnet', 2026, 0, 2),
(15, 'Nicolas', 'Marchand', 2026, 0, 2),
(16, 'Aurélie', 'Carre', 2026, 0, 2),
(17, 'Constance', 'Masson', 2026, 0, 1),
(18, 'Susanne', 'Boucher', 2026, 0, 1),
(19, 'Louise', 'Leconte', 2026, 0, 2),
(20, 'Arthur', 'Vincent', 2026, 0, 1),
(21, 'Susanne', 'Breton', 2026, 0, 1),
(22, 'Adèle', 'Roux', 2026, 0, 1),
(23, 'Éric', 'Renard', 2026, 1, 1),
(24, 'Margot', 'Perez', 2026, 0, 2),
(25, 'Isabelle', 'Girard', 2026, 0, 2),
(26, 'Aurélie', 'Pereira', 2026, 0, 2),
(27, 'Matthieu', 'Gomes', 2026, 0, 1),
(28, 'Denise', 'Maury', 2026, 0, 1),
(29, 'Jules', 'Imbert', 2026, 0, 2),
(30, 'Henri', 'Lucas', 2026, 0, 1),
(31, 'Frédérique', 'Mathieu', 2026, 0, 2),
(32, 'Thibaut', 'Jacques', 2026, 0, 2),
(33, 'Étienne', 'Bouvet', 2026, 0, 2),
(34, 'Céline', 'Tanguy', 2026, 0, 1),
(35, 'Julien', 'Laporte', 2026, 0, 1);

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
(1, 'admin@campus-la-chataigneraie.org', '$2y$13$FPz9ZmFncD655sDtlJ.Bu.jtcP.//8w0W62GwK3o8U4E8WzWlncwG', 'Admin', 'Lycée'),
(2, 'secretaire@campus-la-chataigneraie.org', '$2y$13$1/AYpBGVlFI8jZ0to64FXOdkNF2TqxC6LfcfjzMoF6lgqjfbxaJsG', 'Secrétaire', 'Lycée'),
(3, 'catherine.baranger@campus-la-chataigneraie.org', '$2y$13$VZeAN.hH.LWVBSeoHhr4ZO3r9rWQAP9xLL6GhUtDk0laAG7RZuZZe', 'Catherine', 'Baranger'),
(4, 'rejane.boursier@campus-la-chataigneraie.org', '$2y$13$FeHX/br1wIFrrGmvoR9JveiD9Rxf/x3K13ahCpL3bnEBBCrdfMyae', 'Réjane', 'Boursier'),
(5, 'sandrine.ternisien@campus-la-chataigneraie.org', '$2y$13$Cg1QVZhW.dpAEuP6vy3Gru1g4OM.R9aGATa4h32FW7U.cud1Equh.', 'Sandrine', 'Ternisien'),
(6, 'nathalie.grandin@campus-la-chataigneraie.org', '$2y$13$I.kY1sqmaTuVJ3.LzXmEYe2cvtcMD2RCSGC7lE/HTU8e33qBOvGo2', 'Nathalie', 'Grandin'),
(7, 'marie.serrault@campus-la-chataigneraie.org', '$2y$13$qX//xCHNdei1vFjGYJqOl.AJOOGQ70rv6oh9yEN3oH7mJPot6hvAq', 'Marie', 'Serrault'),
(8, 'christophe.baudoux@campus-la-chataigneraie.org', '$2y$13$VgU5VkJ7scRBzqWFr4/2puVNT4odvviutPsud9Nn/fEYaPHmuhSwq', 'Christophe', 'Baudoux'),
(9, 'antoine.bloyet@campus-la-chataigneraie.org', '$2y$13$ifzbFkMzkrwL3R8v3eR9du1.RSBAT6bCXgxBSQMI4uF1mLamH95hy', 'Antoine', 'Bloyet'),
(10, 'kevin.bayeul@campus-la-chataigneraie.org', '$2y$13$01dXczAAXxTLNVyxhkIQcu35HW/eVhqJQYfl.XH3kcWAew17qzCPC', 'Kévin', 'Bayeul'),
(11, 'laurent.maurice@campus-la-chataigneraie.org', '$2y$13$x8OQPV/pOOu07nyoWA2Rse4zrueCBZzsyBnJUEN5GUEOLIprBJC6O', 'Laurent', 'Maurice'),
(12, 'robin.szylobryt@campus-la-chataigneraie.org', '$2y$13$zZOi0gb4j8FN7IBmfluNFO9b3lQDon5QF8Ay0Jq8dxX.8gq.VmOZm', 'Robin', 'Szylobryt');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

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
