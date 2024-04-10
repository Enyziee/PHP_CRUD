<?php

use MVC\Router;
use MVC\Controllers\LoginController;

$router = new Router();

$router->addRoute('login', LoginController::class, 'loginPage');

$router->addRoute('auth/login', LoginController::class, 'authenticate');