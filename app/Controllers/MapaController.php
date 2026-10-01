<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParcelaModel; // Ajustá el nombre de tu modelo si es diferente
use Config\Database;

class MapaController extends BaseController
{
    public function obtenerCapas()
    {
        $parcelaModel = new ParcelaModel();

        // 1) PARCELAS: se mantiene EXACTAMENTE igual que antes (no se toca)
        $parcelas = $parcelaModel
            ->select('id, nro_catastro, cuartel, propietario, superficie_ha, actividad, latitud, longitud')
            ->findAll();

        // 2) TAMBOS: tabla aparte (columnas: id, productor, latitud, longitud)
        $db = Database::connect();
        $tambos = $db->table('tambos')
            ->select('id, productor, latitud, longitud')
            ->get()
            ->getResultArray();

        // Adaptamos cada tambo al MISMO formato que espera el mapa (Leaflet + filtros)
        $tambosAdaptados = [];
        foreach ($tambos as $t) {
            // Solo incluimos los que tengan coordenadas cargadas
            if (empty($t['latitud']) || empty($t['longitud'])) {
                continue;
            }

            $tambosAdaptados[] = [
                'id'            => 'tambo-' . $t['id'],   // id único para no chocar con parcelas
                'nro_catastro'  => 'Tambo #' . $t['id'],  // los tambos no tienen catastro
                'cuartel'       => 'Sin asignar',
                'propietario'   => $t['productor'] ?: 'Sin datos',
                'superficie_ha' => 0,
                'actividad'     => 'Tambos',              // 👈 clave para que el filtro "Tambos" los muestre
                'latitud'       => $t['latitud'],
                'longitud'      => $t['longitud'],
            ];
        }

        // 3) Unimos ambas fuentes en una sola respuesta JSON para Leaflet
        $capas = array_merge($parcelas, $tambosAdaptados);

        return $this->response->setJSON($capas);
    }
}