-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 27 mai 2021 à 10:24
-- Version du serveur :  8.0.25-0ubuntu0.20.04.1
-- Version de PHP :  7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `Equipe`
--

CREATE TABLE `Equipe` (
  `idEquipe` int NOT NULL,
  `nomEquipe` varchar(25) NOT NULL,
  `niveau` int DEFAULT '0',
  `adresse` varchar(50) NOT NULL,
  `numTel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Equipe`
--

INSERT INTO `Equipe` (`idEquipe`, `nomEquipe`, `niveau`, `adresse`, `numTel`) VALUES
(1, 'NULLA', 0, 'Une adresse 1', '11-11-11-11-11-'),
(2, 'NULLB', 0, 'Une adresse 2', '22-22-22-22-22'),
(3, 'MARSEILLE', 0, 'Une adresse 3', '03-04-03-04-03'),
(4, 'LYON', 0, 'Une adresse 4', '04-05-04-05-04'),
(5, 'ST-ETIENNE', 0, 'Une adresse 5', '05-06-05-06-05'),
(6, 'FC BARCELONA', 0, 'Une adresse 7', '02-03-02-03-06'),
(7, 'LIVERPOOL', 0, 'Une adresse 8', '03-04-03-04-07'),
(8, 'CHELSEA', 0, 'Une adresse 9', '04-05-04-05-08'),
(9, 'MANCHESTER', 0, 'Une adresse 10', '05-06-05-06-09'),
(10, 'PSG', 0, 'Une adresse 11', '01-02-01-02-01'),
(11, 'BORDEAUX', 0, 'Une adresse 12', '02-03-02-03-02'),
(12, 'Gods', 0, 'Une adresse 666', '66-66-66-66-66');

-- --------------------------------------------------------

--
-- Structure de la table `EquipeMatchT`
--

CREATE TABLE `EquipeMatchT` (
  `idEquipe` int NOT NULL,
  `idMatchT` int NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `EquipeMatchT`
--

INSERT INTO `EquipeMatchT` (`idEquipe`, `idMatchT`, `score`) VALUES
(5, 3, 0),
(5, 11, -1),
(6, 4, 2),
(6, 11, -1),
(7, 4, 7),
(7, 6, 5),
(7, 7, 1),
(7, 10, -1),
(8, 3, 8),
(8, 6, 4),
(8, 9, -1),
(9, 2, 9),
(9, 5, 1),
(9, 8, -1),
(10, 1, 7),
(10, 8, -1),
(11, 1, 9),
(11, 5, 5),
(11, 7, 8),
(11, 9, -1),
(12, 2, 8),
(12, 10, -1);

-- --------------------------------------------------------

--
-- Structure de la table `EquipePoule`
--

CREATE TABLE `EquipePoule` (
  `idEquipe` int NOT NULL,
  `idPoule` int NOT NULL,
  `idMatchT` int NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `EquipeTournoi`
--

CREATE TABLE `EquipeTournoi` (
  `idEquipe` int NOT NULL,
  `idTournoi` int NOT NULL,
  `estInscrite` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `EquipeTournoi`
--

INSERT INTO `EquipeTournoi` (`idEquipe`, `idTournoi`, `estInscrite`) VALUES
(5, 1, 1),
(5, 3, 1),
(5, 4, 1),
(6, 1, 1),
(6, 3, 1),
(6, 4, 1),
(7, 1, 1),
(7, 3, 1),
(7, 4, 1),
(8, 1, 1),
(8, 3, 1),
(8, 4, 1),
(9, 1, 1),
(9, 3, 1),
(9, 4, 1),
(10, 1, 1),
(10, 3, 1),
(10, 4, 1),
(11, 1, 1),
(11, 3, 1),
(11, 4, 1),
(12, 1, 1),
(12, 3, 1),
(12, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Gestionnaire`
--

CREATE TABLE `Gestionnaire` (
  `idGestionnaire` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Gestionnaire`
--

INSERT INTO `Gestionnaire` (`idGestionnaire`) VALUES
(2),
(14),
(16);

-- --------------------------------------------------------

--
-- Structure de la table `Joueur`
--

CREATE TABLE `Joueur` (
  `idJoueur` int NOT NULL,
  `idEquipe` int NOT NULL,
  `estCapitaine` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Joueur`
--

INSERT INTO `Joueur` (`idJoueur`, `idEquipe`, `estCapitaine`) VALUES
(2, 10, 1),
(3, 10, 0),
(4, 10, 0),
(5, 11, 1),
(6, 11, 0),
(7, 11, 0),
(8, 3, 1),
(9, 3, 0),
(10, 3, 0),
(11, 4, 1),
(12, 4, 0),
(13, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `MatchT`
--

CREATE TABLE `MatchT` (
  `idMatchT` int NOT NULL,
  `idTournoi` int NOT NULL,
  `date` date NOT NULL,
  `horaire` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `MatchT`
--

INSERT INTO `MatchT` (`idMatchT`, `idTournoi`, `date`, `horaire`) VALUES
(1, 1, '2021-06-17', '23:41:00'),
(2, 1, '2021-06-17', '23:41:00'),
(3, 1, '2021-06-11', '23:41:00'),
(4, 1, '2021-05-30', '13:49:00'),
(5, 1, '2021-06-25', '23:41:00'),
(6, 1, '2021-06-30', '23:41:00'),
(7, 1, '2021-07-02', '16:31:00'),
(8, 3, '2021-06-18', '00:23:00'),
(9, 3, '2021-06-18', '00:23:00'),
(10, 3, '2021-06-18', '00:23:00'),
(11, 3, '2021-06-24', '00:23:00'),
(12, 3, '2021-06-25', '00:23:00'),
(13, 3, '2021-06-25', '00:23:00'),
(14, 3, '2021-07-02', '00:23:00');

-- --------------------------------------------------------

--
-- Structure de la table `Poule`
--

CREATE TABLE `Poule` (
  `idPoule` int NOT NULL,
  `idTournoi` int NOT NULL,
  `nbEquipes` int NOT NULL,
  `nomPoule` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `Tournoi`
--

CREATE TABLE `Tournoi` (
  `idTournoi` int NOT NULL,
  `nom` varchar(25) NOT NULL,
  `dateDeb` date NOT NULL,
  `duree` int NOT NULL,
  `idGestionnaire` int NOT NULL,
  `lieu` text NOT NULL,
  `nombreTotalEquipes` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Tournoi`
--

INSERT INTO `Tournoi` (`idTournoi`, `nom`, `dateDeb`, `duree`, `idGestionnaire`, `lieu`, `nombreTotalEquipes`) VALUES
(1, 'COUPE DU MONDE', '2012-12-12', 50, 2, 'Paris (48.859;2.347)', 8),
(3, 'OPEN TENNIS 4', '2021-05-27', 30, 14, 'Saint-Tropez (43.26285;6.658133)', 8),
(4, 'FUTUR', '2021-12-25', 100, 2, 'Carcassonne (43.227434;2.386974)', 8);

-- --------------------------------------------------------

--
-- Structure de la table `Type`
--

CREATE TABLE `Type` (
  `idType` int NOT NULL,
  `idTournoi` int NOT NULL,
  `typeTournoi` enum('Coupe','Championnat','Tournoi') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` int NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(200) NOT NULL,
  `motDePasse` varchar(64) NOT NULL,
  `role` enum('Utilisateur','Administrateur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`idUtilisateur`, `nom`, `prenom`, `email`, `motDePasse`, `role`) VALUES
(1, 'ADMIN', 'Admin', 'admin@test.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Administrateur'),
(2, 'DUJARDIN', 'Jean', 'JeanDujardin@test.com', '4ff17bc8ee5f240c792b8a41bfa2c58af726d83b925cf696af0c811627714c85', 'Utilisateur'),
(3, 'Machin', 'Truc', 'M@T.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(4, 'Jean', 'Dupont', 'J@D.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(5, 'Henri', 'Guibet', 'H@G.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(6, 'Louis', 'De Funès', 'L@F.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(7, 'Jean', 'Gabin', 'J@G.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(8, 'Robert', 'Redford', 'R@R.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(9, 'Lino', 'Ventura', 'L@V.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(10, 'Francis', 'Blanche', 'F@B.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(11, 'Venantino', 'Venantini', 'V@V.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(12, 'Jean', 'Lefevre', 'J@L.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(13, 'Bernard', 'Blier', 'B@B.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(14, 'Line', 'Renaud', 'L@R.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(15, 'Jean-Pierre', 'Marielle', 'JP@M.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(16, 'Jean', 'Rochefort', 'J@R.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(17, 'Jean-Pierre', 'Belmondo', 'JP@B.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(18, 'Philippe', 'Noiret', 'P@N.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(19, 'Claude', 'Rich', 'C@R.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(20, 'Guy', 'Bedos', 'G@B.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(21, 'Claude', 'Brasseur', 'C@B.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(22, 'Pierre', 'Richard', 'P@R.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur'),
(23, 'Mireille', 'Darc', 'M@D.com', '74913f96f46a13995ef292f85deffae7b86a35d5d3180a5581b04b12b7b30245', 'Utilisateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD PRIMARY KEY (`idEquipe`),
  ADD UNIQUE KEY `nomEquipe` (`nomEquipe`),
  ADD UNIQUE KEY `adresse` (`adresse`),
  ADD UNIQUE KEY `numTel` (`numTel`);

--
-- Index pour la table `EquipeMatchT`
--
ALTER TABLE `EquipeMatchT`
  ADD PRIMARY KEY (`idEquipe`,`idMatchT`),
  ADD KEY `FK_EquipeMatchT_MatchT` (`idMatchT`);

--
-- Index pour la table `EquipePoule`
--
ALTER TABLE `EquipePoule`
  ADD PRIMARY KEY (`idEquipe`,`idPoule`,`idMatchT`),
  ADD KEY `FK_EquipePoule_Poule` (`idPoule`),
  ADD KEY `FK_EquipePoule_MatchT` (`idMatchT`);

--
-- Index pour la table `EquipeTournoi`
--
ALTER TABLE `EquipeTournoi`
  ADD PRIMARY KEY (`idEquipe`,`idTournoi`),
  ADD KEY `FK_EquipeTournoi_Tournoi` (`idTournoi`);

--
-- Index pour la table `Gestionnaire`
--
ALTER TABLE `Gestionnaire`
  ADD PRIMARY KEY (`idGestionnaire`);

--
-- Index pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD PRIMARY KEY (`idJoueur`),
  ADD KEY `FK_Joueur_Equipe` (`idEquipe`);

--
-- Index pour la table `MatchT`
--
ALTER TABLE `MatchT`
  ADD PRIMARY KEY (`idMatchT`),
  ADD KEY `FK_MatchT_Tournoi` (`idTournoi`);

--
-- Index pour la table `Poule`
--
ALTER TABLE `Poule`
  ADD PRIMARY KEY (`idPoule`),
  ADD KEY `FK_Poule_Tournoi` (`idTournoi`);

--
-- Index pour la table `Tournoi`
--
ALTER TABLE `Tournoi`
  ADD PRIMARY KEY (`idTournoi`),
  ADD KEY `FK_Tournoi_Gestionnaire` (`idGestionnaire`);

--
-- Index pour la table `Type`
--
ALTER TABLE `Type`
  ADD PRIMARY KEY (`idType`),
  ADD KEY `FK_Type_Tournoi` (`idTournoi`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `EquipeMatchT`
--
ALTER TABLE `EquipeMatchT`
  ADD CONSTRAINT `FK_EquipeMatchT_Equipe` FOREIGN KEY (`idEquipe`) REFERENCES `Equipe` (`idEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EquipeMatchT_MatchT` FOREIGN KEY (`idMatchT`) REFERENCES `MatchT` (`idMatchT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EquipePoule`
--
ALTER TABLE `EquipePoule`
  ADD CONSTRAINT `FK_EquipePoule_Equipe` FOREIGN KEY (`idEquipe`) REFERENCES `Equipe` (`idEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EquipePoule_MatchT` FOREIGN KEY (`idMatchT`) REFERENCES `MatchT` (`idMatchT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EquipePoule_Poule` FOREIGN KEY (`idPoule`) REFERENCES `Poule` (`idPoule`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EquipeTournoi`
--
ALTER TABLE `EquipeTournoi`
  ADD CONSTRAINT `FK_EquipeTournoi_Equipe` FOREIGN KEY (`idEquipe`) REFERENCES `Equipe` (`idEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EquipeTournoi_Tournoi` FOREIGN KEY (`idTournoi`) REFERENCES `Tournoi` (`idTournoi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Gestionnaire`
--
ALTER TABLE `Gestionnaire`
  ADD CONSTRAINT `FK_Gestionnaire_Utilisateur` FOREIGN KEY (`idGestionnaire`) REFERENCES `Utilisateur` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD CONSTRAINT `FK_Joueur_Equipe` FOREIGN KEY (`idEquipe`) REFERENCES `Equipe` (`idEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Joueur_Utilisateur` FOREIGN KEY (`idJoueur`) REFERENCES `Utilisateur` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MatchT`
--
ALTER TABLE `MatchT`
  ADD CONSTRAINT `FK_MatchT_Tournoi` FOREIGN KEY (`idTournoi`) REFERENCES `Tournoi` (`idTournoi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Poule`
--
ALTER TABLE `Poule`
  ADD CONSTRAINT `FK_Poule_Tournoi` FOREIGN KEY (`idTournoi`) REFERENCES `Tournoi` (`idTournoi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Tournoi`
--
ALTER TABLE `Tournoi`
  ADD CONSTRAINT `FK_Tournoi_Gestionnaire` FOREIGN KEY (`idGestionnaire`) REFERENCES `Gestionnaire` (`idGestionnaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Type`
--
ALTER TABLE `Type`
  ADD CONSTRAINT `FK_Type_Tournoi` FOREIGN KEY (`idTournoi`) REFERENCES `Tournoi` (`idTournoi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
