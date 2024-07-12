<?php
// src/App/Controller/ViewTrait.php

namespace App\Controller;

trait ViewTrait {
     function render(string $view, array $data = [], string $layout = 'layout'): void {
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
}
