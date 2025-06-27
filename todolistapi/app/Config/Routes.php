<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/register', 'AuthController::register');

$routes->post('/login', 'AuthController::login');

$routes->get('/api/todo', 'TodoController::index');
$routes->post('/api/todo', 'TodoController::create');
$routes->put('/api/todo/(:num)', 'TodoController::update/$1');
$routes->post('/api/todo/(:num)', 'TodoController::update/$1');
$routes->delete('/api/todo/(:num)', 'TodoController::delete/$1');
$routes->get('/api/todo/(:num)', 'TodoController::show/$1');
