<?php

namespace App\Middleware;

class AuthenticationMiddleware {
    public static function isAuthenticated() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  // Start session if not already started
        }
        if (!isset($_SESSION['userid'])) {
            header('Location: /login');
            exit();
        }
    }
}
