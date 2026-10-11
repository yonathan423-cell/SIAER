<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta raíz -> Home
$routes->get('/', 'Home::index');

// Login y Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::procesarLogin');
$routes->post('login/procesar', 'Auth::procesarLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('tambos', 'Tambos::mapa');

// ====================================================================
// RUTAS EXCLUSIVAS PARA ADMINISTRADOR
// ====================================================================
$routes->group('', ['filter' => 'role:admin'], static function ($routes) {
    // Panel de Control
    $routes->get('dashboard', 'Dashboard::index');

    // Gestión de Usuarios
    $routes->get('usuarios', 'Usuarios::index');
});