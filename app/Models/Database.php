<?php
//dit is de database data
class Database {
    private $host = 'localhost';
    private $db_name = 'Soundsense';
    private $username = 'root';
    private $password = '';
    private $conn;
// dit is de connect function die connect je met de database.ERRMODE zorgt ervoor dat als de script/code een error krijgt dat hij gelijk de script/code stopt op het moment dat de error komt en dat weergeeft waar hij is gestopt en waar de error is
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}