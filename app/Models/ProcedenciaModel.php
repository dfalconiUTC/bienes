<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcedenciaModel extends Model
{
    protected $table = 'procedencias';
    protected $primaryKey = 'id_procedencia';
    protected $allowedFields = [
        'nombre',
        'descripcion'
    ];

    protected $useTimestamps = false;
}