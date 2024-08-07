<?php
// src/App/bootstrap.php
require_once '/var/www/html/gestionboutique/vendor/autoload.php';

use Pimple\Container;
use Symfony\Component\Yaml\Yaml;
use App\Routes\WebRoutes;
use App\Routes\ApiRoutes;

// Charger la configuration depuis config.yaml
$config = Yaml::parseFile('/var/www/html/gestionboutique/src/App/config.yaml');

// Créer un conteneur de services
$container = new Container();

// Ajouter les services au conteneur depuis la configuration
foreach ($config['services'] as $id => $service) {
    $container[$id] = function ($c) use ($service) {
        $class = $service['class'];
        $args = $service['arguments'] ?? [];
        
        // Résoudre les arguments
        $resolvedArgs = [];
        foreach ($args as $arg) {
            if (is_string($arg) && strpos($arg, '@') === 0) {
                $resolvedArgs[] = $c[substr($arg, 1)];
            } else {
                $resolvedArgs[] = $arg; // Passer les valeurs non identifiées
            }
        }
        
        return new $class(...$resolvedArgs);
    };
}

// Définir les routes après avoir défini tous les services nécessaires
$container['webRoutes'] = function() {
    return WebRoutes::getRoutes();  // Appel de la méthode statique pour obtenir les routes
};

$container['apiRoutes'] = function() {
    return ApiRoutes::getRoutes();   // Appel de la méthode statique pour obtenir les routes
};

// Assurez-vous que les services Authorize et FileHandler sont définis
$container['App\Authorize\Authorize'] = function() {
    return new App\Authorize\Authorize(); // Instanciation du service Authorize
};

$container['App\Files\FileHandler'] = function() {
    return new App\Files\FileHandler(); // Instanciation du service FileHandler
};

$container['App\Session\Session'] = function() {
    return new App\Session\Session(); // Instanciation du service Session
};

// Définir le service router
$container['router'] = function($c) {
    return new App\Core\Router(
        $c['webRoutes'],
        $c['apiRoutes'],
        $c['App\Authorize\Authorize'],
        $c['App\Files\FileHandler'],
        $c['App\Session\Session'],
        $c // Passer le conteneur pour les services
    );
};

// Rendre le conteneur accessible dans l'application
return $container;