<?php

namespace SIOC\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Competence;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class CompetenceDAO
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
     * Retourne une liste de competences trie par date (+recent au -recent).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "SELECT * FROM Competence ORDER BY com_id DESC";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $competences[$competenceId] = $this->buildCompetence($row);
        }
        return $competences;
    }

    /**
     * Creer un objet Competence a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Competence
     */
    private function buildCompetence(array $row) {
        $competence = new Competence();
        $competence->hydrate($row);
        return $competence;
    }
}
