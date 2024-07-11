<?php
// src/App/Core/Router.php

namespace App\Core;

use App\App;
use ReflectionClass;
use App\Controller\ErrorController;
use ReflectionException;

class Router {
    private $routes = [];
    private $apiPrefix = '/api';

    public function __construct(array $webRoutes, array $apiRoutes) {
        foreach ($webRoutes as $route) {
            $this->addRoute($route[0], $route[1], $route[2], false);
        }

        foreach ($apiRoutes as $route) {
            $this->addRoute($route[0], $route[1], $route[2], true);
        }
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
        $errorController = new ErrorController();
    
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
                // Paramètre requis manquant
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

            // Déterminer si c'est une route API
            $isApi = strpos($route->getUri(), $this->apiPrefix) === 0;
    
            return [
                'reflection' => $controllerReflection,
                'instance' => $controllerReflection->newInstance(null, $isApi),
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
