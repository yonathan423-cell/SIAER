<?php

namespace App\Controllers;



use App\Libraries\AuditLogger;


 
use App\Models\ParcelaModel;

class Parcelas extends BaseController
{
    protected $parcelaModel;

    public function __construct()
    {
        $this->parcelaModel = new ParcelaModel();
    }

    // Listado de parcelas
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



    {
        $data = [
            'titulo'   => 'Gestión de Parcelas',
            'parcelas' => $this->parcelaModel->findAll()
        ];

        return view('parcelas/index', $data);
    }

    // Formulario de creación
    public function crear()
    {
        $data = ['titulo' => 'Nueva Parcela'];
        return view('parcelas/crear', $data);
    }

    // Guardar nueva parcela
    public function guardar()
    {
        $rules = [
            'n_catastro'  => 'required',
            'propietario' => 'required|min_length[3]',
            'cuartel'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $nuevaParcela = [
            'n_catastro'        => $this->request->getPost('n_catastro') ?? $this->request->getPost('catastro'),
            'propietario'       => $this->request->getPost('propietario'),
            'cuartel'           => $this->request->getPost('cuartel'),
            'superficie_ha'     => $this->request->getPost('superficie_ha') ?? $this->request->getPost('superficie'),
            'actividad'         => $this->request->getPost('actividad'),
            'latitud'           => $this->request->getPost('latitud'),
            'longitud'          => $this->request->getPost('longitud'),
            'anio_relevamiento' => $this->request->getPost('anio_relevamiento'),
            'estado'            => $this->request->getPost('estado') ?? 'activo',
        ];

        if ($this->parcelaModel->insert($nuevaParcela)) {
            $nuevoId = $this->parcelaModel->getInsertID();

            // Registrar inserción en audit_logs
            AuditLogger::log('parcelas', $nuevoId, 'INSERT', null, $nuevaParcela);

            return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela creada correctamente.');
        } else {
            dd($this->parcelaModel->errors(), $this->parcelaModel->db()->getError());
        }
    }


    // Mostrar formulario de edición y procesar actualización
    public function editar($id = null)


    public function editar($id)

    {
        // 1. Buscar la parcela por ID
        $parcela = $this->parcelaModel->find($id);


        if (!$parcela) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("No se encontró la parcela con ID: $id");
        }

        // 2. Si la petición viene por POST (al presionar "Guardar cambios")
        if ($this->request->getMethod() === 'post' || $this->request->getMethod() === 'POST') {
            
            $rules = [
                'n_catastro' => 'required',
                'latitud'    => 'required',
                'longitud'   => 'required',
                'cuartel'    => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
            }

            $datosPrevios = $parcela;

            $datosNuevos = [
                'n_catastro'        => $this->request->getPost('n_catastro'),
                'latitud'           => $this->request->getPost('latitud'),
                'longitud'          => $this->request->getPost('longitud'),
                'superficie_ha'     => $this->request->getPost('superficie_ha'),
                'propietario'       => $this->request->getPost('propietario'),
                'actividad'         => $this->request->getPost('actividad'),
                'cuartel'           => $this->request->getPost('cuartel'),
                'anio_relevamiento' => $this->request->getPost('anio_relevamiento'),
            ];

            if ($this->parcelaModel->update($id, $datosNuevos)) {
                // Registrar actualización en audit_logs
                AuditLogger::log('parcelas', (int)$id, 'UPDATE', $datosPrevios, $datosNuevos);

        if (! $parcela) {

            return redirect()->to('/parcelas')->with('error', 'Parcela no encontrada.');
        }

        if ($this->request->getMethod() === 'post') {

            return redirect()->to(base_url('parcelas'))->with('error', 'Parcela no encontrada.');
        }

        if ($this->request->is('post') || $this->request->getMethod() === 'POST') {

            $volver = $this->request->getPost('volver') ?: base_url('parcelas');


                $redirectUrl = $this->request->getPost('volver') ?: base_url('parcelas');
                return redirect()->to($redirectUrl)->with('mensaje', 'Parcela actualizada correctamente.');
            }

            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar la parcela.');
        }


        // 3. Si es GET, mostrar la vista con los datos cargados
        return view('parcelas/editar', [
            'titulo'  => 'Editar Parcela',
            'parcela' => $parcela
        ]);

        return view('parcelas/editar', ['titulo' => 'Editar parcela', 'parcela' => $parcela]);

        return view('parcelas/editar', ['titulo' => 'Editar Parcela', 'parcela' => $parcela]);

    }

    // Eliminar parcela
    public function eliminar($id)
    {

        $datosPrevios = $this->parcelaModel->find($id);

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

        return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela eliminada correctamente.');
    }

    public function mapaJson()
    {
        $anio    = $this->request->getGet('anio');
        $cuartel = $this->request->getGet('cuartel');

        $builder = $this->parcelaModel
            ->select('parcelas.*, MAX(explotaciones.tipo_de_actividad) AS tipo_de_actividad')
            ->join('explotaciones', 'explotaciones.id_parcelas = parcelas.id', 'left');


        if ($datosPrevios && $this->parcelaModel->delete($id)) {
            // Registrar eliminación en audit_logs
            AuditLogger::log('parcelas', (int)$id, 'DELETE', $datosPrevios, null);

            return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela eliminada correctamente.');
        }

        return redirect()->to(base_url('parcelas'))->with('error', 'No se pudo eliminar la parcela.');
    }

}

}

}

