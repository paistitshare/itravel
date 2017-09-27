<?php

use Itravel\Routing\Router as Router;

$ABCDE = dirname(__DIR__) .'../src/App';

$router = new Router();

$router->register('', ['controller' => 'HomeController', 'action' => 'index']);
$router->register('user', ['controller' => 'UserController', 'action' => 'create']);

$router->dispatch($_SERVER['QUERY_STRING']);