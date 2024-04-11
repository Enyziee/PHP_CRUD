<?php

use MVC\Router;
use MVC\Controllers\LoginController;
use MVC\Controllers\ProdutosController;

$router = new Router();

$router->addRoute('/', LoginController::class, 'home');

$router->addRoute('login', LoginController::class, 'showLoginPage');
$router->addRoute('register', LoginController::class, 'showRegisterPage');

$router->addRoute('auth/login', LoginController::class, 'authenticate');
$router->addRoute('auth/register', LoginController::class, 'register');

$router->addRoute('produtos', ProdutosController::class, 'index');
$router->addRoute('produtos/create', ProdutosController::class, 'showCreateProduct');

$router->addRoute('produtos/saveproduct', ProdutosController::class, 'createProduct');
$router->addRoute('produtos/updateproduct', ProdutosController::class, 'updateProduct');
$router->addRoute('produtos/deleteproduct', ProdutosController::class, 'deleteProduct');


