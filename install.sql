CREATE TABLE `personne` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `sexe` varchar(50) NOT NULL,
  `date_de_naissance` timestamp NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `cree_le` timestamp NOT NULL,
  `id_adresse` int NOT NULL
);

CREATE TABLE `adresse` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `numero_voie` int NOT NULL,
  `type_voie` varchar(50) NOT NULL,
  `nom_voie` varchar(255) NOT NULL,
  `complement_adresse` tinytext,
  `ville` varchar(100) NOT NULL,
  `code_postal` int NOT NULL
);

CREATE TABLE `professeur` (
  `id_personne` int PRIMARY KEY NOT NULL,
  `statut` varchar(50) NOT NULL
);

CREATE TABLE `eleve` (
  `id_personne` int PRIMARY KEY NOT NULL,
  `statut` varchar(50) NOT NULL,
  `id_classe` int NOT NULL
);

CREATE TABLE `classe` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `libele` varchar(150) NOT NULL
);

CREATE TABLE `questions` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_professeur` int NOT NULL,
  `id_theme` int NOT NULL,
  `question` tinytext NOT NULL
);

CREATE TABLE `theme` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `libele` varchar(255) NOT NULL
);

CREATE TABLE `questions_reponses` (
  `id_questions` int NOT NULL,
  `id_reponses` int NOT NULL,
  `valeur` varchar(50) NOT NULL,
  PRIMARY KEY (`id_questions`, `id_reponses`)
);

CREATE TABLE `reponses` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `reponse` tinytext NOT NULL
);

CREATE TABLE `qcm` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_theme` int NOT NULL,
  `libele` varchar(255) NOT NULL,
  `cree_le` timestamp NOT NULL,
  `date_limite` timestamp NOT NULL,
  `id_professeur` int NOT NULL
);

CREATE TABLE `qcm_questions` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_question` int NOT NULL,
  `id_qcm` int NOT NULL
);

CREATE TABLE `reponses_eleve` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_reponses` int NOT NULL,
  `id_qcm_questions` int NOT NULL,
  `id_eleve` int NOT NULL
);

CREATE TABLE `note_eleve` (
  `id_eleve` int NOT NULL,
  `id_qcm` int NOT NULL,
  `note` float NOT NULL,
  PRIMARY KEY (`id_eleve`, `id_qcm`)
);

CREATE TABLE `classe_qcm` (
  `id_classe` int NOT NULL,
  `id_qcm` int NOT NULL,
  PRIMARY KEY (`id_classe`, `id_qcm`)
);

CREATE TABLE `articles` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `article` tinytext NOT NULL,
  `ajoute_le` timestamp NOT NULL
);

ALTER TABLE `personne` ADD FOREIGN KEY (`id_adresse`) REFERENCES `adresse` (`id`);

ALTER TABLE `professeur` ADD FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id`);

ALTER TABLE `eleve` ADD FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id`);

ALTER TABLE `eleve` ADD FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`);

ALTER TABLE `questions` ADD FOREIGN KEY (`id_professeur`) REFERENCES `professeur` (`id_personne`);

ALTER TABLE `questions` ADD FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id`);

ALTER TABLE `questions_reponses` ADD FOREIGN KEY (`id_questions`) REFERENCES `questions` (`id`);

ALTER TABLE `questions_reponses` ADD FOREIGN KEY (`id_reponses`) REFERENCES `reponses` (`id`);

ALTER TABLE `qcm` ADD FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id`);

ALTER TABLE `qcm` ADD FOREIGN KEY (`id_professeur`) REFERENCES `professeur` (`id_personne`);

ALTER TABLE `qcm_questions` ADD FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`);

ALTER TABLE `qcm_questions` ADD FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`);

ALTER TABLE `reponses_eleve` ADD FOREIGN KEY (`id_reponses`) REFERENCES `reponses` (`id`);

ALTER TABLE `reponses_eleve` ADD FOREIGN KEY (`id_qcm_questions`) REFERENCES `qcm_questions` (`id`);

ALTER TABLE `reponses_eleve` ADD FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_personne`);

ALTER TABLE `note_eleve` ADD FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_personne`);

ALTER TABLE `note_eleve` ADD FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`);

ALTER TABLE `classe_qcm` ADD FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`);

ALTER TABLE `classe_qcm` ADD FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`);
