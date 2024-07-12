<?php
// src/App/Controller/ControllerInterface.php

namespace App\Controller;

interface ControllerInterface {
    public function render(string $view, array $data = [], string $layout = 'layout'): void;
    public function validate(array $data, array $rules): array;
    public function redirect(string $url, int $statusCode = 302): void;
}
