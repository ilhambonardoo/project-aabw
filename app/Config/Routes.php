<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index');