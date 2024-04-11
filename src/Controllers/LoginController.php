<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\DaoSingleton;
use MVC\Models\Usuarios;


class LoginController extends Controller {
    public function home() {
        $this->render('index');
    }
    
    public function showLoginPage() {
        $this->render('login/login');
    }

    public function showRegisterPage() {
        $this->render('login/register');
    }

    public function authenticate() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header("Location: /login");
        }

        $dao = DaoSingleton::getInstance();
        

        $user = $dao->findUserByEmail($email);
        
        if (empty($user)) {
            header('Location: /login');
        } else {
            if ($password == $user->senha) {
                session_start();
                $_SESSION['nome'] = $user->nome;
                $_SESSION['logged'] = true;

                header('Location: /');
            } else {
                header('Location: /login');
            }
       }
    }

    public function register() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $user = new Usuarios($name, $email, $password);
        } catch (\Throwable $th) {
            echo "ERROR: " . $th->getMessage();
        }

        if (empty($name) || empty($email) || empty($password)) {
            header('Location: /login');
        }

        $dao = DaoSingleton::getInstance();
        $dao->saveUser($user);

        header('Location: /login');
    }
}
    