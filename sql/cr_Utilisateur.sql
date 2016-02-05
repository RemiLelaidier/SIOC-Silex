/**
 * Author:  leetspeakv2
 * Created: 4 févr. 2016
 */

CREATE TABLE Utilisateur
(
    uti_id          INTEGER         auto_increment,
    uti_mail        VARCHAR(50),
    uti_nom         VARCHAR(75),
    uti_prenom      VARCHAR(45),
    uti_password    VARCHAR(45),
    uti_statut      INTEGER,
    PRIMARy KEY(uti_id)
);