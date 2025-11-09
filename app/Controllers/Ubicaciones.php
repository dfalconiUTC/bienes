<?php

namespace App\Controllers;

use App\Models\UbicacionModel;
use Throwable;

class Ubicaciones extends BaseController
{
    protected $ubicacionModel;

    public function __construct()
    {
        $this->ubicacionModel = new UbicacionModel();
    }

    public function index()
    {
        $data['ubicaciones'] = $this->ubicacionModel->findAll();
        return view('ubicaciones/index', $data);
    }

    public function create()
    {
        return view('ubicaciones/create');
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

            $this->ubicacionModel->insert($data);

            return redirect()
                ->to(site_url('ubicaciones'))
                ->with('success', 'Ubicación registrada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ubicacion = $this->ubicacionModel->find($id);

        if (!$ubicacion) {
            return redirect()
                ->to(site_url('ubicaciones'))
                ->with('warning', 'La ubicación solicitada no existe.');
        }

        $data['ubicacion'] = $ubicacion;
        return view('ubicaciones/edit', $data);
    }

    public function update($id)
    {
        try {
            $ubicacion = $this->ubicacionModel->find($id);

            if (!$ubicacion) {
                return redirect()
                    ->to(site_url('ubicaciones'))
                    ->with('warning', 'La ubicación no existe o fue eliminada.');
            }

            $this->ubicacionModel->update($id, $this->request->getPost());

            return redirect()
                ->to(site_url('ubicaciones'))
                ->with('success', 'Ubicación actualizada correctamente.');
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
            $ubicacion = $this->ubicacionModel->find($id);

            if (!$ubicacion) {
                return redirect()
                    ->to(site_url('ubicaciones'))
                    ->with('warning', 'La ubicación no existe o ya fue eliminada.');
            }

            $this->ubicacionModel->delete($id);

            return redirect()
                ->to(site_url('ubicaciones'))
                ->with('success', 'Ubicación eliminada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('ubicaciones'))
                ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}