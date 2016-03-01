<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../vues',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'anonymous' => true, // A modifier
            'logout' => array('logout_path' => '/logout'),
//            'form' => array('login_path' => '/login', 'check_path' => '/login_check'), Bug double redirection
            'users' => $app->share(function () use ($app) {
                return new SIOC\DAO\UtilisateurDAO($app['db']);
            }),
        ),
    ),
));

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN'    => array('ROLE_PROF'),
    'ROLE_PROF'    => array('ROLE_ELEVE'),
    'ROLE_ELEVE'    => array('ROLE_USER')
);

// Definition des rôles utilisateurs
$app['security.access_rules'] = array(
    array('^/login', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/acceuil', 'ROLE_USER'),
    array('^/layout', 'ROLE_USER'),
    array('^/activite/', 'ROLE_ELEVE'),
    array('^/activite/new', 'ROLE_ELEVE'),
    array('^/competence/', 'ROLE_ELEVE'),
    array('^/competence/new', 'ROLE_ELEVE'),
    array('^/competence/.*$', 'ROLE_PROF'),
    array('^/activite/.*$', 'ROLE_PROF'),
    array('^/eleves/.*$', 'ROLE_PROF'),
    array('^/promotion/.*$', 'ROLE_PROF'),//
    array('^/professeurs/.*$', 'ROLE_ADMIN')
);

// Register services.

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
