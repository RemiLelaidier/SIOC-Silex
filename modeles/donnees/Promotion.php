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
class Promotion extends Exception
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_libelle;
    private $_annee;

    // Constantes

    const TAILLE_LIBELLE = 45;		// Les constantes de taille font references
    const MIN_ANNEE = 2013;			// a la taille des champs dans la BDD

    // Constructeur

    public function __construct()
    {
        $this->_id = NULL;
        $this->_libelle = "Libelle vide";
        $this->_annee = 0;
    }

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

    public function setId($data)
    {
        if(is_int($data))
        {
            $this->_id = $data;
        }
        else
        {
            throw new Exception("Promotion -> setID -> mauvais type argument");
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
            throw new Exception("Promotion -> setLibelle -> mauvais type argument ou trop long");
        }
    }

    public function setAnnee($data)
    {
        if(is_int($data) && $data >= self::MIN_ANNEE)
        {
            $this->_annee = $data;
        }
        else
        {
            throw new Exception("Promotion -> setAnnee -> mauvais type argument ou trop petit");
        }
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
    }

    public function toString()
    {
        $resu = "ID 	 -> ". $this->getId() ."\r";
        $resu .= "Libelle -> ". $this->getLibelle() ."\r";
        $resu .= "Annee   -> ". $this->getAnnee();
        return $resu;
    }
}