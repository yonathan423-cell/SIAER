<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Verificar que el usuario esté logueado
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Debes iniciar sesión para acceder al panel.');
        }

        $data = [
            'titulo'  => 'Panel de Control',
            'usuario' => session()->get('usuario'),
            'rol'     => session()->get('rol'),
        ];

        return view('dashboard/index', $data);
    }
}