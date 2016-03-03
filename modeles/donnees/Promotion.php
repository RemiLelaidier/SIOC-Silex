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

    // Constantes

    const TAILLE_LIBELLE = 45;		// Les constantes de taille font references
    const MIN_ANNEE = 2013;			// a la taille des champs dans la BDD

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
        if(is_int($data))
        {
            $this->_id = $data;
        }
    }

    public function setLibelle($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_LIBELLE)
        {
            $this->_libelle = $data;
        }
    }

    public function setAnnee($data)
    {
        if(is_int($data) && $data >= self::MIN_ANNEE)
        {
            $this->_annee = $data;
        }
    }
    
    public function setEleves($data)
    {
        if(is_array($data))
        {
            $this->_eleves = $data;
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
        if(isset($datas['pro_eleves']))
        {
            $this->setEleves($datas['pro_eleves']);
        }
    }
}