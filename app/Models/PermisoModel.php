<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['clave', 'nombre_permiso', 'modulo'];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    public function getPermisosAgrupados()
    {
        return $this->findAll();
    }
}