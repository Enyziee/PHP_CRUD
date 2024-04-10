<?php

namespace MVC;

class Router {
    protected $routes = [];

    public function __construct() {}

    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri) {
        if (array_key_exists($uri, $this->routes)) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "$uri - 404 Not Found";
            exit;
        }
    }
}
