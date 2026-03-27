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

$routes->get('/akun1', "Akun1Controller::index");
$routes->get('/akun1/create', "Akun1Controller::create");
$routes->post('/akun1/store', "Akun1Controller::store");
$routes->get('/akun1/delete/(:num)', 'Akun1Controller::delete/$1');

$routes->get('/akun2', "Akun2Controller::index");
$routes->get('/akun2/create', "Akun2Controller::create");
$routes->post('/akun2/store', "Akun2Controller::store");
$routes->get('/akun2/delete/(:num)', 'Akun2Controller::delete/$1');

$routes->get('/akun3', "Akun3Controller::index");
$routes->get('/akun3/create', "Akun3Controller::create");
$routes->post('/akun3/store', "Akun3Controller::store");
$routes->get('/akun3/delete/(:num)', 'Akun3Controller::delete/$1');
