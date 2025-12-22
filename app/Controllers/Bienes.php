<?php

namespace App\Controllers;

use App\Models\BienModel;
use App\Models\CustodioModel;
use App\Models\ProcedenciaModel;
use App\Models\UbicacionModel;
use App\Models\HistorialCustodioModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Dompdf\Dompdf;
use Dompdf\Options;

class Bienes extends BaseController
{
    protected $bienModel;
    protected $custodioModel;
    protected $procedenciaModel;
    protected $ubicacionModel;
    protected $historialModel;

    public function __construct()
    {
        $this->bienModel = new BienModel();
        $this->custodioModel = new CustodioModel();
        $this->procedenciaModel = new ProcedenciaModel();
        $this->ubicacionModel = new UbicacionModel();
        $this->historialModel = new HistorialCustodioModel();
    }

    public function index()
    {
        $auth = service('auth');
        $userId = session('id_usuario');
        $bienes = [];

        $hasFullView = $auth->tienePermiso('bienes.view');
        $hasOwnView = $auth->tienePermiso('bienes.view_own');
        $hasDeptView = $auth->tienePermiso('bienes.view_dept');

        $db = \Config\Database::connect();
        $custodioUsuario = $db->table('custodios')
            ->select('id_custodio, departamento')
            ->where('usuario_id', $userId)
            ->get()
            ->getRowArray();

        if ($hasFullView) {
            $bienes = $this->bienModel->getConRelaciones();

        } elseif ($hasDeptView && $custodioUsuario) {
            $departamento = "Unidad Administrativa y Financiera";
            if ($departamento) {
                $bienes = $this->bienModel->getBienesPorDepartamento($departamento);
            }

        } elseif ($hasOwnView && $custodioUsuario) {
            $custodioId = $custodioUsuario['id_custodio'];
            $bienes = $this->bienModel->getBienesPorCustodio($custodioId);

        } else {
            $bienes = [];
        }

        $data['bienes'] = $bienes;

        return view('bienes/index', $data);
    }

    public function create()
    {
        $data = [
            'procedencias' => $this->procedenciaModel->findAll(),
            'ubicaciones' => $this->ubicacionModel->findAll(),
            'custodios' => $this->custodioModel->findAll(),
        ];
        return view('bienes/create', $data);
    }

