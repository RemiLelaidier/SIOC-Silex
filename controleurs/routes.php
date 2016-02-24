<?php

use Symfony\Component\HttpFoundation\Request;

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Home page
$app->get('/activite', function ($id) use ($app) {
    $activites = $app['dao.activite']->findAll();
    return $app['twig']->render('activite.html.twig', array('activites' => $activites));
})->bind('activite');

$app->get('/stats', function () use($app) {
    $stats = $app['dao.stat']->findAll();
    return $app['twig']->render('stats.html.twig');
});

$app->get('/eleve', function () use($app) {
    $eleves = $app['dao.eleve']->findAll();
    return $app['twig']->render('eleves.html.twig');
});

$app->get('/professeur', function () use($app) {
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('professeurs.html.twig');
});

$app->get('/competence', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
});

$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.activite']->findAll();
    return $app['twig']->render('promotion.html.twig', array('promotions' => $promotions));
});

$app->get('/', function () use($app) {
    return $app['twig']->render('acceuil.html.twig');
});