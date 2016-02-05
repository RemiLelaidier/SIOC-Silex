<?php

// Home page
$app->get('/', function () use ($app) {
    $activites = $app['dao.activite']->findAll();

    ob_start();             // start buffering HTML output
    require '../vues/view.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;
});