<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SIOC\DAO;

use SIOC\donnees\Cursus;

/**
 * Description of CursusDAO
 *
 * @author leetspeakv2
 */
class CursusDAO extends DAO
{
    /**
     * Trouver le cursus de l'eleve
     * 
     * @param integer $id
     * @return \SIOC\donnees\Cursus
     */
    public function findByEleve($id)
    {
        $sql = "SELECT C.cur_id, C.cur_libelle, C.cur_diminutif"
                . "FROM Cursus AS C, Suit AS S"
                . "WHERE C.cur_id = S.sui_cursus"
                . "AND S.sui_eleve = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    
    /**
     * Creer un cursus a partir d'un tuple
     *
     * @param array $row
     * @return \SIOC\donnees\Cursus
     */
    protected function buildDomainObject($row) {
        $cursus = new Cursus();
        $cursus->hydrate($row);
        return $cursus;
    }
}
