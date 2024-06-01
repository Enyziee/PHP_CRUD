<?php

namespace MVC;

use Closure;
use Exception;

class Router {
    protected $routes = [];

    public function GET(string $url, $controller , string $target) {
        $this->addRoute('GET', $url, $controller, $target);
    }

    public function POST(string $url, $controller , string $target) {
        $this->addRoute('POST', $url, $controller, $target);
    }

    public function PUT(string $url, $controller , string $target) {
        $this->addRoute('PUT', $url, $controller, $target);
    }

    public function DELETE(string $url, $controller , string $target) {
        $this->addRoute('DELETE', $url, $controller, $target);
    }

    protected function addRoute(string $method, string $url, $controller , string $target) {
        $this->routes[$method][$url] = ['controller' => $controller, 'target' => $target];
    }

    public function matchRoute() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);

                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {

                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    
                    $controller = new $target['controller'];
                    $action = $target['target'];

                    $controller->$action($params);
                    
                    return;
                }
            }
        }
        throw new Exception('Route not found');
    }
}