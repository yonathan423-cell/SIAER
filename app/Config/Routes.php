<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =========================================================================
// RUTA RAÍZ (CARGA EL HOME SI HAY SESIÓN, O REDIRIGE AL LOGIN)
// =========================================================================
$routes->get('/', static function() {
    if (session()->get('isLoggedIn')) {
        return view('home'); // Carga tu archivo home.php de la carpeta Views
    }
    return redirect()->to(base_url('login'));
});

// =========================================================================
// RUTAS DE AUTENTICACIÓN
// =========================================================================
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::procesarLogin');            
$routes->post('login/procesar', 'Auth::procesarLogin');   
$routes->get('logout', 'Auth::logout');

// =========================================================================
// RUTAS EXCLUSIVAS PARA ADMINISTRADOR
// =========================================================================
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
    $routes->post('usuarios/cambiarRol', 'Usuarios::actualizarRol'); // Alias de compatibilidad
});

// =========================================================================
// RUTAS LECTURA DEL MAPA (ADMIN, OPERADOR Y CLIENTE)
// =========================================================================
$routes->group('', ['filter' => 'role:admin,operador,cliente'], static function ($routes) {
    $routes->get('parcelas', 'Parcelas::index');
    $routes->get('parcelas/mapaJson', 'Parcelas::mapaJson');
    $routes->get('parcelas/ver/(:num)', 'Parcelas::ver/$1');   // 👈 NUEVA: detalle de parcela

    // Alias para que el fetch('mapa/obtenerCapas') funcione directo:
    $routes->get('mapa/obtenerCapas', 'Parcelas::mapaJson');
});

// =========================================================================
// RUTAS DE EDICIÓN/ESCRITURA (ADMIN Y OPERADOR)
// =========================================================================
$routes->group('', ['filter' => 'role:admin,operador'], static function ($routes) {
    $routes->get('parcelas/crear', 'Parcelas::crear');
    $routes->post('parcelas/guardar', 'Parcelas::guardar');
    $routes->get('parcelas/editar/(:num)', 'Parcelas::editar/$1');
    $routes->post('parcelas/editar/(:num)', 'Parcelas::editar/$1');
    $routes->get('parcelas/eliminar/(:num)', 'Parcelas::eliminar/$1');
});

// =========================================================================
// RUTAS EXCLUSIVAS PARA CLIENTE
// =========================================================================
$routes->group('', ['filter' => 'role:cliente'], static function ($routes) {
    $routes->get('mis-parcelas', 'Parcelas::misParcelas');
    $routes->get('parcelas/mis-parcelas', 'Parcelas::misParcelas');
});