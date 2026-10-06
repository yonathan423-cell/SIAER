<?php

namespace App\Controllers;

use App\Models\ParcelaModel;

class Home extends BaseController
{
    public function index()
    {
        $parcelaModel = new ParcelaModel();

        // Obtenemos todas las parcelas EXCLUYENDO las del Cuartel 1
        $parcelas = $parcelaModel
            ->where('cuartel !=', 1)
            ->where('cuartel !=', '1')
            ->where('cuartel !=', 'Cuartel 1')
            ->where('cuartel !=', 'Cuartel I')
            ->findAll();

        $data = [
            'titulo'   => 'Mapa de Parcelas - SIAER',
            'parcelas' => $parcelas
        ];

        return view('home', $data);
    }
}