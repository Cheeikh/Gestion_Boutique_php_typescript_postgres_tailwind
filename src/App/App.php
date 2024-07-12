<?php
// src/App/App.php

namespace App;

use App\Database\MysqlDatabase;
use App\Security\SecurityDatabase;
use App\Core\Router;
use Pimple\Container;

class App {
    private static $instance;
    private $database;
    private $router;
    private $container;

    private function __construct(Container $container) {
        $this->container = $container; // Stocker le conteneur

        // Récupérer la base de données à partir du conteneur
        $this->database = $container['App\Database\MysqlDatabase']; // Utilisez le bon identifiant

        // Charger les routes
        $webRoutes = require __DIR__ . '/Routes/web.php';
        $apiRoutes = require __DIR__ . '/Routes/api.php';

        // Instancier le routeur avec les services nécessaires
        $this->router = $container['router']; // Utiliser le conteneur pour obtenir le routeur
    }

    public static function getInstance(Container $container = null) {
        if (!self::$instance && $container !== null) {
            self::$instance = new self($container);
        }
        return self::$instance;
    }

    public function getDatabase(): MysqlDatabase {
        return $this->database;
    }

    public static function getSecurityDB(): SecurityDatabase {
        return new SecurityDatabase(self::getInstance()->getDatabase());
    }

    public function getModel(string $model) {
        // Obtenir le modèle à partir du conteneur
        $modelClass = 'App\\Model\\' . ucfirst($model) . 'Model';
        return $this->container[$modelClass]; // Utiliser le conteneur stocké pour obtenir le modèle
    }

    public function run(): void {
        $this->router->dispatch();
    }

    public function getRouter(): Router {
        return $this->router;
    }
}
