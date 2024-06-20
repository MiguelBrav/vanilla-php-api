<?php
class Database {
    private $host = 'name_or_ip_remote_server'; 
    private $user = 'your_user';
    private $pass = 'your_password';
    private $port = '3306'; 
    private $database = 'contact_list'; 
    private $charset = 'utf8mb4';

    public function getConnection() {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   
        ];

        try {
            $connection = new PDO($dsn, $this->user, $this->pass, $options);
            return $connection;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage());
        }
    }
}



