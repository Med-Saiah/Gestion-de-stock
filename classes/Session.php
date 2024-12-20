<?php

class Session {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    //fonctions pour gérer les sessions
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
   
    public function get($key) {
        return $_SESSION[$key] ?? null;
    }
     public function exists($key)
     {
        return isset($_SESSION[$key]);
     }

     //fonction pour supprimer une session
    public function unset($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    //fonction pour détruire toutes les sessions
    public function destroy() {
         session_unset();
         session_destroy();
    }
}