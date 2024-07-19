<?php
// src/App/Session/Session.php

namespace App\Session;

class Session implements SessionInterface {
    public static function start(): void {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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

    public static function remove(string $key): void {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function getFlash() {
        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }
        return $flash;
    }

    public static function hasFlash(): bool {
        return isset($_SESSION['flash']);
    }
}