<?php

// Home page
$app->get('/activite', function () use ($app) {
    $activites = $app['dao.activite']->findAll();
    return $app['twig']->render('activite.html.twig', array('activites' => $activites));
});

$app->get('/competence', function () use ($app) {
    $competences = $app['dao.competence']->findAll();
    return $app['twig']->render('competence.html.twig', array('competences' => $competences));
});

$app->get('/promotion', function () use ($app) {
    $promotions = $app['dao.activite']->findAll();
    return $app['twig']->render('promotion.html.twig', array('promotions' => $promotions));
});