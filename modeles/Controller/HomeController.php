<?php
namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Knp\Snappy\Pdf;

/**
 * Description of HomeController
 *
 * @author Remi Lelaidier
 */
class HomeController {
    
    /**
     * Page d'acceuil
     * 
     * @param Application $app Silex Application
     */
    public function homeAction(Application $app)
    {
        if ($app['security.authorization_checker']->isGranted('ROLE_ELEVE')) 
        {
            $id = $app['security.token_storage']->getToken()->getUser()->getId();
            $professeurs = $app['dao.utilisateur']->findAllProfesseur();
            $activites = $app['dao.activite']->findAllbyUtilisateur($id);
            $competences = $app['dao.competence']->findAll();
            $nbComp = $app['dao.competence']->findNbByEleve($id);
            $promotion = $app['dao.promotion']->findByEleve($id);
            
            var_dump($promotion);
            die();

            return $app['twig']->render('acceuil.html.twig', array(
                'professeurs' => $professeurs,
                'activites' => $activites,
                'competences' => $competences,
                'nbComp' => $nbComp,
                'promotion' => $promotion
            ));
        }
        else {
            $professeurs = $app['dao.utilisateur']->findAllProfesseur();
            $eleves = $app['dao.utilisateur']->findAllEleve();
            $promotions = $app['dao.promotion']->findAll();
        
            return $app['twig']->render('acceuil_admin_prof.html.twig', array(
                'eleves' => $eleves,
                'professeurs' => $professeurs,
                'promotions' => $promotions
            ));
        }
    }
    
    /**
     * Page Login
     * 
     * @param Request $request Requete Entrante
     * @param Application $app Silex Application 
     */
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
    
    /**
     * Page Tableau
     * 
     * @param Application $app
     */
    public function tableauAction(Application $app){

        $competences = $app['dao.competence']->findAll();
        $activites = $app['dao.activite']->findAll();
        return $app['twig']->render('tableau.html.twig', array(
            'competences' => $competences,
            'activites' => $activites,
        ));
    }

    public function newPDF(){

        $snappy = new Pdf();
        $snappy->setBinary('/usr/local/bin/wkhtmltopdf');
        $competences = $app['dao.competence']->findAll();
        return $app['twig'] -> render('competence.html.twig', array('competences' => $competences));
    }
}
