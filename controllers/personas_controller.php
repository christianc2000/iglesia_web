<?php
require_once('models/Persona.php');
require_once('models/Parentezco.php');
class PersonaController
{
  public function index()
  {
    $personas = Persona::all();
    require_once('views/personas/index.php');
  }
  public function edit()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');
    $persona = Persona::find($_GET['id']);
    require_once('views/personas/edit.php');
  }
  public function create()
  {
    require_once('views/personas/create.php');
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
      $tipo = $_POST['tipo'];
      // echo $correo;
      $persona = Persona::create($ci, $nombre, $apellido, $correo, $tipo, $celular, $direccion, $sexo, $fecha_nacimiento);

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
      $tipo = $_POST['tipo'];
      $sexo = $_POST['sexo'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];

      // echo $correo;
      $persona = Persona::update($id, $ci, $nombre, $apellido, $correo, $tipo, $celular, $direccion, $sexo, $fecha_nacimiento);

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

  //PARENTEZCO
  public function parentezco()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');
    $id = $_GET['id'];
    $personas = Parentezco::sinParentezcos($id);
    $parentezcos = Parentezco::misParentezcos($id);
    // echo $parentezcos[1]['pariente_nombre'];
    // $parentezcos_relacionados = Parentezco::getMiembroParentezcoRelacionados($id);
    $persona = Persona::find($id);
    require_once('views/personas/parentezco.php');
  }
  public function storeParentezco()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $personaA_id = $_POST['personaA_id'];
      $personaB_id = $_POST['personaB_id'];
      $parentezco = $_POST['parentezco'];
      // echo "ingresa a storeParentezco " . $miembroa_id . ", " . $miembrob_id . ", " . $parentezco;
      $parentezco = Parentezco::create($parentezco, $personaA_id, $personaB_id);
      //    echo "pasa a storeParentezco " . $parentezco;
      if ($parentezco) {
        // Redirige a una página de éxito o muestra un mensaje de éxito
        header("Location: ?controller=personas&action=parentezco&id=" . $personaA_id);
        exit();
      } else {
        // Maneja el caso en el que la creación de la persona falla
        // Puedes redirigir a una página de error o mostrar un mensaje de error
        header("Location: ?controller=home&action=error");
        exit();
      }
    }
  }
  public function deleteParentezco()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $persona_id = $_POST['persona_id'];
      $personaA_id = $_POST['personaA_id'];
      $personaB_id = $_POST['personaB_id'];

      // echo "antes del delete";

      $parentezco = Parentezco::delete($personaA_id, $personaB_id);
      // echo "pasa a storeParentezco " . $parentezco;
      if ($parentezco) {
        echo "id: " . $personaA_id;
        echo "id: " . $personaB_id;
        // Redirige a una página de éxito o muestra un mensaje de éxito
        header("Location: ?controller=personas&action=parentezco&id=" . $persona_id);
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
