<?php

namespace SIOC\DAO;

use SIOC\donnees\Activite;
use SIOC\DAO\CompetenceDAO;
use SIOC\DAO\UtilisateurDAO;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier Yoken Babel José Lopes
 */
class ActiviteDAO extends DAO
{
    public function find($id) {
        $sql = "SELECT * FROM Activite WHERE act_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($id);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($id);
            return $this->buildDomainObject($row);
        }
    }

    // TODO
    // Methode findAll //
    public function findAll()
    {
        $sql = "SELECT * FROM Activite";
        $result = $this->getDb()->fetchAll($sql, array());

        // Convertit le resultat de la requete en tableau //
        $activites = array();
        foreach ($result as $row) {
            $activiteId = $row['act_id'];
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($activiteId);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($activiteId);
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
        return $activites;
    }
    
    public function findAllbyUtilisateur($utilisateurId)
    {
        $sql = "SELECT A.act_id, A.act_debut, A.act_duree, A.act_libelle, A.act_description"
                . " FROM Activite AS A, Utilisateur AS U"
                . " WHERE A.act_eleve = U.uti_id"
                . " AND U.uti_id = ?";
        $result = $this->getDb()->fetchAssoc($sql, array($utilisateurId));
        $activites = array();
        foreach($result as $row) {
            $activiteId = $row['act_id'];
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($activiteId);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($activiteId);
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
    }

    /**
     * Creer un objet Activite a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Activite
     */
   protected function buildDomainObject($row) {
        $activite = new Activite();
        $activite->hydrate($row);
        return $activite;
    }
}
