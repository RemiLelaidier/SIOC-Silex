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
 * Sécurisation de l'application, identification et redirection login
 */
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'anonymous' => false, // A modifier
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
    'ROLE_ADMIN'    => array('ROLE_PROF'),
    'ROLE_PROF'     => array('ROLE_ELEVE')
);

/**
 * Definition des rôles utilisateurs
 */
$app['security.access_rules'] = array(
    // Login
    // array('^/login$', ''),
    // Utilisateur
    array('^/utilisateur/new$', 'ROLE_PROF'),
    array('^/utilisateur$', 'ROLE_ADMIN'),
    array('^/utilisateur/(edit|sup)/[0-9]*$', 'ROLE_PROF'),
    array('^/professeur$', 'ROLE_ADMIN'),
    array('^/eleve$', 'ROLE_PROF'),
    // Activite
    array('^/activite$', 'ROLE_ELEVE'),
    array('^/activite/new$', 'ROLE_ELEVE'),
    array('^/activite/(edit|sup)/[0-9]*$', 'ROLE_ELEVE'),
    // Competence
    array('^/competence$', 'ROLE_ELEVE'),
    array('^/competence/new$', 'ROLE_PROF'),
    array('^/competence/(edit|sup)/[0-9]*$', 'ROLE_PROF'),
    // Promotion
    array('^/promotion$', 'ROLE_PROF'),
    array('^/promotion/new$', 'ROLE_PROF'),
    array('^/promotion/(edit|sup)/[0-9]*$', 'ROLE_PROF'),
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
