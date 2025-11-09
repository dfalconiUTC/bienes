<?php

namespace App\Models;

use CodeIgniter\Model;

class CustodioModel extends Model
{
    protected $table = 'custodios';
    protected $primaryKey = 'id_custodio';
    protected $allowedFields = [
        'nombre',
        'tipo',
        'departamento',
        'correo',
        'telefono'
    ];

    protected $useTimestamps = false;
}