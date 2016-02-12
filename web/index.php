<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/controleurs/config/dev.php';
require __DIR__.'/controleurs/app.php';
require __DIR__.'/controleurs/routes.php';

$app->run();