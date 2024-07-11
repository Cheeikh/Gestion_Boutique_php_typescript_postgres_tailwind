<?php
//src/App/Helpers/helpers.php


function view($view) {
    $viewPath = __DIR__ . '/../Views/' . $view . '.html.php';

    if (file_exists($viewPath)) {
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout/layout.html.php';
    }
}

