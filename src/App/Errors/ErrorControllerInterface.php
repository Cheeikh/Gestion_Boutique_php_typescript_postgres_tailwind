<?php
// src/App/Errors/ErrorControllerInterface.php

namespace App\Errors;

interface ErrorControllerInterface {
    public function loadView(int $code): void;
}
