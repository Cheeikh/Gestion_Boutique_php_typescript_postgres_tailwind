<?php
// config.php

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Définir la constante ROOT
define('ROOT', $_ENV['ROOT']);
