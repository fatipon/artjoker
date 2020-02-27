<?php

use app\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});

$router = new Router;
$router->run();