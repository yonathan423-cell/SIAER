<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table            = 'parcelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Columnas reales de la tabla `parcelas` en siaer_db
    protected $allowedFields    = [
        'n_catastro',
        'propietario',
        'cuartel',
        'superficie',
        'actividad',
        'latitud',
        'longitud',
        'anio_relevamiento',
    ];
    protected $useTimestamps    = false;

    /**
     * Parcelas unidas con su explotación (tabla `explotaciones`, 1 por parcela).
     * Si `parcelas.actividad` está vacía, se usa `explotaciones.tipo_de_actividad`.
     */
    public function conExplotacion(bool $excluirCuartel1 = false, ?int $id = null): array
    {
        $b = $this->select('parcelas.*, e.tipo_de_actividad, e.cultivo, e.otro_tipo_ganadero, e.cant_de_animales')
                  ->join('explotaciones e', 'e.id_parcelas = parcelas.id', 'left');

        if ($excluirCuartel1) {
            $b->where("TRIM(REPLACE(LOWER(parcelas.cuartel), 'cuartel', '')) NOT IN ('1', 'i')", null, false);
        }
        if ($id !== null) {
            $b->where('parcelas.id', $id);
        }

        $filas = $b->orderBy('parcelas.id', 'ASC')->findAll();

        foreach ($filas as &$f) {
            // "5" -> "Cuartel 5" (la base tiene algunos cuarteles sin el prefijo)
            $cuartel = trim((string) ($f['cuartel'] ?? ''));
            if ($cuartel !== '' && ctype_digit($cuartel)) {
                $f['cuartel'] = 'Cuartel ' . $cuartel;
            }

            if (trim((string) ($f['actividad'] ?? '')) === '') {
                $f['actividad'] = $f['tipo_de_actividad'] ?? null;
            }
        }
        unset($f);

        return $filas;
    }

    public function conExplotacionPorId(int $id): ?array
    {
        $r = $this->conExplotacion(false, $id);
        return $r[0] ?? null;
    }
}
