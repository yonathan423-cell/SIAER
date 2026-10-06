<?php
namespace App\Controllers;

use App\Libraries\AuditLogger;

use App\Models\TamboModel;

class Tambos extends BaseController
{
    public function mapa()
    {
        $tambos = (new TamboModel())->findAll();
        return view('tambos/mapa', ['tambos' => $tambos]);
    }
}