CREATE TABLE IF NOT EXISTS Utilisateur
(
	idUtilisateur INTEGER NOT NULL PRIMARY KEY,
	nom VARCHAR(25) NOT NULL,
	prenom VARCHAR(25) NOT NULL,
	email VARCHAR(200) NOT NULL,
	motDePasse VARCHAR(64) NOT NULL, -- Un VARCHAR de longueur 64 pour contenir un mot de passe hashé avec l'algorithme SHA-256.
	role ENUM('Utilisateur', 'Administrateur') NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Gestionnaire
(
	idGestionnaire INTEGER NOT NULL PRIMARY KEY,
	CONSTRAINT FK_Gestionnaire_Utilisateur FOREIGN KEY (idGestionnaire) REFERENCES Utilisateur(idUtilisateur) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Tournoi
(
	idTournoi INTEGER NOT NULL PRIMARY KEY,
	nom VARCHAR(25) NOT NULL,
	dateDeb DATE NOT NULL,
	duree INTEGER NOT NULL,
	idGestionnaire INTEGER NOT NULL,
	lieu VARCHAR(25) NOT NULL,
	CONSTRAINT FK_Tournoi_Gestionnaire FOREIGN KEY (idGestionnaire) REFERENCES Gestionnaire(idGestionnaire) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Type
(
	idType INTEGER NOT NULL PRIMARY KEY,
	idTournoi INTEGER NOT NULL,
	typeTournoi ENUM('Concours', 'Compétition'),
	CONSTRAINT FK_Type_Tournoi FOREIGN KEY (idTournoi) REFERENCES Tournoi(idTournoi) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Equipe
(
	idEquipe INTEGER NOT NULL PRIMARY KEY,
	idTournoi INTEGER NOT NULL,
	nomEquipe VARCHAR(25) NOT NULL,
	niveau INTEGER DEFAULT 0,
	adresse VARCHAR(50) NOT NULL,
	numTel VARCHAR(15) NOT NULL,
	CONSTRAINT FK_Equipe_Tournoi FOREIGN KEY (idTournoi) REFERENCES Tournoi(idTournoi) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Joueur
(
	idJoueur INTEGER NOT NULL PRIMARY KEY,
	idEquipe INTEGER NOT NULL,
	estCapitaine BOOLEAN NOT NULL,
	CONSTRAINT FK_Joueur_Utilisateur FOREIGN KEY (idJoueur) REFERENCES Utilisateur(idUtilisateur) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_Joueur_Equipe FOREIGN KEY (idEquipe) REFERENCES Equipe(idEquipe) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS MatchT
(
	idMatchT INTEGER NOT NULL PRIMARY KEY,
	idTournoi INTEGER NOT NULL,
	date DATE NOT NULL,
	horaire TIME NOT NULL,
	CONSTRAINT FK_MatchT_Tournoi FOREIGN KEY (idTournoi) REFERENCES Tournoi(idTournoi) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS EquipeMatchT
(
	idEquipe INTEGER NOT NULL,
	idMatchT INTEGER NOT NULL,
	score INTEGER NOT NULL,
	CONSTRAINT PK_EquipeMatchT PRIMARY KEY (idEquipe, idMatchT),
	CONSTRAINT FK_EquipeMatchT_Equipe FOREIGN KEY (idEquipe) REFERENCES Equipe(idEquipe) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_EquipeMatchT_MatchT FOREIGN KEY (idMatchT) REFERENCES MatchT(idMatchT) ON UPDATE CASCADE ON DELETE CASCADE
) DEFAULT CHARSET=utf8;