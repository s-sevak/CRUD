<?php

include 'db.php';

$pdo = getDbConnection();
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
