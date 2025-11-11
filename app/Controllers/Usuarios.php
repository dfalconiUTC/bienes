<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('usuarios/index', $data);
    }

    public function create()
    {
        return view('usuarios/create');
    }

    public function store()
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'usuario' => $this->request->getPost('usuario'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => $this->request->getPost('rol'),
            'estado' => $this->request->getPost('estado'),
        ];

        $this->usuarioModel->insert($data);

        return redirect()->to(site_url('usuarios'))
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $data['usuario'] = $this->usuarioModel->find($id);
        return view('usuarios/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'usuario' => $this->request->getPost('usuario'),
            'rol' => $this->request->getPost('rol'),
            'estado' => $this->request->getPost('estado'),
        ];

        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);

        return redirect()->to(site_url('usuarios'))
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        return redirect()->to(site_url('usuarios'))
            ->with('success', 'Usuario eliminado correctamente.');
    }
}