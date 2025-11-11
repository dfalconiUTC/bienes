<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login()
    {
        // Si ya está logueado, redirige
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $user = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->where('usuario', $user)->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        if ($usuario['estado'] !== 'activo') {
            return redirect()->back()->with('error', 'Usuario inactivo.');
        }

        if (!password_verify($password, $usuario['password_hash'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        // Guardar sesión
        $sessionData = [
            'id_usuario' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'correo' => $usuario['correo'],
            'rol' => $usuario['rol'],
            'isLoggedIn' => true
        ];

        session()->set($sessionData);
        return redirect()->to('/dashboard')->with('success', 'Bienvenido al sistema.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}