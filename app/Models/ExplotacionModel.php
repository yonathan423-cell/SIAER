<?php

namespace App\Models;

use CodeIgniter\Model;

class ExplotacionModel extends Model
{
    protected $table            = 'explotaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'parcela_id', 'tipo_actividad', 'cultivo_principal',
        'tipo_ganado', 'cantidad_animales',
    ];

    protected $validationRules = [
        'parcela_id'     => 'required|integer',
        'tipo_actividad' => 'required|in_list[agricola,ganadera,mixta]',
    ];

    public function porParcela(int $parcelaId): array
    {
        return $this->where('parcela_id', $parcelaId)->findAll();
    }
}
