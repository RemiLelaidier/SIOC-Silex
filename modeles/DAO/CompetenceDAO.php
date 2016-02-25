<?php

namespace SIOC\DAO;

use Doctrine\DBAL\Connection;
use SIOC\modeles\donnees\Competence;

/**
 * Description of CompetenceDAO
 *
 * @author Remi Lelaidier
 */
class CompetenceDAO extends DAO
{

    public function find($id) {
        $sql = "SELECT * FROM Competence WHERE com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune competence avec l'id " . $id);
    }

    // Methode findAll //
    public function findAll()
    {
        $sql = "SELECT * FROM Competence ORDER BY com_id";
        $result = $this->getDb()->fetchAll($sql, array());

        // Convertit le resultat de la requete en tableau //
        $competences = array();
        foreach ($result as $row) {
            //$competenceId = $row['com_id'];
            //$competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    
    // Methode findAllbyActivite
    public function findAllbyActivite($activiteId)
    {
        $sql = "SELECT C.com_id, C.com_reference, C.com_libelle, C.com_description, C.com_obligatoire "
                . "FROM Competence AS C, Associe AS A "
                . "WHERE A.ass_competence = C.com_id "
                . "AND A.ass_activite = ?";
        $result = $this->getDb()->fetchAll($sql, array($activiteId));
                
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    
    /**
     * Creer un objet Competence a partir d'une liste
     *
     * @param array $row
     * @return \SIOC\modeles\donnees\Competence
     */
    protected function buildDomainObject($row) {
        $competence = new Competence();
        $competence->hydrate($row);
        return $competence;
    }
 
    // TODO
    protected function save(Competence $competence) {
        $competenceData = array(
            'com_id' => $competence->getCompetence()->getId()
        );
        if ($competence->getId()){
            $this->getDb()->update('com_id', $commentDate, array('com_id' => $comment->getId()));
        }
        else {
            $this->getDb()->insert('Competence', $competenceData);
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
}