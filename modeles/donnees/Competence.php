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
class Competence extends Exception
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_reference;
    private $_libelle;
    private $_description;
    private $_obligatoire;

    // Constantes

    const TAILLE_REFERENCE = 10;		// Les constantes de taille font references
    const TAILLE_LIBELLE = 35;			// a la taille des champs dans la BDD
    const TAILLE_DESCRIPTION = 350;

    // Constructeur

    public function __construct()
    {
        $this->_id = NULL;
        $this->_reference = NULL;
        $this->_libelle = "Competence x";
        $this->_description = "description";
        $this->_obligatoire = FALSE;
    }

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

    public function setId($id)
    {
        if(is_int($id))
        {
            $this->_id = $id;
        }
    }

    public function setReference($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_REFERENCE)
        {
            $this->_reference = $data;
        }
    }

    public function setLibelle($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_LIBELLE)
        {
            $this->_libelle = $data;
        }
    }

    public function setDescription($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_DESCRIPTION)
        {
            $this->_description = $data;
        }
    }
    
    public function setObligatoire($data)
    {
        if(is_bool($data))
        {
            $this->_obligatoire = $data;
        }
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