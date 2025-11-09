<?php

namespace App\Models;

use CodeIgniter\Model;

class BienModel extends Model
{
    protected $table = 'bienes';
    protected $primaryKey = 'id_bien';
    protected $allowedFields = [
        'codigo_bien',
        'nombre_bien',
        'codigo_interno',
        'descripcion',
        'fecha_ingreso',
        'serie',
        'modelo',
        'marca',
        'color',
        'estado_bien',
        'cuenta_contable',
        'valor_contable',
        'procedencia_id',
        'ubicacion_id',
        'custodio_actual_id',
        'observaciones'
    ];

    protected $useTimestamps = false;

    public function getConRelaciones()
    {
        return $this->select('bienes.*, 
                              p.nombre AS procedencia, 
                              u.nombre AS ubicacion, 
                              u.campus AS campus,
                              c.nombre AS custodio_actual')
            ->join('procedencias p', 'p.id_procedencia = bienes.procedencia_id', 'left')
            ->join('ubicaciones u', 'u.id_ubicacion = bienes.ubicacion_id', 'left')
            ->join('custodios c', 'c.id_custodio = bienes.custodio_actual_id', 'left')
            ->findAll();
    }
}