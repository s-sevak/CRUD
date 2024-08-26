<?php

include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $data['id']]);
    echo json_encode(["message" => "Пользователь удалён"]);
} else {
    echo json_encode(["error" => "Ошибка ввода"]);
}
