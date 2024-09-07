<?php

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
$uriParts = explode('/', trim($requestUri, '/'));

$resource = $uriParts[0];
$id = $uriParts[1] ?? null;

if ($method === 'GET' && $requestUri === '/') {
    require_once 'test.php';
    exit;
}

require_once '../src/functions.php';

switch ($method) {
    case 'GET':
        if ($resource === 'users' || $resource === '') {
            if (isset($id)) {
                getUser($id);
            } else {
                getUsers();
            }
        }
        break;
    case 'POST':
        if ($resource === 'users') {
            addUser($_POST);
        }
        break;
    case 'PUT':
        if ($resource === 'users') {
            if (isset($id)) {
                $data = json_decode(file_get_contents('php://input'), true);
                updateUser($id, $data);
            }
        }
        break;
    case 'DELETE':
        if ($resource === 'users') {
            if (isset($id)) {
                deleteUser($id);
            }
        }
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Метод не найден"]);
            break;
}

