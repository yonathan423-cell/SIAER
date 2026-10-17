<?php

namespace App\Controllers;

use App\Models\ParcelaModel;

class MapaController extends BaseController
{
    // Carga la vista principal del mapa
    public function index()
    {
        $data = ['titulo' => 'Mapa de Parcelas - General Paz'];
        return view('mapa/index', $data);
    }

    // Endpoint que devuelve el JSON para renderizar en Leaflet
    public function getParcelasJson()
    {
        $parcelaModel = new ParcelaModel();

        // Excluye el Cuartel 1 en todas sus variantes y suma la actividad de la explotación
        $parcelas = $parcelaModel->conExplotacion(true);

        return $this->response->setJSON($parcelas);
    }
}