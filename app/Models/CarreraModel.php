<?php

namespace App\Models;

use CodeIgniter\Model;

class CarreraModel extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id_carrera';
    protected $allowedFields = ['nombre', 'coordinador_id'];

    public function getCarrerasConCoordinador()
    {
        return $this->select('carreras.*, c.nombre as nombre_coordinador')
            ->join('custodios c', 'c.id_custodio = carreras.coordinador_id', 'left')
            ->findAll();
    }
}