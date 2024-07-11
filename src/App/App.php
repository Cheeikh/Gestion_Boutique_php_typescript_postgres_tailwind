<?php
// src/App/App.php

namespace App;

use App\Database\MysqlDatabase;
use App\Core\Router;
use PDO;

class App {
    private static $instance;
    private $database;
    private $router;

    private function __construct(PDO $pdo) {
        $this->database = new MysqlDatabase($pdo);
        
        // Charger les routes
        $webRoutes = require __DIR__ . '/Routes/web.php';
        $apiRoutes = require __DIR__ . '/Routes/api.php';
        
        $this->router = new Router($webRoutes, $apiRoutes);
    }

    public static function getInstance(PDO $pdo = null) {
        if (!self::$instance && $pdo !== null) {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getModel($model) {
        $modelClass = 'App\\Model\\' . ucfirst($model) . 'Model';
        return new $modelClass($this->database);
    }

    public function run() {
        $this->router->dispatch();
    }

    public function getRouter() {
        return $this->router;
    }
}
