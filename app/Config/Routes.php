<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta raíz → Home
$routes->get('/', 'Home::index');

// Login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

// Parcelas
$routes->get('parcelas', 'Parcelas::index');
$routes->get('parcelas/crear', 'Parcelas::crear');
$routes->post('parcelas/guardar', 'Parcelas::guardar');
$routes->get('parcelas/editar/(:num)', 'Parcelas::editar/$1');
$routes->post('parcelas/actualizar/(:num)', 'Parcelas::actualizar/$1');
$routes->get('parcelas/eliminar/(:num)', 'Parcelas::eliminar/$1');

// Mapa JSON
$routes->get('parcelas/mapaJson', 'Parcelas::mapaJson');
