<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Home page
$app->get('/activite', function () use ($app) {
    $activites = $app['dao.activite']->findAll();
    return $app['twig']->render('activite.html.twig', array('activites' => $activites));
})->bind('activite');

$app->get('/stats', function () use($app) {
    $stats = $app['dao.stat']->findAll();
    return $app['twig']->render('stats.html.twig');
})->bind('stats');

$app->get('/eleve', function () use($app) {
    $eleves = $app['dao.eleve']->findAll();
    return $app['twig']->render('eleves.html.twig');
})->bind('eleve');

$app->get('/professeur', function () use($app) {
    $professeurs = $app['dao.professeur']->findAll();
    return $app['twig']->render('professeurs.html.twig');
})->bind('professeur');

$app->get('/competence', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
})->bind('competence');

$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.activite']->findAll();
    return $app['twig']->render('promotion.html.twig', array('promotions' => $promotions));
})->bind('promotion');

$app->get('/', function () use($app) {
    return $app['twig']->render('acceuil.html.twig');
});

//Création new competence
$app->get('/competence/new', function () use ($app) {
    return $app['twig']->render('ajout_competence.html.twig');
})->bind('ajout_competence');

//POST du formulaire de competence
$app->post('/competence', function (Request $request) use ($app) {
    $competence = $request->get('competence');
    competence('com_reference','com_libelle','com_description', $competence);
    return;
    var_dump($request);
    die();
});

//Creer route utilisateur
//Prevoir route eleve ses activités
