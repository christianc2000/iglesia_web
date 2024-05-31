<?php
require_once 'views/vendor/autoload.php';
require_once('controllers/patronstrategy/EstrategiaExport.php');
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Word implements EstrategiaExport
{
    // Lógica específica para exportar a WORD
    public function exportar($datos)
    {
        // Crear un nuevo objeto PHPWord
        $phpWord = new PhpWord();
        // Agregar una sección al documento
        $section = $phpWord->addSection();
        // Obtener el contenido HTML y agregarlo al documento
        ob_start();
        require_once('views/certificados/certificado_word.php');
        $html = ob_get_clean();
        // Imprime el HTML para verificar si se está capturando correctamente
        // echo $html;
        // Convertir el HTML a formato de Word y agregarlo al documento
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

        // Definir el nombre del archivo Word
        $word_file = "certificado_" . str_replace(' ', '_', $datos['protagonista']) . "_" . str_replace(' ', '_', $datos['sacramento']) . ".docx";
        $word_path = "controllers/patronstrategy/files/" . $word_file;

        // Guardar el documento Word
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($word_path);
        header("Location: $word_path");
        // return $word_path;
    }
}
