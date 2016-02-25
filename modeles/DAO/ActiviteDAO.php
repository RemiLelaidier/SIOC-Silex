<?php

namespace SIOC\DAO;

use SIOC\donnees\Activite;
use SIOC\DAO\CompetenceDAO;

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
            $row['act_utilisateur'] = $utilisateur->findbyActivite($id);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($id);
            return $this->buildDomainObject($row);
        }
        else
        {
            throw new \Exception("Aucune activite avec l'id " . $id);
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
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($activiteId);
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
        return $activites;
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
