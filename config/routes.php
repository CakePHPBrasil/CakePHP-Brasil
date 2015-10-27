<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::prefix('admin', function($routes) {
    $routes->connect('/', ['controller'         => 'Dashboard', 'action'=>'home']);
    $routes->connect('/login', ['controller'    => 'Users', 'action'=>'login']);
    $routes->connect('/logout', ['controller'   => 'Users', 'action'=>'logout']);
    $routes->connect('/:controller', ['action'  => 'index']);
    $routes->connect('/:controller/:action/*');
});

Router::scope('/', function ($routes) {
    $routes->connect('/', ['controller'         => 'Pages', 'action' => 'index']);
    $routes->connect('/login', ['controller'    => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller'   => 'Users', 'action' => 'logout']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'add']);
    $routes->connect('/profile', ['controller'  => 'Users', 'action' => 'profile']);

    $routes->connect('/:controller', ['action'  => 'index']);
    $routes->connect('/:controller/:action/*');
   
    $routes->fallbacks('DashedRoute');
});

Plugin::routes();
