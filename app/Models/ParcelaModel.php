<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table            = 'parcelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'nro_catastro', 'latitud', 'longitud', 'superficie_ha',
        'propietario', 'cuartel', 'anio_relevamiento',
    ];

    protected $validationRules = [
        'nro_catastro'       => 'required|max_length[30]',
        'latitud'            => 'required|decimal',
        'longitud'           => 'required|decimal',
        'cuartel'            => 'required|max_length[10]',
        'anio_relevamiento'  => 'required|integer',
    ];

    protected $validationMessages = [
        'nro_catastro' => [
            'required' => 'Debe indicar el número de catastro de la parcela.',
        ],
    ];

    /**
     * Devuelve solo los campos necesarios para pintar el mapa (liviano, sin lag),
     * excluyendo siempre el Cuartel 1 (corresponde al casco urbano, no al área rural).
     */
    public function paraMapa(?int $anio = null): array
    {
        $query = $this->select('id, nro_catastro, latitud, longitud, cuartel')
                       ->where('cuartel !=', '1');

        if ($anio !== null) {
            $query->where('anio_relevamiento', $anio);
        }

        return $query->findAll();
    }

    /**
     * Listado filtrado por año y/o segmento (cuartel), para la vista de tabla.
     */
    public function filtrar(?int $anio = null, ?string $cuartel = null): array
    {
        $query = $this->where('cuartel !=', '1'); // Cuartel 1 fuera de alcance

        if ($anio !== null) {
            $query->where('anio_relevamiento', $anio);
        }
        if ($cuartel !== null) {
            $query->where('cuartel', $cuartel);
        }

        return $query->orderBy('nro_catastro', 'ASC')->findAll();
    }
}


