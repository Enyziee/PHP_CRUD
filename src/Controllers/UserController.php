<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Models\Usuarios;
use MVC\Modules\JWT;
use stdClass;

class UserController {
    public function getUserInfo($params) {
        $dao = DaoSingleton::getInstance();

        $result = null;

        if (!isset($params['id'])) {
            return;
        }

        $result = $dao->findUserById($params['id']);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        
        $response = new stdClass();
        $response->data = $result;
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getAllUsersInfo() {
        $dao = DaoSingleton::getInstance();

        $result = $dao->getAllUsers();

        $response = new stdClass();
        $response->data = $result;

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function updateUserInfo($params) {
        $dao = DaoSingleton::getInstance();

        $values =  json_decode(file_get_contents('php://input'), true);

        $nome = $values['nome'];
        $email = $values['email'];

        $user = $dao->findUserById($params['id']);

        if ($nome) {
            $user->nome = $nome;
        }

        if ($email) {
            $user->email = $email;
        }

        $dao->updateUserInfo($user);

    }

    public function getHistory() {
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        if (!$token[1]) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $payload = null;

        try {
            $payload = JWT::verifyJWT($token[1]);
        } catch (\Throwable $th) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }


        $dao = DaoSingleton::getInstance();

        $userid = json_decode($payload, true)['userid'];

        $result = $dao->getAllRecords($userid);
        
        $response = new stdClass();
        $response->data = [];


        foreach ($result as $key => $value) {
            array_push($response->data, json_decode($value));
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}