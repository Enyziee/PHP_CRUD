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
            header('Location: /login');
        }

        $dao = DaoSingleton::getInstance();
        $dao->connect();

        $results = $dao->findUserByEmail($email);

        
        session_start();
        $_SESSION['email'] = $email;


        var_dump($_SESSION);


    //    if (count($results) == 0) {
    //         header('Location: /login');
    //     } else {
    //         // var_dump($results[0]);

    //         $user = new Usuarios($results[0]->nome,$results[0]->email, $results[0]->senha);



    //         if ($password == $user->senha) {
    //             $_SESSION[$user->email] = random_bytes(12);


    //             // header('Location: /');
    //         } else {
    //             // header('Location: /login');
    //         }
    //    }
            

        
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
            header('Location: /login');
        }

        $dao = DaoSingleton::getInstance();
        $dao->connect();

        $dao->saveUser($user);

        header('Location: /login');
    }
}
    