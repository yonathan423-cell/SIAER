<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParcelaModel; // Ajustá el nombre de tu modelo si es diferente

class MapaController extends BaseController
{
    public function obtenerCapas()
    {
        $parcelaModel = new ParcelaModel();
        
        // Traemos las parcelas que tengan latitud y longitud cargadas
        $parcelas = $parcelaModel->select('id, nro_catastro, cuartel, propietario, superficie_ha, actividad, latitud, longitud')->findAll();

        // Devolvemos la información en formato JSON para que Leaflet la dibuje
        return $this->response->setJSON($parcelas);
    }
}