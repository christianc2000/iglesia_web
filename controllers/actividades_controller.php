<?php
require_once('models/Actividad.php');
require_once('models/Persona.php');
require_once('models/Participacion.php');
require_once('models/Sacramento.php');
require_once('models/TipoParticipacion.php');
class ActividadController
{
    public function index()
    {
        $actividades = Actividad::all();

        require_once('views/actividades/index.php');
    }

    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        //    $visitante = Visitante::find($_GET['id']);

        require_once('views/actividades/show.php');
    }

    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        require_once('views/actividades/edit.php');
    }

    public function create()
    {
        $sacramentos = Sacramento::all();
        require_once('views/actividades/create.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = $_POST['fecha'];
            $horaInicio = $_POST['hora_inicio'];
            $horaFin = $_POST['hora_fin'];
            $sacramento_id = $_POST['sacramento_id'];
            //  echo "Estoy en actividads: fecha: $fecha, horaInicio: $horaInicio, horaFin: $horaFin, montoTotal: $montoTotal, nombre: $nombre"; 
            $created = Actividad::create($fecha, $horaInicio, $horaFin, $sacramento_id);

            if ($created) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la actividad falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $fecha = $_POST['fecha'];
            $horaInicio = $_POST['hora_inicio'];
            $horaFin = $_POST['hora_fin'];
            // $montoTotal = $_POST['montoTotal'];
            $nombre = $_POST['nombre'];
            // echo "Estoy en actividads: fecha: $fecha, horaInicio: $horaInicio, horaFin: $horaFin, nombre: $nombre";

            $updated = Actividad::update($id, $nombre, $fecha, $horaInicio, $horaFin);

            if ($updated) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=index");
                exit();
            } else {
                // Maneja el caso en el que la actualización de la actividad falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }


    // public function delete()
    // {
    //     if (!isset($_GET['id']))
    //         return call('pages', 'error');
    // $miembro = Miembro::delete($_GET['id']);

    // if ($miembro) {
    //     // Redirige a una página de éxito o muestra un mensaje de éxito
    //     header("Location: ?controller=miembros&action=index");
    //     exit();
    // } else {
    //     // Maneja el caso en el que la creación de la persona falla
    //     // Puedes redirigir a una página de error o mostrar un mensaje de error
    //     header("Location: ?controller=home&action=error");
    //     exit();
    // }
    // }
    /****************PARTICIPACION******************* */
    public function participacion()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $personas = Persona::allPersonAsistencia($_GET['id']);
        $actividad = Actividad::find($_GET['id']);
        $tipo_participacions = TipoParticipacion::all();
        $participacions = Participacion::getAllParticipacion($_GET['id']);
        $sacramento = Sacramento::find($actividad->sacramento_id);
        //echo $asistencias[1][1];
        require_once('views/actividades/participacion.php');
    }
    public function deleteParticipacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $persona_id = $_POST['persona_id'];
            $actividad_id = $_POST['actividad_id'];
            $participacion = Participacion::deleteParticipacion($actividad_id, $persona_id);
            if ($participacion) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=participacion&id=" . $actividad_id);
                exit();
            } else {
                // Maneja el caso en el que la actualización de la actividad falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function storeParticipacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actividad_id = $_POST['actividad_id'];
            $persona_id = $_POST['persona_id'];
            $tipo_participacion_id = $_POST['tipo_participacion_id'];
            // echo "ingresa a storeParentezco " . $miembroa_id . ", " . $miembrob_id . ", " . $parentezco;
            $participacion = Participacion::create($persona_id, $actividad_id, $tipo_participacion_id);
            //    echo "pasa a storeParentezco " . $parentezco;
            if ($participacion) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=actividades&action=participacion&id=" . $actividad_id);
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }

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
        $fecha_actual = date('d/m/Y');
        $hora_actual = date('H:i:s');
        $fecha_hora_actual=$fecha_actual." ".$hora_actual;
        // echo $protagonistas;
        // echo $sacramento->nombre;
        // require_once('views/pdf/certificado_matrimonio.php');
        require_once('views/pdf/certificado.php');
    }
}
