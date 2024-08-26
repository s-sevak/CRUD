<?php

include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'], $data['phone'], $data['email'])) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email) VALUES (:name, :phone, :email)");

    $stmt->execute([
        ':name' => $data['name'],
        ':phone' => $data['phone'],
        ':email' => $data['email'],
    ]);
    echo json_encode(["message" => "Пользователь создан"]);
} else {
    echo json_encode(["error" => "Ошибка ввода"]);
}
