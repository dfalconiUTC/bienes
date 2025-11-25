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
        $db = \Config\Database::connect();

        $builder = $db->table('custodios c');
        $builder->select('c.*, j.nombre AS jefe_nombre');
        $builder->join('custodios j', 'j.id_custodio = c.jefe_inmediato_id', 'left');

        $query = $builder->get();

        $data['custodios'] = $query->getResultArray();

        return view('custodios/index', $data);
    }


    public function create()
    {
        $data['custodios'] = $this->custodioModel->findAll();
        return view('custodios/create', $data);
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
        $data['custodios'] = $this->custodioModel->findAll();
        $data['custodio'] = $custodio;

        return view('custodios/edit', $data);
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