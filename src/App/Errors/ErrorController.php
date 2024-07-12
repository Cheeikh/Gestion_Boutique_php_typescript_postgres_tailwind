<?php
// src/App/Errors/ErrorController.php

namespace App\Errors;

class ErrorController implements ErrorControllerInterface {
    protected const HTTP_CODES = [
        404 => 'Not Found',
        500 => 'Internal Server Error'
    ];

    public function loadView(int $code): void {
        if (array_key_exists($code, self::HTTP_CODES)) {
            http_response_code($code);
            require_once __DIR__ . '/../../Views/Errors/' . $code . '.php';
        } else {
            http_response_code(500);
            require_once __DIR__ . '/../../Views/Errors/500.php';
        }
    }
}