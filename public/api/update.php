<?php

include 'db.php';

$data = json_decode(file_get_contents('php://input'), true); // Получаем и преобразуем данные из запроса

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
