<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->resource('dosen', ['controller' => 'DosenController']);
$routes->resource('mahasiswa', ['controller' => 'MahasiswaController']);

$routes->post('auth/register', 'Auth::register');
$routes->post('auth/login', 'Auth::login');
