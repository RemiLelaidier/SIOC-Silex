<?php

namespace SIOC\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Competence;

/**
 * Description of CompetenceDAO
 *
 * @author Remi Lelaidier
 */
class CompetenceDAO extends DAO
{

    public function find($id) {
        $sql = "SELECT * FROM Competence WHERE com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune competence avec l'id " . $id);
    }

    // Methode findAll //
    public function findAll()
    {
        $sql = "SELECT * FROM Competence ORDER BY com_id";
        $result = $this->getDb()->fetchAll($sql, array());

        // Convertit le resultat de la requete en tableau //
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $comptence->setId($row['com_id']);
            $competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    /**
     * Creer un objet Competence a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Competence
     */
    protected function buildDomainObject($row) {
        $competence = new Competence();
        $competence->hydrate($row);
        return $competence;
    }
    
}
