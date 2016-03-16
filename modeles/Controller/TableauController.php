<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: AnonyMind
 * Date: 16/03/2016
 * Time: 10:18
 */

class TableauController {

    public function tableauAffichage(Application $app){

        $tableau = $app['dao.competence']->findAll();
        $tableau = $app['dao.activite']->findAll();
        return $app['twig']->render('tableau.html.twig', array('tableau' => $tableau));




    }

}
