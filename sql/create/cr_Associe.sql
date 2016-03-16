CREATE TABLE Associe
(
    ass_competence      INTEGER,
    ass_activite        INTEGER,
    PRIMARY KEY(ass_competence, ass_activite),
    FOREIGN KEY(ass_competence) REFERENCES Competence(com_id) ON DELETE CASCADE,
    FOREIGN KEY(ass_activite) REFERENCES Activite(act_id) ON DELETE CASCADE
);