<?php

namespace SIOC\donnees;

/**
 * Created by PhpStorm.
 * User: Remi Lelaidier
 * Date: 09/12/2015
 * Time: 10:14
 * Versions : -v1.0 : Version nominale
              -v1.1 : Ajout de la fonction toString()
 *            -v1.2 : Gestion des exceptions
 * Projet : SIOC
 */
class Promotion
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_libelle;
    private $_annee;
    private $_eleves;

    // Accesseurs

    public function getId()
    {
        return $this->_id;
    }

    public function getLibelle()
    {
        return $this->_libelle;
    }

    public function getAnnee()
    {
        return $this->_annee;
    }
    
    public function getEleves()
    {
        return $this->_eleves;
    }

    public function setId($data)
    {
            $this->_id = $data;
    }

    public function setLibelle($data)
    {
            $this->_libelle = $data;
    }

    public function setAnnee($data)
    {
            $this->_annee = $data;
    }
    
    public function setEleves($data)
    {
            $this->_eleves = $data;
    }

    // Methodes

    public function hydrate(array $datas)
    {
        if(isset($datas['pro_id']))
        {
            $this->setId($datas['pro_id']);
        }
        if(isset($datas['pro_libelle']))
        {
            $this->setLibelle($datas['pro_libelle']);
        }
        if(isset($datas['pro_annee']))
        {
            $this->setAnnee($datas['pro_annee']);
        }
        if(isset($datas['pro_eleves']))
        {
            $this->setEleves($datas['pro_eleves']);
        }
    }
}