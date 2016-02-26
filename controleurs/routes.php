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
$app->post('/competence', function (Request $request) use ($app) {
    $competence = new \SIOC\donnees\Competence();
    $competence -> setReference($request->get('reference'));
    $competence -> setLibelle($request -> get('libelle'));
    $competence -> setDescription($request -> get('description'));
    $competence -> setObligatoire($request->get('obligatoire'));
    $app['dao.competence']->save($competence);
    $competences = $app['dao.competence']->findAll();
    return $app['twig'] -> render('competence.html.twig', array('competences' => $competences,
    ));
});

$app->post('/activite', function (Request $request) use ($app) {
    $activite = new \SIOC\donnees\Activite();
    $activite -> setDebut($request->get('debut'));
    $activite -> setDuree($request -> get('duree'));
    $activite -> setLibelle($request -> get('libelle'));
    $activite -> setDescription($request->get('description'));
    $activite -> setCompetences($request->get('competences'));
    $activite -> setUtilisateur($request->get('utilisateur'));
    $app['dao.activite']->save($activite);
 //   $activites['twig'] -> render('activite')
});

$app->post('/utilisateur', function (Request $request) use ($app) {
    $utilisateur = new \SIOC\donnees\Utilisateur();
    $utilisateur->setUsername($request->get('username'));
    $utilisateur->setNom($request->get('nom'));
    $utilisateur->setPrenom($request->get('prenom'));
    $utilisateur->setMail($request->get('mail'));
    $utilisateur->setPassword($request->get('password'));
    $utilisateur->setSalt($request->get('salt'));
    $utilisateur->setRole($request->get('statut'));
    $app['dao.utilisateur']->save($utilisateur);
});

$app->post('/promotion', function (Request $request) use ($app) {
    $promotion = new \SIOC\donnees\Promotion();
    $promotion -> setLibelle($request->get('libelle'));
    $promotion -> setAnnee($request -> get('annee'));
    $app['dao.promotion']->save($promotion);
    $promotions = $app['dao.promotion']->findAll();
    return $app['twig'] -> render('promotion.html.twig', array('promotions' => $promotions,
    ));
});


//Creer route utilisateur
//Prevoir route eleve ses activités
