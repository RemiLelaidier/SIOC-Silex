/**
 * Author:  leetspeakv2
 * Created: 4 févr. 2016
 */

CREATE TABLE Activite
(
    act_id                  INTEGER         auto_increment,
    act_debut               DATE,
    act_duree               INTEGER,
    act_libelle             VARCHAR(35),
    act_description         VARCHAR(350),
    PRIMARY KEY(act_id)
);