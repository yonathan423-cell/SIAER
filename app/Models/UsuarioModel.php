<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'email', 'password_hash', 'rol'];
    protected $useTimestamps    = true;

    protected $validationRules  = [
        'nombre' => 'required|max_length[100]',
        'email'  => 'required|valid_email|max_length[150]',
        'rol'    => 'required|in_list[admin,operador]',
    ];
}