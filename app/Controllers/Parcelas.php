<?php

namespace App\Controllers;
use App\Models\ParcelaModel;

class Parcelas extends BaseController
{
    protected $parcelaModel;

    public function __construct()
    {
        $this->parcelaModel = new ParcelaModel();
    }

    public function index()
{
    $anio    = $this->request->getGet('anio');
    $cuartel = $this->request->getGet('cuartel');

    $builder = $this->parcelaModel;
    if ($anio)    { $builder = $builder->where('anio_relevamiento', (int) $anio); }
    if ($cuartel) { $builder = $builder->like('cuartel', $cuartel); }

    $data['parcelas']            = $builder->findAll();
    $data['anioSeleccionado']    = $anio;
    $data['cuartelSeleccionado'] = $cuartel;

    return view('parcelas/index', $data);
}

    public function crear()
    {
        return view('parcelas/crear');
    }

    public function guardar()
{
    $volver = $this->request->getPost('volver') ?: base_url('parcelas');

    $data = [
        'nro_catastro'      => $this->request->getPost('nro_catastro'),
        'latitud'           => $this->request->getPost('latitud'),
        'longitud'          => $this->request->getPost('longitud'),
        'superficie_ha'     => $this->request->getPost('superficie_ha'),
        'propietario'       => $this->request->getPost('propietario'),
        'cuartel'           => $this->request->getPost('cuartel'),
        'anio_relevamiento' => $this->request->getPost('anio_relevamiento'),
    ];

    if ($this->parcelaModel->insert($data) === false) {
        return redirect()->back()
            ->withInput()
            ->with('errores', $this->parcelaModel->errors());
    }

    return redirect()->to($volver)
        ->with('mensaje', '✅ Parcela creada correctamente.');
}


    public function editar($id)
    {
        $parcela = $this->parcelaModel->find($id);

        if (! $parcela) {
            return redirect()->to('/parcelas')->with('error', 'Parcela no encontrada.');
        }

        if ($this->request->getMethod() === 'post') {
            $volver = $this->request->getPost('volver') ?: base_url('parcelas');

            if (! $this->parcelaModel->update($id, $this->request->getPost())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errores', $this->parcelaModel->errors());
            }

            return redirect()->to($volver)->with('mensaje', 'Parcela actualizada correctamente.');
        }

        return view('parcelas/editar', ['titulo' => 'Editar parcela', 'parcela' => $parcela]);
    }

    public function eliminar($id)
    {
        $this->parcelaModel->delete($id);
        return redirect()->to('/parcelas')->with('mensaje', 'Parcela eliminada.');
    }

    public function mapaJson()
{
    $anio    = $this->request->getGet('anio');
    $cuartel = $this->request->getGet('cuartel');

    $builder = $this->parcelaModel;
    if ($anio)    { $builder = $builder->where('anio_relevamiento', (int) $anio); }
    if ($cuartel) { $builder = $builder->like('cuartel', $cuartel); }

    $puntos = array_map(function ($p) {
        return [
            'latitud'      => (float) $p['latitud'],
            'longitud'     => (float) $p['longitud'],
            'nro_catastro' => $p['nro_catastro'],
            'cuartel'      => $p['cuartel'],
        ];
    }, $builder->findAll());

    return $this->response->setJSON($puntos);
}
}