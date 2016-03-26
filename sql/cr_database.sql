/**
 * Author:  leetspeakv2
 * Created: 4 févr. 2016
 */
/**
 * Creation
 */

CREATE TABLE Competence
(
    com_id                  INTEGER         auto_increment,
    com_reference           VARCHAR(10),
    com_libelle             VARCHAR(350),
    com_description         VARCHAR(350),
    com_obligatoire         BOOLEAN,
    PRIMARY KEY(com_id)
)ENGINE=INNODB;

ALTER TABLE Competence AUTO_INCREMENT = 1;

CREATE TABLE Promotion
(
    pro_id          INTEGER         auto_increment,
    pro_libelle     VARCHAR(45),
    pro_annee       INTEGER,
    PRIMARY KEY(pro_id)
);

ALTER TABLE Promotion AUTO_INCREMENT = 1;

CREATE TABLE Utilisateur
(
    uti_id          INTEGER         auto_increment,
    uti_mail        VARCHAR(50),
    uti_username    VARCHAR(35),
    uti_nom         VARCHAR(75),
    uti_prenom      VARCHAR(45),
    uti_password    VARCHAR(255),
    uti_salt        VARCHAR(25),
    uti_role        VARCHAR(20),
    PRIMARY KEY(uti_id)
)ENGINE=INNODB;

ALTER TABLE Utilisateur AUTO_INCREMENT = 1;

CREATE TABLE Activite
(
    act_id                  INTEGER         auto_increment,
    act_debut               INTEGER,
    act_duree               INTEGER,
    act_periode             VARCHAR(25),
    act_libelle             VARCHAR(35),
    act_description         VARCHAR(350),
    act_eleve               INTEGER,
    PRIMARY KEY(act_id),
    CONSTRAINT ActUser
        FOREIGN KEY(act_eleve) REFERENCES Utilisateur(uti_id) 
    ON DELETE CASCADE
)ENGINE=INNODB;

ALTER TABLE Activite AUTO_INCREMENT = 1;

