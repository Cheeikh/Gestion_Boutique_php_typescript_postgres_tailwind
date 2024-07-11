<?php
// src/App/Core/Route.php
namespace App\Core;

class Route {
    private $uri;
    private $action;
    private $method;

    public function __construct($method, $uri, $action) {
        $this->method = $method;
        $this->uri = $this->cleanUri($uri);
        $this->action = $action;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getAction() {
        return $this->action;
    }

    public function getMethod() {
        return $this->method;
    }

    private function cleanUri($uri) {
        if (strpos($uri, '?') !== false) {
            $uri = strstr($uri, '?', true);
        }
        return rtrim($uri, '/');
    }
}

