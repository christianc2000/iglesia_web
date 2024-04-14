<?php 

require_once('models/cargo_model.php');
require_once('models/tipo_cargo_model.php');
require_once('models/persona_model.php');
require_once('models/ministerio_model.php');

class CargoController{
    public function cargos()
    {

        if (!isset($_GET['id'])) //el id del ministerio
            return call('pages', 'error');
        $miembros = Persona::all(); //todos los miembros que pueda seleccionar
        $miembros_con_cargos = Cargo::getMiembrosVigentesMinisterio($_GET['id']); //retorna el historial del ministerio con miembros vigentes que pertenecen a él
        //    print_r($historialv_ministerio);
        //    var_dump($historialv_ministerio[0][1]);
        $tipo_cargos = TipoCargo::all();
        $miembros_sin_cargos = Cargo::getMiembrosCaducadosMinisterio($_GET['id']); //retorna el historial del ministerio con miembros caducados que pertenecen a él
        $ministerio = Ministerio::find($_GET['id']);
        require_once('views/ministerios/ministerio_cargo_view.php');
    }
    public function storeEncargado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ministerio_id = $_POST['id'];
            $miembro_id = $_POST['miembro_id'];
            $tipo_cargo_id = $_POST['tipo_cargo_id'];
            $fecha_registro = $_POST['fecha_registro'];
            $cargo = Cargo::create($tipo_cargo_id, $miembro_id, $ministerio_id, $fecha_registro);

            if ($cargo) {
                // Redirige a una página de éxito o muestra un mensaje de éxito
                header("Location: ?controller=cargos&action=cargos&id=" . $ministerio_id);
                exit();
            } else {
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
    public function finalizarCargoMinisterio()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ministerio_id = $_POST['ministerio_id'];
            $cargo_id = $_POST['cargo_id'];

            // echo "antes del ministerio id" . $ministerio_id;
            // echo "antes del historial id" . $historial_id;
            $cargo = Cargo::finalizarCargoMinisterio($cargo_id);
            // echo "pasa a storeParentezco " . $historialministerio;
            if ($cargo) {
                header("Location: ?controller=cargos&action=cargos&id=" . $ministerio_id);
                exit();
            } else {
                echo "no entra";
                // Maneja el caso en el que la creación de la persona falla
                // Puedes redirigir a una página de error o mostrar un mensaje de error
                header("Location: ?controller=home&action=error");
                exit();
            }
        }
    }
}