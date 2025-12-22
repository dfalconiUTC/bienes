<?php

namespace App\Controllers;

use App\Models\HistorialCustodioModel;
use App\Models\BienModel;
use App\Models\CustodioModel;
use CodeIgniter\I18n\Time;
use Throwable;

class Historial extends BaseController
{
    protected $historialModel;
    protected $bienModel;
    protected $custodioModel;

    public function __construct()
    {
        $this->historialModel = new HistorialCustodioModel();
        $this->bienModel = new BienModel();
        $this->custodioModel = new CustodioModel();
    }

    public function index()
    {
        $data['historial'] = $this->historialModel->getHistorialConDetalles();
        return view('historial/index', $data);
    }

    public function create($bien_id = null)
    {
        $bienes = $this->bienModel->findAll();
        $custodios = $this->custodioModel->findAll();

        $bienSeleccionado = null;
        $custodioActivo = null;

        if ($bien_id) {
            $bienSeleccionado = $this->bienModel->find($bien_id);

            if ($bienSeleccionado) {
                $custodioActivo = $this->historialModel
                    ->select('historial_custodios.*, custodios.nombre as nombre_custodio')
                    ->join('custodios', 'custodios.id_custodio = historial_custodios.custodio_id')
                    ->where('bien_id', $bien_id)
                    ->where('fecha_fin IS NULL')
                    ->orderBy('fecha_inicio', 'DESC')
                    ->first();
            }
        }

        $data = [
            'bienes' => $bienes,
            'custodios' => $custodios,
            'bienSeleccionado' => $bienSeleccionado,
            'custodioActivo' => $custodioActivo
        ];

        return view('historial/create', $data);
    }

    public function store()
    {
        try {
            $bien_id = $this->request->getPost('bien_id');
            $custodio_id = $this->request->getPost('custodio_id');
            $fecha_inicio = $this->request->getPost('fecha_inicio');
            $observaciones = $this->request->getPost('observaciones');

            if (empty($bien_id) || empty($custodio_id) || empty($fecha_inicio)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('warning', 'Por favor, complete todos los campos obligatorios.');
            }

            $historialActivo = $this->historialModel
                ->where('bien_id', $bien_id)
                ->where('fecha_fin IS NULL')
                ->first();

            if ($historialActivo) {
                $this->historialModel->update($historialActivo['id_historial'], [
                    'fecha_fin' => $fecha_inicio
                ]);
            }

            $this->historialModel->insert([
                'bien_id' => $bien_id,
                'custodio_id' => $custodio_id,
                'fecha_inicio' => $fecha_inicio,
                'observaciones' => $observaciones,
                'fecha_fin' => null
            ]);

            $this->bienModel->update($bien_id, [
                'custodio_actual_id' => $custodio_id
            ]);

            return redirect()
                ->to(site_url('historial'))
                ->with('success', 'Custodio asignado correctamente.');

        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $historial = $this->historialModel->select('h.*, 
                                                b.nombre_bien, b.codigo_bien,
                                                c.nombre AS custodio_receptor')
            ->from('historial_custodios h')
            ->join('bienes b', 'b.id_bien = h.bien_id', 'left')
            ->join('custodios c', 'c.id_custodio = h.custodio_id', 'left')
            ->where('h.id_historial', $id)
            ->first();

        if (!$historial) {
            return redirect()
                ->to(site_url('historial'))
                ->with('warning', 'El registro solicitado no existe.');
        }

        $data = [
            'historial' => $historial,
            'bienes' => $this->bienModel->findAll(),
            'custodios' => $this->custodioModel->findAll()
        ];

        $auth = service('auth');
        return view('historial/edit', $data);
    }

    public function update($id)
    {
        try {
            $dataToUpdate = [
                'aprobador_usuario_id' => session('id_usuario'),
                'fecha_aprobacion' => Time::now()->toDateTimeString(),
                'observaciones' => $this->request->getPost('observaciones'),
                'estado_acta' => $this->request->getPost('estado_acta')
            ];

            if (empty($dataToUpdate['fecha_fin'])) {
                $dataToUpdate['fecha_fin'] = null;
            }

            $this->historialModel->update($id, $dataToUpdate);

            return redirect()
                ->to('/historial')
                ->with('success', 'Registro actualizado correctamente.');
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
            $registro = $this->historialModel->find($id);
            if (!$registro) {
                return redirect()
                    ->to('/historial')
                    ->with('warning', 'El registro no existe o ya fue eliminado.');
            }

            $this->historialModel->delete($id);

            return redirect()
                ->to('/historial')
                ->with('success', 'Registro eliminado correctamente.');
        } catch (Throwable $e) {
            return redirect()
                ->to('/historial')
                ->with('error', 'No se pudo eliminar el registro: ' . $e->getMessage());
        }
    }

    public function activoPorBien($bienId)
    {
        $historial = $this->historialModel
            ->select('custodios.nombre')
            ->join('custodios', 'custodios.id_custodio = historial_custodios.custodio_id')
            ->where('bien_id', $bienId)
            ->where('fecha_fin IS NULL')
            ->first();

        if ($historial) {
            return $this->response->setJSON([
                'activo' => true,
                'custodio' => $historial['nombre']
            ]);
        }

        return $this->response->setJSON(['activo' => false]);
    }
}