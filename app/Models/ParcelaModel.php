<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table            = 'parcelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Agregá o verifica las columnas exactas que tiene tu tabla parcelas en la BD
    protected $allowedFields    = [
        'padron', 
        'propietario', 
        'cuartel', 
        'hectareas', 
        'uso_suelo', 
        'estado'
    ];

    protected $useTimestamps    = false;
}