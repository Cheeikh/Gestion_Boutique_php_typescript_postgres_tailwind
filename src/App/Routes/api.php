<?php
// src/App/Routes/api.php
require_once __DIR__ . '/../Helpers/helpers.php';

use App\Controller\DebtController;

return [
    ['GET', '/dette/list', [DebtController::class, 'show']]
];
