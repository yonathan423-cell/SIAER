<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Si no hay sesión, manda al login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión primero.');
        }

        $userRole = strtolower($session->get('rol') ?? '');
        $uri      = service('uri')->getPath();

        // 2. Si la ruta viene protegida por argumentos (ej: $routes->get('...', '...', ['filter' => 'role:admin']))
        if (!empty($arguments)) {
            $rolesPermitidos = array_map('strtolower', $arguments);

            if (!in_array($userRole, $rolesPermitidos)) {
                // Evitamos el bucle redirigiendo a la ruta segura según rol
                $destino = ($userRole === 'cliente') ? base_url('mis-parcelas') : base_url('parcelas');
                return redirect()->to($destino)->with('error', 'No tienes permisos para acceder a esta sección.');
            }
        }

        // 3. Protección de módulos ADMIN
        if (str_contains($uri, 'usuarios') || str_contains($uri, 'dashboard')) {
            if ($userRole !== 'admin') {
                return redirect()->to(base_url('parcelas'));
            }
        }

        // 4. Bloqueo de acciones de escritura para CLIENTE (Solo evalúa submódulos de creación/edición)
        if (
            str_contains($uri, 'parcelas/crear') || 
            str_contains($uri, 'parcelas/guardar') || 
            str_contains($uri, 'parcelas/editar') || 
            str_contains($uri, 'parcelas/eliminar')
        ) {
            if (!in_array($userRole, ['admin', 'operador'])) {
                return redirect()->to(base_url('parcelas'))->with('error', 'El cliente solo puede consultar datos.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acción
    }
}