<?php
// src/App/Files/FileHandlerInterface.php

namespace App\Files;

interface FileHandlerInterface {
    public function upload(array $file, string $directory): string;
}
