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
            'rol'      => 'required|in_list[admin,operador,cliente]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->usuarioModel->save([
            'nombre'        => $this->request->getPost('nombre'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'           => strtolower($this->request->getPost('rol')),
        ]);

        return redirect()->to(base_url('usuarios'))->with('mensaje', 'Usuario creado correctamente.');
    }

    // Procesar la actualización desde el modal del lápiz
    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $rules = [
            'nombre' => 'required|min_length[3]',
            'email'  => "required|valid_email|is_unique[usuarios.email,id,{$id}]",
            'rol'    => 'required|in_list[admin,operador,cliente]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('mensaje', 'Error en la validación de los datos.');
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email'  => $this->request->getPost('email'),
            'rol'    => strtolower($this->request->getPost('rol')),
        ];

        $this->usuarioModel->update($id, $data);

        return redirect()->to(base_url('usuarios'))->with('mensaje', '¡Usuario actualizado correctamente!');
    }

    // Eliminar usuario
    public function eliminar($id)
    {
        $this->usuarioModel->delete($id);
        return redirect()->to(base_url('usuarios'))->with('mensaje', 'Usuario eliminado correctamente.');
    }

    // Actualización rápida de rol vía AJAX
    public function actualizarRol()
    {
        $json = $this->request->getJSON();

        if (isset($json->id) && isset($json->rol)) {
            $id  = (int) $json->id;
            $rol = strtolower(trim($json->rol));

            if (in_array($rol, ['admin', 'operador', 'cliente'])) {
                
                // Evita que el admin logueado se desgradúe a sí mismo por error
                if ($id === (int) session()->get('id') && $rol !== 'admin') {
                    return $this->response->setJSON([
                        'success' => false, 
                        'mensaje' => 'No puedes quitarte el rol de Administrador a ti mismo.'
                    ]);
                }

                $actualizado = $this->usuarioModel->update($id, ['rol' => $rol]);

                if ($actualizado) {
                    return $this->response->setJSON([
                        'success' => true, 
                        'mensaje' => 'Rol actualizado correctamente.'
                    ]);
                }
            }
        }

        return $this->response->setJSON([
            'success' => false, 
            'mensaje' => 'Error al actualizar el rol.'
        ]);
    }
}