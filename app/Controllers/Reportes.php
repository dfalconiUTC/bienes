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
    // ====================================================================
    // 2. INVENTARIO POR CUSTODIO (Vista de selección y Generación PDF)
    // ====================================================================

    /**
     * Muestra la vista con el formulario para seleccionar el custodio.
     */
    public function porCustodio()
    {
        $data['title'] = 'Reporte de Bienes por Custodio';
        $data['custodios'] = $this->custodioModel->findAll();

        return view('reportes/por_custodio_view', $data); // Vista definida más adelante
    }

    /**
     * Genera el reporte en PDF para el custodio seleccionado.
     */
    public function generarReportePorCustodioPDF()
    {
        $id_custodio = $this->request->getPost('id_custodio');

        if (empty($id_custodio)) {
            return redirect()->back()->with('warning', 'Debe seleccionar un custodio.');
        }

        try {
            // Obtener datos del custodio y sus bienes
            $custodio = $this->custodioModel->find($id_custodio);
            $bienes = $this->bienModel->where('id_custodio', $id_custodio)->getConRelaciones();

            if (!$custodio) {
                return redirect()->back()->with('error', 'Custodio no encontrado.');
            }

            // Si $bienes está vacío, se puede optar por mostrar el PDF sin bienes o redireccionar

            $data = [
                'title' => 'Reporte de Bienes Asignados',
                'custodio' => $custodio,
                'bienes' => $bienes,
                'fecha' => Time::now()->toDateString(),
            ];

            // 1. Cargar la vista HTML del reporte
            $html = view('reportes/pdf_por_custodio', $data);

            // 2. Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', ROOTPATH); // Permite cargar recursos locales (imágenes, CSS)

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // 3. Salida del PDF
            $filename = 'Reporte_Custodio_' . $custodio['nombre'] . '_' . Time::now()->toDateString() . '.pdf';

            $dompdf->stream($filename, ["Attachment" => 1]); // 1 fuerza la descarga
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }


    // ====================================================================
    // 3. LISTADO DE BIENES DADOS DE BAJA (Generación PDF)
    // ====================================================================

    /**
     * Genera un reporte en PDF de todos los bienes marcados con estado 'Baja'.
     */
    public function bienesEnBaja()
    {
        try {
            // Asumiendo que 'Baja' es el valor exacto para el estado
            $bienes = $this->bienModel->where('estado_bien', 'Baja')->getConRelaciones();

            if (empty($bienes)) {
                return redirect()->to('reportes')->with('warning', 'No hay bienes dados de baja.');
            }

            $data = [
                'title' => 'Reporte de Bienes Dados de Baja',
                'bienes' => $bienes,
                'fecha' => Time::now()->toDateString(),
            ];

            // 1. Cargar la vista HTML del reporte
            $html = view('reportes/pdf_bienes_baja', $data);

            // 2. Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', ROOTPATH);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // 3. Salida del PDF
            $filename = 'Bienes_Baja_' . Time::now()->toDateString() . '.pdf';

            $dompdf->stream($filename, ["Attachment" => 1]);
            exit;

        } catch (\Throwable $e) {
            return redirect()->to('reportes')->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }


    // ====================================================================
    // 4. BIENES CLASIFICADOS POR PROCEDENCIA (Exportación Excel)
    // ====================================================================

    /**
     * Genera un reporte en Excel de todos los bienes, agrupados/ordenados por Procedencia.
     */
    public function bienesPorProcedencia()
    {
        try {
            // Asumiendo un método para obtener bienes con relaciones y ordenar por procedencia
            $bienes = $this->bienModel->getConRelaciones();

            // Sort by procedencia
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
}