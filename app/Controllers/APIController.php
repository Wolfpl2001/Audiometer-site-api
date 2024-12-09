<?php

namespace App\Controllers;
use PDO;
use PDOException;

class APIController
{
    private $pdo;

    public function __construct()
    {
        $this->initializeDatabase();
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
    
    public function getAPIKey()
    {
        // Pobranie danych z żądania
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Sprawdzanie, czy klucz 'key' i 'email' istnieją w danych wejściowych
        if (!isset($input['key']) || !isset($input['email'])) {
            echo json_encode(['status' => 'error', 'message' => 'Key or email not provided']);
            return;
        }
    
        $getKey = $input['key'];
        $inputEmail = $input['email'];
        $stmt = $this->pdo->prepare("SELECT login_id FROM activation_key ");
        $stmt->execute();
        $idkey = $stmt->fetchColumn();
        if ($idkey){
            echo json_encode(['status' => 'error', 'message' => 'Key already was used']);
        }else{
            try {
                // SQL query to check activation and related user
                $stmt = $this->pdo->prepare("
                    SELECT ak.*, u.email
                    FROM activation_key ak
                    JOIN users u ON ak.User_id = u.UserID
                    WHERE ak.activation_key = :getKey
                ");
                $stmt->execute(['getKey' => $getKey]);
                $key = $stmt->fetch();
        
                // Check if data is found
                if ($key) {
                    $dbEmail = $key['email'];
        
                    // Email validation
                    if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
                        echo json_encode(['status' => 'error', 'message' => 'Invalid email format in input']);
                        return;
                    }
        
                    // Compare emails (case insensitive)
                    if (strcasecmp($dbEmail, $inputEmail) === 0) {
                        // Generowanie unikalnego i nie powtarzającego się klucza
                        $randomKey = $this->generateUniqueRandomKey($key['User_id']);
        
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Valid data received',
                            'randomKey' => $randomKey
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Email does not match'
                        ]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Key not found']);
                }
            } catch (PDOException $e) {
                $this->handleException($e);
            }
        }
    }
    
    /**
     * Generate a unique random key and store it in the database
     */
    private function generateUniqueRandomKey($userId)
    {
        //
        $randomKey = $this->generateRandomKey();
    
        // 
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM activation_key WHERE login_id = :randomKey");
        $stmt->execute(['randomKey' => $randomKey]);
        $exists = $stmt->fetchColumn();
    
        // 
        if ($exists) {
            return $this->generateUniqueRandomKey($userId); // rekurencyjnie próbuj ponownie
        }
    
        // 
        $stmt = $this->pdo->prepare("UPDATE activation_key SET login_id = :randomKey WHERE User_id = :userId");
        $stmt->execute([
            'randomKey' => $randomKey,
            'userId' => $userId
        ]);
    
        return $randomKey;
    }
    
    /**
     * Generate a random key consisting of letters and digits
     */
    private function generateRandomKey($length = 24)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomKey = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomKey .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomKey;
    }
    
    

    public function handleException($exception)
    {
        // Zalogowanie wyjątku
        error_log($exception->getMessage());

        // Obsługa PDOException
        if ($exception instanceof PDOException) {
            // Błąd bazy danych – ustaw kod 500 (Internal Server Error)
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $exception->getMessage()
            ]);
        } else {
            // Ogólny błąd – ustaw kod 400 (Bad Request)
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'An error occurred: ' . $exception->getMessage()
            ]);
        }
    }

    public function testAPI()
    {
        echo "API działa!";
    }
}
