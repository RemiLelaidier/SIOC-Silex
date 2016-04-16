<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SIOC\donnees;

/**
 * Description of Cursus
 *
 * @author leetspeakv2
 */
class Cursus 
{
    // Attributs
    
    private $_id;
    private $_libelle;
    private $_diminutif;
    
    // Methodes
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getLibelle()
    {
        return $this->_libelle;
    }
    
    public function getDiminutif()
    {
        return $this->_diminutif;
    }
    
    public function setId($data)
    {
        $this->_id = $data;
    }
    
    public function setLibelle($data)
    {
        $this->_libelle = $data;
    }
    
    public function setDiminutif($data)
    {
        $this->_diminutif = $data;
    }
    
    public function hydrate($datas)
    {
        if(isset($datas['cur_id']))
        {
            $this->setId($datas['cur_id']);
        }
        if(isset($datas['cur_libelle']))
        {
            $this->setId($datas['cur_libelle']);
        }
        if(isset($datas['cur_diminutif']))
        {
            $this->setId($datas['cur_diminutif']);
        }
    }
}
