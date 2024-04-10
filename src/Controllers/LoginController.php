<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\DaoSingleton;

class LoginController extends Controller {
    public function loginPage() {
        $this->render('loginPage');
    }

    public function authenticate() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header('Location: /mvc/login');
        }

        echo $email . ' - ' . $password . '<br>';

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
}
    