<?php
// src/App/Routes/web.php
require_once __DIR__ . '/../Helpers/helpers.php';


use App\Controller\ClientController;
use App\Controller\DebtController;
use App\Controller\ExoController;

return [
    ['POST', '/clients/create', [ClientController::class, 'create']],
    ['POST', '/clients/show', [ClientController::class, 'show']],
    ['POST', '/dette/list', [DebtController::class, 'show']],
    ['GET', '/dettes/add/#id/#date/#dat1', [ExoController::class, 'store']],
    ['GET', '/clients', function () {
        view('Client/clients');
    }]
];
