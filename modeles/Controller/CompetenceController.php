<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CompetenceController
 *
 * @author leetspeakv2
 */
class CompetenceController {
    
    /**
     * Affichage des competences
     * 
     * @param Application $app Silex Application
     */
    public function competenceAction(Application $app)
    {
        $competences = $app['dao.competence']->findAll();
        return $app['twig']->render('competence.html.twig', array('competences' => $competences));
    }
    
    /**
     * Formulaire Ajout Competence
     *  
     * @param Application $app Silex Application
     */
    public function competenceAjoutAction(Application $app)
    {
        return $app['twig']->render('ajout_competence.html.twig');
    }
    
    /**
     * Insertion Competence
     * 
     * @param Application $app Silex Application
     * @param Request $request Requete Entrante
     */
    public function competenceInsertAction(Request $request, Application $app)
    {
        $competence = new \SIOC\donnees\Competence();
        if(null !== $request->request->get('id'))
        {
            $competence->setId($request->request->get('id'));
        }
        $competence -> setReference($request->request->get('reference'));
        $competence -> setLibelle($request->request->get('libelle'));
        $competence -> setDescription($request->request->get('description'));
        $competence -> setObligatoire($request->request->get('obligatoire'));
        $app['dao.competence']->save($competence);
        $competences = $app['dao.competence']->findAll();
        return $app['twig'] -> render('competence.html.twig', array(
            'competences' => $competences,
        ));
    }
    
    /**
     * Suppression Competence
     * 
     * @param integer $id Id competence
     * @param Application $app Silex Application
     */
    public function competenceSupAction($id, Application $app)
    {
        $competence = $app['dao.competence']->find($id);
        $app['dao.competence']->erase($competence);
        $competences = $app['dao.competence']->findAll();
        return $app['twig']->render('competence.html.twig', array(
            'competences' => $competences,
        ));
    }
    
    /**
     * Edition Competence
     * 
     * @param integer $id Id competence
     * @param Application $app Silex Application
     */
    public function competenceEditAction($id, Application $app)
    {
        $competence = $app['dao.competence']->find($id);
        return $app['twig']->render('ajout_competence.html.twig', array(
            'competence' => $competence,
        ));
    }
}
