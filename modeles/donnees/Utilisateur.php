<?php

namespace SIOC\donnees;

use Symfony\Component\Security\Core\User\UserInterface;
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
class Utilisateur implements UserInterface
{
    // Attributs

    private $_id;				// Les champs de la BDD sont modelises ici
    private $_username;
    private $_nom;
    private $_prenom;
    private $_mail;
    private $_password;
    private $_salt;
    private $_role;

    // Constantes

    const TAILLE_NOM = 75;		// Les constantes de taille font references
    const TAILLE_PRENOM = 45;	// a la taille des champs dans la BDD
    const TAILLE_MAIL = 50;
    const TAILLE_PASSWORD = 45;
    const TAILLE_USERNAME = 35;
    // Constructeur

    public function __construct()
    {
        
    }

    // Accesseurs

    public function getId()
    {
        return $this->_id;
    }
    
    public function getUsername()
    {
        return $this->_username;
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
    
    public function getSalt()
    {
        return $this->_salt;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function setId($id)
    {
        if(is_int($id))
        {
            $this->_id = $id;
        }
    }

    public function setUsername($data)
    {
        if(is_string($data))
        {
            $this->_nom = $data;
        }
    }
    
    public function setNom($data)
    {
        if(is_string($data))
        {
            $this->_username = $data;
        }
    }

    public function setPrenom($data)
    {
        if(is_string($data))
        {
            $this->_prenom = $data;
        }
    }

    public function setMail($data)
    {
        if(is_string($data))
        {
            $this->_mail = $data;
        }
    }

    public function setPassword($data)
    {
        if(is_string($data))
        {
            $this->_password = $data;
        }
    }
    
    public function setSalt($data)
    {
        if(is_string($data))
        {
            $this->_salt = $data;
        }
    }

    public function setRole($data)
    {
        if(is_string($data))
        {
            $this->_role = $data;
        }
    }

    // Methodes

    public function hydrate(array $datas)  // Permet de remplir d'initialiser les attributs
    {
        if(isset($datas['uti_id']))
        {
            $this->setId($datas['uti_id']);
        }
        if(isset($datas['uti_username']))
        {
            $this->setUsername($datas['uti_username']);
        }
        if(isset($datas['uti_nom']))
        {
            $this->setNom($datas['uti_nom']);
        }
        if(isset($datas['uti_prenom']))
        {
            $this->setPrenom($datas['uti_prenom']);
        }
        if(isset($datas['uti_mail']))
        {
            $this->setMail($datas['uti_mail']);
        }
        if(isset($datas['uti_password']))
        {
            $this->setPassword($datas['uti_password']);
        }
        if(isset($datas['uti_salt']))
        {
            $this->setSalt($datas['uti_salt']);
        }
        if(isset($datas['uti_role']))
        {
            $this->setRole($datas['uti_role']);
        }
    }

    public function toString()
    {
        $resu = "ID 	 -> ". $this->getId() ."\r";
        $resu .= "Nom     -> ". $this->getNom() ."\r";
        $resu .= "Prenom  -> ". $this->getPrenom() ."\r";
        $resu .= "E-mail  -> ". $this->getMail() ."\r";
        $resu .= "Pass    -> ". $this->getPassword() ."\r";
        $resu .= "Role    -> ". $this->getRole();
        return $resu;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}