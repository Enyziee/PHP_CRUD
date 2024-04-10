<?php

require_once 'vendor/autoload.php';
require_once('./src/routes.php');

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);
