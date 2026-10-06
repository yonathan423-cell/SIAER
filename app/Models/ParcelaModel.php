<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table            = 'parcelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Lista completa de columnas permitidas (incluye geográficas)
    protected $allowedFields    = [
        'padron', 
        'propietario', 
        'cuartel', 
        'hectareas', 
        'actividad',
        'estado',
        'latitud', 
        'longitud',
        'geom'
    ];

    protected $useTimestamps    = false;
}