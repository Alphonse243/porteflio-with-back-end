<?php

namespace Core;

class Router {
    private $routes = [];

    public function add($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($url) {
        if (array_key_exists($url, $this->routes)) {
            $controller = "Controllers\\" . $this->routes[$url]['controller'];
            $action = $this->routes[$url]['action'];
            
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            throw new \Exception("No route found for URL '$url'");
        }
    }
}
