<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

/**
 * Register global error and exception handlers
 */
ErrorHandler::register();
ExceptionHandler::register();

/**
 * Register service providers.
 */
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../vues',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

/**
 * Gestion des erreurs
*/
$app->error(function(\Exception $e, $code) use($app){
    switch($code){
        case 404:
            $codeErreur = $code;
            $MessageErreur = "La page est introuvable";
            break;
        case 403:
            $codeErreur = $code;
            $MessageErreur = "L'acces a cette page vous a ete refuse";
            break;
        default:
            $codeErreur = "Inconnue";
            $MessageErreur = "Une erreur inconnue est survenue";
    }
    return $app['twig']->render('error.html.twig', array(
        'codeErreur'    => $codeErreur,
        'MessageErreur' => $MessageErreur
    ));
});

/**
 * Sécurisation de l'application, identification et redirection login
 */
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'anonymous' => false,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' =>$app->share(function () use ($app) {
                return new SIOC\DAO\UtilisateurDAO($app['db']);
                 }),
            ),
        ),
    ));

/**
 * Hierarchie des utilisateurs
 */
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN'    => array('ROLE_PROF')
);

/**
 * Definition des regles d'acces
 */
$app['security.access_rules'] = array(
    // Utilisateur
    array('^/utilisateur/new$', 'ROLE_PROF'),
    array('^/utilisateur$', 'ROLE_ADMIN'),
    array('^/utilisateur/(edit|sup)/[0-9]+$', 'ROLE_PROF'),
    array('^/professeur$', 'ROLE_ADMIN'),
    array('^/eleve$', 'ROLE_PROF'),
    // Activite
    array('^/activite$', 'ROLE_ELEVE'),
    array('^/activite/new$', 'ROLE_ELEVE'),
    array('^/activite/(edit|sup)/[0-9]+$', 'ROLE_ELEVE'),
    // Competence
    array('^/competence/new$', 'ROLE_PROF'),
    array('^/competence/(edit|sup)/[0-9]+$', 'ROLE_PROF'),
    // Promotion
    array('^/promotion$', 'ROLE_PROF'),
    array('^/promotion/new$', 'ROLE_PROF'),
    array('^/promotion/(edit|sup)/[0-9]+$', 'ROLE_PROF'),
);

/**
 * Service de BDD
 */
$app['dao.activite'] = $app->share(function ($app) {
    return new SIOC\DAO\ActiviteDAO($app['db']);
});

$app['dao.competence'] = $app->share(function ($app) {
    return new SIOC\DAO\CompetenceDAO($app['db']);
});

$app['dao.promotion'] = $app->share(function ($app) {
    return new SIOC\DAO\PromotionDAO($app['db']);
});

$app['dao.utilisateur'] = $app->share(function ($app) {
    return new SIOC\DAO\UtilisateurDAO($app['db']);
});
