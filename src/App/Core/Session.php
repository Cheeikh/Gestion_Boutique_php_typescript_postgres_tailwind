<?php
// src/App/Core/Session.php

namespace App\Core;

class Session {
    /**
     * Démarre une nouvelle session ou reprend une session existante
     */
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Ferme la session en cours
     */
    public static function close() {
        session_destroy();
    }

    /**
     * Définit une valeur dans la session
     *
     * @param string $key   La clé de la valeur à définir
     * @param mixed $value  La valeur à stocker
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Récupère une valeur de la session
     *
     * @param string $key     La clé de la valeur à récupérer
     * @param mixed $default  La valeur par défaut si la clé n'existe pas
     * @return mixed          La valeur stockée ou la valeur par défaut
     */
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Vérifie si une clé existe dans la session
     *
     * @param string $key  La clé à vérifier
     * @return bool        True si la clé existe, false sinon
     */
    public static function isset($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une valeur de la session
     *
     * @param string $key  La clé de la valeur à supprimer
     */
    public static function unset($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Vide complètement la session
     */
    public static function clear() {
        $_SESSION = [];
    }

    
}