<?php

include '../config/Database.php';

class UserManger
{
    private PDO $DbConnection;

    public function __construct()
    {
        $this->DbConnection = (new Database())->getConnection();
    }

    public function getUsers(): void
    {
        $stmt = $this->DbConnection->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    }

    public function getUser(int $id): void
    {
        $stmt = $this->DbConnection->query("SELECT * FROM users WHERE id = :id");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user === []) {
            http_response_code(404);
            echo json_encode(["error" => "Пользователь не найден"]);
        } else {
            echo json_encode($user);
        }
    }

    public function addUser(array $data): void
    {
        if (isset($data['name'], $data['phone'], $data['email'])) {
            $stmt = $this->DbConnection->prepare("INSERT INTO users (name, phone, email) VALUES (:name, :phone, :email)");
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

    public function updateUser(int $id, array $data): void
    {
        $data['id'] = $id;
        if (isset($data['id'], $data['name'], $data['phone'], $data['email'])) {
            $stmt = $this->DbConnection->prepare("UPDATE users SET name = :name, phone = :phone WHERE email = :email");
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

    public function deleteUser(int $id): void
    {
        $stmt = $this->DbConnection->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        echo json_encode(["message" => "Пользователь удалён"]);
    }
}