<?php

namespace SIOC\DAO;

use SIOC\donnees\Competence;
use SIOC\donnees\Cursus;

use SIOC\DAO\CursusDAO;

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
            $cursus = new CursusDAO($this->getDb());
            $row['com_cursus'] = $cursus->findByCompetence($row['com_id']);
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
            $cursus = new CursusDAO($this->getDb());
            $row['com_cursus'] = $cursus->findByCompetence($competenceId);
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
        $result = $this->getDb()->fetchAll($sql, array($activiteId));
                
        $competences = array();
        foreach ($result as $row) {
            $competenceId = $row['com_id'];
            $cursus = new CursusDAO($this->getDb());
            $row['com_cursus'] = $cursus->findByCompetence($competenceId);
            $competences[$competenceId] = $this->buildDomainObject($row);
        }
        return $competences;
    }
    
    /**
     * Renvoie le nb de competences valides par l'utilisateur
     *
     * @param integer $id
     * @return integer $nbComp
     */
    public function findNbByEleve($id)
    {
        $sql = "SELECT COUNT(DISTINCT ass.ass_competence) AS nbComp"
                . " FROM Associe AS ass, Activite AS act"
                . " WHERE ass.ass_activite = act.act_id"
                . " AND act.act_eleve = ?";
        $nbComp = $this->getDb()->fetchAssoc($sql, array($id));
        return $nbComp['nbComp'];
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
    public function save(Competence $competence, Cursus $cursus) {
        $competenceData = array(
            'com_reference'   => $competence->getReference(),
            'com_libelle'     => $competence->getLibelle(),
            'com_description' => $competence->getDescription(),
            'com_obligatoire' => $competence->getObligatoire()
        );
        
        if ($competence->getId()){
            $this->getDb()->update('Competence', $competenceData, array(
                'com_id' => $competence->getId()
            ));
            
            $this->getDb()->delete('Estdans', array(
                'est_competence'    => $competence->getId()
            ));
            $cursusData = array(
                'est_competence'    => $competence->getId(),
                'est_cursus'        => $cursus->getId()
            );
            $this->getDb()->insert('Estdans', $cursusData);
        }
        else {
            $this->getDb()->insert('Competence', $competenceData);
            $id = $this->getDb()->lastInsertId();
            $competence->setId($id);
            $cursusData = array(
                'est_competence'    => $competence->getId(),
                'est_cursus'        => $cursus->getId()
            );
            $this->getDb()->insert('Estdans', $cursusData);
        }
    }
    
    /**
     * Suppression de la Competence
     *
     * @param \SIOC\donnees\Competence
     * @return none
     */
    public function erase($competence)
    {
        $this->getDb()->delete('Competence', array(
            'com_id'  => $competence->getId()
        ));
    }
}