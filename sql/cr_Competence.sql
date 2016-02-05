/**
 * Author:  leetspeakv2
 * Created: 4 févr. 2016
 */

CREATE TABLE Competence
(
    com_id                  INTEGER         auto_increment,
    com_reference           VARCHAR(10),
    com_libelle             VARCHAR(35),
    com_description         VARCHAR(350),
    com_obligatoire         BOOLEAN,
    PRIMARY KEY(com_id)
);