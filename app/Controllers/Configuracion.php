<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;

class Configuracion extends BaseController
{
    private $configModel;

    public function __construct()
    {
        $this->configModel = new ConfiguracionModel();
    }

    public function index()
    {
        $config = $this->configModel->first();

        return view('configuracion/index', [
            'config' => $config
        ]);
    }

    public function guardar()
    {
        $data = [
            'responsable_bienes_nombre' => $this->request->getPost('responsable_bienes_nombre'),
            'responsable_bienes_cedula' => $this->request->getPost('responsable_bienes_cedula'),
            'asignado_ud_nombre' => $this->request->getPost('asignado_ud_nombre'),
            'asignado_ud_cedula' => $this->request->getPost('asignado_ud_cedula'),
            'rector_nombre' => $this->request->getPost('rector_nombre'),
            'rector_cedula' => $this->request->getPost('rector_cedula'),
        ];

        // Consultar si ya existe configuración
        $config = $this->configModel->first();

        if ($config) {
            // actualizar
            $this->configModel->update($config['id_config'], $data);
            $msg = 'Configuración actualizada exitosamente.';
        } else {
            // insertar
            $this->configModel->insert($data);
            $msg = 'Configuración registrada exitosamente.';
        }

        return redirect()
            ->to(site_url('configuracion'))
            ->with('success', $msg);
    }
}