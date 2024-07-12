<?php
// src/App/Files/FileHandler.php

namespace App\Files;

class FileHandler implements FileHandlerInterface {
    protected $imagesType = ['image/jpeg', 'image/png', 'image/gif'];

    public function upload(array $file, string $directory): string {
        if (in_array($file['type'], $this->imagesType) && $file['error'] === UPLOAD_ERR_OK) {
            $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
            $destPath = $directory . $fileName;
            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                return $fileName;
            }
        }
        return 'naruto.jpg'; // Fallback image
    }
}