<?php
//src/App/Helpers/helpers.php


function view($view, $login= false) {
    $viewPath = __DIR__ . '/../Views/' . $view . '.html.php';

    if (file_exists($viewPath)) {
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        if ($login == false) {
            include __DIR__ . '/../Views/layout/layout.html.php';
        } else {
            include __DIR__ . '/../Views/layout/layout2.html.php';
        }
    }
}

