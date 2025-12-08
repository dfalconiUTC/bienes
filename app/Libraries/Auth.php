<?php

namespace App\Libraries;

use App\Models\RolPermisoModel;

class Auth
{
    protected $rolPermisoModel;
    protected $permisosUsuario = null;
    protected $idRolUsuario;

    public function __construct()
    {
        $this->rolPermisoModel = new RolPermisoModel();

        $this->idRolUsuario = session()->get('id_rol');
    }

    protected function loadPermisos()
    {
        if ($this->permisosUsuario === null && $this->idRolUsuario) {
            if ($this->idRolUsuario == 1) {
                $this->permisosUsuario = ['*'];
                return;
            }

            $this->permisosUsuario = $this->rolPermisoModel->getPermisosByRolId($this->idRolUsuario);
        }
    }

    public function tienePermiso(string $clavePermiso): bool
    {
        if (empty($this->idRolUsuario)) {
            return false;
        }

        $this->loadPermisos();

        if (in_array('*', $this->permisosUsuario) || in_array($clavePermiso, $this->permisosUsuario)) {
            return true;
        }

        return false;
    }

    public function findFirstPermittedRoute(): string
    {
        $this->loadPermisos();
        $permisosMap = [
            'procedencias.view' => 'procedencias',
            'ubicaciones.view' => 'ubicaciones',
            'custodios.view' => 'custodios',
            'bienes.view' => 'bienes',
            'bienes.view_own' => 'bienes',
            'reportes.view' => 'reportes',
            'historial.view' => 'historial',
            'config.manage' => 'configuracion',
            'users.manage' => 'usuarios',
        ];

        if ($this->tienePermiso('dashboard.view')) {
            return site_url('dashboard');
        }

        foreach ($permisosMap as $permisoClave => $ruta) {
            if ($this->tienePermiso($permisoClave)) {
                return site_url($ruta);
            }
        }

        return site_url('logout');
    }
}