<?php

require_once 'vendor/autoload.php';
require_once('./src/routes.php');

$uri = $_GET['url'] ?? '/';


$uri = $_SERVER['REQUEST_URI'];
if (strlen($uri) > 1 && strpos($uri, '/') === 0) {
    $uri = substr($uri, 1);
}

$router->dispatch($uri);
