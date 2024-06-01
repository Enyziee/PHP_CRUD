<?php

use MVC\Controllers\AuthController;
use MVC\Controllers\CalorieController;
use MVC\Controllers\UserController;
use MVC\Router;

$router = new Router();

// Rotas para autenticação
$router->POST('/login', AuthController::class, 'login');
$router->POST('/register', AuthController::class, 'register');

$router->POST('/calculate', CalorieController::class, 'calculateBMR');
$router->GET('/history', UserController::class, 'getHistory');

// Crud básico para usuários

$router->GET('/users', UserController::class, 'getAllUsersInfo');
$router->GET('/users/:id', UserController::class, 'getUserInfo');
$router->PUT('/users/:id', UserController::class, 'updateUserInfo');
$router->DELETE('/users/:id', UserController::class, 'deleteUser');

