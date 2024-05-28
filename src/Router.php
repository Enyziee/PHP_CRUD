<?php

namespace MVC;

class Router {
    protected $getRoutes = [];
    protected $postRoutes = [];

    public function __construct() {}

    public function GET($route, $controller, $action) {
        $this->getRoutes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function POST($route, $controller, $action) {
        $this->postRoutes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri) {
        $routes = [];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $routes = $this->getRoutes;
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $routes = $this->postRoutes;
        }
        
        if (array_key_exists($uri, $routes)) {
            $controller = $routes[$uri]['controller'];
            $action = $routes[$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            // header("HTTP/1.0 404 Not Found");
            echo "$uri - 404 Not Found";
            exit;
        }
    }
}
