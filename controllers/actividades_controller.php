<?php
require_once('models/actividad_model.php');
// require_once('models/persona_model.php');
// require_once('models/participacion_model.php');
require_once('models/sacramento_model.php');
// require_once('models/tipo_participacion_model.php');
class ActividadController
{
    public function index()
    {
        $actividades = Actividad::all();

        require_once('views/actividades/actividad_index_view.php');
    }

    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        //    $visitante = Visitante::find($_GET['id']);

        require_once('views/actividades/actividad_show_view.php');
    }

    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        $sacramentos = Sacramento::all();
        $sacramento=Sacramento::find($actividad->sacramento_id);
        require_once('views/actividades/actividad_edit_view.php');
    }

    public function create()
    {
        $sacramentos = Sacramento::all();
        require_once('views/actividades/actividad_create_view.php');
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
}
