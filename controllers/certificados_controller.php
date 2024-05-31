<?php
require_once('models/participacion_model.php');
require_once('models/sacramento_model.php');
require_once('models/actividad_model.php');
require_once('controllers/patronstrategy/ContextoExport.php');
require_once('controllers/patronstrategy/Pdf.php');
require_once('controllers/patronstrategy/Imagen.php');
require_once('controllers/patronstrategy/Word.php');
require_once('controllers/patronstrategy/Html.php');

class CertificadoController
{
    public function generarCertificado()
    {
        function salida($protagonistas)
        {
            $cadena = "";
            if (count($protagonistas) > 1) {
                for ($i = 0; $i < count($protagonistas) - 1; $i++) {
                    if ($i == 0) {
                        $cadena = $cadena . $protagonistas[$i]['persona_nombre'];
                    } else {
                        $cadena = $cadena . ', ' . $protagonistas[$i]['persona_nombre'];
                    }
                }
                $cadena = $cadena . " y " . $protagonistas[count($protagonistas) - 1]['persona_nombre'];
            }
            if (count($protagonistas) == 1) {
                return $protagonistas[0]['persona_nombre'];
            }
            return $cadena;
        }
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad_id = $_GET['id'];
        $actividad = Actividad::find($actividad_id);
        $sacramento = Sacramento::find($actividad->sacramento_id);
        $protagonistas = Participacion::getProtagonista($actividad_id);
        $protagonistas = salida($protagonistas);
        date_default_timezone_set('America/La_Paz');
        $dia_actual = date('d');
        $mes_actual = date('F'); // Mes en inglés
        $anio_actual = date('Y');
        $hora_actual = date('H:i:s A');
        $mes_traducido = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];
        $mes_actual_espanol = $mes_traducido[$mes_actual]; // Traducción del mes
        $fecha_hora_actual = "$dia_actual de $mes_actual_espanol del $anio_actual, $hora_actual";
        require_once('views/certificados/certificado_exportar_view.php');
        // require_once('views/certificados/certificado_view.php');
    }
    public function exportarCertificado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            // Uso
            $exportador = new ContextoExport();

            // Seleccionar la estrategia deseada (por ejemplo, PDF)
            switch ($datos['estrategia']) {
                case 1:
                    $exportador->setEstrategia(new Pdf());
                    $exportador->exportarDatos($datos);
                    break;
                case 2:
                    $exportador->setEstrategia(new Imagen());
                    $exportador->exportarDatos($datos);
                    break;
                case 3:
                    $exportador->setEstrategia(new Word());
                    $exportador->exportarDatos($datos);
                    break;
                case 4:
                    $exportador->setEstrategia(new Html());
                    $exportador->exportarDatos($datos);
                default:
                    # code...
                    break;
            }
        }
    }
}
