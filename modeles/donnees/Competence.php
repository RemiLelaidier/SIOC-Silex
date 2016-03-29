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
class Competence
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_reference;
    private $_libelle;
    private $_description;
    private $_obligatoire;
    private $_cursus;

    // Accesseurs

    public function getId()
    {
        return $this->_id;
    }

    public function getReference()
    {
        return $this->_reference;
    }

    public function getLibelle()
    {
        return $this->_libelle;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getObligatoire()
    {
        return $this->_obligatoire;
    }
    
    public function getCursus()
    {
        return $this->_cursus;
    }

    public function setId($id)
    {
            $this->_id = $id;
    }

    public function setReference($data)
    {
            $this->_reference = $data;
    }

    public function setLibelle($data)
    {
            $this->_libelle = $data;
    }

    public function setDescription($data)
    {
            $this->_description = $data;
    }
    
    public function setObligatoire($data)
    {
            $this->_obligatoire = $data;
    }
    
    public function setCursus($data)
    {
        $this->_cursus = $data;
    }

    // Methodes

    public function hydrate(array $datas)                               // Permet de remplir d'initialiser les attributs
    {
        if(isset($datas['com_id']))
        {
            $this->setId($datas['com_id']);
        }
        if(isset($datas['com_reference']))
        {
            $this->setReference($datas['com_reference']);
        }
        if(isset($datas['com_libelle']))
        {
            $this->setLibelle($datas['com_libelle']);
        }
        if(isset($datas['com_description']))
        {
            $this->setDescription($datas['com_description']);
        }
        if(isset($datas['com_obligatoire']))
        {
            $this->setObligatoire($datas['com_obligatoire']);
        }
        if(isset($datas['com_cursus']))
        {
            $this->setCursus($datas['com_cursus']);
        }
    }

    public function toString()                               // Renvoie les attributs sous forme de chaine de caractere
    {
        $resu = "ID 	 -> ". $this->getId() ."\r";
        $resu .= "Ref     -> ". $this->getReference() ."\r";
        $resu .= "Libelle -> ". $this->getLibelle() ."\r";
        $resu .= "Descri  -> ". $this->getDescription() ."\r";
        $resu .= "Oblige  -> ". $this->getObligatoire();
        return $resu;
    }
}