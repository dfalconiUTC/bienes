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
        'observaciones',
        'estado_acta',
        'aprobador_usuario_id',
        'fecha_aprobacion'
    ];

    protected $useTimestamps = false;

    public function getHistorialConDetalles()
    {
        return $this->select('historial_custodios.*, 
                              b.nombre_bien, b.codigo_bien, b.id_bien,
                              c.nombre AS custodio, c.tipo AS tipo_custodio')
            ->join('bienes b', 'b.id_bien = historial_custodios.bien_id', 'left')
            ->join('custodios c', 'c.id_custodio = historial_custodios.custodio_id', 'left')
            ->orderBy('(fecha_fin IS NOT NULL)', 'ASC')
            ->orderBy('fecha_inicio', 'DESC')
            ->orderBy('b.codigo_bien', 'ASC')
            ->findAll();
    }

    public function getActasConTodosLosEstados()
    {
        return $this->select('h.*, b.codigo_bien, b.nombre_bien, 
                          c.nombre AS custodio_receptor, 
                          u.nombre AS aprobador_nombre')
            ->from('historial_custodios h')
            ->join('bienes b', 'b.id_bien = h.bien_id')
            ->join('custodios c', 'c.id_custodio = h.custodio_id')
            ->join('usuarios u', 'u.id_usuario = h.aprobador_usuario_id', 'left')
            ->findAll();
    }

}