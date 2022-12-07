<?php

require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$path = getPath();

$controllerName = ucwords($path[0]) ?: 'Recipe';
$controller = $controllerName . 'Controller';
$methodName = $path[1] ?? 'index';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $methodName .= $_SERVER['REQUEST_METHOD'];
}

if (class_exists($controller)) {
    if (method_exists($controller, $methodName)) {
        $controller = new $controller();
        $controller->$methodName();
    } else {
        error(404, 'Method not found');
    }
} else {
    error(404, 'Controller not found');
}