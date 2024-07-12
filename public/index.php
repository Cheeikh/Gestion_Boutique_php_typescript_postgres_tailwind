<?php
// public/index.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../src/App/bootstrap.php';

// Initialiser le conteneur
$container = require '../src/App/bootstrap.php';

// Récupérer l'instance de l'application
$app = App\App::getInstance($container);

// Lancer l'application
$app->run();

