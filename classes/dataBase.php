<?php

class DataBase
{
    private $host = "localhost";
    private $dbName = "bdCrud";
    private $userName = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null; // Inicialize a conexão como null
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->password);
        } catch (PDOException $exception) {
            echo "Erro de Conexão: " . $exception->getMessage();
        }
        return $this->conn; // Retorne a conexão depois do bloco try-catch
    }
}