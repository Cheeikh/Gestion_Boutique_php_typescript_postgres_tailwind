<?php
// src/App/Routes/WebRoutes.php

namespace App\Routes;

use App\Controller\ClientController;
use App\Controller\DebtController;
use App\Controller\ExoController;

class WebRoutes {
    public static function getRoutes() {
        return [
            ['POST', '/clients/create', [ClientController::class, 'create']],
            ['POST', '/clients/show', [ClientController::class, 'show']],
            ['POST', '/dette/list', [DebtController::class, 'show']],
            ['GET', '/dettes/add/#id/#date/#dat1', [ExoController::class, 'store']],
            ['GET', '/clients', function () {
                view('Client/clients');
            }],
            ['GET', '/clients/detail', function () {
                view('Client/detail');
            }]
        ];
    }
}
