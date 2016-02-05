<?php

namespace SIOC\modeles\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Utilisateur;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class UtilisateurDAO
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
     * Retourne une liste des utilisateurs trie par date (+recent au -recent).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "SELECT * FROM Utilisateur ORDER BY uti_id DESC";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $utilisateurs = array();
        foreach ($result as $row) {
            $utilisateurId = $row['uti_id'];
            $utilisateurs[$utilisateurId] = $this->buildUtilisateur($row);
        }
        return $utilisateurs;
    }

    /**
     * Creer un objet Utilisateur a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Utilisateur
     */
    private function buildUtilisateur(array $row) {
        $utilisateur = new Utilisateur();
        $utilisateur->hydrate($row);
        return $utilisateur;
    }
}
