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

    // Listado general de parcelas (para administradores / gestores)
    public function index()
    {
        $parcelas = $this->parcelaModel->conExplotacion();

        // Superficies reales (sin Cuartel 1) para las tarjetas de resumen
        $total = $recria = $urbano = $agricola = 0.0;
        foreach ($parcelas as $x) {
            $num = trim(str_ireplace('cuartel', '', (string) ($x['cuartel'] ?? '')));
            if ($num === '1' || strtolower($num) === 'i') {
                continue;
            }
            $sup = (float) ($x['superficie'] ?? 0);
            $act = strtr(mb_strtolower((string) ($x['actividad'] ?? ''), 'UTF-8'), ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u']);
            $total += $sup;
            if (str_contains($act, 'urbano')) {
                $urbano += $sup;
            } elseif (str_contains($act, 'mixt')) {
                // las explotaciones mixtas no se suman a agrícola ni a ganadería
            } elseif (str_contains($act, 'agric')) {
                $agricola += $sup;
            } elseif (str_contains($act, 'ganader')) {
                $recria += $sup;
            }
        }

        $data = [
            'titulo'          => 'Gestión de Parcelas',
            'parcelas'        => $parcelas,
            'superficie_total' => $total,
            'sup_recria'      => $recria,
            'sup_urbano'      => $urbano,
            'sup_agricola'    => $agricola,
        ];

        return view('parcelas/index', $data);
    }

    // Listado de parcelas exclusivo para el usuario cliente
    public function misParcelas()
    {
        $data = [
            'titulo'   => 'Mis Parcelas',
            'parcelas' => $this->parcelaModel->conExplotacion(true) // true = sin Cuartel 1 (casco urbano)
        ];

        return view('parcelas/mis_parcelas', $data);
    }

    // Método para mostrar las parcelas agrupadas por cuartel (Panel de Administración)
    public function cuarteles()
    {
        $data = [
            'titulo'   => 'Parcelas Agrupadas por Cuartel',
            'parcelas' => $this->parcelaModel->conExplotacion(true), // true = sin Cuartel 1 (casco urbano)
            'usuario'  => session()->get('usuario'),
            'rol'      => session()->get('rol')
        ];

        return view('parcelas/cuarteles_detallados', $data);
    }

    // Campo numérico opcional: vacío se guarda como NULL (evita errores de decimal con '')
    private function valorOpcional(string $campo)
    {
        $v = $this->request->getPost($campo);
        return ($v === null || trim((string) $v) === '') ? null : $v;
    }

    // JSON para el mapa (sin Cuartel 1, con la actividad de la explotación)
    public function mapaJson()
    {
        return $this->response->setJSON($this->parcelaModel->conExplotacion(true));
    }

    // Detalle de una parcela
    public function ver($id = null)
    {
        $parcela = $this->parcelaModel->conExplotacionPorId((int) $id);

        if (!$parcela) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("No se encontró la parcela con ID: $id");
        }

        return view('parcelas/ver', ['titulo' => 'Detalle de Parcela', 'parcela' => $parcela]);
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
            'superficie'        => $this->valorOpcional('superficie'),
            'actividad'         => $this->request->getPost('actividad'),
            'latitud'           => $this->request->getPost('latitud'),
            'longitud'          => $this->request->getPost('longitud'),
            'anio_relevamiento' => $this->valorOpcional('anio_relevamiento'),
        ];

        if ($this->parcelaModel->insert($nuevaParcela)) {
            $nuevoId = $this->parcelaModel->getInsertID();

            // Registrar inserción en audit_logs
            AuditLogger::log('parcelas', $nuevoId, 'INSERT', null, $nuevaParcela);

            return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela creada correctamente.');
        } else {
            log_message('error', 'No se pudo insertar la parcela: ' . json_encode($this->parcelaModel->errors()));

            return redirect()->back()->withInput()->with('error', 'No se pudo guardar la parcela. Revisá los datos e intentá de nuevo.');
        }
    }

    // Mostrar formulario de edición y procesar actualización
    public function editar($id = null)
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
                'superficie'        => $this->valorOpcional('superficie'),
                'propietario'       => $this->request->getPost('propietario'),
                'actividad'         => $this->request->getPost('actividad'),
                'cuartel'           => $this->request->getPost('cuartel'),
                'anio_relevamiento' => $this->valorOpcional('anio_relevamiento'),
            ];

            if ($this->parcelaModel->update($id, $datosNuevos)) {
                // Registrar actualización en audit_logs
                AuditLogger::log('parcelas', (int)$id, 'UPDATE', $datosPrevios, $datosNuevos);

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
    }

    // Eliminar parcela
    public function eliminar($id)
    {
        $datosPrevios = $this->parcelaModel->find($id);

        if ($datosPrevios && $this->parcelaModel->delete($id)) {
            // Registrar eliminación en audit_logs
            AuditLogger::log('parcelas', (int)$id, 'DELETE', $datosPrevios, null);

            return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela eliminada correctamente.');
        }

        return redirect()->to(base_url('parcelas'))->with('error', 'No se pudo eliminar la parcela.');
    }
}