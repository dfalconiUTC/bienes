<?php
namespace App\Controllers;

use App\Models\ActaModel;
use App\Models\ActaDetalleModel;
use App\Models\ActaFirmaModel;
use App\Models\BienModel;
use App\Models\CustodioModel;

class Actas extends BaseController
{
    protected $actaModel;
    protected $detalleModel;
    protected $firmaModel;
    protected $bienModel;
    protected $custodioModel;

    public function __construct()
    {
        $this->actaModel = new ActaModel();
        $this->detalleModel = new ActaDetalleModel();
        $this->firmaModel = new ActaFirmaModel();
        $this->bienModel = new BienModel();
        $this->custodioModel = new CustodioModel(); // Para sugerir nombres
    }

    public function index()
    {
        $data['actas'] = $this->actaModel->orderBy('id_acta', 'DESC')->findAll();
        return view('actas/index', $data);
    }

    public function create()
    {
        // Enviamos custodios para poder autocompletar firmas si se desea
        $data['custodios'] = $this->custodioModel->findAll();
        return view('actas/form', $data);
    }

    // Método AJAX para buscar bien por código
    public function buscarBien($codigo)
    {
        $bien = $this->bienModel->where('codigo_bien', $codigo)->first();
        if ($bien) {
            return $this->response->setJSON(['status' => 'success', 'data' => $bien]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Bien no encontrado']);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Iniciamos transacción

        // 1. Guardar Cabecera
        $actaData = [
            'tipo' => $this->request->getPost('tipo'),
            'titulo' => $this->request->getPost('titulo'),
            'periodo' => $this->request->getPost('periodo'),
            'detalle' => $this->request->getPost('detalle'),
            'numero_acta' => $this->request->getPost('numero_acta'),
            'fecha_impresion' => $this->request->getPost('fecha_impresion'),
            'encabezado_lugar' => $this->request->getPost('encabezado_lugar'),
            'compareciente_nombre' => $this->request->getPost('compareciente_nombre'),
            'receptor_nombre' => $this->request->getPost('receptor_nombre'),
            'introduccion_texto' => $this->request->getPost('introduccion_texto'),
            'observaciones_finales' => $this->request->getPost('observaciones_finales'),
            'nota' => $this->request->getPost('nota'),
            'estado' => 'Borrador'
        ];

        $this->actaModel->insert($actaData);
        $actaId = $this->actaModel->getInsertID();

        // 2. Guardar Bienes (Items)
        $bienes = $this->request->getPost('bienes'); // Array de IDs
        if (!empty($bienes)) {
            foreach ($bienes as $bienId) {
                $this->detalleModel->insert([
                    'acta_id' => $actaId,
                    'bien_id' => $bienId
                ]);
            }
        }

        // 3. Guardar Firmas
        $titulos = $this->request->getPost('firma_titulo');
        $nombres = $this->request->getPost('firma_nombre');
        $cedulas = $this->request->getPost('firma_cedula');
        $cargos = $this->request->getPost('firma_cargo');

        if (!empty($titulos)) {
            for ($i = 0; $i < count($titulos); $i++) {
                $this->firmaModel->insert([
                    'acta_id' => $actaId,
                    'titulo' => $titulos[$i],
                    'nombre' => $nombres[$i],
                    'cedula' => $cedulas[$i],
                    'cargo' => $cargos[$i],
                    'orden' => $i
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Error al guardar el acta.');
        }

        return redirect()->to('/actas')->with('success', 'Acta creada correctamente.');
    }

    public function edit($id)
    {
        $acta = $this->actaModel->find($id);
        if (!$acta) {
            return redirect()->to('/actas')->with('error', 'Acta no encontrada');
        }

        // Recuperar detalles (bienes) con JOIN para mostrar nombre y código
        $detalles = $this->detalleModel
            ->select('acta_detalles.*, bienes.codigo_bien, bienes.nombre_bien, bienes.descripcion, bienes.estado_bien')
            ->join('bienes', 'bienes.id_bien = acta_detalles.bien_id')
            ->where('acta_id', $id)
            ->findAll();

        // Recuperar firmas ordenadas
        $firmas = $this->firmaModel->where('acta_id', $id)->orderBy('orden', 'ASC')->findAll();

        $data = [
            'acta' => $acta,
            'detalles' => $detalles,
            'firmas' => $firmas,
            'custodios' => $this->custodioModel->findAll() // Por si quiere cambiar nombres usando el autocomplete
        ];

        return view('actas/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Actualizar Cabecera
        $actaData = [
            'tipo' => $this->request->getPost('tipo'),
            'titulo' => $this->request->getPost('titulo'),
            'periodo' => $this->request->getPost('periodo'),
            'detalle' => $this->request->getPost('detalle'),
            'numero_acta' => $this->request->getPost('numero_acta'),
            'fecha_impresion' => $this->request->getPost('fecha_impresion'),
            'encabezado_lugar' => $this->request->getPost('encabezado_lugar'),
            'compareciente_nombre' => $this->request->getPost('compareciente_nombre'),
            'receptor_nombre' => $this->request->getPost('receptor_nombre'),
            'introduccion_texto' => $this->request->getPost('introduccion_texto'),
            'observaciones_finales' => $this->request->getPost('observaciones_finales'),
            'nota' => $this->request->getPost('nota'),
        ];
        $this->actaModel->update($id, $actaData);

        // 2. Actualizar Bienes (Estrategia: Borrar y Reinsertar es lo más seguro y fácil)
        $this->detalleModel->where('acta_id', $id)->delete();

        $bienes = $this->request->getPost('bienes');
        if (!empty($bienes)) {
            foreach ($bienes as $bienId) {
                $this->detalleModel->insert([
                    'acta_id' => $id,
                    'bien_id' => $bienId
                ]);
            }
        }

        // 3. Actualizar Firmas (Igual estrategia: Borrar y Reinsertar)
        $this->firmaModel->where('acta_id', $id)->delete();

        $titulos = $this->request->getPost('firma_titulo');
        $nombres = $this->request->getPost('firma_nombre');
        $cedulas = $this->request->getPost('firma_cedula');
        $cargos = $this->request->getPost('firma_cargo');

        if (!empty($titulos)) {
            for ($i = 0; $i < count($titulos); $i++) {
                $this->firmaModel->insert([
                    'acta_id' => $id,
                    'titulo' => $titulos[$i],
                    'nombre' => $nombres[$i],
                    'cedula' => $cedulas[$i],
                    'cargo' => $cargos[$i],
                    'orden' => $i
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Error al actualizar el acta.');
        }

        return redirect()->to('/actas')->with('success', 'Acta actualizada correctamente.');
    }

    // --- ELIMINACIÓN ---

    public function delete($id)
    {


        if ($this->actaModel->delete($id)) {
            return redirect()->to('/actas')->with('success', 'Acta eliminada correctamente.');
        } else {
            return redirect()->to('/actas')->with('error', 'No se pudo eliminar el acta.');
        }
    }


    public function pdf($id)
    {
        $acta = $this->actaModel->find($id);
        if (!$acta) {
            return redirect()->back()->with('error', 'Acta no encontrada');
        }

        // 1. CONSULTA ACTUALIZADA: Traemos todo de bienes y el nombre de la ubicación
        $detalles = $this->detalleModel
            ->select('acta_detalles.*, b.*, u.nombre as nombre_ubicacion, u.campus as nombre_campus')
            ->join('bienes b', 'b.id_bien = acta_detalles.bien_id')
            ->join('ubicaciones u', 'u.id_ubicacion = b.ubicacion_id', 'left') // Join opcional por si no tiene ubicación
            ->where('acta_id', $id)
            ->findAll();

        $firmas = $this->firmaModel->where('acta_id', $id)->orderBy('orden', 'ASC')->findAll();

        $data = [
            'acta' => $acta,
            'detalles' => $detalles,
            'firmas' => $firmas,
            'logoPath' => FCPATH . 'static/img/icons/logo.png',
            'fecha_humana' => $this->fechaEnLetras($acta['fecha_impresion'])
        ];

        $html = view('actas/pdf_template', $data);

        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);

        // 2. CAMBIO A HORIZONTAL
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $filename = 'Acta_' . $acta['numero_acta'] . '.pdf';
        $dompdf->stream($filename, ["Attachment" => false]);
    }

    // Helper pequeño para fecha en letras (Ej: "15 días del mes de enero de 2025")
    private function fechaEnLetras($fecha)
    {
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        $timestamp = strtotime($fecha);
        $dia = date('d', $timestamp);
        $mes = $meses[date('m', $timestamp)];
        $anio = date('Y', $timestamp);

        return "a los $dia días del mes de $mes del año $anio";
    }
}