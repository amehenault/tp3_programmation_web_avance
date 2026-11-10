SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `journal`;
DROP TABLE IF EXISTS `post_categorie`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

--
-- Table users
--

CREATE TABLE `users` (
  `idUsers` int unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(45) NOT NULL DEFAULT 'client',
  PRIMARY KEY (`idUsers`),
  UNIQUE KEY `Email_UNIQUE` (`Email`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`idUsers`, `Nom`, `Email`, `Username`, `Password`, `Role`) VALUES
(1, 'Amé', 'ame@example.com', 'admin', '$2y$12$fGNt90YbDtfGe5.Du4Qlw.ug2QYK4MRfbXoeCJeimyR.dj02QZYu2', 'admin'),
(2, 'Alex', 'alex@example.com', 'alex', '$2y$12$/MhXt0LFJY9qHv95Kun7ge2ub94nMIYBY3JI8soqkFuEvMzkY80N.', 'client');

--
-- Table categories
--

CREATE TABLE `categories` (
  `idCategories` int unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) NOT NULL,
  PRIMARY KEY (`idCategories`),
  UNIQUE KEY `Nom_UNIQUE` (`Nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`idCategories`, `Nom`) VALUES
(1, 'Design'),
(2, 'Programmation'),
(3, 'Entrepreneuriat'),
(4, 'Marketing');

--
-- Table posts
--

CREATE TABLE `posts` (
  `idPosts` int unsigned NOT NULL AUTO_INCREMENT,
  `Titre` varchar(255) NOT NULL,
  `Contenu` longtext NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `Users_idUsers` int unsigned NOT NULL,
  PRIMARY KEY (`idPosts`),
  KEY `fk_Posts_Users1_idx` (`Users_idUsers`),
  CONSTRAINT `fk_Posts_Users1` FOREIGN KEY (`Users_idUsers`) REFERENCES `users` (`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `posts` (`idPosts`, `Titre`, `Contenu`, `Image`, `Create_at`, `update_at`, `Users_idUsers`) VALUES
(1, 'Choisir une palette de couleurs', 'Créer son univers visuel sans le changer dans 3 mois', '91b26b357a8b9dcc5084.jpg', '2026-09-22 10:52:37', NULL, 1),
(2, 'Comprendre la programmation orientée objet', 'Introduction aux classes et aux objets.', '7fbc86ff66e715ef0d9b.jpg', '2026-09-22 10:52:37', NULL, 1),
(3, 'Créer une identité visuelle cohérente', 'Les éléments importants pour construire une identité forte.', '2f4a8490ba68737621fc.jpg', '2026-09-22 10:52:37', '2026-09-22 17:10:21', 1);

--
-- Table post_categorie
--

CREATE TABLE `post_categorie` (
  `idPost_Categories` int NOT NULL AUTO_INCREMENT,
  `Categories_idCategories` int unsigned NOT NULL,
  `Posts_idPosts1` int unsigned NOT NULL,
  PRIMARY KEY (`idPost_Categories`),
  KEY `fk_Post_categorie_Categories1_idx` (`Categories_idCategories`),
  KEY `fk_Post_categorie_Posts1_idx` (`Posts_idPosts1`),
  CONSTRAINT `fk_Post_categorie_Categories1` FOREIGN KEY (`Categories_idCategories`) REFERENCES `categories` (`idCategories`),
  CONSTRAINT `fk_Post_categorie_Posts1` FOREIGN KEY (`Posts_idPosts1`) REFERENCES `posts` (`idPosts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `post_categorie` (`idPost_Categories`, `Categories_idCategories`, `Posts_idPosts1`) VALUES
(1, 1, 3);

--
-- Table journal (journal de bord des visites)
--

CREATE TABLE `journal` (
  `idJournal` int unsigned NOT NULL AUTO_INCREMENT,
  `Ip` varchar(45) NOT NULL,
  `Date_visite` datetime NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Page` varchar(255) NOT NULL,
  PRIMARY KEY (`idJournal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
