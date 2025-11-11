<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión para continuar.');
        }

        // Si solo el administrador puede acceder:
        if (isset($arguments[0]) && $arguments[0] === 'admin') {
            if ($session->get('rol') !== 'admin') {
                return redirect()->to('/login')->with('error', 'Acceso restringido solo para administradores.');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}