<?php

/**
 *  HomeController
 */
// Route page d'acceuil
$app->get('/', "SIOC\Controller\HomeController::homeAction");

// Route page de connexion
$app->get('/login', "SIOC\Controller\HomeController::loginAction")->bind('login');

/**
 *  ActiviteController
 */
// Route page activite
$app->get('/activite', "SIOC\Controller\ActiviteController::activiteAction")->bind('activite');

// Route Ajout Activite
$app->get('/activite/new', "SIOC\Controller\ActiviteController::activiteAjoutAction")->bind('ajout_activite');

// Route Activite{id}
$app->get('/activite/{id}', "SIOC\Controller\ActiviteController::activiteIdAction")->bind('activite_');

// Route insertion Activite
$app->post('/activite', "SIOC\Controller\ActiviteController::activiteInsertAction");

/**
 *  UtilisateurController
 */
// Route Utilisateur
$app->get('/utilisateur', "SIOC\Controller\UtilisateurController::utilisateurAction")->bind('utilisateur');

// Route Professeur
$app->get('/professeur', "SIOC\Controller\UtilisateurController::professeurAction")->bind('professeur');

// Route Ajout Utilisateur
$app->get('/utilisateur/new', "SIOC\Controller\UtilisateurController::utilisateurAjoutAction")->bind('ajout_utilisateur');

// Route Insertion Utilisateur
$app->post('/utilisateur', "SIOC\Controller\UtilisateurController::utilisateurInserAction");

/**
 *  CompetenceController
 */
//Route Competence
$app->get('/competence', "SIOC\Controller\CompetenceController::competenceAction")->bind('competence');

// Route Ajout Competence
$app->get('/competence/new', "SIOC\Controller\CompetenceController::competenceAjoutAction")->bind('ajout_competence');

// Route Insert Competence
$app->post('/competence', "SIOC\Controller\CompetenceController::competenceInsertAction");

/**
 *  PromotionController
 */
// Route Promotion
$app->get('/promotion', "SIOC\Controller\PromotionController::promotionAction")->bind('promotion');

// Route Ajout Promotion
$app->get('/promotion/new', "SIOC\Controller\PromotionController::promotionAjoutAction")->bind('ajout_promotion');

// Route Insert Promotion
$app->post('/promotion', "SIOC\Controller\PromotionController::promotionInsertAction");

// Route Promotion{id}
$app->get('/promotion/{id}', "SIOC\Controller\PromotionController::promotionIdAction")->bind('promotion/{id}');