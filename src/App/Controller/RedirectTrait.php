<?php
// src/App/Controller/RedirectTrait.php

namespace App\Controller;

trait RedirectTrait {
     function redirect(string $url, int $statusCode = 302): void {
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
