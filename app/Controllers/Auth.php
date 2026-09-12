<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login()
    {
        return view('login', ['titulo' => 'Iniciar sesión']);
    }

    public function procesarLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->where('email', $email)->first();

        if (! $usuario || ! password_verify($password, $usuario['password_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email o contraseña incorrectos.');
        }

        // Normalizamos el rol a minúsculas por seguridad de comparación
        $rol = strtolower($usuario['rol']);

        // Guardamos las claves en la sesión
        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario'    => $usuario['nombre'],
            'rol'        => $rol,
            'isLoggedIn' => true,
        ]);

        // Redirección inteligente según el rol ingresado
        switch ($rol) {
            case 'admin':
                // Administrador va al panel general / gestión de usuarios
                $destino = '/'; // O '/usuarios' / '/dashboard' según tu preferencia
                break;

            case 'operador':
                // Operador va directo al mapa / gestión de parcelas
                $destino = '/parcelas'; 
                break;

            case 'cliente':
                // Cliente va a su vista privada de consulta
                $destino = '/mis-parcelas'; 
                break;

            default:
                $destino = '/';
                break;
        }

        return redirect()->to(base_url($destino))
            ->with('mensaje', 'Bienvenido, ' . $usuario['nombre'] . '.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('mensaje', 'Sesión cerrada.');
    }
}