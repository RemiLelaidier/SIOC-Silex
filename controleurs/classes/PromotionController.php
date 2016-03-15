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
     * 
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
     * 
     */
    public function promotionAjoutAction(Application $app)
    {
        return $app['twig']->render('ajout_promotion.html.twig');
    }
    
    /**
     * 
     */
    public function promotionInsertAction(Application $app, Request $request)
    {
        $promotion = new \SIOC\donnees\Promotion();
        $promotion -> setLibelle($request->request->get('libelle'));
        $promotion -> setAnnee($request->request->get('annee'));
        $app['dao.promotion']->save($promotion);
        $promotions = $app['dao.promotion']->findAll();
        return $app['twig'] -> render('promotion.html.twig', array('promotions' => $promotions));
    }
    
    /**
     * 
     */
    public function promotionIdAction($id, Application $app)
    {
        $promotion = $app['dao.promotion']->find($id);
        return $app['twig']->render('voir_promotion.html.twig', array(
            'promotion' => $promotion,
        ));
    }
}
