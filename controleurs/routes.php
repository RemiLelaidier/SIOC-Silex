<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
//use Silex\PdfServiceProviderInterface;
//use Silex\PdfServiceProvider;

//$app->get("/login", "SIOC-Silex\vues\login.html.twig::login");
//$app->post("/login_check", "admin\controllers\AdminController::loginCheck");

/**
 * Route page d'acceuil
 */
$app->get('/', function () use($app) {
    if ($app['security.authorization_checker']->isGranted('ROLE_ELEVE')) {
        $id = $app['security.token_storage']->getToken()->getUser()->getId();
        $professeurs = $app['dao.utilisateur']->findAllProfesseur();
        $activites = $app['dao.activite']->findAllbyUtilisateur($id);
        $competences = $app['dao.competence']->findAll();
        $nbComp = $app['dao.competence']->findNbByEleve($id);
        $promotion = $app['dao.promotion']->findByEleve($id);

    return $app['twig']->render('acceuil.html.twig', array(
        'professeurs' => $professeurs,
        'activites' => $activites,
        'competences' => $competences,
        'nbComp' => $nbComp,
        'promotion' => $promotion
        ));
    }
 else {
        return $app['twig']->render('acceuil_admin_prof.html.twig');
    }
});

/**
 * Route export PDF
 */
//$app->get('/index', function() use ($app) {
//    $app['pdf.generator']->findAll();
//    $competences = $app['dao.competence']->findAll();
//    return $app['pdf.generator']->render('index.html.twig', array('competences' => $competences));
//})->bind('index');


//$app->get('/competence', function () use ($app) {
//    $competences = $app['dao.competence']->findAll();
//    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
//})->bind('competence');

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
 * Route page activite
 * TOCHECK
 */
$app->get('/activite', function () use ($app) {
    $activites = $app['dao.activite']->findAll();
//    $activitesEleve = $app['dao.activite']->findAllbyUtilisateur($id);
    return $app['twig']->render('activite.html.twig', array(
        'activites' => $activites,
//        'activiteEleve' => $activitesEleve
    ));
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
 */
$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.promotion']->findAll();
    $nbEleves = $app['dao.utilisateur']->findAllEleve();
    return $app['twig']->render('promotion.html.twig', array(
        'promotions' => $promotions,
        'nbEleves' => $nbEleves
    ));
})->bind('promotion');

/**
 * Route page stats
 */
$app->get('/stats', function () use ($app) {
    $id = $app['security.token_storage']->getToken();
    //$stats = $app['dao.activite']->findAllbyUtilisateur($id);
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
    $competence -> setReference($request->request->get('reference'));
    $competence -> setLibelle($request->request->get('libelle'));
    $competence -> setDescription($request->request->get('description'));
    $competence -> setObligatoire($request->request->get('obligatoire'));
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
    $activite -> setDuree($request->get('duree'));
    $activite -> setLibelle($request->get('libelle'));
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
    var_dump($request);
    die();
    $salt = substr(md5(time()), 0, 23);
    $utilisateur = new \SIOC\donnees\Utilisateur();
    $promotion = new \SIOC\donnees\Promotion();
    $utilisateur->setUsername($request->request->get('username'));
    $utilisateur->setNom($request->request->get('nom'));
    $utilisateur->setPrenom($request->request->get('prenom'));
    $utilisateur->setMail($request->request->get('email'));
    $utilisateur->setSalt($salt);
    $encoder = $app['security.encoder.digest'];
    $utilisateur->setPassword($encoder->encodePassword($request->request->get('password'),$utilisateur->getSalt()));
    $utilisateur->setRole($request->request->get('role'));
    if($utilisateur->getRole() == 'ROLE_ELEVE'){
        $promotion-setId($request->request->get('promo'));
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

$app->get('/promotion/{id}', function () use ($app) {
    $promotion = $app['dao.promotion']->find($id);
    return $app['twig']->render('voir_promotion.html.twig', array(
        'promotions' => $promotion,
    ));
})->bind('promotion/{id}');

