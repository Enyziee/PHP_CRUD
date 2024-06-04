<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Modules\JWT;
use stdClass;

class UserController {

    public function getUserInfo() {
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
        $payload = JWT::verifyJWT($token[1]);

        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }
        
        $userid = $payload['userid'];

        $dao = DaoSingleton::getInstance();
        $result = $dao->findUserById($userid);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        
        $response = new stdClass();
        $response->data = $result;
        unset($response->data->senha);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    public function updateUserInfo() {
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
        $payload = JWT::verifyJWT($token[1]);

        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $values =  json_decode(file_get_contents('php://input'), true);
        $nome = $values['nome'];
        $email = $values['email'];

        $dao = DaoSingleton::getInstance();
        $user = $dao->findUserById($payload['userid']);

        if ($nome) {
            $user->nome = $nome;
        }

        if ($email) {
            $user->email = $email;
        }

        $dao->updateUserInfo($user);
    }

    public function deleteUser() {
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
        $payload = JWT::verifyJWT($token[1]);

        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }
        
        $dao = DaoSingleton::getInstance();
        
        try {
            $dao->deleteUserById($payload['userid']);
        } catch (\Throwable $th) {
            header('HTTP/1.1 500 Internal Server Error');
            return;
        }

        $response = new stdClass();
        $response->message = 'User deleted successfully';

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}