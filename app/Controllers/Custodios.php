<?php

namespace App\Controllers;

use App\Models\CustodioModel;
use App\Models\UsuarioModel;
use App\Models\CarreraModel;
use Exception;

class Custodios extends BaseController
{
    protected $custodioModel;
    protected $usuarioModel;
    protected $carrerasModel;

    public function __construct()
    {
        $this->custodioModel = new CustodioModel();
        $this->usuarioModel = new UsuarioModel();
        $this->carrerasModel = new CarreraModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('custodios c');

        // AGREGAMOS ', false' AL FINAL DEL SELECT
        $builder->select('
            c.*, 
            car.nombre as carrera_nombre,
            CASE 
                WHEN c.es_docente = 1 THEN coord.nombre 
                ELSE j.nombre 
            END as jefe_real_nombre
        ', false); // <--- ¡ESTO ES LO IMPORTANTE!

        // 1. Join para el Jefe Manual (Administrativos)
        $builder->join('custodios j', 'j.id_custodio = c.jefe_inmediato_id', 'left');

        // 2. Join para conectar con la Carrera (Docentes)
        $builder->join('carreras car', 'car.id_carrera = c.carrera_id', 'left');

        // 3. Join para obtener el nombre del Coordinador de esa carrera
        $builder->join('custodios coord', 'coord.id_custodio = car.coordinador_id', 'left');

        $query = $builder->get();

        $data['custodios'] = $query->getResultArray();

        return view('custodios/index', $data);
    }

    public function create()
    {
        $data['custodios'] = $this->custodioModel->findAll();
        $data['carreras'] = $this->carrerasModel->getCarrerasConCoordinador();
        return view('custodios/create', $data);
    }

    public function store()
    {
        try {
            $db = \Config\Database::connect();

            $custodioRol = $db->table('roles')->select('id_rol')->where('slug', 'custodio')->get()->getRowArray();
            $rolIdCustodio = $custodioRol['id_rol'] ?? 0;

            $usuarioData = [
                'nombre' => $this->request->getPost('nombre'),
                'correo' => $this->request->getPost('correo'),
                'usuario' => $this->request->getPost('usuario'),
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'rol_id' => $rolIdCustodio,
                'estado' => 'activo',
            ];

            $usuarioId = $this->usuarioModel->insert($usuarioData, true);

            if (!$usuarioId) {
                throw new Exception("Error al crear usuario.");
            }

            $tipo = $this->request->getPost('tipo');

            $esDocente = ($tipo === 'Docente') ? 1 : 0;

            $carreraId = $this->request->getPost('carrera_id');
            $jefeId = $this->request->getPost('jefe_inmediato_id');

            $custodioData = [
                'usuario_id' => $usuarioId,
                'nombre' => $this->request->getPost('nombre'),
                'tipo' => $tipo,
                'departamento' => $this->request->getPost('departamento'),
                'correo' => $this->request->getPost('correo'),
                'telefono' => $this->request->getPost('telefono'),
                'es_docente' => $esDocente,
                'carrera_id' => ($esDocente == 1 && !empty($carreraId)) ? $carreraId : null,
                'jefe_inmediato_id' => ($esDocente == 0 && !empty($jefeId)) ? $jefeId : null,
            ];

            $this->custodioModel->insert($custodioData);

            return redirect()->to('/custodios')->with('success', 'Custodio registrado correctamente.');

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $custodio = $this->custodioModel->find($id);
        if (!$custodio) {
            return redirect()->to('/custodios')->with('error', 'Custodio no encontrado');
        }

        $data['custodios'] = $this->custodioModel->findAll();
        $data['carreras'] = $this->carrerasModel->getCarrerasConCoordinador();
        $data['custodio'] = $custodio;

        return view('custodios/edit', $data);
    }

    public function update($id)
    {
        try {
            $tipo = $this->request->getPost('tipo');
            $esDocente = ($tipo === 'Docente') ? 1 : 0;

            $carreraId = $this->request->getPost('carrera_id');
            $jefeId = $this->request->getPost('jefe_inmediato_id');

            $custodioData = [
                'nombre' => $this->request->getPost('nombre'),
                'tipo' => $tipo,
                'departamento' => $this->request->getPost('departamento'),
                'correo' => $this->request->getPost('correo'),
                'telefono' => $this->request->getPost('telefono'),

                'es_docente' => $esDocente,

                'carrera_id' => ($esDocente == 1 && !empty($carreraId)) ? $carreraId : null,
                'jefe_inmediato_id' => ($esDocente == 0 && !empty($jefeId)) ? $jefeId : null,
            ];

            $this->custodioModel->update($id, $custodioData);

            return redirect()->to('/custodios')->with('success', 'Custodio actualizado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {

            $this->custodioModel->delete($id);
            return redirect()->to('/custodios')->with('success', 'Custodio eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()->to('/custodios')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}