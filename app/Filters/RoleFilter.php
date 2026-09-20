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
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión primero.');
        }

        $userRole = strtolower($session->get('rol') ?? '');
        $uri      = trim(service('uri')->getPath(), '/');

        // Función auxiliar para redirigir según el rol
        $getHomeByRole = function ($role) {
            return match ($role) {
                'cliente'  => base_url('mis-parcelas'),
                'operador' => base_url('parcelas'),
                'admin'    => base_url('parcelas'),
                default    => base_url('login'),
            };
        };

        // 2. Validación por argumentos asignados en Routes.php (ej: 'role:admin,operador')
        if (! empty($arguments)) {
            $rolesPermitidos = array_map('strtolower', $arguments);

            if (! in_array($userRole, $rolesPermitidos)) {
                return redirect()->to($getHomeByRole($userRole))
                    ->with('error', 'No tienes permisos para acceder a esta sección.');
            }
        }

        // 3. Protección de módulos estrictos de ADMIN
        if (str_contains($uri, 'usuarios') || str_contains($uri, 'dashboard')) {
            if ($userRole !== 'admin') {
                return redirect()->to($getHomeByRole($userRole))
                    ->with('error', 'Acceso denegado. Zona de administración.');
            }
        }

        // 4. Bloqueo de acciones de escritura/edición para CLIENTE
        if (
            str_contains($uri, 'parcelas/crear') || 
            str_contains($uri, 'parcelas/guardar') || 
            str_contains($uri, 'parcelas/editar') || 
            str_contains($uri, 'parcelas/eliminar')
        ) {
            if (! in_array($userRole, ['admin', 'operador'])) {
                return redirect()->to($getHomeByRole($userRole))
                    ->with('error', 'El cliente solo puede consultar datos.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acción requerida tras la petición
    }
}