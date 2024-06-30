<?php
require_once __DIR__ . '/../src/Models/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo 'Connexion à la base de données réussie';
} else {
    echo 'Échec de la connexion à la base de données';
}
