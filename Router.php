<?php

class Router {

    private array $routes;

    function __construct() {

        $this->addRoute('', 'Form');
        $this->addRoute('process', 'Process');
    }

    public function getRoute(string $route) {
        return $this->routes[$route];
    }

    public function getController() {

        $controllerId = isset($_GET['id']) ? $_GET['id'] : '';
        $controllerName = $this->routes[$controllerId];

        require('controllers/' . $controllerName . '.php');
        $controller = ucfirst($controllerName);

        return new $controller;
    }

    public function addRoute(string $route, string $name) {
        
        $this->routes[$route] = $name;
    }
}
