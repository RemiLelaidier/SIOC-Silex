<?php

namespace SIOC\modeles\DAO;

use SIOC\modeles\donnees\Promotion;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class PromotionDAO extends DAO
{
    public function find($id) {
        $sql = "SELECT * FROM Promotion WHERE pro_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune competence avec l'id " . $id);
    }

    /**
     * Creer un objet Promotion a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Promotion
     */
    private function buildDomainObject(array $row) {
        $promotion = new Promotion();
        $promotion->hydrate($row);
        return $promotion;
    }
}
