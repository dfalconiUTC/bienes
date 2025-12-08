<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermisoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'))->with('error', 'Debe iniciar sesión para acceder.');
        }

        $accesoPermitido = false;

        foreach ($arguments as $permisoRequerido) {
            if (service('auth')->tienePermiso($permisoRequerido)) {
                $accesoPermitido = true;
                break;
            }
        }

        if (!$accesoPermitido) {
            session()->destroy();
            return redirect()->to(site_url('login'))->with('error', 'Acceso denegado. Sus permisos han cambiado o son insuficientes para la acción solicitada. Vuelva a ingresar.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}