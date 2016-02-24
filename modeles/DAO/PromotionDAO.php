<?php

namespace SIOC\DAO;

use SIOC\donnees\Promotion;

/**
 * Description of PromotionDAO
 *
 * @author Remi Lelaidier
 */
class PromotionDAO extends DAO
{
    public function find($id) {
        $sql = "SELECT * FROM Promotion WHERE pro_id";
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
    protected function buildDomainObject($row) {
        $promotion = new Promotion();
        $promotion->hydrate($row);
        return $promotion;
    }
}
