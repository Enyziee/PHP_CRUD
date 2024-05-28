<?php

use MVC\Controllers\AuthController;
use MVC\Controllers\CalorieController;
use MVC\Controllers\UserController;
use MVC\Router;

$router = new Router();

$router->POST('login', AuthController::class, 'login');
$router->POST('register', AuthController::class, 'register');

$router->POST('calculate', CalorieController::class, 'calculateBMR');

$router->GET('history', UserController::class, 'getHistory');
