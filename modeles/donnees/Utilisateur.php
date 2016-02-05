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
class Utilisateur extends Exception
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_nom;
    private $_prenom;
    private $_mail;
    private $_password;
    private $_statut;

    // Constantes

    const TAILLE_NOM = 75;		// Les constantes de taille font references
    const TAILLE_PRENOM = 45;	// a la taille des champs dans la BDD
    const TAILLE_MAIL = 50;
    const TAILLE_PASSWORD = 45;
    const STATUT_ELEVE = 1;
    const STATUT_PROF = 2;
    const STATUT_VISITEUR = 3;
    const STATUT_ADMIN = 4;

    // Constructeur

    public function __construct()
    {
        $this->_id = NULL;
        $this->_nom = "Nom";
        $this->_prenom = "Prenom";
        $this->_mail = "mail@mailbox.com";
        $this->_password = "password";
        $this->_statut = 0;
    }

    // Accesseurs

    public function getId()
    {
        return $this->_id;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getPrenom()
    {
        return $this->_prenom;
    }

    public function getMail()
    {
        return $this->_mail;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getStatut()
    {
        return $this->_statut;
    }

    public function setId($id)
    {
        if(is_int($id))
        {
            $this->_id = $id;
        }
        else
        {
            throw new Exception("Utilisateur -> setID -> mauvais type argument");
        }
    }

    public function setNom($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_NOM)
        {
            $this->_nom = $data;
        }
        else
        {
            throw new Exception("Utilisateur -> setNom -> mauvais type argument ou trop long");
        }
    }

    public function setPrenom($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_PRENOM)
        {
            $this->_prenom = $data;
        }
        else
        {
            throw new Exception("Utilisateur -> setPrenom -> mauvais type argument ou trop long");
        }
    }

    public function setMail($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_MAIL)
        {
            $this->_mail = $data;
        }
        else
        {
            throw new Exception("Utilisateur -> setMail -> mauvais type argument ou trop long");
        }
    }

    public function setPassword($data)
    {
        if(is_string($data) && strlen($data) <= self::TAILLE_PASSWORD)
        {
            $this->_password = $data;
        }
        else
        {
            throw new Exception("Utilisateur -> setPassword -> mauvais type argument ou trop long");
        }
    }

    public function setStatut($data)
    {
        if(in_array($data, [self::STATUT_ELEVE, self::STATUT_PROF, self::STATUT_VISITEUR, self::STATUT_ADMIN]))
        {
            $this->_statut = $data;
        }
        else
        {
            throw new Exception("Utilisateur -> setStatut -> mauvais type argument ou hors limite");
        }
    }

    // Methodes

    public function hydrate(array $datas)  // Permet de remplir d'initialiser les attributs
    {
        if(isset($datas['id']))
        {
            $this->setId($datas['id']);
        }
        if(isset($datas['nom']))
        {
            $this->setNom($datas['nom']);
        }
        if(isset($datas['prenom']))
        {
            $this->setPrenom($datas['prenom']);
        }
        if(isset($datas['mail']))
        {
            $this->setMail($datas['mail']);
        }
        if(isset($datas['password']))
        {
            $this->setPassword($datas['password']);
        }
        if(isset($datas['statut']))
        {
            $this->setStatut($datas['statut']);
        }
    }

    public function toString()
    {
        $resu = "ID 	 -> ". $this->getId() ."\r";
        $resu .= "Nom     -> ". $this->getNom() ."\r";
        $resu .= "Prenom  -> ". $this->getPrenom() ."\r";
        $resu .= "E-mail  -> ". $this->getMail() ."\r";
        $resu .= "Pass    -> ". $this->getPassword() ."\r";
        $resu .= "Statut  -> ". $this->getStatut();
        return $resu;
    }
}