    public function store()
    {
        try {
            $postData = $this->request->getPost();

            if (empty($postData['nombre_bien']) || empty($postData['codigo_bien'])) {
                return redirect()->back()->withInput()->with('warning', 'Debe completar al menos el nombre y el código del bien.');
            }

            $this->bienModel->insert($postData);

            return redirect()->to('/bienes')->with('success', 'Bien registrado correctamente.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al guardar el bien: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $bien = $this->bienModel->find($id);
        if (!$bien) {
            return redirect()->to('/bienes')->with('warning', 'El bien solicitado no existe.');
        }

        $custodio_actual = $this->historialModel
            ->select('custodios.*')
            ->join('custodios', 'custodios.id_custodio = historial_custodios.custodio_id')
            ->where('historial_custodios.bien_id', $id)
            ->where('historial_custodios.fecha_fin IS NULL')
            ->first();

        $data = [
            'bien' => $bien,
            'procedencias' => $this->procedenciaModel->findAll(),
            'ubicaciones' => $this->ubicacionModel->findAll(),
            'custodios' => $this->custodioModel->findAll(),
            'custodio_actual' => $custodio_actual
        ];

        return view('bienes/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->bienModel->update($id, $this->request->getPost());
            return redirect()->to('/bienes')->with('success', 'Bien actualizado correctamente.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el bien: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $bien = $this->bienModel->find($id);
            if (!$bien) {
                return redirect()->to('/bienes')->with('warning', 'El bien que intenta eliminar no existe.');
            }

            $this->bienModel->delete($id);
            return redirect()->to('/bienes')->with('success', 'Bien eliminado correctamente.');
        } catch (\Throwable $e) {
            return redirect()->to('/bienes')->with('error', 'No se pudo eliminar el bien: ' . $e->getMessage());
        }
    }

    public function historial($id)
    {
        $data['historial'] = $this->historialModel
            ->where('bien_id', $id)
            ->getHistorialConDetalles();

        if (empty($data['historial'])) {
            return redirect()->to('/bienes')->with('warning', 'No existe historial para el bien seleccionado.');
        }

        return view('bienes/historial', $data);
    }

    public function exportHistorial($id)
    {
        try {
            $bien = $this->bienModel->find($id);
            if (!$bien) {
                return redirect()->to('/bienes')->with('warning', 'Bien no encontrado.');
            }

            $historial = $this->historialModel
                ->select('historial_custodios.*, c.nombre AS custodio, c.tipo AS tipo_custodio')
                ->join('custodios c', 'c.id_custodio = historial_custodios.custodio_id', 'left')
                ->where('historial_custodios.bien_id', $id)
                ->orderBy('historial_custodios.fecha_inicio', 'ASC')
                ->findAll();

            if (empty($historial)) {
                return redirect()->to('/bienes')->with('warning', 'No hay historial disponible para este bien.');
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Historial Custodios');

            $sheet->setCellValue('A1', 'Historial de Custodios del Bien');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

            $sheet->setCellValue('A3', 'Código Bien:');
            $sheet->setCellValue('B3', $bien['codigo_bien']);
            $sheet->setCellValue('A4', 'Nombre Bien:');
            $sheet->setCellValue('B4', $bien['nombre_bien']);

            $headers = ['Custodio', 'Tipo', 'Fecha Inicio', 'Fecha Fin', 'Observaciones'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '6', $header);
                $sheet->getStyle($col . '6')->getFont()->setBold(true);
                $sheet->getStyle($col . '6')->getAlignment()->setHorizontal('center');
                $col++;
            }

            $row = 7;
            foreach ($historial as $item) {
                $sheet->setCellValue("A$row", $item["custodio"]);
                $sheet->setCellValue("B$row", $item["tipo_custodio"]);
                $sheet->setCellValue("C$row", $item["fecha_inicio"]);
                $sheet->setCellValue("D$row", $item["fecha_fin"] ?? 'Activo');
                $sheet->setCellValue("E$row", $item["observaciones"]);
                $row++;
            }

            foreach (range('A', 'E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Historial_Bien_' . $bien['codigo_bien'] . '_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (\Throwable $e) {
            return redirect()->to('/bienes')->with('error', 'Error al exportar historial: ' . $e->getMessage());
        }
    }

    public function barcodePdf($codigo = null)
    {
        if (!$codigo) {
            return redirect()->back()->with('warning', 'No se proporcionó un código.');
        }

        try {
            // Generar código de barras
            $generator = new BarcodeGeneratorPNG();
            $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

            // Crear HTML con el código de barras
            $html = '
                <h3 style="text-align:center;">Código: ' . htmlspecialchars($codigo) . '</h3>
                <div style="text-align:center;">
                    <img src="data:image/png;base64,' . base64_encode($barcode) . '" alt="Código de barras">
                </div>
            ';

            // Configurar Dompdf
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A7', 'portrait');
            $dompdf->render();

            // Descargar el PDF
            $dompdf->stream('codigo_' . $codigo . '.pdf', ['Attachment' => true]);
            exit;
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al generar el código de barras: ' . $e->getMessage());
        }
    }

    public function generarActa($id)
    {
        $request = \Config\Services::request();
        $db = \Config\Database::connect();

        // 1. Obtener Datos
        $bien = $db->table('bienes b')
            ->select('b.*, c.nombre AS custodio_nombre, c.jefe_inmediato_id')
            ->join('custodios c', 'c.id_custodio = b.custodio_actual_id', 'left')
            ->where('b.id_bien', $id)
            ->get()->getRowArray();

        if (!$bien) {
            return redirect()->back()->with('error', 'El bien no existe');
        }

        $asignacion = $db->table('historial_custodios')
            ->select('fecha_inicio')
            ->where('bien_id', $id)
            ->where('custodio_id', $bien['custodio_actual_id'])
            ->where('fecha_fin IS NULL', null, false)
            ->get()->getRowArray();

        $jefe = null;
        if (!empty($bien['jefe_inmediato_id'])) {
            $jefe = $db->table('custodios')
                ->select('nombre')
                ->where('id_custodio', $bien['jefe_inmediato_id'])
                ->get()->getRowArray();
        }

        $config = $db->table('configuracion_sistema')->get()->getRowArray();

        $opcionesFirmas = [
            'jefe' => $request->getPost('firma_jefe') == '1',
            'resp_bienes' => $request->getPost('firma_resp_bienes') == '1',
            'ud' => $request->getPost('firma_ud') == '1',
            'rector' => $request->getPost('firma_rector') == '1',
        ];
        
        // 2. Preparar datos para la vista
        $data = [
            'bien' => $bien,
            'asignacion' => $asignacion,
            'jefe' => $jefe,
            'config' => $config,
            // Procesamos la fecha aquí para no ensuciar la vista con llamadas a $this
            'fecha_actual' => $this->fechaEnEspañol(date('Y-m-d')),
            'opciones'     => $opcionesFirmas
        ];

        // 3. Renderizar la vista en una variable
        // En CI4, view() devuelve el string automáticamente
        $html = view('reportes/reporte_bien', $data);

        // 4. Generar PDF
        $dompdf = new Dompdf(); // Asegúrate de instanciarlo bien según tu namespace

        // Opcional: Permitir imágenes externas si fuera necesario (aunque usas rutas locales)
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('acta_bien_' . $id . '.pdf', ["Attachment" => true]);
    }

    function fechaEnEspañol($fecha)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8'); // Para servidores con soporte de locales
        $meses = [
            '01' => 'enero',
            '02' => 'febrero',
            '03' => 'marzo',
            '04' => 'abril',
            '05' => 'mayo',
            '06' => 'junio',
            '07' => 'julio',
            '08' => 'agosto',
            '09' => 'septiembre',
            '10' => 'octubre',
            '11' => 'noviembre',
            '12' => 'diciembre'
        ];

        $dia = date('d', strtotime($fecha));
        $mes = $meses[date('m', strtotime($fecha))];
        $anio = date('Y', strtotime($fecha));

        return "$dia de $mes de $anio";
    }

    // En tu controlador de Bienes

    public function configurarActa($id)
    {
        $db = \Config\Database::connect();

        // Solo necesitamos datos básicos para mostrarle al usuario qué está imprimiendo
        $bien = $db->table('bienes')
            ->select('id_bien, nombre_bien, codigo_bien')
            ->where('id_bien', $id)
            ->get()->getRowArray();

        if (!$bien) {
            return redirect()->back()->with('error', 'El bien no existe');
        }

        $data = ['bien' => $bien];

        // Cargamos una vista simple con el formulario
        return view('bienes/configurar_impresion', $data);
    }
}