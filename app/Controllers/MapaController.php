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

        // Consulta filtrando para EXCLUIR el Cuartel 1 en todas sus variantes
        $parcelas = $parcelaModel
            ->where('cuartel !=', 1)
            ->where('cuartel !=', '1')
            ->where('cuartel !=', 'Cuartel 1')
            ->where('cuartel !=', 'Cuartel I')
            ->findAll();

        return $this->response->setJSON($parcelas);
    }
}