CREATE TABLE Faitpartie
(
    fap_eleve       INTEGER,
    fap_promo       INTEGER,
    PRIMARY KEY(fap_eleve, fap_promo),
    CONSTRAINT FapUser
        FOREIGN KEY(fap_eleve) REFERENCES Utilisateur(uti_id) 
    ON DELETE CASCADE,
    CONSTRAINT FapPro
        FOREIGN KEY(fap_promo) REFERENCES Promotion(pro_id) 
    ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE Associe
(
    ass_competence      INTEGER,
    ass_activite        INTEGER,
    PRIMARY KEY(ass_competence, ass_activite),
    CONSTRAINT AssComp
        FOREIGN KEY(ass_competence) REFERENCES Competence(com_id) 
    ON DELETE CASCADE,
    CONSTRAINT AssAct
        FOREIGN KEY(ass_activite) REFERENCES Activite(act_id) 
    ON DELETE CASCADE
)ENGINE=INNODB;

/*
 *  Remplissage
 */
INSERT INTO Competence(com_reference, com_libelle, com_description ,com_obligatoire) VALUES
('SO1', 'Participation à un projet d’évolution d’un SI (solution applicative et d’infrastructure portant prioritairement sur le domaine de spécialité du candidat)', 'desc' ,1),
('SO2', 'Prise en charge d’incidents et de demandes d’assistance liés au domaine de spécialité du candidat', 'desc' ,1),
('SO3', 'Elaboration de documents relatifs à la production et à la fourniture de services', 'desc' ,1),
('SO4', 'Productions relatives à la mise en place d’un dispositif de veille technologique et à l’étude d’une technologie, d’un composant, d’un outil ou d’une méthode', 'desc' ,1),
('A1.1.1', 'Analyse du cahier des charges d''un service à produire', 'desc' ,0),
('A1.1.2', 'Étude de l''impact de l''intégration d''un service sur le système informatique','desc',0),
('A1.1.3', 'Étude des exigences liées à la qualité attendue d''un service','desc',0),
('A1.2.1', 'Élaboration et présentation d''un dossier de choix de solution technique','desc',0),
('A1.2.2', 'Rédaction des spécifications techniques de la solution retenue','desc',0),
('A1.2.3', 'Évaluation des risques liés à l''utilisation d''un service','desc',0),
('A1.2.4', 'Détermination des tests nécessaires à la validation d''un service','desc',0),
('A1.2.5', 'Définition des niveaux d''habilitation associés à un service','desc',0),
('A1.3.1', 'Test d''intégration et d''acceptation d''un service','desc',0),
('A1.3.2', 'Définition des éléments nécessaires à la continuité d''un service','desc',0),
('A1.3.3', 'Accompagnement de la mise en place d''un nouveau service','desc',0),
('A1.3.4', 'Déploiement d''un service', 'desc' ,0),
('A1.4.1', 'Participation à un projet', 'desc' ,0),
('A1.4.2', 'Évaluation des indicateurs de suivi d''un projet et justification des écarts', 'desc' ,0),
('A1.4.3', 'Gestion des ressources', 'desc' ,0),
('A2.1.1', 'Accompagnement des utilisateurs dans la prise en main d''un service', 'desc' ,0),
('A2.1.2', 'Évaluation et maintien de la qualité d''un service', 'desc' ,0),
('A2.2.1', 'Suivi et résolution d''incidents', 'desc' ,0),
('A2.2.2', 'Suivi et réponse à des demandes d''assistance', 'desc' ,0),
('A2.2.3', 'Réponse à une interruption de service', 'desc' ,0),
('A2.3.1', 'Identification, qualification et évaluation d''un problème', 'desc' ,0),
('A2.3.2', 'Proposition d''amélioration d''un service', 'desc' ,0),
('A3.1.1', 'Installation et configuration d’éléments d’infrastructure ','desc', 0),
('A3.1.2', 'Maquettage et prototypage d’une solution d’infrastructure','desc', 0),
('A3.1.3', 'Prise en compte du niveau de sécurité nécessaire à une infrastructure ','desc', 0),
('A3.2.1', 'Installation et configuration d''éléments d''infrastructure ','desc', 0),
('A3.2.2', 'Remplacement ou mise à jour d''éléments défectueux ou obsolètes','desc', 0),
('A3.2.3', 'Mise à jour de la documentation technique d’une solution d’infrastructure\r\n','desc', 0),
('A3.3.1', 'Administration sur site ou à distance des éléments d’un réseau, de serveurs, de services et d’équipements terminaux','desc', 0),
('A3.3.2', 'Appliquer des procédures de sauvegarde et de restauration','desc', 0),
('A3.3.3', 'Gestion des identités et des habilitations\r\n','desc', 0),
('A3.3.4', 'Automatisation des tâches d’administration\r\n','desc', 0),
('A3.3.5', 'Gestion des indicateurs et des fichiers d’activité\r\n','desc', 0),
('A4.1.1', 'Proposition d''une solution applicative','desc', 0),
('A4.1.2', 'Conception ou adaptation de l''interface utilisateur d''une solution applicative','desc', 0),
('A4.1.3', 'Conception ou adaptation d''une base de données','desc', 0),
('A4.1.4', 'Définition des caractéristiques d''une solution applicative','desc', 0),
('A4.1.5', 'Prototypage de composants logiciels','desc', 0),
('A4.1.6', 'Gestion d''environnements de développement et de test','desc', 0),
('A4.1.7', 'Développement, utilisation ou adaptation de composants logiciels','desc', 0),
('A4.1.8', 'Réalisation des tests nécessaires à la validation d''éléments adaptés ou développés ','desc', 0),
('A4.1.9', 'Rédaction d''une documentation technique ','desc', 0),
('A4.1.10', ' Rédaction d''une documentation d''utilisation ','desc', 0),
('A4.2.1', 'Analyse et correction d''un dysfonctionnement, d''un problème de qualité de …','desc', 0),
('A4.2.2', 'Adaptation d''une solution applicative aux évolutions de ses composants','desc', 0),
('A4.2.3', 'Réalisation des tests nécessaires à la mise en production d''éléments mis à jour','desc', 0),
('A4.2.4', 'Mise à jour d''une documentation technique','desc', 0),
('A5.1.1', 'Mise en place d''une gestion de configuration','desc', 0),
('A5.1.2', 'Recueil d''informations sur une configuration et ses éléments','desc', 0),
('A5.1.3', 'Suivi d''une configuration et de ses éléments','desc', 0),
('A5.1.4', 'Étude de propositions de contrat de service (client, fournisseur)','desc', 0),
('A5.1.5', 'Évaluation d''un élément de configuration ou d''une configuration ','desc', 0),
('A5.1.6', 'Évaluation d''un investissement informatique','desc', 0),
('A5.2.1', 'Exploitation des référentiels, normes et standards adoptés par le prestataire','desc', 0),
('A5.2.2', 'Veille technologique','desc', 0),
('A5.2.3', 'Repérage des compléments de formation ou d''auto-formation','desc', 0),
('A5.2.4', 'Étude d‘une technologie, d’un composant, d’un outil ou d’une méthode','desc', 0);

INSERT INTO Promotion(pro_libelle, pro_annee) VALUES
('SIO PTFQ', 2015),
('SIO 1', 2015),
('SIO 2', 2015);

INSERT INTO Utilisateur(uti_mail, uti_username, uti_nom, uti_prenom, uti_password, uti_salt, uti_role) values
('eleve@mail.com','Eleve', 'Eleve', 'Y', 'tJMjCsrGKt2wcuEXw2Ndzgp33plWs1zDBCni2VI1gUqOKk78jAB3lcQNgUNfbZ//VoeI8IxOa/tD2QZjtjSKpQ==', '3be39f6126c2298b8847811', 'ROLE_ELEVE'),
('admin@mail.com','admin', 'Admin', 'X', 'EHU9k4B6s232Sw+pmdyJueS8lR9fyVqSAdPEfC6SYgVS9AKAOmes+3CSsSBB9elJJlwa8mwKSv5ENf7a3GsHig==', 'f1b548d2f6c7c21437d1dea', 'ROLE_ADMIN'),
('prof@mail.com','prof', 'Prof', 'Z', 't+8+7V2KCTYDG+ZVqy4aIL6b3QkIHK2NDkJG+GU7uWi6A87iJnT0qKqp/B1CKsUkzDNIp3znkw/UvCc/X6dcYA==', '1f5487ea04c124931c8a183', 'ROLE_PROF');

INSERT INTO Faitpartie(fap_eleve, fap_promo) VALUES
(1,3);