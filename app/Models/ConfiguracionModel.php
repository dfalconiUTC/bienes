<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion_sistema';
    protected $primaryKey = 'id_config';
    protected $allowedFields = [
        'responsable_bienes_nombre',
        'responsable_bienes_cedula',
        'asignado_ud_nombre',
        'asignado_ud_cedula',
        'rector_nombre',
        'rector_cedula'
    ];
}