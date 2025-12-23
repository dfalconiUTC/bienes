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

class Reportes extends BaseController
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
        $data['title'] = 'Reportes y Consultas';
        return view('reportes/index', $data);
    }

    public function bienesExportExcel()
    {
        try {
            $bienes = $this->bienModel->getConRelaciones();

            if (empty($bienes)) {
                return redirect()->to('/bienes')->with('warning', 'No hay datos para exportar.');
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Listado de Bienes');

            $headers = [
                'Código',
                'Nombre',
                'Código Interno',
                'Descripción',
                'Fecha Ingreso',
                'Serie',
                'Modelo',
                'Marca',
                'Color',
                'Estado',
                'Cuenta Contable',
                'Valor Contable',
                'Custodio Actual',
                'Ubicación',
                'Campus',
                'Procedencia',
                'Observaciones'
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $col++;
            }

            $row = 2;
            foreach ($bienes as $item) {
                $sheet->setCellValue("A$row", $item["codigo_bien"]);
                $sheet->setCellValue("B$row", $item["nombre_bien"]);
                $sheet->setCellValue("C$row", $item["codigo_interno"]);
                $sheet->setCellValue("D$row", $item["descripcion"]);
                $sheet->setCellValue("E$row", $item["fecha_ingreso"]);
                $sheet->setCellValue("F$row", $item["serie"]);
                $sheet->setCellValue("G$row", $item["modelo"]);
                $sheet->setCellValue("H$row", $item["marca"]);
                $sheet->setCellValue("I$row", $item["color"]);
                $sheet->setCellValue("J$row", $item["estado_bien"]);
                $sheet->setCellValue("K$row", $item["cuenta_contable"]);
                $sheet->setCellValue("L$row", $item["valor_contable"]);
                $sheet->setCellValue("M$row", $item["custodio_actual"] ?? 'No asignado');
                $sheet->setCellValue("N$row", $item["ubicacion"] ?? 'No asignado');
                $sheet->setCellValue("O$row", $item["campus"] ?? 'No asignado');
                $sheet->setCellValue("P$row", $item["procedencia"] ?? 'No asignado');
                $sheet->setCellValue("Q$row", $item["observaciones"]);
                $row++;
            }

            foreach (range('A', 'Q') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Listado_Bienes_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (\Throwable $e) {
            return redirect()->to('/bienes')->with('error', 'Error al generar el Excel: ' . $e->getMessage());
        }
    }

    public function porCustodio()
    {
        $data['title'] = 'Reporte de Bienes por Custodio';
        $data['custodios'] = $this->custodioModel->withDeleted()->findAll();

        return view('reportes/por_custodio_view', $data); // Vista definida más adelante
    }

    public function generarReportePorCustodioPDF()
    {
        $id_custodio = $this->request->getPost('id_custodio');

        if (empty($id_custodio)) {
            return redirect()->back()->with('warning', 'Debe seleccionar un custodio.');
        }

        try {
            $custodio = $this->custodioModel->withDeleted()->find($id_custodio);

            // Asumo que getConRelaciones() trae marcas, ubicaciones, etc.
            $bienes = $this->bienModel->where('id_custodio', $id_custodio)->getConRelaciones();

            if (!$custodio) {
                return redirect()->back()->with('error', 'Custodio no encontrado.');
            }

            // 1. TRAEMOS LA CONFIGURACIÓN PARA LA FIRMA <--- NUEVO
            $db = \Config\Database::connect();
            $config = $db->table('configuracion_sistema')->get()->getRowArray();

            $data = [
                'title' => 'Reporte de Bienes Asignados',
                'custodio' => $custodio,
                'bienes' => $bienes,
                'config' => $config, // <--- Enviamos la config a la vista
                'fecha' => Time::now()->toDateString(),
            ];

            $html = view('reportes/pdf_por_custodio', $data);

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', ROOTPATH);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);

            // 2. CAMBIAMOS A HORIZONTAL (LANDSCAPE) <--- NUEVO
            $dompdf->setPaper('A4', 'landscape');

            $dompdf->render();

            $filename = 'Reporte_Custodio_' . $custodio['nombre'] . '_' . Time::now()->toDateString() . '.pdf';

            $dompdf->stream($filename, ["Attachment" => 1]);
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    public function bienesEnBaja()
    {
        try {
            $bienes = $this->bienModel->where('estado_bien', 'De baja')->getConRelaciones();

            if (empty($bienes)) {
                return redirect()->to('reportes')->with('warning', 'No hay bienes dados de baja.');
            }

            $data = [
                'title' => 'Reporte de Bienes Dados de Baja',
                'bienes' => $bienes,
                'fecha' => Time::now()->toDateString(),
            ];

            $html = view('reportes/pdf_bienes_baja', $data);

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', ROOTPATH);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'Bienes_Baja_' . Time::now()->toDateString() . '.pdf';

            $dompdf->stream($filename, ["Attachment" => 1]);
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }


    public function bienesPorProcedencia()
    {
        try {
            $bienes = $this->bienModel->getConRelaciones();

            usort($bienes, function ($a, $b) {
                return strcmp($a['procedencia'] ?? '', $b['procedencia'] ?? '');
            });

            if (empty($bienes)) {
                return redirect()->to('reportes')->with('warning', 'No hay bienes para reportar.');
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Bienes por Procedencia');

            $headers = [
                'Procedencia',
                'Código',
                'Nombre',
                'Descripción',
                'Custodio Actual',
                'Ubicación'
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $col++;
            }

            $row = 2;
            foreach ($bienes as $item) {
                $sheet->setCellValue("A$row", $item["procedencia"] ?? 'Sin Procedencia');
                $sheet->setCellValue("B$row", $item["codigo_bien"]);
                $sheet->setCellValue("C$row", $item["nombre_bien"]);
                $sheet->setCellValue("D$row", $item["descripcion"]);
                $sheet->setCellValue("E$row", $item["custodio_actual"] ?? 'No asignado');
                $sheet->setCellValue("F$row", $item["ubicacion"] ?? 'No asignado');
                $row++;
            }

            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Bienes_Por_Procedencia_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el Excel: ' . $e->getMessage());
        }
    }

    public function bienesPorDepartamento()
    {
        $auth = service('auth');
        $userId = session('id_usuario');
        $bienes = [];
        $departamento = null;
        $filtro_abierto = false;

        if ($auth->tienePermiso('reportes.general')) {
            $filtro_abierto = true;
            $bienes = $this->bienModel->getConRelaciones();
            $departamento = 'GENERAL';

        } else {
            $custodioUsuario = $this->custodioModel->where('usuario_id', $userId)->first();
            $departamento = $custodioUsuario['departamento'] ?? null;

            if (empty($departamento)) {
                return redirect()->to('reportes')->with('warning', 'Su cuenta no está asociada a un departamento válido para reportes.');
            }

            $bienes = $this->bienModel->getBienesPorDepartamento($departamento);
        }

        try {
            if (empty($bienes)) {
                $msg = $filtro_abierto ? 'No hay bienes registrados en el sistema.' : 'No hay bienes asignados a su departamento (' . $departamento . ').';
                return redirect()->to('reportes')->with('warning', $msg);
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $baseTitle = 'Bienes Dept ' . $departamento;
            $sheetTitle = substr($baseTitle, 0, 31);
            $sheet->setTitle($sheetTitle);

            $headers = [
                'Código',
                'Nombre',
                'Departamento',
                'Custodio Actual',
                'Ubicación',
                'Valor Contable'
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $col++;
            }

            $row = 2;
            foreach ($bienes as $item) {
                $sheet->setCellValue("A$row", $item["codigo_bien"]);
                $sheet->setCellValue("B$row", $item["nombre_bien"]);

                $sheet->setCellValue("C$row", $item["departamento"] ?? $departamento);

                $sheet->setCellValue("D$row", $item["custodio_actual"] ?? 'No asignado');
                $sheet->setCellValue("E$row", $item["ubicacion"] ?? 'No asignado');
                $sheet->setCellValue("F$row", $item["valor_contable"]);
                $row++;
            }


            $filename = 'Bienes_Departamento_' . url_title($departamento) . '_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte departamental: ' . $e->getMessage());
        }
    }

    public function flujoAprobacion()
    {
        try {
            $actas = $this->historialModel->getActasConTodosLosEstados();

            if (empty($actas)) {
                return redirect()->to('reportes')->with('warning', 'No hay registros de actas para reportar.');
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Flujo de Aprobación');

            $headers = [
                'ID Historial',
                'Código Bien',
                'Nombre Bien',
                'Custodio Receptor',
                'Fecha Inicio',
                'Estado Acta',
                'Aprobador',
                'Fecha Aprobación'
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $col++;
            }

            $row = 2;
            foreach ($actas as $item) {
                $sheet->setCellValue("A$row", $item["id_historial"]);
                $sheet->setCellValue("B$row", $item["codigo_bien"]);
                $sheet->setCellValue("C$row", $item["nombre_bien"]);
                $sheet->setCellValue("D$row", $item["custodio_receptor"]);
                $sheet->setCellValue("E$row", $item["fecha_inicio"]);
                $sheet->setCellValue("F$row", $item["estado_acta"]);
                $sheet->setCellValue("G$row", $item["aprobador_nombre"] ?? 'Pendiente/N/A');
                $sheet->setCellValue("H$row", $item["fecha_aprobacion"] ?? 'Pendiente');
                $row++;
            }

            foreach (range('A', 'H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Flujo_Aprobacion_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte de flujo: ' . $e->getMessage());
        }
    }

    public function conciliacionContable()
    {
        try {
            $conciliacion = $this->bienModel->getConciliacionContable();

            if (empty($conciliacion)) {
                return redirect()->to('reportes')->with('warning', 'No hay datos contables para conciliar.');
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Conciliacion Contable');

            $headers = [
                'Cuenta Contable',
                'Total Bienes',
                'Valor Contable Total'
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $col++;
            }

            $row = 2;
            foreach ($conciliacion as $item) {
                $sheet->setCellValue("A$row", $item["cuenta_contable"]);
                $sheet->setCellValue("B$row", $item["total_bienes"]);
                $sheet->setCellValue("C$row", $item["valor_total_contable"]);
                // Formato de moneda para el valor total
                $sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('#,##0.00');
                $row++;
            }

            foreach (range('A', 'C') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Conciliacion_Contable_' . Time::now()->toDateString() . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar la conciliación: ' . $e->getMessage());
        }
    }
}