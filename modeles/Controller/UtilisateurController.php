<?php

namespace SIOC\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of UtilisateurController
 *
 * @author leetspeakv2
 */
class UtilisateurController {
    
    /**
     * Affichage Utilisateurs
     * 
     * @param Application $app Silex Application
     */
    public function utilisateurAction(Application $app)
    {
        $utilisateurs = $app['dao.utilisateur']->findAll();
        return $app['twig']->render('utilisateur.html.twig', array(
            'utilisateurs' => $utilisateurs
        ));
    }
    
    /**
     * Affichage des professeurs
     * 
     * @param Application $app Silex Application
     */
    public function professeurAction(Application $app)
    {
        $professeurs = $app['dao.utilisateur']->findAllProfesseur();
        return $app['twig']->render('professeurs.html.twig', array(
            'professeurs' => $professeurs
        ));
    }
    
    /**
     * Affichage des eleves
     * 
     * @param Application $app Silex Application
     */
    public function eleveAction(Application $app)
    {
        $eleves = $app['dao.utilisateur']->findAllEleve();
        return $app['twig']->render('eleves.html.twig', array(
            'eleves' => $eleves
        ));
    }
    
    /**
     * Formulaire ajout Utilisateur
     * 
     * @param Application $app Silex Application
     */
    public function utilisateurAjoutAction(Application $app)
    {
        $promotions = $app['dao.promotion']->findAll();
        return $app['twig']->render('ajout_utilisateur.html.twig', array(
            'promotions' => $promotions
        ));
    }
    
    /**
     * Insertion Utilisateur
     * 
     * @param Application $app Silex Application
     * @param Request $request Requete Entrante
     */
    public function utilisateurInsertAction(Application $app, Request $request)
    {
        $salt = substr(md5(time()), 0, 23);
        $utilisateur = new \SIOC\donnees\Utilisateur();
        $promotion = new \SIOC\donnees\Promotion();
        $cursus = new \SIOC\donnees\Cursus();
        if(null !== $request->request->get('id'))
        {
            $utilisateur->setId($request->request->get('id'));
        }
        $utilisateur->setUsername($request->request->get('username'));
        $utilisateur->setNom($request->request->get('nom'));
        $utilisateur->setPrenom($request->request->get('prenom'));
        $utilisateur->setMail($request->request->get('email'));
        $utilisateur->setSalt($salt);
        $encoder = $app['security.encoder.digest'];
        $utilisateur->setPassword($encoder->encodePassword($request->request->get('password'),$utilisateur->getSalt()));
        $utilisateur->setRole($request->request->get('role'));
        if($utilisateur->getRole() == 'ROLE_ELEVE'){
            $promotion->setId($request->request->get('promo'));
            $cursus->setId($request->request->get('cursus'));
        }
        $app['dao.utilisateur']->save($utilisateur, $promotion, $cursus);
        $role = $app['security.token_storage']->getToken()->getUser()->getRole();
        if($role == "ROLE_ADMIN")
        {
            return $app->redirect('/utilisateur');
        }
        else
        {
            return $app->redirect('/eleve');
        }
    }
    
    /**
     * Suppression Utilisateur
     * 
     * @param integer $id Id utilisateur
     * @param Application $app Silex Application
     */
    public function utilisateurSupAction($id, Application $app)
    {
        $utilisateur = $app['dao.utilisateur']->find($id);
        $app['dao.utilisateur']->erase($utilisateur);
        $role = $app['security.token_storage']->getToken()->getUser()->getRole();
        if($role == "ROLE_ADMIN")
        {
            return $app->redirect('/utilisateur');
        }
        else
        {
            return $app->redirect('/eleve');
        }
    }
    
    /**
     * Edition Utilisateur
     * 
     * @param integer $id Id utilisateur
     * @param Application $app Silex Application
     */
    public function utilisateurEditAction($id, Application $app)
    {
        $utilisateur = $app['dao.utilisateur']->find($id);
        $promotions = $app['dao.promotion']->findAll();
        return $app['twig'] -> render('ajout_utilisateur.html.twig', array(
            'utilisateur' => $utilisateur,
            'promotions' => $promotions
        ));
    }
}
