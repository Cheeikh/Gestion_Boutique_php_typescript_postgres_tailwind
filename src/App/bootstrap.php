<?php
// src/App/bootstrap.php
require_once '/var/www/html/gestionboutique/vendor/autoload.php';

use App\Database\MysqlDatabase;
use Dotenv\Dotenv;

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Établir une connexion à la base de données
try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Instancier MysqlDatabase et le rendre disponible pour l'application
$database = new MysqlDatabase($pdo);

// Vous pouvez maintenant utiliser $database dans votre application
