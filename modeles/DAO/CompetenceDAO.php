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
    /**
     * Creer un objet Competence a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Competence
     */
    private function buildDomainObject(array $row) {
        $competence = new Competence();
        $competence->hydrate($row);
        return $competence;
    }
    
}
