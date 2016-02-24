<?php

namespace SIOC\DAO;

use SIOC\donnees\Activite;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class ActiviteDAO extends DAO
{
    public function find($id) {
        $sql = "SELECT * FROM Activite WHERE act_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune activite avec l'id " . $id);
    }

    // Methode findAll //
    public function findAll() {
        $sql = "SELECT * FROM Activite ORDER BY act_id=?";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le resultat de la requete en tableau //
        $activites = array();
        foreach ($activite as $row) {
            $activiteId = $row['act_id'];
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
        return $activites;


    /**
     * Creer un objet Activite a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Activite
     */
    protected function buildDomainObject($row) {
        $activite = new Activite();
        $activite->setId($row['act_id']);
        $activite->hydrate($row);
        return $activite;
    }
    
    // relations
    
    private $utilisateurDAO;

    public function setUserDAO(UtilisateurDAO $user){
        $this->utilisateurDAO = $utilisateurDAO;
    }
    
    private $competenceDAO;
    
    public function setCompetenceDAO(CompetenceDAO $competence){
        $this->competenceDAO = $competenceDAO;
    }
}
