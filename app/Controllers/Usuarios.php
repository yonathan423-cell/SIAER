<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // Listado principal de usuarios
    public function index()
    {
        $data = [
            'titulo'   => 'Gestión de Usuarios',
            'usuarios' => $this->usuarioModel->findAll()
        ];

        return view('usuarios/index', $data);
    }

    // Formulario para crear un usuario nuevo
    public function crear()
    {
        $data = ['titulo' => 'Nuevo Usuario'];
        return view('usuarios/crear', $data);
    }

    // Guardar usuario en la base de datos
    public function guardar()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre'   => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[6]',
            'rol'      => 'required|in_list[admin,operador]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->usuarioModel->save([
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => $this->request->getPost('rol'),
        ]);

        return redirect()->to(base_url('usuarios'))->with('mensaje', 'Usuario creado correctamente.');
    }

    // Eliminar usuario
    public function eliminar($id)
    {
        $this->usuarioModel->delete($id);
        return redirect()->to(base_url('usuarios'))->with('mensaje', 'Usuario eliminado correctamente.');
    }
}