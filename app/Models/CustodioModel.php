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
        'es_docente',
        'carrera_id',
        'departamento',
        'correo',
        'telefono',
        'jefe_inmediato_id',
        'usuario_id',
    ];

    protected $useTimestamps = false;

    public function obtenerJefeReal($id_custodio)
    {
        $custodio = $this->find($id_custodio);

        if (!$custodio)
            return null;

        if ($custodio['es_docente'] == 1 && !empty($custodio['carrera_id'])) {
            $db = \Config\Database::connect();
            $carrera = $db->table('carreras')
                ->select('coordinador_id')
                ->where('id_carrera', $custodio['carrera_id'])
                ->get()->getRowArray();

            return $carrera ? $carrera['coordinador_id'] : null;
        }

        return $custodio['jefe_inmediato_id'];
    }
}