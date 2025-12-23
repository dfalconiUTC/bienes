<?php

namespace App\Controllers;

use App\Models\CarreraModel;
use App\Models\CustodioModel;
use Throwable;

class Carreras extends BaseController
{
    protected $carreraModel;
    protected $custodioModel;

    public function __construct()
    {
        $this->carreraModel = new CarreraModel();
        $this->custodioModel = new CustodioModel();
    }

    public function index()
    {
        $data['carreras'] = $this->carreraModel
            ->select('carreras.*, c.nombre as nombre_coordinador')
            ->join('custodios c', 'c.id_custodio = carreras.coordinador_id', 'left')
            ->findAll();

        return view('carreras/index', $data);
    }

    public function create()
    {
        $data['custodios'] = $this->custodioModel->findAll();
        return view('carreras/create', $data);
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

            $this->carreraModel->insert($data);

            return redirect()
                ->to(site_url('carreras'))
                ->with('success', 'Carrera registrada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $carrera = $this->carreraModel->find($id);

        if (!$carrera) {
            return redirect()
                ->to(site_url('carreras'))
                ->with('warning', 'La carrera solicitada no existe.');
        }

        $data['carrera'] = $carrera;
        $data['custodios'] = $this->custodioModel->findAll();

        return view('carreras/edit', $data);
    }

    public function update($id)
    {
        try {
            $carrera = $this->carreraModel->find($id);

            if (!$carrera) {
                return redirect()
                    ->to(site_url('carreras'))
                    ->with('warning', 'La carrera no existe o fue eliminada.');
            }

            $this->carreraModel->update($id, $this->request->getPost());

            return redirect()
                ->to(site_url('carreras'))
                ->with('success', 'Carrera actualizada correctamente.');
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
            $carrera = $this->carreraModel->find($id);

            if (!$carrera) {
                return redirect()
                    ->to(site_url('carreras'))
                    ->with('warning', 'La carrera no existe o ya fue eliminada.');
            }

            $this->carreraModel->delete($id);

            return redirect()
                ->to(site_url('carreras'))
                ->with('success', 'Carrera eliminada correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('carreras'))
                ->with('error', 'No se pudo eliminar (posiblemente tenga registros asociados): ' . $e->getMessage());
        }
    }
}