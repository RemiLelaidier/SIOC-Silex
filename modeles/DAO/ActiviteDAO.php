<?php

namespace SIOC\modeles\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Activite;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class ActiviteDAO
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
     * Retourne une liste d'activite trie par date (+recent au -recent).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "SELECT * FROM Activite ORDER BY act_id DESC";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $activites = array();
        foreach ($result as $row) {
            $activiteId = $row['act_id'];
            $activites[$activiteId] = $this->buildActivite($row);
        }
        return $activites;
    }

    /**
     * Creer un objet Activite a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Activite
     */
    private function buildActivite(array $row) {
        $activite = new Activite();
        $activite->hydrate($row);
        return $activite;
    }
}
