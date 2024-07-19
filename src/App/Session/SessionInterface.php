<?php
// src/App/Session/SessionInterface.php

namespace App\Session;

interface SessionInterface {
    public static function start(): void;
/*     public static function close(): void;
 */    public static function set(string $key, $value): void;
    public static function get(string $key);
    public static function isset(string $key): bool;
}