<?php

use MVC\Router;
use MVC\Controllers\LoginController;

$router = new Router();

$router->addRoute('/', LoginController::class, 'home');

$router->addRoute('login', LoginController::class, 'loginPage');
$router->addRoute('register', LoginController::class, 'registerPage');

$router->addRoute('auth/login', LoginController::class, 'authenticate');
$router->addRoute('auth/register', LoginController::class, 'register');