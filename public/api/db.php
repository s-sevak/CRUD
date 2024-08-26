<?php

function getDbConnection() {
    $host = 'mysql';
    $dbname = 'users';
    $username = 'user';
    $password = 'secret';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die(json_encode(["error" => "Ошибка подключения: " . $e->getMessage()]));
    }
}
