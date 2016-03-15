<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ActiviteController
 *
 * @author leetspeakv2
 */
class ActiviteController {
    
    /**
     * 
     */
    public function activiteAction(Application $app)
    {
        $id = $app['security.token_storage']->getToken()->getUser()->getId();
        $activites = $app['dao.activite']->findAllbyUtilisateur($id);
        return $app['twig']->render('activite.html.twig', array(
            'activites' => $activites,
        ));
    }
    
    /*
     * 
     */
    public function activiteAjoutAction(Application $app)
    {
        $competences = $app['dao.competence']->findAll();
        return $app['twig']->render('ajout_activite.html.twig', array('competences' => $competences));
    }
    
    /**
     * 
     */
    public function activiteIdAction($id, Application $app)
    {
        $activites = $app['dao.activite']->findAllbyUtilisateur($id);
        return $app['twig']->render('activite.html.twig', array(
            'activites' => $activites,
        ));
    }
    
    /**
     * 
     */
    public function activiteInsertAction(Request $request, Application $app)
    {
        $activite = new \SIOC\donnees\Activite();
        $activite -> setDebut($request->request->get('debut'));
        $activite -> setDuree($request->request->get('duree'));
        $activite -> setLibelle($request->request->get('libelle'));
        $activite -> setDescription($request->request->get('description'));
        $activite -> setCompetences($request->request->get('competences'));
        $activite -> setUtilisateur($request->request->get('utilisateur'));
        $app['dao.activite']->save($activite);
        $activites = $app['dao.activite']->findAll();
        return $app['twig'] -> render('activite.html.twig', array('activites' => $activites));
    }
}
