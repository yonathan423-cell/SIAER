<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Rutas Públicas / Inicio
$routes->get('/', 'Home::index');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login/procesar', 'Auth::procesarLogin');
$routes->get('logout', 'Auth::logout');

// Rutas Exclusivas para ADMINISTRADOR
$routes->group('', ['filter' => 'role:admin'], static function ($routes) {
    // Panel de Control
    $routes->get('dashboard', 'Dashboard::index');

    // Gestión de Usuarios
    $routes->get('usuarios', 'Usuarios::index');
    $routes->get('usuarios/crear', 'Usuarios::crear');
    $routes->post('usuarios/guardar', 'Usuarios::guardar');
    $routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1');
    $routes->post('usuarios/editar/(:num)', 'Usuarios::editar/$1');
    $routes->post('usuarios/actualizar', 'Usuarios::actualizar');
    $routes->get('usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');
    
    // Endpoint AJAX para cambio rápido de rol sin recargar página
    $routes->post('usuarios/actualizar-rol', 'Usuarios::actualizarRol');
});

// Rutas Lectura del Mapa (Acceso para ADMIN, OPERADOR y CLIENTE)
$routes->group('', ['filter' => 'role:admin,operador,cliente'], static function ($routes) {
    $routes->get('parcelas', 'Parcelas::index');
    $routes->get('parcelas/mapaJson', 'Parcelas::mapaJson');
});

// Rutas de Edición/Escritura (Exclusivas para ADMIN y OPERADOR)
$routes->group('', ['filter' => 'role:admin,operador'], static function ($routes) {
    $routes->get('parcelas/crear', 'Parcelas::crear');
    $routes->post('parcelas/guardar', 'Parcelas::guardar');
    $routes->get('parcelas/editar/(:num)', 'Parcelas::editar/$1');
    $routes->post('parcelas/editar/(:num)', 'Parcelas::editar/$1');
    $routes->get('parcelas/eliminar/(:num)', 'Parcelas::eliminar/$1');
});

// Rutas Exclusivas para CLIENTE
$routes->group('', ['filter' => 'role:cliente'], static function ($routes) {
    $routes->get('mis-parcelas', 'ClienteController::index');
});