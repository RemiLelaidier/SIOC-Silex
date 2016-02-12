<?php

namespace SIOC\modeles\DAO;

use SIOC\modeles\donnees\Activite;

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


    /**
     * Creer un objet Activite a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Activite
     */
    private function buildDomainObject(array $row) {
        $activite = new Activite();
        $activite->hydrate($row);
        return $activite;
    }
}
