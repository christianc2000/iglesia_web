<?php
require_once 'views/vendor/autoload.php';
require_once('controllers/patronstrategy/EstrategiaExport.php');

class Html implements EstrategiaExport
{
    public function exportar($datos)
    {
        ob_start();
        require_once('views/certificados/certificado_pdf.php');
        $html = ob_get_clean();
        $html_path = "controllers/patronstrategy/files/certificado_" . str_replace(' ', '_', $datos['protagonista']) . "_" . str_replace(' ', '_', $datos['sacramento']). ".html";
        file_put_contents($html_path, $html);
        header("Location: $html_path");
    }
}
