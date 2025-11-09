<?php

namespace App\Models;

use CodeIgniter\Model;

class UbicacionModel extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    protected $allowedFields = [
        'nombre',
        'campus',
        'descripcion'
    ];

    protected $useTimestamps = false;
}