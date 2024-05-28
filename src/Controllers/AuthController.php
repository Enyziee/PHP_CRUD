<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Models\Usuarios;
use MVC\Modules\JWT;

class AuthController {
    public function login() {
        $values =  json_decode(file_get_contents('php://input'), true);

        $email = $values['email'];
        $password = $values['password'];

        if (!$email || !$password) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $user = $dao->findUserByEmail($email);

        if (!$user) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        echo JWT::createJWT($user->id);
    }

    public function register() {
        $values =  json_decode(file_get_contents('php://input'), true);

        $nome = $values['nome'];
        $email = $values['email'];
        $senha = $values['senha'];

        if (!$nome || !$email || !$senha) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();
        $user = $dao->findUserByEmail($email);

        if ($user) {
            header('HTTP/1.1 409 Conflict');
            return;
        }

        $err = $dao->saveUser(new Usuarios($nome, $email, $senha));

        if (!$err) {
            header('HTTP/1.1 500 Internal Server Error');
            return;
        }


        header('HTTP/1.1 201 Created');
        echo JWT::createJWT($dao->findUserByEmail($email)->id);
    }
}