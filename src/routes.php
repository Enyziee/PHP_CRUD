<?php

use MVC\Controllers\AdminController;
use MVC\Controllers\AuthController;
use MVC\Controllers\UserController;
use MVC\Controllers\HealthController;
use MVC\Router;

$router = new Router();

// Rotas para autenticação
$router->POST('/login', AuthController::class, 'login');
$router->POST('/register', AuthController::class, 'register');

// Endpoints para os usuários
$router->GET('/user', UserController::class, 'getUserInfo');
$router->PUT('/user', UserController::class, 'updateUserInfo');
$router->DELETE('/user', UserController::class, 'deleteUser');

// Endpoints para administradores
$router->GET('/users', AdminController::class, 'getAllUsersInfo');
$router->GET('/users/:id', AdminController::class, 'getUserInfo');
$router->PUT('/users/:id', AdminController::class, 'updateUserInfo');
$router->DELETE('/users/:id', AdminController::class, 'deleteUser');

// Endpoints para intregrações com aplicativos de saúde
$router->GET('/health', HealthController::class, 'getHealthInfo');
$router->POST('/health', HealthController::class, 'saveHealthInfo');
$router->PUT('/health', HealthController::class, 'updateHealthInfo');

$router->POST('/health/steps', HealthController::class, 'addDaySteps');
$router->GET('/health/steps', HealthController::class, 'getLastSteps');

// $router->POST('/health/meals', HealthController::class, 'addDayMeals');
// $router->GET('/health/meals', HealthController::class, 'getLastMeals');

$router->GET('/health/bmr', HealthController::class, 'getBMR');

