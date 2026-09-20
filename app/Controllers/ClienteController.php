<?php

namespace App\Controllers;

class ClienteController extends BaseController
{
    public function index()
    {
        $data = [
            'titulo' => 'Mis Parcelas'
        ];

        return view('cliente/mis_parcelas', $data);
    }
}