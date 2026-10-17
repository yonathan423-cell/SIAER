<?php

namespace App\Models;

use CodeIgniter\Model;

class ExplotacionModel extends Model
{
    protected $table            = 'explotaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_parcelas', 'tipo_de_actividad', 'cultivo',
        'otro_tipo_ganadero', 'cant_de_animales',
    ];

    protected $validationRules = [
        'id_parcelas'       => 'required|integer',
        'tipo_de_actividad' => 'permit_empty|max_length[100]',
    ];

    public function porParcela(int $parcelaId): array
    {
        return $this->where('id_parcelas', $parcelaId)->findAll();
    }
}
