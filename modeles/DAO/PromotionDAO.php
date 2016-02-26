<?php

namespace SIOC\DAO;

use SIOC\donnees\Promotion;
use SIOC\DAO\UtilisateurDAO;

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
            $eleves = new UtilisateurDAO($this->getDb());
            $row['pro_eleves'] = $eleves->findbyPromotion($id);
            return $this->buildDomainObject($row);
        }
    }
    
    public function findAll()
    {
        $sql = "SELECT * FROM Promotion ORDER BY pro_id";
        $result = $this->getDb()->fetchAll($sql, array());
        
        $promotions = array();
        foreach ($result as $row) {
            $promotionId = $row['pro_id'];
            $eleves = new UtilisateurDAO($this->getDb());
            $row['pro_eleves'] = $eleves->findbyPromotion($promotionId);
            $promotions[$promotionId] = $this->buildDomainObject($row);
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
