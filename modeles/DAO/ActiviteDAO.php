<?php

namespace SIOC\DAO;

use SIOC\donnees\Activite;
use SIOC\DAO\CompetenceDAO;
use SIOC\DAO\UtilisateurDAO;

/**
 * Description of ActiviteDAO
 *
 * @author SIO PTFQ
 */
class ActiviteDAO extends DAO
{
    /**
     * Trouve l'activite a l'id corrspondante
     *
     * @param integer $id
     * @return \SIOC\donnees\Activite
     */
    public function find($id) {
        $sql = "SELECT * FROM Activite WHERE act_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($id);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($id);
            return $this->buildDomainObject($row);
        }
    }

    /**
     * Trouve toutes les activites
     *
     * @param none
     * @return array(\SIOC\donnees\Activite)
     */
    public function findAll()
    {
        $sql = "SELECT * FROM Activite";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le resultat de la requete en tableau //
        $activites = array();
        foreach ($result as $row) {
            $activiteId = $row['act_id'];
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($activiteId);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($activiteId);
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
        return $activites;
    }
    
    /**
     * Trouve toutes les activites a l'utilisateur associe
     *
     * @param integer $utilisateurId
     * @return array(\SIOC\donnees\Activite)
     */
    public function findAllbyUtilisateur($utilisateurId)
    {
        $sql = "SELECT A.act_id, A.act_debut, A.act_duree, A.act_libelle, A.act_description"
                . " FROM Activite AS A, Utilisateur AS U"
                . " WHERE A.act_eleve = U.uti_id"
                . " AND U.uti_id = ?";
        $result = $this->getDb()->fetchAll($sql, array($utilisateurId));
        $activites = array();
        foreach($result as $row) {
            $activiteId = $row['act_id'];
            $utilisateur = new UtilisateurDAO($this->getDb());
            $row['act_eleve'] = $utilisateur->findbyActivite($activiteId);
            $competences = new CompetenceDAO($this->getDb());
            $row['act_competences'] = $competences->findAllbyActivite($activiteId);
            $activites[$activiteId] = $this->buildDomainObject($row);
        }
        return $activites;
    }

    /**
     * Creer un objet Activite a partir d'un tuple
     *
     * @param array $row
     * @return \SIOC\donnees\Activite
     */
   protected function buildDomainObject($row) {
        $activite = new Activite();
        $activite->hydrate($row);
        return $activite;
    }
    
    /**
     * Sauvegarde/MAJ d'une Activite
     *
     * @param \SIOC\donnees\Activite
     * @return none
     * 
     * TOTEST
     */
    public function save(Activite $activite) {
        $activiteData = array(
            'act_debut'         => $activite->getDebut(),
            'act_duree'         => $activite->getDuree(),
            'act_libelle'       => $activite->getLibelle(),
            'act_description'   => $activite->getDescription(),
            'act_eleve'         => $activite->getUtilisateur()
        );
        
        if ($activite->getId()){
            $this->getDb()->update('Activite', $activiteData, array('act_id' => $activite->getId()));
            foreach ( $activite->getCompetences() as $key => $competence )
            {
                $competenceData = array(
                    'ass_competence'    => $competence->getId(),
                    'ass_activite'      => $activite->getId()
                );
                $this->getDb()->update('Associe', $competenceData, array(
                    'ass_competence' => $competence->getId(),
                    'ass_activite'   => $activite->getId()
                        ));
            }
            
        }
        else {
            $this->getDb()->insert('Activite', $activiteData);
            $id = $this->getDb()->lastInsertId();
            $activite->setId($id);
            foreach ( $activite->getCompetences() as $key => $competence )
            {
                $competenceData = array(
                    'ass_competence'    => $competence->getId(),
                    'ass_activite'      => $activite->getId()
                );
                $this->getDb()->insert('Associe', $competenceData);
            }
        }
    }
    
    /**
     * Suppression de l'Activite
     *
     * @params integer $id
     * @return none
     * 
     * TOTEST
     */
    public function erase($id)
    {
        
    }
}
