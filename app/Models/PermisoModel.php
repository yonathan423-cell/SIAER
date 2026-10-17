<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table            = 'permisos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_parcelas', 'tipo', 'estado', 'fecha', 'observaciones',
    ];

    // Estados que existen hoy en los datos: Vigente, En trámite, Vencido
    protected $validationRules = [
        'id_parcelas'   => 'required|integer',
        'tipo'          => 'permit_empty|max_length[100]',
        'estado'        => 'permit_empty|in_list[Vigente,En trámite,Vencido]',
        'fecha'         => 'permit_empty|valid_date',
    ];

    public function porParcela(int $parcelaId): array
    {
        return $this->where('id_parcelas', $parcelaId)
                    ->orderBy('fecha', 'DESC')
                    ->findAll();
    }
}
