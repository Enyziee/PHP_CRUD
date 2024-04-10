<?php

use MVC\Router;
use MVC\Controllers\LoginController;

$router = new Router();
$router->addRoute('/', LoginController::class, 'index');
