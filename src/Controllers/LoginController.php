<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\DaoSingleton;
use MVC\Models\Usuarios;

class LoginController extends Controller {
    public function home() {
        $this->render('home');
    }
    
    public function loginPage() {
        $this->render('loginPage');
    }

    public function registerPage() {
        $this->render('registerPage');
    }

    public function authenticate() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header('Location: mvc/login');
        }

        $dao = DaoSingleton::getInstance();
        $dao->connect();

        $user = $dao->findUserByEmail($email);  

        
        // if ($user && password_verify($password, $user->password)) {
        //     $_SESSION['user'] = $user->id;
        //     header('Location: /');
        // } else {
        //     header('Location: /login');
        // }
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
            header('Location: /mvc/login');
        }

        $dao = DaoSingleton::getInstance();
        $dao->connect();

        $dao->saveUser($user);

        header('Location: /mvc/login');
    }
}
    