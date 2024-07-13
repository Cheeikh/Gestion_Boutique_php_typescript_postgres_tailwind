<?php

namespace App\Core;

use ReflectionClass;
use App\Controller\ErrorController;
use Symfony\Component\Yaml\Yaml;
use ReflectionException;
use App\Authorize\Authorize;
use App\Files\FileHandler;
use Pimple\Container;
use App\Session\Session;


class Router {
    private $routes = [];
    private $apiPrefix = '/api';
    private $container;
    private $session;

    public function __construct(array $webRoutes, array $apiRoutes, Authorize $authorize, FileHandler $fileHandler, Session $session, Container $container) {
        $this->container = $container;
        $this->session = $container['App\Session\Session'];
        $this->loadServices();
        

        foreach ($webRoutes as $route) {
            $this->addRoute($route[0], $route[1], $route[2], false);
        }

        foreach ($apiRoutes as $route) {
            $this->addRoute($route[0], $route[1], $route[2], true);
        }
    }
    
    private function loadServices() {
        $config = Yaml::parseFile('/var/www/html/gestionboutique/src/App/config.yaml');
        
        foreach ($config['services'] as $service => $details) {
            if (!isset($details['class'])) {
                error_log("Service $service is missing 'class' key.");
                continue;  // Ignorer ce service
            }
            $class = $details['class'];
            $arguments = $details['arguments'] ?? [];
            $resolvedArguments = [];
    
            foreach ($arguments as $argument) {
                if (strpos($argument, '@') === 0) {
                    $resolvedArguments[] = $this->getService(substr($argument, 1));
                } else {
                    $resolvedArguments[] = $argument;
                }
            }
    
            if (!isset($this->container[$service])) {
                $reflectionClass = new ReflectionClass($class);
                $this->container[$service] = $reflectionClass->newInstanceArgs($resolvedArguments);
            }
        }
    }
    
    

    private function getService($service) {
        return $this->container[$service] ?? null;
    }

    private function addRoute($method, $uri, $action, $isApi) {
        if ($isApi) {
            $uri = $this->apiPrefix . $uri;
        }

        $routeReflection = new ReflectionClass(Route::class);
        $route = $routeReflection->newInstance($method, $uri, $action);
        $this->routes[] = $route;
    }

    private function matchRoute($requestUri, $routeUri) {
        $requestParts = explode('/', trim($requestUri, '/'));
        $routeParts = explode('/', trim($routeUri, '/'));

        if (count($requestParts) !== count($routeParts)) {
            return false;
        }

        $params = [];

        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], '#') === 0) {
                $params[substr($routeParts[$i], 1)] = $requestParts[$i];
            } elseif ($routeParts[$i] !== $requestParts[$i]) {
                return false;
            }
        }

        return $params;
    }

    public function dispatch() {
        $request = $this->parseRequest();
        $routeInfo = $this->findRoute($request);
        $errorController = new ErrorController(
            $this->container['App\Authorize\Authorize'],
            $this->container['App\Files\FileHandler'],
            $this->container['App\Session\Session']
        );

        if (!$routeInfo) {
            $errorController->notFound();
            return;
        }

        $route = $routeInfo['route'];
        $params = $routeInfo['params'];
        $controllerInfo = $this->getControllerInfo($route);
        
        if (!$controllerInfo) {
            $errorController->notFound();
            return;
        }

        if (isset($controllerInfo['closure'])) {
            call_user_func($controllerInfo['closure']);
            return;
        }

        $controller = $controllerInfo['instance'];
        $methodName = $controllerInfo['method'];

        if (!$this->checkAuthorization($controller, $methodName)) {
            $errorController->forbidden();
            return;
        }

        $method = $controllerInfo['reflection']->getMethod($methodName);
        $parameters = $method->getParameters();
        $args = [];

        foreach ($parameters as $parameter) {
            $paramName = $parameter->getName();
            if (isset($params[$paramName])) {
                $args[] = $params[$paramName];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $args[] = $parameter->getDefaultValue();
            } else {
                $errorController->notFound();
                return;
            }
        }

        $method->invokeArgs($controller, $args);
    }

    private function parseRequest() {
        return [
            'uri' => $this->cleanUri($_SERVER['REQUEST_URI']),
            'method' => $_SERVER['REQUEST_METHOD']
        ];
    }

    private function findRoute($request) {
        foreach ($this->routes as $route) {
            if ($route->getMethod() === $request['method']) {
                $params = $this->matchRoute($request['uri'], $route->getUri());
                if ($params !== false) {
                    return ['route' => $route, 'params' => $params];
                }
            }
        }
        return null;
    }

    private function getControllerInfo($route) {
        $action = $route->getAction();
        
        if (is_array($action)) {
            $controllerClass = $action[0];
            $methodName = $action[1];

            if (!$this->isClassInstantiable($controllerClass)) {
                error_log("Controller class $controllerClass does not exist or is not instantiable");
                return null;
            }

            $controllerReflection = new ReflectionClass($controllerClass);
            if (!$controllerReflection->hasMethod($methodName)) {
                error_log("Method $methodName does not exist in $controllerClass");
                return null;
            }

            $controller = $this->getService($controllerClass);
            if ($controller === null) {
                $controller = $controllerReflection->newInstanceArgs([
                    $this->getService('authorize'),
                    $this->getService('fileHandler')
                ]);
            }

            return [
                'reflection' => $controllerReflection,
                'instance' => $controller,
                'method' => $methodName
            ];
        } elseif ($action instanceof \Closure) {
            return [
                'closure' => $action
            ];
        }

        return null;
    }

    private function isClassInstantiable($className) {
        if (!class_exists($className)) {
            return false;
        }
        
        try {
            $reflection = new ReflectionClass($className);
            return !$reflection->isAbstract() && !$reflection->isInterface();
        } catch (ReflectionException $e) {
            return false;
        }
    }

    private function checkAuthorization($controller, $method) {
        return true; 
    }

    private function cleanUri($uri) {
        $uri = preg_replace('#/+#', '/', $uri);
        $uri = rtrim($uri, '/');
        if (strpos($uri, '?') !== false) {
            $uri = strstr($uri, '?', true);
        }
        return $uri;
    }
}
