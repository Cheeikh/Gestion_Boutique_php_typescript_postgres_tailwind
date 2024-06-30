<?php
// Chargement du fichier de configuration de l'application
require_once(__DIR__ . '/../bootstrap.php');

// Chargement des contrôleurs
require_once(__DIR__ . '/../Controllers/UserController.php');
require_once(__DIR__ . '/../Controllers/DebtController.php');
/* require_once '../Controllers/ProductController.php';
require_once '../Controllers/PaymentController.php'; */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        echo "Bienvenue sur la page d'accueil de la gestion de boutique!";
        break;

    case '/users':
        $controller = new UserController();
        $controller->index();
        break;

    case '/debts':
        $controller = new DebtController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;

  /*   case '/products':
        $controller = new ProductController();
        $controller->index();
        break;

    case '/payments':
        $controller = new PaymentController();
        $controller->index();
        break; */

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
?>