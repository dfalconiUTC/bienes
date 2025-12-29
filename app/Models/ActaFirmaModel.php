<?php
namespace App\Models;
use CodeIgniter\Model;

class ActaFirmaModel extends Model
{
    protected $table = 'acta_firmas';
    protected $primaryKey = 'id_firma';
    protected $allowedFields = ['acta_id', 'titulo', 'nombre', 'cedula', 'cargo', 'orden'];
}