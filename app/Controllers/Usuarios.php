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
        $rules = [
            'usuario'  => 'required|min_length[3]|is_unique[usuarios.usuario]',
            'password' => 'required|min_length[6]',
            'rol'      => 'required|in_list[admin,operador,cliente]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->usuarioModel->save([
            'usuario'    => $this->request->getPost('usuario'),
            'contrasena' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'        => strtolower($this->request->getPost('rol')),
        ]);

        return redirect()->to(base_url('usuarios'))->with('mensaje', 'Usuario creado correctamente.');
    }

    // Procesar la actualización desde el modal del lápiz
    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $rules = [
            'usuario' => "required|min_length[3]|is_unique[usuarios.usuario,id,{$id}]",
            'rol'     => 'required|in_list[admin,operador,cliente]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('mensaje', 'Error en la validación de los datos.');
        }

        $data = [
            'usuario' => $this->request->getPost('usuario'),
            'rol'     => strtolower($this->request->getPost('rol')),
        ];

        // Si enviaron una nueva contraseña desde el modal, la actualizamos
        if ($this->request->getPost('password')) {
            $data['contrasena'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);

        return redirect()->to(base_url('usuarios'))->with('mensaje', '¡Usuario actualizado correctamente!');
    }

    // Eliminar usuario
    public function eliminar($id)
    {
        // Evitar que el admin en sesión se elimine a sí mismo
        if ((int)$id === (int)session()->get('usuario_id')) {
            return redirect()->to(base_url('usuarios'))->with('error', 'No puedes eliminar tu propia cuenta.');
        }

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
                if ($id === (int) session()->get('usuario_id') && $rol !== 'admin') {
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