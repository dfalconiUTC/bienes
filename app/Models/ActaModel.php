<?php
namespace App\Models;
use CodeIgniter\Model;

class ActaModel extends Model
{
    protected $table = 'actas';
    protected $primaryKey = 'id_acta';
    protected $allowedFields = [
        'tipo',
        'numero_acta',
        'titulo',
        'periodo',
        'fecha_impresion',
        'encabezado_lugar',
        'compareciente_nombre',
        'receptor_nombre',
        'introduccion_texto',
        'observaciones_finales',
        'estado'
    ];
    protected $useTimestamps = true;
}