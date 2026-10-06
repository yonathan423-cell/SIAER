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
            'padron'      => 'required',
            'propietario' => 'required|min_length[3]',
            'cuartel'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nuevaParcela = [
            'padron'      => $this->request->getPost('padron'),
            'propietario' => $this->request->getPost('propietario'),
            'cuartel'     => $this->request->getPost('cuartel'),
            'hectareas'   => $this->request->getPost('hectareas'),
            'uso_suelo'   => $this->request->getPost('uso_suelo'),
            'estado'      => $this->request->getPost('estado') ?? 'activo',
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

    // Actualizar parcela existente
    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $rules = [
            'padron'      => 'required',
            'propietario' => 'required|min_length[3]',
            'cuartel'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('mensaje', 'Error en la validación de los datos.');
        }

        $datosPrevios = $this->parcelaModel->find($id);

        $datosNuevos = [
            'padron'      => $this->request->getPost('padron'),
            'propietario' => $this->request->getPost('propietario'),
            'cuartel'     => $this->request->getPost('cuartel'),
            'hectareas'   => $this->request->getPost('hectareas'),
            'uso_suelo'   => $this->request->getPost('uso_suelo'),
            'estado'      => $this->request->getPost('estado'),
        ];

        if ($this->parcelaModel->update($id, $datosNuevos)) {
            // Registrar actualización en audit_logs
            AuditLogger::log('parcelas', (int)$id, 'UPDATE', $datosPrevios, $datosNuevos);

            return redirect()->to(base_url('parcelas'))->with('mensaje', 'Parcela actualizada correctamente.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo actualizar la parcela.');
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