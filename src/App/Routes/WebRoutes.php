<?php
// src/App/Routes/WebRoutes.php

namespace App\Routes;

use App\Controller\ClientController;
use App\Controller\DebtController;
use App\Controller\LoginController;

class WebRoutes {
    public static function getRoutes() {
        return [
            ['POST', '/clients/create', [ClientController::class, 'create']],
            ['POST', '/debt/create', [DebtController::class, 'create']],
            ['POST', '/clients/show', [ClientController::class, 'show']],
            ['GET', '/dette/list', [DebtController::class, 'show']],
            ['GET', '/debt/list/#id', [DebtController::class, 'list']],
            ['GET', '/paiments/#id', [DebtController::class, 'Paiements']],
            ['GET', '/paiement/add/#id', [DebtController::class, 'AddPaiement']],
            ['POST', '/debt/clear-cart', [DebtController::class, 'clearCart']],
            ['POST', '/debt/remove-product', [DebtController::class, 'removeProduct']],
            ['POST', '/login', [LoginController::class, 'login']],
            ['GET', '/dettes/details/#id', [DebtController::class, 'details']], // Ajout de la route pour les détails de la dette
            ['GET', '/clients', function () {
                view('Client/clients');
            }],
            ['GET', '/debt/add', function () {
                view('Debt/add');
            }],
            ['GET', '/', function () {
                view('Login/connexion', true);
            }]
        ];
    }
}
