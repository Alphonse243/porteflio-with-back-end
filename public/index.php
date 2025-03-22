<?php

require_once '../config/config.php';
require_once '../vendor/autoload.php';
require_once '../config/database.php';

$router = new Core\Router();

// Add your routes here
$router->add('/', 'HomeController', 'index');
$router->add('/about', 'HomeController', 'about');
$router->add('/projects', 'ProjectController', 'index');
$router->add('/contact', 'ContactController', 'index');

// Get current URL
$url = $_SERVER['REQUEST_URI'];
$url = trim(parse_url($url, PHP_URL_PATH), '/');
$url = $url ?: '/';

try {
    $router->dispatch($url);
} catch (Exception $e) {
    echo $e->getMessage();
}
