<?php

header('Content-Type: application/json');

require_once '../config/database.php';

function getUsers(): void
{
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

function getUser(int $id): void
{
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM users WHERE id = '$id'");
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($user === []) {
        http_response_code(404);
        echo json_encode(["error" => "Пользователь не найден"]);
    } else {
        echo json_encode($user);
    }
}

function addUser(array $data): void
{
    if (isset($data['name'], $data['phone'], $data['email'])) {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("INSERT INTO users (name, phone, email) VALUES (:name, :phone, :email)");

        $stmt->execute([
            ':name' => $data['name'],
            ':phone' => $data['phone'],
            ':email' => $data['email'],
        ]);
        http_response_code(201);
        echo json_encode(["message" => "Пользователь создан"]);
    } else {
        echo json_encode(["error" => "Ошибка ввода"]);
    }
}

function updateUser(int $id, array $data): void
{
    $data['id'] = $id;
    if (isset($data['id'], $data['name'], $data['phone'], $data['email'])) {
        $pdo = getDbConnection(); // Получаем подключение к базе данных
        $stmt = $pdo->prepare("UPDATE users SET name = :name, phone = :phone, email = :email WHERE id = :id");
        $stmt->execute([
            ':id' => $data['id'],
            ':name' => $data['name'],
            ':phone' => $data['phone'],
            ':email' => $data['email'],
        ]);
        echo json_encode(["message" => "Пользователь изменён"]);
    } else {
        echo json_encode(["error" => "Ошибка ввода"]);
    }

}

function deleteUser(int $id): void
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo json_encode(["message" => "Пользователь удалён"]);
}
