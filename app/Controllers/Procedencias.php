<?php

namespace App\Controllers;

use App\Models\ProcedenciaModel;
use Throwable;

class Procedencias extends BaseController
{
    protected $procedenciaModel;

    public function __construct()
    {
        $this->procedenciaModel = new ProcedenciaModel();
    }

    public function index()
    {
        $data['procedencias'] = $this->procedenciaModel->findAll();
        return view('procedencias/index', $data);
    }

    public function create()
    {
        return view('procedencias/create');
    }

    public function store()
    {
        try {
            $data = $this->request->getPost();

            if (empty($data['nombre'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('warning', 'El campo nombre es obligatorio.');
            }

            $this->procedenciaModel->insert($data);

            return redirect()
                ->to(site_url('procedencias'))
                ->with('success', 'Procedencia registrada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $procedencia = $this->procedenciaModel->find($id);

        if (!$procedencia) {
            return redirect()
                ->to(site_url('procedencias'))
                ->with('warning', 'La procedencia solicitada no existe.');
        }

        $data['procedencia'] = $procedencia;
        return view('procedencias/edit', $data);
    }

    public function update($id)
    {
        try {
            $procedencia = $this->procedenciaModel->find($id);

            if (!$procedencia) {
                return redirect()
                    ->to(site_url('procedencias'))
                    ->with('warning', 'La procedencia no existe o fue eliminada.');
            }

            $this->procedenciaModel->update($id, $this->request->getPost());

            return redirect()
                ->to(site_url('procedencias'))
                ->with('success', 'Procedencia actualizada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $procedencia = $this->procedenciaModel->find($id);

            if (!$procedencia) {
                return redirect()
                    ->to(site_url('procedencias'))
                    ->with('warning', 'La procedencia no existe o ya fue eliminada.');
            }

            $this->procedenciaModel->delete($id);

            return redirect()
                ->to(site_url('procedencias'))
                ->with('success', 'Procedencia eliminada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('procedencias'))
                ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}