<?php

$includes = array(
    'Config.php',
    'Router.php',
    'View.php',
    'Controller.php',
    'helpers/dataProcessor.php',
    'helpers/dbManager.php'
);

foreach ($includes as $file) {
    require $file;
}

spl_autoload_register(function ($className) {
    require 'classes/' . $className . '.class.php';
});


$router = new Router;
$controller = $router->getController();

$controller->printHtml();
