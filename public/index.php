<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();

$router->get('/', function(){
    echo 'Home Page';
});
// /about?name=john -> /about/name/john -> /about/john -> /about/:name
$router->any(['GET', 'POST'], '/about', function(array $obj){
    var_dump($obj);
    echo "This is about routing";
});

try {
    $router->process();
} catch (Exception $e) {
    echo $e->getMessage();
}