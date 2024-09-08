<?php

include 'UserManger.php';

class Router
{
    private $requestMethod;
    private $requestUri;
    private $resource;
    private $method;
    private $id;
    private $uriParts;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', trim($this->requestUri, '/'));
        $this->resource = $uriParts[0];
        $this->id = $uriParts[1] ?? null;
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uriParts = explode('/', trim($this->requestUri, '/'));
    }

    public function route()
    {
        if ($this->method === 'GET' && $this->requestUri === '/') {
            require_once '../public/test.php';
            exit;
        }

        $userManger = new UserManger();

        switch ($this->method) {
            case 'GET':
                if ($this->resource === 'users' || $this->resource === '') {
                    if (isset($this->id)) {
                        $userManger->getUser($this->id);
                    } else {
                        $userManger->getUsers();
                    }
                }
                break;
            case 'POST':
                if ($this->resource === 'users') {
                    $userManger->addUser($_POST);
                }
                break;
            case 'PUT':
            if ($this->resource === 'users' && $this->id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $userManger->updateUser($this->id, $data);
            }
            break;

            case 'DELETE':
                if ($this->resource === 'users' && $this->id) {
                    $userManger->deleteUser($this->id);
                }
                break;

            default:
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(["error" => "Метод не найден"]);
                break;
        }
    }
}