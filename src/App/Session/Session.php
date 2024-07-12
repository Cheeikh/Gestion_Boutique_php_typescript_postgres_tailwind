<?php
// src/App/Session/Session.php

namespace App\Session;

class Session implements SessionInterface {
    public static function start(): void {
        session_start();
    }
    
    public static function close(): void {
        session_destroy();
    }

    public static function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public static function isset(string $key): bool {
        return isset($_SESSION[$key]);
    }
}