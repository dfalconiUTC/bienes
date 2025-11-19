<?php

namespace App\Controllers;

use App\Models\BienModel;
use App\Models\HistorialCustodioModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bienModel = new BienModel();
        $historial = new HistorialCustodioModel();

        /* ============================
            1. INDICADORES PRINCIPALES
        ============================= */
        $total_bienes = $bienModel->countAll();
        $bienes_activos = $bienModel->where('estado_bien', 'De baja')->countAllResults();
        $bienes_sin_custodio = $bienModel->where('custodio_actual_id', null)->countAllResults();
        $valor_total = $bienModel->selectSum('valor_contable')->first()['valor_contable'] ?? 0;


        /* ============================
            2. GRÁFICO: BIENES POR ESTADO
        ============================= */
        $labels_estados = ['Nuevo', 'Usado', 'Dañado', 'De baja'];

        $data_estados = [
            $bienModel->where('estado_bien', 'Nuevo')->countAllResults(),
            $bienModel->where('estado_bien', 'Usado')->countAllResults(),
            $bienModel->where('estado_bien', 'Dañado')->countAllResults(),
            $bienModel->where('estado_bien', 'De baja')->countAllResults(),
        ];


        /* ======================================
            3. GRÁFICO: BIENES POR UBICACIÓN
           ====================================== */
        $ubicacionData = $bienModel
            ->select('u.nombre AS nombre_ubicacion, COUNT(*) AS total')
            ->join('ubicaciones u', 'u.id_ubicacion = bienes.ubicacion_id', 'left')
            ->groupBy('u.id_ubicacion')
            ->orderBy('total', 'DESC')
            ->findAll();

        $labels_ubicacion = array_map(fn($x) => $x['nombre_ubicacion'] ?? 'Sin ubicación', $ubicacionData);
        $data_ubicacion = array_column($ubicacionData, 'total');


        /* ======================================
            4. GRÁFICO: BIENES POR PROCEDENCIA
           ====================================== */
        $procedenciaData = $bienModel
            ->select('p.nombre AS nombre_procedencia, COUNT(*) AS total')
            ->join('procedencias p', 'p.id_procedencia = bienes.procedencia_id', 'left')
            ->groupBy('p.id_procedencia')
            ->orderBy('total', 'DESC')
            ->findAll();

        $labels_procedencia = array_map(fn($x) => $x['nombre_procedencia'] ?? 'Sin procedencia', $procedenciaData);
        $data_procedencia = array_column($procedenciaData, 'total');


        /* ======================================
            5. TOP 5 CUSTODIOS
        ======================================= */
        $top_custodios = $historial
            ->select('c.nombre, COUNT(*) AS total')
            ->join('custodios c', 'c.id_custodio = historial_custodios.custodio_id', 'left')
            ->where('historial_custodios.fecha_fin', null)
            ->groupBy('c.id_custodio')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->findAll();



        /* ======================================
            7. RETORNAR A LA VISTA
        ======================================= */
        return view('dashboard', [
            'total_bienes' => $total_bienes,
            'bienes_activos' => $bienes_activos,
            'bienes_sin_custodio' => $bienes_sin_custodio,
            'valor_total' => $valor_total,

            // Estados
            'labels_estados' => $labels_estados,
            'data_estados' => $data_estados,

            // Ubicaciones
            'labels_ubicacion' => $labels_ubicacion,
            'data_ubicacion' => $data_ubicacion,

            // Procedencias
            'labels_procedencia' => $labels_procedencia,
            'data_procedencia' => $data_procedencia,

            // Custodios
            'top_custodios' => $top_custodios,

        ]);
    }
}