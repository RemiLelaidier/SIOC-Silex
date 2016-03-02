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
        $result = $this->getDb()->fetchAll($sql);
        
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
     * Trouve la promotion d'un eleve passe en Id
     *
     * @param integer $id
     * @return array(\SIOC\donnees\Promotion)
     */
    public function findByEleve($id)
    {
        $sql = "SELECT P.pro_id, P.pro_libelle, P.pro_annee"
                . " FROM Promotion AS P, Faitpartie AS F"
                . " WHERE F.fap_promo = P.pro_id"
                . " AND F.fap_eleve = ?";
        $row = $this->getDb()->fetchAll($sql, array($id));
        if ($row)
        {
            $promotionId = $row['pro_id'];
            $eleves = new UtilisateurDAO($this->getDb());
            $row['pro_eleves'] = $eleves->findAllbyPromotion($promotionId);
            return $this->buildDomainObject($row);
        }
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
    
    /**
     * Sauvegarde/MAJ d'une Promotion
     *
     * @param \SIOC\donnees\Promotion
     * @return none
     */
    public function save(Promotion $promotion) {
        $promotionData = array(
            'pro_libelle'  => $promotion->getLibelle(),
            'pro_annee'    => $promotion->getAnnee()
        );
        
        if ($promotion->getId()){
            $this->getDb()->update('Promotion', $promotionData, array('pro_id' => $promotion->getId()));
        }
        else {
            $this->getDb()->insert('Promotion', $promotionData);
            $id = $this->getDb()->lastInsertId();
            $promotion->setId($id);
        }
    }
}
