<?php

namespace App\Models;

use CodeIgniter\Model;

class RolPermisoModel extends Model
{
    protected $table = 'rol_permiso';
    protected $primaryKey = ['rol_id', 'permiso_id'];
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['rol_id', 'permiso_id'];
    protected $useTimestamps = false;

    public function getPermisosByRolId(int $rolId): array
    {
        $permisos = $this->db->table($this->table)
            ->select('p.clave')
            ->join('permisos p', 'p.id_permiso = rol_permiso.permiso_id')
            ->where('rol_permiso.rol_id', $rolId)
            ->get()
            ->getResultArray();

        return array_column($permisos, 'clave');
    }

    public function syncPermisos(int $rolId, array $permisoIds): bool
    {
        $this->where('rol_id', $rolId)->delete();

        if (empty($permisoIds)) {
            return true;
        }

        $data = [];
        foreach ($permisoIds as $permisoId) {
            $data[] = [
                'rol_id' => $rolId,
                'permiso_id' => $permisoId
            ];
        }

        try {
            return $this->db->table($this->table)->insertBatch($data);
        } catch (\Exception $e) {
            log_message('error', 'Error al sincronizar permisos para el Rol ' . $rolId . ': ' . $e->getMessage());
            return false;
        }
    }
}