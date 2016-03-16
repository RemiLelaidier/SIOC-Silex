CREATE TABLE Faitpartie
(
    fap_eleve       INTEGER,
    fap_promo       INTEGER,
    PRIMARY KEY(fap_eleve, fap_promo),
    FOREIGN KEY(fap_eleve) REFERENCES Utilisateur(uti_id) ON DELETE CASCADE,
    FOREIGN KEY(fap_promo) REFERENCES Promotion(pro_id) ON DELETE CASCADE
);