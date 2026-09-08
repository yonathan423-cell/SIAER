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

        // Guardamos las claves con los mismos nombres que consulta layout/base.php
        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario'    => $usuario['nombre'], // Antes era usuario_nombre
            'rol'        => $usuario['rol'],    // Antes era usuario_rol
            'isLoggedIn' => true,               // Antes era logueado
        ]);

        // Redirigimos al inicio de la web en lugar de a parcelas
        return redirect()->to(base_url('/'))
            ->with('mensaje', 'Bienvenido, ' . $usuario['nombre'] . '.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('mensaje', 'Sesión cerrada.');
    }
}