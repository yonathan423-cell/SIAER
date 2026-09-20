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
        // Capturamos el email y contraseña del formulario
        $email    = $this->request->getPost('usuario') ?? $this->request->getPost('email');
        $password = $this->request->getPost('password') ?? $this->request->getPost('contrasena');

        // Buscamos por la columna 'email' real de la base de datos
        $usuario = $this->usuarioModel->where('email', $email)->first();

        if (! $usuario || ! password_verify($password, $usuario['contrasena'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email o contraseña incorrectos.');
        }

        $rol = strtolower($usuario['rol']);

        // Guardamos en la sesión
        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario'    => $usuario['nombre'], // mostramos el nombre completo
            'email'      => $usuario['email'],
            'rol'        => $rol,
            'isLoggedIn' => true,
        ]);

        // Redirección por rol
        switch ($rol) {
            case 'admin':
                $destino = '/parcelas'; 
                break;

            case 'operador':
                $destino = '/parcelas'; 
                break;

            case 'cliente':
                $destino = '/mis-parcelas'; 
                break;

            default:
                $destino = '/parcelas';
                break;
        }

        return redirect()->to(base_url($destino))
            ->with('mensaje', '¡Hola, ' . $usuario['nombre'] . '! Que tengas una buena jornada.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('mensaje', 'Sesión cerrada.');
    }
}