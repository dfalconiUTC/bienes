<?php

namespace App\Controllers;

use App\Models\RolModel;
use App\Models\PermisoModel;
use App\Models\RolPermisoModel;

class Roles extends BaseController
{
    protected $rolModel;
    protected $permisoModel;
    protected $rolPermisoModel;

    public function __construct()
    {
        $this->rolModel = new RolModel();
        $this->permisoModel = new PermisoModel();
        $this->rolPermisoModel = new RolPermisoModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gestión de Roles y Permisos',
            'roles' => $this->rolModel->findAll(),
        ];
        return view('roles/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Crear Nuevo Rol';
        return view('roles/create', $data);
    }


    public function store()
    {
        $nombre = $this->request->getPost('nombre_rol');
        $descripcion = $this->request->getPost('descripcion');

        $slug = url_title($nombre, '_', true);

        $data = [
            'nombre_rol' => $nombre,
            'slug' => $slug,
            'descripcion' => $descripcion,
        ];

        try {
            $this->rolModel->insert($data);
            return redirect()->to('roles')->with('success', 'Rol "' . $nombre . '" creado exitosamente. ¡Asigne permisos!');
        } catch (\ReflectionException $e) {
            return redirect()->back()->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    public function edit(int $id_rol)
    {
        $rol = $this->rolModel->find($id_rol);

        if (!$rol) {
            return redirect()->to('roles')->with('error', 'Rol no encontrado.');
        }

        $permisosRaw = $this->permisoModel->findAll();

        $permisosAgrupados = [];
        foreach ($permisosRaw as $permiso) {
            $modulo = $permiso['modulo'] ?? 'Sin Módulo';
            $permisosAgrupados[$modulo][] = $permiso;
        }

        $permisosAsignados = $this->rolPermisoModel->getPermisosByRolId($id_rol);

        $data = [
            'title' => 'Asignar Permisos a: ' . $rol['nombre_rol'],
            'rol' => $rol,
            'permisos_agrupados' => $permisosAgrupados,
            'permisos_asignados' => $permisosAsignados,
        ];

        return view('roles/edit', $data);
    }

    public function update(int $id_rol)
    {
        $permisosClaves = $this->request->getPost('permisos') ?? [];

        if (!$this->rolModel->find($id_rol)) {
            return redirect()->to('roles')->with('error', 'Rol no encontrado.');
        }
        $permisoModel = new PermisoModel();
        if (!empty($permisosClaves)) {
            $permisosSeleccionados = $permisoModel->whereIn('clave', $permisosClaves)->findAll();
            $idsParaGuardar = array_column($permisosSeleccionados, 'id_permiso');
        } else {
            $idsParaGuardar = [];
        }


        if ($this->rolPermisoModel->syncPermisos($id_rol, $idsParaGuardar)) {
            return redirect()->to('roles')->with('success', 'Permisos actualizados correctamente para el rol.');
        } else {
            return redirect()->back()->with('error', 'Error al guardar los permisos. Intente de nuevo.');
        }
    }
}