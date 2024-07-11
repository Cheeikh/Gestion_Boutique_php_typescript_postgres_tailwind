<?php
// src/App/Controller/Controller.php

namespace App\Controller;

use App\App;
use PDO;

abstract class Controller {
    protected $app;
    protected $isApi = false;

    public function __construct(PDO $pdo = null, $isApi = false) {
        $this->isApi = $isApi;
        if ($pdo === null) {
            $this->app = App::getInstance();
        } else {
            $this->app = App::getInstance($pdo);
        }

        if ($this->app === null) {
            echo "Erreur: impossible d'initialiser l'application";
            die();
        }
    }

    protected function render($view, $data = [], $layout = 'layout') {
        extract($data);
    
        // Chemin vers le fichier de vue
        $viewPath = __DIR__ . '/../Views/' . $view . '.html.php';
    
        // Vérifier si le fichier de vue existe
        if (file_exists($viewPath)) {
            ob_start();
            include $viewPath;
            $content = ob_get_clean();
    
            // Vérifier si le layout spécifique existe
            $layoutPath = __DIR__ . '/../Views/layout/' . $layout . '.html.php';
            if (file_exists($layoutPath)) {
                include $layoutPath;
            } else {
                // Utiliser un layout par défaut si le layout spécifique n'existe pas
                include __DIR__ . '/../Views/layout/layout.html.php';
            }
        }
    }
    

    protected function getModel($modelName) {
        return $this->app->getModel($modelName);
    }

    protected function validate($data, $rules) {
        $errors = [];

        foreach ($rules as $field => $rule) {
            if (!isset($data[$field])) {
                $errors[$field] = 'Le champ est requis';
                continue;
            }

            if (!preg_match($rule['pattern'], $data[$field])) {
                $errors[$field] = $rule['message'];
            }
        }

        return $errors;
    }

    protected function redirect($url, $statusCode = 302) {
        if (!$this->isApi) {
            header('Location: ' . $url, true, $statusCode);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(['redirect' => $url]);
            exit();
        }
    }
}
