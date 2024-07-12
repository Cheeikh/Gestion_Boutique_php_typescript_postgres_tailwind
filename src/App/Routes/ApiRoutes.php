<?php
// src/App/Routes/ApiRoutes.php

namespace App\Routes;

use App\Controller\DebtController;

class ApiRoutes {
    public static function getRoutes() {
        return [
            ['GET', '/dette/list', [DebtController::class, 'show']]
        ];
    }
}
