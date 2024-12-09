<?php

namespace App\Middleware;

class AdminAuthenticationMiddleware {
    public static function isAuthenticated() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  // Start session if not already started
        }

        if (!isset($_SESSION['userid'])) {
            // User is not logged in
            header('Location: /login');
            exit();
        }

        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
            // User is logged in but not admin
            header('Location: /loginafter');
            exit();
        }

        // User is logged in and is admin, continue
    }
}
