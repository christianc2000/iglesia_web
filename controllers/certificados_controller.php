<?php
require_once('models/participacion_model.php');
require_once('models/sacramento_model.php');
require_once('models/actividad_model.php');
class CertificadoController
{
    public function generarPDF()
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
        // echo $actividad->id;
        $sacramento = Sacramento::find($actividad->sacramento_id);
        $protagonistas = Participacion::getProtagonista($actividad_id);
        $protagonistas = salida($protagonistas);
        date_default_timezone_set('America/La_Paz');

        // Obtener la fecha y hora actual
        // $fecha_actual = date('d/m/Y');
        // $hora_actual = date('H:i:s');
        // $fecha_hora_actual=$fecha_actual.", ".$hora_actual;
        // Obtener la fecha y hora actual
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
        //         $hora_actual = time(); // Obtener la marca de tiempo actual (puedes reemplazar esto con tu marca de tiempo)
        // $fecha_objeto = date_create("@$hora_actual"); // Crear un objeto DateTime
        // $fecha_formateada = date_format($fecha_objeto, "d \d\e F \d\e\l Y, H:i:s A");
        // echo $protagonistas;
        // echo $sacramento->nombre;
        // require_once('views/pdf/certificado_matrimonio.php');
        require_once('views/certificados/certificado_view.php');
    }
}
