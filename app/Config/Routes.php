<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login/procesar', 'Auth::procesarLogin');
$routes->get('logout', 'Auth::logout');

// Panel de Control / Dashboard
$routes->get('dashboard', 'Dashboard::index');

// Rutas de Parcelas
$routes->get('parcelas', 'Parcelas::index');
$routes->get('parcelas/crear', 'Parcelas::crear');
$routes->post('parcelas/guardar', 'Parcelas::guardar');
$routes->get('parcelas/editar/(:num)', 'Parcelas::editar/$1');
$routes->post('parcelas/editar/(:num)', 'Parcelas::editar/$1');
$routes->get('parcelas/eliminar/(:num)', 'Parcelas::eliminar/$1');
$routes->get('parcelas/mapaJson', 'Parcelas::mapaJson');

// Rutas de Gestión de Usuarios (Exclusivo Administrador)
$routes->get('usuarios', 'Usuarios::index');
$routes->get('usuarios/crear', 'Usuarios::crear');
$routes->post('usuarios/guardar', 'Usuarios::guardar');
$routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1');
$routes->post('usuarios/editar/(:num)', 'Usuarios::editar/$1');
$routes->get('usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');