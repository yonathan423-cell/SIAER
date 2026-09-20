<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    
    // Alineado con las columnas reales de la tabla usuarios en siaer_db
    protected $allowedFields    = ['nombre', 'email', 'contrasena', 'rol'];
    
    // Devuelve arreglos asociativos al hacer findAll() o find()
    protected $returnType       = 'array';
    
    // Desactivado para evitar errores de columnas inexistentes (created_at / updated_at)
    protected $useTimestamps    = false;

    // Reglas de validación nativas del modelo
    protected $validationRules  = [
        'nombre'     => 'required|min_length[3]|max_length[100]',
        'email'      => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        'contrasena' => 'required|min_length[6]',
        'rol'        => 'required|in_list[admin,operador,cliente]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre completo es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Ingresá un correo electrónico válido.',
            'is_unique'   => 'Ese correo electrónico ya está registrado en el sistema.',
        ],
        'contrasena' => [
            'required'   => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
        ],
        'rol' => [
            'in_list' => 'El rol seleccionado no es válido (debe ser admin, operador o cliente).',
        ],
    ];
}