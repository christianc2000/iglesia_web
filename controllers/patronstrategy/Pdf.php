<?php
require_once('controllers/patronstrategy/EstrategiaExport.php');
require 'views/vendor/autoload.php';
use Dompdf\Dompdf;

class Pdf implements EstrategiaExport
{

    public function exportar($datos)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        ob_start();
        require_once('views/certificados/certificado_pdf.php');
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = ob_get_clean();
        $dompdf->loadHtml($html);
        // $dompdf->setPaper('letter');
        $dompdf->setPaper('A4', 'landscape'); //formato para certificados
        $dompdf->render();
        // Guardar el PDF en el proyecto
        $pdf_content = $dompdf->output();
        $pdf_file = "certificado_". str_replace(' ', '_', $datos['protagonista'])."_".str_replace(' ', '_', $datos['sacramento']).".pdf"; // Nombre del archivo PDF
        $pdf_path = "controllers/patronstrategy/files/" . $pdf_file; // Ruta donde guardar el archivo
        file_put_contents($pdf_path, $pdf_content);
        header("Location: $pdf_path");
        // Devolver la ruta del archivo guardado
        // return $pdf_path;
    }
}
