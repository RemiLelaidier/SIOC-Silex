<?php
use Symfony\Component\HttpFoundation\Request;

/**
 * Route page d'acceuil
 * TOCHECK
 */
$app->get('/', function (Request $request) use($app) {
    $professeurs = $app['dao.utilisateur']->findAllProfesseur();
    return $app['twig']->render('acceuil.html.twig', array(
        'professeurs' => $professeurs
    ));
});

/**
 * Route page de connexion
 */
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

/**
 * Route vers la verification de login
 *  TODO   comparaison mot de passe -> BDD
 */

$app->get('/login/check', function() use ($app) {
})->bind('acceuil');

/**
 * Route page activite
 * TOCHECK
 */
$app->get('/activite', function () use ($app) {
    $activites = $app['dao.activite']->findAll();
    $activiteEleve = $app['dao.utilisateur']->findAllbyUtilisateur();
    return $app['twig']->render('activite.html.twig', array(
        'activites' => $activites,
        'activiteEleve' => $activiteEleve));
})->bind('activite');

/**
 * Route page utilisateur
 */
$app->get('/utilisateur', function () use($app) {
    $utilisateurs = $app['dao.utilisateur']->findAll();
    return $app['twig']->render('utilisateur.html.twig', array('utilisateurs' => $utilisateurs));
})->bind('utilisateur');

/**
 * Route page eleve
 */
$app->get('/eleve', function () use($app) {
    $eleves = $app['dao.utilisateur']->findAllEleve();
    return $app['twig']->render('eleves.html.twig', array('eleves' => $eleves));
})->bind('eleve');

/**
 * Route page professeur
 */
$app->get('/professeur', function () use($app) {
    $professeurs = $app['dao.utilisateur']->findAllProfesseur();
    return $app['twig']->render('professeurs.html.twig', array('professeurs' => $professeurs));
})->bind('professeur');

/**
 * Route page competence
 */
$app->get('/competence', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
})->bind('competence');

/**
 * Route page promotion
 * TOCHECK
 */
$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.promotion']->findAll();
//    $nbEleves = $app['dao.utilisateur']->findNbEleve();
    //TODO NB ELEVE
    return $app['twig']->render('promotion.html.twig', array(
        'promotions' => $promotions,
//        'nbEleves' => $nbEleves
    ));
})->bind('promotion');

/**
 * Route page stats
 */
$app->get('/stats', function () use ($app) {
    $token = $app['security.token_storage']->getToken();
    var_dump($token);
    die();
    $stats = $app['dao.activite']->findAllbyUtilisateur($token);
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('stats.html.twig', array('stats' => $stats, 'competences' => $competences));
})->bind('stats');

/**
 * Route page ajout de competence
 */
$app->get('/competence/new', function () use ($app) {
    return $app['twig']->render('ajout_competence.html.twig');
})->bind('ajout_competence');

/**
 * Route page ajout activite
 */
$app->get('/activite/new', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('ajout_activite.html.twig', array('competences' => $competences));
})->bind('ajout_activite');

/**
 * Route page ajout utilisateur
 */
$app->get('/utilisateur/new', function () use ($app) {
    $promotions = $app['dao.promotion']->findAll();
    return $app['twig']->render('ajout_utilisateur.html.twig', array('promotions' => $promotions));
})->bind('ajout_utilisateur');

/**
 * Route page ajout promotion
 */
$app->get('/promotion/new', function() use ($app) {
    return $app['twig']->render('ajout_promotion.html.twig');
})->bind('ajout_promotion');

/**
 * Route reponse competence
 */
$app->post('/competence', function (Request $request) use ($app) {
    $competence = new \SIOC\donnees\Competence();
    $competence -> setReference($request->get('reference'));
    $competence -> setLibelle($request -> get('libelle'));
    $competence -> setDescription($request -> get('description'));
    $competence -> setObligatoire($request->get('obligatoire'));
    $app['dao.competence']->save($competence);
    $competences = $app['dao.competence']->findAll();
    return $app['twig'] -> render('competence.html.twig', array('competences' => $competences));
});

/**
 * Route activite
 */
$app->post('/activite', function (Request $request) use ($app) {
    $activite = new \SIOC\donnees\Activite();
    $activite -> setDebut($request->get('debut'));
    $activite -> setDuree($request -> get('duree'));
    $activite -> setLibelle($request -> get('libelle'));
    $activite -> setDescription($request->get('description'));
    $activite -> setCompetences($request->get('competences'));
    $activite -> setUtilisateur($request->get('utilisateur'));
    $app['dao.activite']->save($activite);
    $activites = $app['dao.activite']->findAll();
    return $app['twig'] -> render('activite.html.twig', array('activites' => $activites));
});

/**
 * Route utilisateur
 */
$app->post('/utilisateur', function (Request $request) use ($app) {
    $utilisateur = new \SIOC\donnees\Utilisateur();
    $promotion = new \SIOC\donnees\Promotion();
    $utilisateur->setUsername($request->get('username'));
    $utilisateur->setNom($request->get('nom'));
    $utilisateur->setPrenom($request->get('prenom'));
    $utilisateur->setMail($request->get('mail'));
    $utilisateur->setPassword(sha1($request->get('password')));
    $utilisateur->setSalt($request->get('salt'));
    $utilisateur->setRole($request->get('statut'));
    if($utilisateur->getRole() == 'ROLE_ELEVE'){
        $promotion-setId($request->get('promo'));
    }
    $app['dao.utilisateur']->save($utilisateur, $promotion);
    $utilisateurs = $app['dao.utilisateur']->findAll();
    return $app['twig'] -> render('utilisateur.html.twig', array('utilisateurs' => $utilisateurs));
});

/**
 * Route promotion
 */
$app->post('/promotion', function (Request $request) use ($app) {
    $promotion = new \SIOC\donnees\Promotion();
    $promotion -> setLibelle($request->get('libelle'));
    $promotion -> setAnnee($request -> get('annee'));
    $app['dao.promotion']->save($promotion);
    $promotions = $app['dao.promotion']->findAll();
    return $app['twig'] -> render('promotion.html.twig', array('promotions' => $promotions));
});


//Prevoir route eleve ses activités
