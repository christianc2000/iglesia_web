<?php
require_once('models/persona_model.php');
// require_once('models/parentesco_model.php');
// require_once('models/tipo_parentesco_model.php');
class PersonaController
{

  public function index()
  {
    $personas = Persona::all();//Persona::all();
    require_once('views/personas/persona_index_view.php');
  }
  public function edit()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');
    $persona = Persona::find($_GET['id']);
    require_once('views/personas/persona_edit_view.php');
  }
  public function create()
  {
    require_once('views/personas/persona_create_view.php');
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $ci = $_POST['ci'];
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $correo = $_POST['correo'];
      $celular = $_POST['celular'];
      $direccion = $_POST['direccion'];
      $sexo = $_POST['sexo'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];
      // echo $correo;
      $persona = Persona::create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento);

      if ($persona) {
        // Redirige a una página de éxito o muestra un mensaje de éxito
        header("Location: ?controller=personas&action=index");
        exit();
      } else {
        // Maneja el caso en el que la creación de la persona falla
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
      $ci = $_POST['ci'];
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $correo = $_POST['correo'];
      $celular = $_POST['celular'];
      $direccion = $_POST['direccion'];
      $sexo = $_POST['sexo'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];

      // echo $correo;
      $persona = Persona::update($id, $ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento);

      if ($persona) {
        // Redirige a una página de éxito o muestra un mensaje de éxito
        header("Location: ?controller=personas&action=index");
        exit();
      } else {
        // Maneja el caso en el que la creación de la persona falla
        // Puedes redirigir a una página de error o mostrar un mensaje de error
        header("Location: ?controller=home&action=error");
        exit();
      }
    }
  }
  public function delete()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');
    $miembro = Persona::delete($_GET['id']);

    if ($miembro) {
      // Redirige a una página de éxito o muestra un mensaje de éxito
      header("Location: ?controller=personas&action=index");
      exit();
    } else {
      // Maneja el caso en el que la creación de la persona falla
      // Puedes redirigir a una página de error o mostrar un mensaje de error
      header("Location: ?controller=home&action=error");
      exit();
    }
  }
}
