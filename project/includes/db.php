<?php
class Database {
    private $host = '195.80.50.118:3306';
    private $user = 'cryfox';
    private $pass = 'ro2003iv';
    private $dbname = 'university';

    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            //$this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode('Connection Error: ' . $e->getMessage());
            return false;
        }

        return $this->conn;
    }
}
?>
