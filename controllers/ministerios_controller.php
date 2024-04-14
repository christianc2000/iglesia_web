<?php
require_once('models/ministerio_model.php');
class MinisterioController
{
    public function index()
    {
        $ministerios = Ministerio::all();

        require_once('views/ministerios/ministerio_index_view.php');
    }
    public function create()
    {
        require_once('views/ministerios/ministerio_create_view.php');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];

            // echo "está en el store ministerio";
            $ministerio = Ministerio::create($nombre, $descripcion, $estado);

            if ($ministerio) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=ministerios&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function show()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');

        $ministerio = Ministerio::find($_GET['id']);

        require_once('views/ministerios/ministerio_show_view.php');
    }
    public function edit()
    {
        if (!isset($_GET['id']))
            return call('pages', 'error');

        $ministerio = Ministerio::find($_GET['id']);

        require_once('views/ministerios/ministerio_edit_view.php');
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $descripcion = $_POST['descripcion'];
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];


            // echo $correo;
            $ministerio = Ministerio::update($id, $nombre, $descripcion, $estado);

            if ($ministerio) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=ministerios&action=index");
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
}
