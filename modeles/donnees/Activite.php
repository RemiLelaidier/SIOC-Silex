<?php

namespace SIOC\modeles\donnees;

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
class Activite extends Exception
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_debut;
    private $_duree;
    private $_libelle;
    private $_description;

    // Constantes
    // Les constantes de taille font references
    const TAILLE_LIBELLE = 35;			// a la taille des champs dans la BDD
    const TAILLE_DESCRIPTION = 350;		//TODO

    // Constructeur

    public function __construct()
    {
        $this->_id = NULL;
        $this->_duree = NULL;
        $this->_libelle = "Activites x";
        $this->_description = "description";
    }

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

    public function getLibelle()
    {
        return $this->_libelle;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setId($id)
    {
        if(is_int($id))
        {
            $this->_id = $id;
        }
        else
        {
            throw new Exception("Activite -> setID -> mauvais type argument");
        }
    }

    public function setDebut($data)
    {
        if(preg_match('!^(0?\d|[12]\d|3[01])-(0?\d|1[012])-((?:19|20)\d{2})$!', $data)) 
        {
            $this->_debut = $data;
        }
        else
        {
            throw new Exception("Activite -> setDebut -> mauvais type argument");
        }
    }
    
    public function setDuree($data)
    {
        if(is_int($data))
        {
            $this->_duree = $data;
        }
        else
        {
            throw new Exception("Activite -> setDuree -> mauvais type argument");
        }
    }

    public function setLibelle($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_LIBELLE)
        {
            $this->_libelle = $data;
        }
        else
        {
            throw new Exception("Activite -> setLibelle -> mauvais type argument ou trop long");
        }
    }

    public function setDescription($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_DESCRIPTION)
        {
            $this->_description = $data;
        }
        else
        {
            throw new Exception("Activite -> setDescription -> mauvais type argument ou trop long");
        }
    }

    // Methodes

    public function hydrate(array $datas)  // Permet de remplir d'initialiser les attributs
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
        if(isset($datas['act_libelle']))
        {
            $this->setLibelle($datas['act_libelle']);
        }
        if(isset($datas['act_description']))
        {
            $this->setDescription($datas['act_description']);
        }
    }

    public function toString()
    {
        $resu = "ID 	 -> ". $this->getId() ."<br/>";
        $resu .= "Duree   -> ". $this->getDuree() ."<br/>";
        $resu .= "Libelle -> ". $this->getLibelle() ."<br/>";
        $resu .= "Descri  -> ". $this->getDescription();
        return $resu;
    }
}