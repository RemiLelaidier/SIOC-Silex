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
        'secured' => array(
            'pattern' => '^.*$',
            'anonymous' => false, // A modifier
            'logout' => array('logout_path' => '/logout'),
            'form' => array('login_path' => '/login', 'check_path' => 'login_check'), //Bug double redirection
            'users' => array(
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
//            'users' => $app->share(function () use ($app) {
//                return new SIOC\DAO\UtilisateurDAO($app['db']);
           // }),
        ),
    ),
));

/**
 * Hierarchie des utilisateurs
 */
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN'    => array('ROLE_PROF'),
    'ROLE_PROF'    => array('ROLE_ELEVE'),
);
/**
 * Definition des rôles utilisateurs
 */

$app['security.access_rules'] = array(
    array('^/professeurs/.*$', 'ROLE_ADMIN'),
    array('^/promotion/.*$', 'ROLE_PROF'),// array('^/professeurs/.*$', 'ROLE_ADMIN')
    array('^/eleves/.*$', 'ROLE_PROF'),
    array('^/activite/.*$', 'ROLE_PROF'),
    array('^/competence/.*$', 'ROLE_PROF'),
    array('^/competence/new', 'ROLE_ELEVE'),
    array('^/competence/', 'ROLE_ELEVE'),
    array('^/activite/new', 'ROLE_ELEVE'),
    array('^/activite/', 'ROLE_ELEVE'),
    array('^/login', 'IS_AUTHENTICATED_ANONYMOUSLY'),
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
