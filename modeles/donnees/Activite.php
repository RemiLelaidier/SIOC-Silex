<?php

namespace SIOC\donnees;

/**
 * Created by PhpStorm.
 * User: Remi Lelaidier
 * Date: 09/12/2015
 * Time: 10:14
 * Versions : -v1.0 : Version nominale
 * Projet : SIOC
 */
class Activite
{
    // Attributs

    private $_id;				
    private $_debut;
    private $_duree;
    private $_periode;
    private $_libelle;
    private $_description;
    private $_competences;
    private $_utilisateur;

    // Accesseurs

    public function getId()
    {
        return $this->_id;
    }

    public function getDebut()
    {
        return $this->_debut;
    }
    
    public function getDuree()
    {
        return $this->_duree;
    }
    
    public function getPeriode()
    {
        return $this->_periode;
    }

    public function getLibelle()
    {
        return $this->_libelle;
    }

    public function getDescription()
    {
        return $this->_description;
    }
    
    public function getCompetences()
    {
        return $this->_competences;
    }
    
    public function getUtilisateur()
    {
        return $this->_utilisateur;
    }

    public function setId($id)
    {
            $this->_id = $id;
    }

    public function setDebut($data)
    {
            $this->_debut = $data;
    }
    
    public function setDuree($data)
    {
            $this->_duree = $data;
    }
    
    public function setPeriode($data)
    {
            $this->_periode = $data;
    }

    public function setLibelle($data)
    {
            $this->_libelle = $data;
    }

    public function setDescription($data)
    {
            $this->_description = $data;
    }
    
    public function setCompetences($data)
    {
            $this->_competences = $data;
    }
    
    public function setUtilisateur($data)
    {
            $this->_utilisateur = $data;
    }

    /**
     * Permet de charger un objet avec les donnees passees
     * 
     * @param array $datas
     * @return none
     */
    public function hydrate(array $datas)
    {
        if(isset($datas['act_id']))
        {
            $this->setId($datas['act_id']);
        }
        if(isset($datas['act_debut']))
        {
            $this->setDuree($datas['act_debut']);
        }
        if(isset($datas['act_duree']))
        {
            $this->setDuree($datas['act_duree']);
        }
        if(isset($datas['act_periode']))
        {
            $this->setPeriode($datas['act_periode']);
        }
        if(isset($datas['act_libelle']))
        {
            $this->setLibelle($datas['act_libelle']);
        }
        if(isset($datas['act_description']))
        {
            $this->setDescription($datas['act_description']);
        }
        if(isset($datas['act_competences']))
        {
            $this->setCompetences($datas['act_competences']);
        }
        if(isset($datas['act_eleve']))
        {
            $this->setUtilisateur($datas['act_eleve']);
        }
    }
}