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
     * Affichage des activites de l'eleve connecte
     * 
     * @param Application $app Silex Application
     */
    public function activiteAction(Application $app)
    {
        $id = $app['security.token_storage']->getToken()->getUser()->getId();
        $activites = $app['dao.activite']->findAllbyUtilisateur($id);
        return $app['twig']->render('activite.html.twig', array(
            'activites' => $activites,
        ));
    }
    
    /**
     * Formualire ajout Activite
     * 
     * @param Application $app Silex Application
     */
    public function activiteAjoutAction(Application $app)
    {
        $competences = $app['dao.competence']->findAll();
        return $app['twig']->render('ajout_activite.html.twig', array(
            'competences' => $competences,
        ));
    }
    
    /**
     * Affichage Activites de l'utilisateur id
     * 
     * @param Application $app Silex Application
     * @param integer $id id Utilisateur
     */
    public function activiteIdAction($id, Application $app)
    {
        $activites = $app['dao.activite']->findAllbyUtilisateur($id);
        return $app['twig']->render('activite.html.twig', array(
            'activites' => $activites,
        ));
    }
    
    /**
     * Insertion Activite
     * 
     * @param Request $request Requete Entrante
     * @param Application $app Silex Application
     */
    public function activiteInsertAction(Request $request, Application $app)
    {
        $activite = new \SIOC\donnees\Activite();
        if(null !== $request->request->get('id'))
        {
            $activite -> setId($request->request->get('id'));
        }
        $activite -> setDebut($request->request->get('debut'));
        $activite -> setDuree($request->request->get('duree'));
        $activite -> setPeriode($request->request->get('periode'));
        $activite -> setLibelle($request->request->get('libelle'));
        $activite -> setDescription($request->request->get('description'));
        $competences = array();
        foreach($request->request->get('competences') as $idCompetence )
        {
            $competences[$idCompetence] = $app['dao.competence']->find($idCompetence);
        }
        $activite -> setCompetences($competences);
        $activite -> setUtilisateur($app['security.token_storage']->getToken()->getUser()->getId());
        $app['dao.activite']->save($activite);
        return $app->redirect('/activite');
    }
    
    /**
     * Suppression Activite
     * 
     * @param integer $id Id activite
     * @param Application $app Silex Application
     */
    public function activiteSupAction($id, Application $app)
    {
        $activte = $app['dao.activite']->find($id);
        $app['dao.activite']->erase($activte);
        return $app->redirect('/activite');
    }
    
    /**
     * Edition Activite
     * 
     * @param integer $id Id activite
     * @param Application $app Silex Application
     */
    public function activiteEditAction($id, Application $app)
    {
        $activite = $app['dao.activite']->find($id);
        $competences = $app['dao.competence']->findAll();
        return $app['twig']->render('ajout_activite.html.twig', array(
            'activite' => $activite,
            'competences' => $competences,
        ));
    }
}
