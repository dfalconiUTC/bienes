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

        if (empty($arguments)) {
            return;
        }

        $auth = service('auth');

        $accesoPermitido = false;

        foreach ($arguments as $permisoRequerido) {
            if ($auth->tienePermiso($permisoRequerido)) {
                $accesoPermitido = true;
                break;
            }
        }

        if (!$accesoPermitido) {
            return redirect()->to(site_url('/'))->with('error', 'Acceso denegado. No tiene los permisos necesarios.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}