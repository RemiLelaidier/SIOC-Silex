<?php

namespace SIOC\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Promotion;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class PromotionDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Retourne une liste des promotions trie par date (+recent au -recent).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "SELECT * FROM Promotion ORDER BY pro_id DESC";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $promotions = array();
        foreach ($result as $row) {
            $promotionId = $row['uti_id'];
            $promotions[$promotionId] = $this->buildPromotion($row);
        }
        return $promotions;
    }

    /**
     * Creer un objet Promotion a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Promotion
     */
    private function buildPromotion(array $row) {
        $promotion = new Promotion();
        $promotion->hydrate($row);
        return $promotion;
    }
}
