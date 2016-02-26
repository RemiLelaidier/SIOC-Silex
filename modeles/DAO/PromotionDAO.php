<?php

namespace SIOC\DAO;

use SIOC\donnees\Promotion;
use SIOC\DAO\UtilisateurDAO;

/**
 * Description of PromotionDAO
 *
 * @author SIO PTFQ
 */
class PromotionDAO extends DAO
{
    /**
     * Trouve la promotion a l'id corrspondante
     *
     * @param integer $id
     * @return \SIOC\donnees\Promotion
     */
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
    
    /**
     * Trouve toutes les promotions
     *
     * @param none
     * @return array(\SIOC\donnees\Promotion)
     */
    public function findAll()
    {
        $sql = "SELECT * FROM Promotion ORDER BY pro_id";
        $result = $this->getDb()->fetchAll($sql, array());
        
        $promotions = array();
        foreach ($result as $row) {
            $promotionId = $row['pro_id'];
            $eleves = new UtilisateurDAO($this->getDb());
            $row['pro_eleves'] = $eleves->findAllbyPromotion($promotionId);
            $promotions[$promotionId] = $this->buildDomainObject($row);
        }
        return $promotions;
    }

    /**
     * Creer une Promotion a partir d'un tuple
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
