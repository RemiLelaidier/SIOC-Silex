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
    $token = $app['security.token_storage']->getToken();
    var_dump($token);
    die();
    $stats = $app['dao.activite']->findAllbyUtilisateur($token);
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('stats.html.twig', array('stats' => $stats, 'competences' => $competences));
})->bind('stats');

$app->get('/', function () use($app) {
    return $app['twig']->render('acceuil.html.twig');
});


//envois ressources aux pages




//Ajout de competences

$app->get('/competence/new', function () use ($app) {
    return $app['twig']->render('ajout_competence.html.twig');
})->bind('ajout_competence');

$app->get('/activite/new', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('ajout_activite.html.twig', array('competences' => $competences));
})->bind('ajout_activite');

$app->get('/utilisateur/new', function () use ($app) {
    $promotions = $app['dao.promotion']->findAll();
    return $app['twig']->render('ajout_utilisateur.html.twig', array('promotions' => $promotions));
})->bind('ajout_utilisateur');

$app->get('/promotion/new', function() use ($app) {
return $app['twig']->render('ajout_promotion.html.twig');
})->bind('ajout_promotion');



//POST du formulaire d'ajout
$app->post('/competence', function (Response $response) use ($app) {
    $competence = new \SIOC\donnees\Competence();
    $competence -> setReference($response->get('reference'));
    $competence -> setLibelle($response -> get('libelle'));
    $competence -> setDescription($response -> get('description'));
    $competence -> setObligatoire($response->get('obligatoire'));
    $app['dao.competence']->save($competence);
});

$app->post('/activite', function (Response $response) use ($app) {
    $activite = new \SIOC\donnees\Activite();
    $activite -> setDebut($response->get('debut'));
    $activite -> setDuree($response -> get('duree'));
    $activite -> setLibelle($response -> get('libelle'));
    $activite -> setDescription($response->get('description'));
    $activite -> setCompetences($response->get('competences'));
    $activite -> setUtilisateur($response->get('utilisateur'));
    $app['dao.activite']->save($activite);
});

$app->post('/utilisateur', function (Response $response) use ($app) {
    $utilisateur = new \SIOC\donnees\Utilisateur();
    $utilisateur->setUsername($response->get('username'));
    $utilisateur->setNom($response->get('nom'));
    $utilisateur->setPrenom($response->get('prenom'));
    $utilisateur->setMail($response->get('mail'));
    $utilisateur->setPassword($response->get('password'));
    $utilisateur->setSalt($response->get('salt'));
    $utilisateur->setRole($response->get('statut'));
    $app['dao.utilisateur']->save($utilisateur);
});

$app->post('/promotion', function (Response $response) use ($app) {
    $promotion = new \SIOC\donnees\Promotion();
    $promotion -> setLibelle($response->get('libelle'));
    $promotion -> setAnnee($response -> get('annee'));
    $app['dao.promotion']->save($promotion);
});

// Useless \o/
//$app->post('/stats', function (Request $request) use ($app) {
//    $stats = new \SIOC\donnees\stats();
//    $stats -> setReference($request->get('reference'));
//    $stats -> setLibelle($request -> get('libelle'));
//    $stats -> setDescription($request -> get('description');
//    $stats -> setObligatoire($request->get('obligatoire');
//    $app['dao.stats']->save($stats);
//});

//Creer route utilisateur
//Prevoir route eleve ses activités
