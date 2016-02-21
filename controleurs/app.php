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
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'anonymous' => false,
            'logout' => array('logout_path' => '/logout'),
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new SIOC\DAO\UtilisateurDAO($app['db']);
            }),
        ),
    ),
));

// Register services.
$app['dao.user'] = $app->share(function ($app) {
    return new SIOC\DAO\UtilisateurDAO($app['db']);
});            

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