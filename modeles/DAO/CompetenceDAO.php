<?php

namespace SIOC\DAO;

use SIOC\donnees\Competence;

/**
 * Description de CompetenceDAO
 *
 * @author SIO PTFQ
 */
class CompetenceDAO extends DAO
{
    /**
     * Trouve une competence
     *
     * @param integer $id
     * @return array(\SIOC\donnees\Competence)
     */
    public function find($id) {
        $sql = "SELECT * FROM Competence WHERE com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    /**
     * Trouve toutes les competences
     *
     * @param none
     * @return array(\SIOC\donnees\Competence)
     */
    public function findAll()
    {
        $sql = "SELECT * FROM Competence ORDER BY com_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le resultat de la requete en tableau //
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    
    /**
     * Trouve toutes les competences associees a une activite
     *
     * @param integer $activiteId
     * @return array(\SIOC\donnees\Competence)
     */
    public function findAllbyActivite($activiteId)
    {
        $sql = "SELECT C.com_id, C.com_reference, C.com_libelle, C.com_description, C.com_obligatoire "
                . " FROM Competence AS C, Associe AS A "
                . " WHERE A.ass_competence = C.com_id "
                . " AND A.ass_activite = ?";
        $result = $this->getDb()->fetchAssoc($sql, array($activiteId));
                
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    
    /**
     * Creer une competence a partir d'un tuple
     *
     * @param array $row
     * @return \SIOC\donnees\Competence
     */
    protected function buildDomainObject($row) {
        $competence = new Competence();
        $competence->hydrate($row);
        return $competence;
    }
 
    /**
     * Sauvegarde/MAJ d'une competence
     *
     * @param \SIOC\donnees\Competence
     * @return none
     */
    public function save(Competence $competence) {
        $competenceData = array(
            'com_reference'   => $competence->getReference(),
            'com_libelle'     => $competence->getLibelle(),
            'com_description' => $competence->getDescription(),
            'com_obligatoire' => $competence->getObligatoire()
        );
        
        if ($competence->getId()){
            $this->getDb()->update('Competence', $competenceData, array('com_id' => $competence->getId()));
        }
        else {
            $this->getDb()->insert('Competence', $competenceData);
            $id = $this->getDb()->lastInsertId();
            $competence->setId($id);  
        }
    }
}