<?php
namespace App\Models;
use CodeIgniter\Model;

class ActaDetalleModel extends Model
{
    protected $table = 'acta_detalles';
    protected $primaryKey = 'id_detalle';
    protected $allowedFields = ['acta_id', 'bien_id', 'observacion'];
}