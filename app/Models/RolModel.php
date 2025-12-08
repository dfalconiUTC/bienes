<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre_rol', 'slug', 'descripcion'];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
}