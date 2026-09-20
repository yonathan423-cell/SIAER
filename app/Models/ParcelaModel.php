<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table            = 'parcelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false; // la tabla no tiene created_at / updated_at

    // Nombres EXACTOS de las columnas reales de siaer_db.parcelas
    protected $allowedFields = [
        'n_catastro', 'latitud', 'longitud', 'superficie',
        'propietario', 'cuartel', 'anio_relevamiento',
    ];

    protected $validationRules = [
        'n_catastro' => 'required|max_length[100]',
        'latitud'    => 'required|decimal',
        'longitud'   => 'required|decimal',
        'cuartel'    => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'n_catastro' => [
            'required' => 'Debe indicar el número de catastro de la parcela.',
        ],
    ];

    /**
     * Datos livianos para el mapa (id, catastro, lat/long, cuartel),
     * excluyendo Cuartel 1 (casco urbano, fuera del área rural del proyecto).
     * SE MANTIENE INTACTO PARA NO ROMPER EL MAPA.
     */
    public function paraMapa(?int $anio = null, ?string $cuartel = null): array
    {
        $query = $this->select('id, n_catastro, latitud, longitud, superficie, cuartel, propietario')
                       ->where('cuartel !=', 'Cuartel 1');

        if ($anio !== null) {
            $query->where('anio_relevamiento', $anio);
        }
        if ($cuartel !== null) {
            $query->where('cuartel', $cuartel);
        }

        return $query->findAll();
    }

    /**
     * Filtro general para administración.
     * SE MANTIENE INTACTO PARA NO ROMPER LAS OTRAS VISTAS.
     */
    public function filtrar(?int $anio = null, ?string $cuartel = null): array
    {
        $query = $this->where('cuartel !=', 'Cuartel 1');

        if ($anio !== null) {
            $query->where('anio_relevamiento', $anio);
        }
        if ($cuartel !== null) {
            $query->where('cuartel', $cuartel);
        }

        return $query->orderBy('n_catastro', 'ASC')->findAll();
    }

    /**
     * NUEVO MÉTODO SEGURO:
     * Trae absolutamente toda la base de datos de parcelas sin filtros ni límites de 10 registros,
     * ideal para la vista general de la tabla de la base.
     */
    public function obtenerTodas(): array
    {
        return $this->orderBy('id', 'ASC')->findAll();
    }
}