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
     * Creer une competence a partir d'un tuple
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
