<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel
            ->select('usuarios.*, r.nombre_rol')
            ->join('roles r', 'r.id_rol = usuarios.rol_id')
            ->findAll();

        $data['title'] = 'Administración de Usuarios';
        return view('usuarios/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->rolModel->findAll();
        return view('usuarios/create', $data);
    }

    public function store()
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'usuario' => $this->request->getPost('usuario'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol_id' => $this->request->getPost('rol_id'),
            'estado' => $this->request->getPost('estado'),
        ];


        $this->usuarioModel->insert($data);

        return redirect()->to(site_url('usuarios'))
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $auth = service('auth');
        $id_usuario_actual = session('id_usuario');
        if ($id != $id_usuario_actual && !$auth->tienePermiso('users.manage')) {
            session()->destroy();
            return redirect()->to('login')->with('error', 'No tiene permisos para editar la cuenta de otro usuario.');
        }

        $data['usuario'] = $this->usuarioModel->find($id);
        $data['roles'] = $this->rolModel->findAll();
        $data['es_gestion_total'] = $auth->tienePermiso('users.manage');

        $data['title'] = 'Editar Usuario';
        return view('usuarios/edit', $data);
    }

    public function update($id)
    {
        $auth = service('auth');
        $id_usuario_actual = session('id_usuario');

        if ($id != $id_usuario_actual && !$auth->tienePermiso('users.manage')) {
            session()->destroy();
            return redirect()->to('login')->with('error', 'Intento de modificar un recurso no autorizado.');
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'usuario' => $this->request->getPost('usuario'),
        ];

        if ($auth->tienePermiso('users.manage')) {
            $data['rol_id'] = $this->request->getPost('rol_id');
            $data['estado'] = $this->request->getPost('estado');
        }

        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);
        if (session('id_usuario') == $id) {
            session()->set('nombre', $data['nombre']);
        }

        return redirect()->to(site_url($auth->tienePermiso('users.manage') ? 'usuarios' : 'usuarios/edit/' . $id))
            ->with('success', $auth->tienePermiso('users.manage') ? 'Usuario actualizado correctamente.' : 'Cuenta actualizada correctamente.');
    }

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        return redirect()->to(site_url('usuarios'))
            ->with('success', 'Usuario eliminado correctamente.');
    }
}