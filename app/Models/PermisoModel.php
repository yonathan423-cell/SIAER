<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table            = 'permisos_inspecciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'parcela_id', 'tipo', 'estado', 'fecha', 'observaciones',
    ];

    protected $validationRules = [
        'parcela_id' => 'required|integer',
        'tipo'       => 'required|max_length[50]',
        'estado'     => 'required|in_list[pendiente,aprobado,rechazado,vencido]',
        'fecha'      => 'required|valid_date',
    ];

    public function porParcela(int $parcelaId): array
    {
        return $this->where('parcela_id', $parcelaId)
                     ->orderBy('fecha', 'DESC')
                     ->findAll();
    }
}
