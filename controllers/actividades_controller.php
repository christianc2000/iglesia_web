<?php
require_once('models/actividad_model.php');
// require_once('models/persona_model.php');
// require_once('models/participacion_model.php');
require_once('models/sacramento_model.php');
require_once('models/estado_model.php');
require_once('patron/ActividadContexto.php');
require_once('patron/Pendiente.php');
require_once('patron/EnProgreso.php');
require_once('patron/Completado.php');
require_once('patron/Suspendido.php');
require_once('patron/Cancelado.php');

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

    public function estado()
    { //ir a vista de estado
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        $estados = Estado::all();
        $estado = Estado::findByActividad($_GET['id']);
        require_once('views/actividades/actividad_estado_view.php');
    }
    public function storeEstado()
    { //Mi contexto
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estado_id = $_POST['estado_id'];
            $actividad_id = $_POST['actividad_id'];
            $estado = Estado::find($estado_id);
            $actividad = Actividad::find($actividad_id);
            $estado_actual=Estado::find($actividad->estado_id);
            // Crear un contexto de actividad con el estado correspondiente
            switch ($actividad->estado_id) {
                case 1:
                    $contexto = new ActividadContexto(new Pendiente());
                    break;
                case 2:
                    $contexto = new ActividadContexto(new EnProgreso());
                    break;
                case 3:
                    $contexto = new ActividadContexto(new Completado());
                    break;
                case 4:
                    $contexto = new ActividadContexto(new Suspendido());
                    break;
                case 5:
                    $contexto = new ActividadContexto(new Cancelado());
                    break;
                default:
                    // Estado no válido, manejar el caso según tus necesidades
                    break;
            }
            switch ($estado_id) {
                case 1:
                    $contexto->pendiente();
                    break;
                case 2:
                    $contexto->iniciar();
                    break;
                case 3:
                    $contexto->completar();
                    break;
                case 4:
                    $contexto->suspender();
                    break;
                case 5:
                    $contexto->cancelar();
                    break;
                default:
                    // Estado no válido, manejar el caso según tus necesidades
                    break;
            }
            // echo "Estado en controlador: ".$contexto->transicionValida()."\n";
            if ($contexto->transicionValida()) {
                echo "Entra succes a TRUE";
                $updated = Actividad::updateEstado($actividad->id, $estado_id);
                if ($updated) {
                    header("Location: ?controller=actividades&action=index");
                    exit();
                } else {
                    header("Location: ?controller=home&action=error");
                    exit();
                }
            } else {
                $mensaje_error = urlencode("No puede pasar del estado <strong>".$estado_actual->nombre."</strong> al estado <strong>".$estado->nombre."</strong>");
                // $_SESSION['error'] = "No puede pasar del estado <strong>".$estado_actual->nombre."</strong> al estado <strong>".$estado->nombre."</strong>";
                header("Location: ?controller=actividades&action=estado&id=" . $actividad->id . "&error=" . $mensaje_error);
                // header("Location: ?controller=actividades&action=estado&id=".$actividad->id);
                exit(); // Asegúrate de salir después de redireccionar
            }
        }
    }
    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');
        $actividad = Actividad::find($_GET['id']);
        $sacramentos = Sacramento::all();
        $sacramento = Sacramento::find($actividad->sacramento_id);
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
            $created = Actividad::create($fecha, $horaInicio, $horaFin, $sacramento_id, 1);

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
            $sacramento_id = $_POST['$sacramento_id'];
            // $montoTotal = $_POST['montoTotal'];
            $nombre = $_POST['nombre'];
            // echo "Estoy en actividads: fecha: $fecha, horaInicio: $horaInicio, horaFin: $horaFin, nombre: $nombre";

            $updated = Actividad::update($id, $nombre, $fecha, $horaInicio, $horaFin, $sacramento_id);

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
