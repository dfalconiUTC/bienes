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

        $hasFullView = $auth->tienePermiso('bienes.view');
        $hasOwnView = $auth->tienePermiso('bienes.view_own');

        $bienes = [];

        if ($hasFullView) {
            $bienes = $this->bienModel->getConRelaciones();

        } elseif ($hasOwnView && $userId) {
            $db = \Config\Database::connect();
            $custodio = $db->table('custodios')
                ->select('id_custodio')
                ->where('usuario_id', $userId)
                ->get()
                ->getRowArray();

            if ($custodio) {
                $custodioId = $custodio['id_custodio'];
                $bienes = $this->bienModel->getBienesPorCustodio($custodioId);
            }
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
        $db = \Config\Database::connect();

        $bien = $db->table('bienes b')
            ->select('b.*, c.nombre AS custodio_nombre, c.jefe_inmediato_id')
            ->join('custodios c', 'c.id_custodio = b.custodio_actual_id', 'left')
            ->where('b.id_bien', $id)
            ->get()
            ->getRowArray();

        if (!$bien) {
            return redirect()->back()->with('error', 'El bien no existe');
        }

        $asignacion = $db->table('historial_custodios')
            ->select('fecha_inicio')
            ->where('bien_id', $id)
            ->where('custodio_id', $bien['custodio_actual_id'])
            ->where('fecha_fin IS NULL', null, false)
            ->get()
            ->getRowArray();

        $jefe = null;
        if (!empty($bien['jefe_inmediato_id'])) {
            $jefe = $db->table('custodios')
                ->select('nombre')
                ->where('id_custodio', $bien['jefe_inmediato_id'])
                ->get()
                ->getRowArray();
        }

        // 3. Traer configuración institucional
        $config = $db->table('configuracion_sistema')
            ->get()
            ->getRowArray();
        $logoPath = FCPATH . 'static/img/icons/logo.png';
        // -------------------------------
        // 4. Construir contenido HTML
        // -------------------------------
        $html = "
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .header { display: flex; align-items: center; margin-bottom: 20px; }
    .logo { width: 80px; margin-right: 15px; }
    .institucion { font-size: 20px; font-weight: bold; text-align: center; }
    .titulo { text-align: center; font-size: 15px; margin: 20px 0; }
    .titulo-firmas { text-align: left; font-size: 15px; font-weight: bold; margin: 20px 0; }
    .seccion { margin-bottom: 10px; }
    .firmas td { padding-top: 40px; text-align: center; vertical-align: top; }
    .firmas b { display: block; margin-top: 5px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
</style>

<div class='header'>
    <img src='" . $logoPath . "' class='logo'>
    <div class='institucion'>
        INSTITUTO SUPERIOR TECNOLÓGICO VICENTE LEÓN<br>
    </div>
</div>

<div class='titulo'>ACTA DE ENTREGA – RECEPCIÓN BIENES MUEBLES Y DE CONTROL ADMINISTRATIVO</div>

<div class='seccion'>
    En la fecha <b>" . $this->fechaEnEspañol(date('Y-m-d')) . "</b>, se deja constancia de la entrega del bien detallado a continuación al custodio/a <b>{$bien['custodio_nombre']}</b>: 
</div>

<div class='seccion'><b>Bien:</b> {$bien['nombre_bien']}</div>
<div class='seccion'><b>Código:</b> {$bien['codigo_bien']}</div>
<div class='seccion'><b>Custodio Responsable:</b> {$bien['custodio_nombre']}</div>";

        if (!empty($asignacion)) {
            $html .= "<div class='seccion'><b>Fecha de Asignación:</b> " . date('d/m/Y', strtotime($asignacion['fecha_inicio'])) . "</div>";
        }

        if ($jefe) {
            $html .= "<div class='seccion'><b>Jefe Inmediato:</b> {$jefe['nombre']}</div>";
        }

        if ($config) {
            $html .= "<div class='titulo-firmas'>Firmas Responsabilidad</div>";
        }

        $html .= "
<table class='firmas'>
    <tr>
        <td>
            _______________________________<br>
             <b>Firma Custodio </b>
            {$bien['custodio_nombre']}
        </td>";

        if ($jefe) {
            $html .= "
        <td>
            _______________________________<br>
             <b>Firma Jefe Inmediato </b>
            {$jefe['nombre']}
        </td>";
        }

        $html .= "</tr>";

        if (!empty($config['responsable_bienes_nombre']) || !empty($config['asignado_ud_nombre'])) {
            $html .= "<tr>";
            if (!empty($config['responsable_bienes_nombre'])) {
                $html .= "
        <td>
            _______________________________<br>
            <b>Responsable de Bienes</b>
            {$config['responsable_bienes_nombre']}<br>{$config['responsable_bienes_cedula']}
        </td>";
            }
            if (!empty($config['asignado_ud_nombre'])) {
                $html .= "
        <td>
            _______________________________<br>
            <b>Asignado de U.D.</b>
            {$config['asignado_ud_nombre']}<br> {$config['asignado_ud_cedula']}
        </td>";
            }
            $html .= "</tr>";
        }

        if (!empty($config['rector_nombre'])) {
            $html .= "
    <tr>
        <td colspan='2'>
            _______________________________<br>
            <b>Rector</b>
            {$config['rector_nombre']} <br>{$config['rector_cedula']}
        </td>
    </tr>";
        }

        $html .= "</table>";

        // -------------------------------
        // 5. Generar PDF
        // -------------------------------
        $dompdf = new Dompdf();
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
}