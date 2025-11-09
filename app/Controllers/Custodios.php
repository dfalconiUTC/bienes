<?php

namespace App\Controllers;

use App\Models\CustodioModel;
use Exception;

class Custodios extends BaseController
{
    protected $custodioModel;

    public function __construct()
    {
        $this->custodioModel = new CustodioModel();
    }

    public function index()
    {
        $data['custodios'] = $this->custodioModel->findAll();
        return view('custodios/index', $data);
    }

    public function create()
    {
        return view('custodios/create');
    }

    public function store()
    {
        try {
            $this->custodioModel->insert($this->request->getPost());

            return redirect()
                ->to('/custodios')
                ->with('success', 'Custodio registrado correctamente.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'No se pudo registrar el custodio: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $custodio = $this->custodioModel->find($id);
        if (!$custodio) {
            return redirect()
                ->to('/custodios')
                ->with('error', 'El custodio no existe.');
        }

        return view('custodios/edit', ['custodio' => $custodio]);
    }

    public function update($id)
    {
        try {
            $this->custodioModel->update($id, $this->request->getPost());

            return redirect()
                ->to('/custodios')
                ->with('success', 'Custodio actualizado correctamente.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'No se pudo actualizar el custodio: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $custodio = $this->custodioModel->find($id);
            if (!$custodio) {
                return redirect()
                    ->to('/custodios')
                    ->with('error', 'El custodio no existe.');
            }

            $this->custodioModel->delete($id);

            return redirect()
                ->to('/custodios')
                ->with('success', 'Custodio eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()
                ->to('/custodios')
                ->with('error', 'No se pudo eliminar el custodio: ' . $e->getMessage());
        }
    }
}