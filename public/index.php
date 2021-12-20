<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();

$router->get('/', function(){
    echo 'Home Page';
});

$router->any(['GET', 'POST'], '/about', function(){
    echo "This is about routing";
});

try {
    $router->process();
} catch (Exception $e) {
    echo $e->getMessage();
}