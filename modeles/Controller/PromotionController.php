<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of PromotionController
 *
 * @author leetspeakv2
 */
class PromotionController {
    
    /**
     * Affichage des promotions
     * 
     * @param Application $app Silex Application
     */
    public function promotionAction(Application $app)
    {
        $promotions = $app['dao.promotion']->findAll();
        $nbEleves = $app['dao.utilisateur']->findAllEleve();
        return $app['twig']->render('promotion.html.twig', array(
            'promotions' => $promotions,
            'nbEleves' => $nbEleves
        ));
    }
    
    /**
     * Formualire Ajout Promotion
     * 
     * @param Application $app Silex Application
     */
    public function promotionAjoutAction(Application $app)
    {
        return $app['twig']->render('ajout_promotion.html.twig');
    }
    
    /**
     * Insertion Promotion
     * 
     * @param Application $app Silex Application
     * @param Request $request Requete Entrante
     */
    public function promotionInsertAction(Application $app, Request $request)
    {
        $promotion = new \SIOC\donnees\Promotion();
        if(null !== $request->request->get('id'))
        {
            $promotion -> setId($request->request->get('id'));
        }
        $promotion -> setLibelle($request->request->get('libelle'));
        $promotion -> setAnnee($request->request->get('annee'));
        $app['dao.promotion']->save($promotion);
        return $app->redirect('/promotion');
    }
    
    /**
     * Affichage Promotion id
     * 
     * @param Application $app Silex Application
     * @param integer $id id promotion
     */
    public function promotionIdAction($id, Application $app)
    {
        $promotion = $app['dao.promotion']->find($id);
        return $app['twig']->render('voir_promotion.html.twig', array(
            'promotion' => $promotion,
        ));
    }
    
    /**
     * Suppression Promotion
     * 
     * @param integer $id Id promotion
     * @param Application $app Silex Application
     */
    public function promotionSupAction($id, Application $app)
    {
        $promotion = $app['dao.promotion']->find($id);
        $app['dao.promotion']->erase($promotion);
        return $app->redirect('/promotion');
    }
    
    /**
     * Edition Promotion
     * 
     * @param integer $id Id Promotion
     * @param Application $app Silex Application
     */
    public function promotionEditAction($id, Application $app)
    {
        $promotion = $app['dao.promotion']->find($id);
        return $app['twig']->render('ajout_promotion.html.twig', array(
            'promotion' => $promotion,
        ));
    }
}
