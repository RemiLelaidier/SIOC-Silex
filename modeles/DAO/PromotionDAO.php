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
        $sql = "SELECT * FROM Promotion WHERE pro_id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    
    public function findAll()
    {
        $sql = "SELECT * FROM Promotion ORDER BY pro_id";
        $result = $this->getDb()->fetchAssoc($sql, array());
        
        $promotions = array();
        foreach ($result as $row) {
            echo $row['pro_id'];
            //$promotionId = $row['pro_id'];
            //$promotions[$promotionId] = $this->buildDomainObject($row);
        }
        return $promotions;
    }

    /**
     * Creer un objet Promotion a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\donnees\Promotion
     */
    protected function buildDomainObject($row) {
        $promotion = new Promotion();
        $promotion->hydrate($row);
        return $promotion;
    }
}
