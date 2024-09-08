<?php

class Database
{
    private $pdo;

    public function __construct()
    {
        $host = 'mysql';
        $dbname = 'users';
        $username = 'user';
        $password = 'secret';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(json_encode(["error" => "Ошибка подключения: " . $e->getMessage()]));
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}