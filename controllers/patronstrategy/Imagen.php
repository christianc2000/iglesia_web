<?php
require_once('controllers/patronstrategy/EstrategiaExport.php');
require 'views/vendor/autoload.php';
use Dompdf\Dompdf;

class Imagen implements EstrategiaExport
{
    public function exportar($datos)
    {
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

        $pdf_content = $dompdf->output();
        $pdf_file = "certificado_" . str_replace(' ', '_', $datos['protagonista']) . "_" .str_replace(' ', '_', $datos['sacramento']). ".pdf"; // Ruta donde se guardará el PDF
        $pdf_path = "controllers/patronstrategy/files/" . $pdf_file;
        file_put_contents($pdf_path, $pdf_content);

        // Convertir el PDF en una imagen utilizando Imagick
        if (!file_exists($pdf_path)) {
            echo "ERR. The pdf doesn't exists";
            return;
        }

        $im = new Imagick();
        // $im->setResolution(300, 300); // Configura la resolución (opcional)
        $im->readImage($pdf_path.'[0]'); // Lee el PDF
        $im->setImageFormat('png'); // Establece el formato de imagen

        $image_file = "controllers/patronstrategy/files/certificado_" . str_replace(' ', '_', $datos['protagonista']) . "_" . str_replace(' ', '_', $datos['sacramento']). ".png";
        $im->writeImage($image_file); // Guarda la imagen en formato JPEG
        header("Location: $image_file");
        // return $image_file;
    }
}
