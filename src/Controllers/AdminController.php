<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Modules\Authorization;
use stdClass;

class AdminController {

    public function getAllUsersInfo() {
        if (!Authorization::isAdmin()) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $result = $dao->getAllUsers();

        // Remove a senha dos usuários dos dados retornados
        foreach ($result as $user) {
            unset($user->senha);
        }

        $response = new stdClass();
        $response->data = $result;

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getUserInfo($params) {
        if (!Authorization::isAdmin()) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        if (!isset($params['id'])) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $result = $dao->findUserById($params['id']);

        if ($result == false) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        unset($result->senha);

        $response = new stdClass();
        $response->data = $result;

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function updateUserInfo($params) {
        if (!Authorization::isAdmin()) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        if (!isset($params['id'])) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $user = $dao->findUserById($params['id']);

        if ($user == false) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        $data = json_decode(file_get_contents('php://input'));

        if (isset($data->nome)) {
            $user->nome = $data->nome;
        }

        if (isset($data->email)) {
            $user->email = $data->email;
        }

        if (isset($data->senha)) {
            $user->senha = $data->senha;
        }

        if (isset($data->role)) {
            $user->role = $data->role;
        }

        $dao->updateUserInfo($user);

        $response = new stdClass();
        $response->message = "User information updated";

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deleteUser($params) {
        if (!Authorization::isAdmin()) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        if (!isset($params['id'])) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $dao->deleteUserById($params['id']);

        $response = new stdClass();
        $response->message = "User deleted";

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}