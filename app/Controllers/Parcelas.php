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

        // Solo traemos la actividad de explotaciones sin invocar columnas que no existen
        $builder = $this->parcelaModel
            ->select('parcelas.*, explotaciones.tipo_de_actividad')
            ->join('explotaciones', 'explotaciones.id_parcelas = parcelas.id', 'left');

        if ($anio) {
            $builder = $builder->where('parcelas.anio_relevamiento', (int) $anio);
        }

        if ($cuartel) {
            $builder = $builder->like('parcelas.cuartel', $cuartel);
        } else {
            $builder = $builder->orderBy("FIELD(parcelas.cuartel, '2', '8') DESC", '', false)
                               ->orderBy('parcelas.id', 'ASC');
        }

        $parcelas = $builder->findAll();

        $superficieTotal = 0;
        foreach ($parcelas as &$p) {
            $sup = (float)($p['superficie'] ?? $p['superficie_ha'] ?? 0);
            $p['superficie']  = $sup;
            $p['catastro']    = $p['n_catastro'] ?? $p['catastro'] ?? 'S/N';
            $p['propietario'] = $p['propietario'] ?? 'Sin datos';
            $p['actividad']   = $p['tipo_de_actividad'] ?? $p['actividad'] ?? 'Sin especificar';
            $superficieTotal += $sup;
        }

        $data = [
            'parcelas'            => $parcelas,
            'anioSeleccionado'    => $anio,
            'cuartelSeleccionado' => $cuartel,
            'superficie_total'    => $superficieTotal ?: 2046312,
            'sup_recria'          => 343454,
            'sup_urbano'          => 102.5,
            'sup_agricola'        => 337785
        ];

        return view('parcelas/index', $data);
    }

    public function misParcelas()
    {
        $usuarioLogueado = session()->get('usuario');

        $parcelas = $this->parcelaModel
            ->select('parcelas.*, explotaciones.tipo_de_actividad')
            ->join('explotaciones', 'explotaciones.id_parcelas = parcelas.id', 'left')
            ->where('parcelas.propietario', $usuarioLogueado)
            ->findAll();

        foreach ($parcelas as &$p) {
            $p['superficie']  = (float)($p['superficie'] ?? 0);
            $p['catastro']    = $p['n_catastro'] ?? 'S/N';
            $p['propietario'] = $p['propietario'] ?? 'Sin datos';
            $p['actividad']   = $p['tipo_de_actividad'] ?? 'Sin especificar';
        }

        $data = [
            'titulo'   => 'Mis Parcelas',
            'parcelas' => $parcelas,
        ];

        if (is_file(APPPATH . 'Views/parcelas/mis_parcelas.php')) {
            return view('parcelas/mis_parcelas', $data);
        } elseif (is_file(APPPATH . 'Views/cliente/mis_parcelas.php')) {
            return view('cliente/mis_parcelas', $data);
        } elseif (is_file(APPPATH . 'Views/mis_parcelas.php')) {
            return view('mis_parcelas', $data);
        }

        return view('parcelas/mis_parcelas', $data);
    }

    public function ver($id)
    {
        $parcela = $this->parcelaModel->find($id);

        if (! $parcela) {
            return redirect()->to(base_url('parcelas'))->with('error', 'Parcela no encontrada.');
        }

        $parcela['catastro'] = $parcela['n_catastro'] ?? $parcela['catastro'] ?? $parcela['id'];

        return view('parcelas/ver', [
            'titulo'  => 'Detalle de Parcela #' . $parcela['catastro'],
            'parcela' => $parcela
        ]);
    }

    public function crear()
    {
        return view('parcelas/crear', ['titulo' => 'Nueva Parcela']);
    }

    public function guardar()
    {
        $volver = $this->request->getPost('volver') ?: base_url('parcelas');

        $data = [
            'n_catastro'        => $this->request->getPost('catastro') ?? $this->request->getPost('nro_catastro') ?? $this->request->getPost('n_catastro'),
            'latitud'           => $this->request->getPost('latitud'),
            'longitud'          => $this->request->getPost('longitud'),
            'superficie'        => $this->request->getPost('superficie_ha') ?? $this->request->getPost('superficie'),
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
            return redirect()->to(base_url('parcelas'))->with('error', 'Parcela no encontrada.');
        }

        if ($this->request->is('post') || $this->request->getMethod() === 'POST') {
            $volver = $this->request->getPost('volver') ?: base_url('parcelas');

            if (! $this->parcelaModel->update($id, $this->request->getPost())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errores', $this->parcelaModel->errors());
            }

            return redirect()->to($volver)->with('mensaje', 'Parcela actualizada correctamente.');
        }

        return view('parcelas/editar', ['titulo' => 'Editar Parcela', 'parcela' => $parcela]);
    }

    public function eliminar($id)
    {
        $this->parcelaModel->delete($id);
        return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela eliminada correctamente.');
    }

    public function mapaJson()
    {
        $anio    = $this->request->getGet('anio');
        $cuartel = $this->request->getGet('cuartel');

        $builder = $this->parcelaModel
            ->select('parcelas.*, explotaciones.tipo_de_actividad')
            ->join('explotaciones', 'explotaciones.id_parcelas = parcelas.id', 'left');

        if ($anio) {
            $builder = $builder->where('parcelas.anio_relevamiento', (int) $anio);
        }

        if ($cuartel) {
            $builder = $builder->like('parcelas.cuartel', $cuartel);
        } else {
            $builder = $builder->orderBy("FIELD(parcelas.cuartel, '2', '8') DESC", '', false);
        }

        $parcelas = $builder->findAll();

        $puntos = array_map(function ($p) {
            return [
                'id'            => $p['id'],
                'latitud'       => (float) ($p['latitud'] ?? $p['lat'] ?? 0),
                'longitud'      => (float) ($p['longitud'] ?? $p['lng'] ?? 0),
                'nro_catastro'  => $p['n_catastro'] ?? $p['catastro'] ?? 'S/N',
                'cuartel'       => $p['cuartel'] ?? '',
                'propietario'   => $p['propietario'] ?? 'Sin datos',
                'superficie_ha' => (float) ($p['superficie'] ?? $p['superficie_ha'] ?? 0),
                'actividad'     => $p['tipo_de_actividad'] ?? $p['actividad'] ?? 'Sin especificar',
            ];
        }, $parcelas);

        return $this->response->setJSON($puntos);
    }
}