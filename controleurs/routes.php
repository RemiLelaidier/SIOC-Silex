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

$app->get('/utilisateur', function () use($app) {
    $utilisateurs = $app['dao.utilisateur']->findAll();
    return $app['twig']->render('utilisateur.html.twig', array('utilisateurs' => $utilisateurs));
})->bind('utilisateur');

$app->get('/eleve', function () use($app) {
    $eleves = $app['dao.utilisateur']->findAll();
    return $app['twig']->render('eleves.html.twig', array('eleves' => $eleves));
})->bind('eleve');

$app->get('/professeur', function () use($app) {
    $professeurs = $app['dao.utilisateur']->findAll();
    return $app['twig']->render('professeurs.html.twig', array('professeurs' => $professeurs));
})->bind('professeur');

$app->get('/competence', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
})->bind('competence');

$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.promotion']->findAll();
    return $app['twig']->render('promotion.html.twig', array('promotions' => $promotions));
})->bind('promotion');

$app->get('/stats', function () use ($app) {
    $stats = $app['dao.activite']->findAll();
    return $app['twig']->render('stats.html.twig', array('stats' => $stats));
})->bind('stats');



$app->get('/', function () use($app) {
    return $app['twig']->render('acceuil.html.twig');
});

//Création nouveaux champs
$app->get('/competence/new', function () use ($app) {
    return $app['twig']->render('ajout_competence.html.twig');
})->bind('ajout_competence');

$app->get('/activite/new', function () use ($app) {
    return $app['twig']->render('ajout_activite.html.twig');
})->bind('ajout_activite');

$app->get('/utilisateur/new', function () use ($app) {
    return $app['twig']->render('ajout_utilisateur.html.twig');
})->bind('ajout_utilisateur');

$app->get('/promotion/new', function() use ($app) {
return $app['twig']->render('ajout_promotion.html.twig');
})->bind('ajout_promotion');



//POST du formulaire de competence
$app->post('/competence', function (Request $request) use ($app) {
    $lololol = array('reference', 'libelle', 'description', 'obligation');
//    $reference = $request->get('reference');
//    $libelle = $request->get('libelle');
//    $description = $request->get('description');
//    $obligation = $request->get('obligation');
    var_dump($lololol);
    die();
});


// instancier objet dao pour recuperer array

$app->post('/activite', function (Request $request) use ($app) {
//    $ = $request->get('');
//    $ = $request->get('');
//    $ = $request->get('');
//    $ = $request->get('');
    var_dump($request->request);
    die();
});

$app->post('/eleve', function (Request $request) use ($app) {
    var_dump($request->request);
    die();
});

$app->post('/professeur', function (Request $request) use ($app) {
    var_dump($request->request);
    die();
});

$app->post('/stats', function (Request $request) use ($app) {
    var_dump($request->request);
    die();
});

$app->post('/promotion', function (Request $request) use ($app) {
    var_dump($request->request);
    die();
});

//Creer route utilisateur
//Prevoir route eleve ses activités