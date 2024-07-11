<?php
// src/App/Controller/Api/Api.php

namespace App\Controller\Api;

class Api {
    public function renderJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}