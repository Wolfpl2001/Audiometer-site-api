<?php

namespace App\Controllers;

use PDO;
use PDOException;

class HomeController
{
    private $pdo;

    public function __construct()
    {
        $this->initializeSession();
        $this->initializeDatabase();
    }

    private function initializeSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function initializeDatabase()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=SoundSense;charset=utf8mb4", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            exit('Database connection could not be established: ' . $e->getMessage());
        }
    }

    public function welcome()
    {
        return view('welcome');  // Assumes view() is a global helper function
    }

    public function login()
    {
        return view('login');
    }

    public function manageUsers()
    {
        $stmt = $this->pdo->query("SELECT UserID, Username, IsAdmin FROM Users");
        $users = $stmt->fetchAll();

        return view('manageusers', ['users' => $users]);
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (empty($username) || empty($password)) {
            header('Location: /login?error=emptyfields');
            exit();
        }

        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE Username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['userid'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['admin'] = $user['IsAdmin'];
            header('Location: /loginafter');
        } else {
            header('Location: /login?error=loginfailed');
            exit();
        }
    }

    public function register()
    {
        return view('register');
    }

    public function processRegistration()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;

        if (empty($username) || empty($password) || empty($confirmPassword)) {
            header('Location: /register?error=emptyfields');
            exit();
        }

        if ($password !== $confirmPassword) {
            header('Location: /register?error=passwordmismatch');
            exit();
        }

        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE Username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->rowCount() > 0) {
            header('Location: /register?error=userexists');
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Users (Username, Password) VALUES (:username, :password)");
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

        header('Location: /manageusers?success=registered');
        exit();
    }

    public function loginafter()
    {
        return view('testpage');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /');
        exit();
    }

    public function editUser()
    {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            header('Location: /manageusers?error=nouserid');
            exit();
        }

        $stmt = $this->pdo->prepare("SELECT UserID, Username, IsAdmin FROM Users WHERE UserID = :userid");
        $stmt->execute(['userid' => $userId]);
        $user = $stmt->fetch();

        if (!$user) {
            header('Location: /manageusers?error=usernotfound');
            exit();
        }

        return view('edituser', ['user' => $user]);
    }

    public function updateUser()
    {
        $userId = $_POST['userid'] ?? null;
        $username = $_POST['username'] ?? null;
        $isAdmin = isset($_POST['isadmin']) ? 1 : 0;

        if (!$userId || !$username) {
            header('Location: /manageusers?error=emptyfields');
            exit();
        }

        $stmt = $this->pdo->prepare("UPDATE Users SET Username = :username, IsAdmin = :isadmin WHERE UserID = :userid");
        $stmt->execute([
            'username' => $username,
            'isadmin' => $isAdmin,
            'userid' => $userId
        ]);

        header('Location: /manageusers?success=updated');
        exit();
    }

    public function deleteUser()
    {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            header('Location: /manageusers?error=nouserid');
            exit();
        }

        $stmt = $this->pdo->prepare("DELETE FROM Users WHERE UserID = :userid");
        $stmt->execute(['userid' => $userId]);

        header('Location: /manageusers?success=deleted');
        exit();
    }
}
