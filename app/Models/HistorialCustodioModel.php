<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialCustodioModel extends Model
{
    protected $table = 'historial_custodios';
    protected $primaryKey = 'id_historial';
    protected $allowedFields = [
        'bien_id',
        'custodio_id',
        'fecha_inicio',
        'fecha_fin',
        'observaciones'
    ];

    protected $useTimestamps = false;

    public function getHistorialConDetalles()
    {
        return $this->select('historial_custodios.*, 
                              b.nombre_bien, b.codigo_bien,
                              c.nombre AS custodio, c.tipo AS tipo_custodio')
            ->join('bienes b', 'b.id_bien = historial_custodios.bien_id', 'left')
            ->join('custodios c', 'c.id_custodio = historial_custodios.custodio_id', 'left')
            ->orderBy('fecha_inicio', 'DESC')
            ->findAll();
    }
}