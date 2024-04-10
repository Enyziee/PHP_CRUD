<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\User;

class LoginController extends Controller {
    public function index() {
        
        $this->render('auth/login');
    }
}
    