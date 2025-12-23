<?php

namespace App\Controllers;

use App\Models\CustodioModel;
use App\Models\UsuarioModel;
use App\Models\CarreraModel;
use App\Models\HistorialCustodioModel;
use App\Models\BienModel;
use Exception;

class Custodios extends BaseController
{
    protected $custodioModel;
    protected $usuarioModel;
    protected $carrerasModel;
    protected $historialModel;
    protected $bienModel;

    public function __construct()
    {
        $this->custodioModel = new CustodioModel();
        $this->usuarioModel = new UsuarioModel();
        $this->carrerasModel = new CarreraModel();
        $this->historialModel = new HistorialCustodioModel();
        $this->bienModel = new BienModel();
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
        $db = \Config\Database::connect();

        // Instanciamos modelos necesarios (o úsalos desde $this si ya los tienes en constructor)

        try {
            // 1. Iniciar Transacción (Seguridad de datos)
            $db->transException(true)->transStart();

            // 2. Verificar si existen registros relacionados
            // Contamos bienes asignados actualmente
            $countBienes = $this->bienModel->where('custodio_actual_id', $id)->countAllResults();

            // Contamos historial (pasado o presente)
            $countHistorial = $this->historialModel->where('custodio_id', $id)->countAllResults();

            $tieneRelaciones = ($countBienes > 0 || $countHistorial > 0);

            if ($tieneRelaciones) {
                // === ESCENARIO A: BORRADO LÓGICO ===
                // El custodio tiene historia, no podemos borrarlo físicamente.

                // A.1. Cerrar historiales abiertos (Poner fecha fin HOY si está NULL)
                $this->historialModel->where('custodio_id', $id)
                    ->where('fecha_fin IS NULL')
                    ->set(['fecha_fin' => date('Y-m-d')])
                    ->update();

                // A.2. Liberar bienes actuales (Poner custodio en NULL)
                // Como es borrado lógico, el ON DELETE SET NULL de la BD no se dispara solo,
                // debemos hacerlo manualmente.
                $this->bienModel->where('custodio_actual_id', $id)
                    ->set(['custodio_actual_id' => null])
                    ->update();

                // A.3. Borrado Lógico del Custodio
                // Al tener useSoftDeletes = true en el modelo, esto solo llena 'deleted_at'
                // y el usuario (login) también debería desactivarse si usas tabla usuarios aparte.
                $this->custodioModel->delete($id);

                // Opcional: Desactivar usuario relacionado si existe
                // $usuarioModel->update($custodio['usuario_id'], ['estado' => 'inactivo']);

                $mensaje = 'Custodio desactivado. Se cerraron sus actas y liberaron sus bienes.';

            } else {
                // === ESCENARIO B: BORRADO FÍSICO ===
                // No tiene historial ni bienes, es seguro eliminarlo totalmente de la BD.

                // El segundo parámetro 'true' fuerza el borrado físico (Purge)
                $this->custodioModel->delete($id, true);

                // Opcional: Borrar usuario relacionado
                // $usuarioModel->delete($custodio['usuario_id']);

                $mensaje = 'Custodio eliminado permanentemente (sin registros asociados).';
            }

            // 3. Confirmar Transacción
            $db->transComplete();

            return redirect()->to('/custodios')->with('success', $mensaje);

        } catch (\Throwable $e) { // Usar Throwable captura Excepciones y Errores
            return redirect()->to('/custodios')->with('error', 'Error al procesar la eliminación: ' . $e->getMessage());
        }
    }
}