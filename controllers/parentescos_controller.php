<?php
require_once('models/persona_model.php');
require_once('models/parentesco_model.php');
require_once('models/tipo_parentesco_model.php');
class ParentescoController
{
    public function parentesco()
    {
      if (!isset($_GET['id']))
        return call('pages', 'error');
      $id = $_GET['id'];
      $personas = Parentesco::sinParentescos($id);
      $parientes = Parentesco::misParentescos($id);
      $tipo_parentescos = TipoParentesco::all();
      // echo $parentezcos[1]['pariente_nombre'];
      // $parentezcos_relacionados = Parentezco::getMiembroParentezcoRelacionados($id);
      $persona = Persona::find($id);
      // $persona->id;
      require_once('views/personas/persona_parentesco_view.php');
    }
    public function storeParentesco()
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $personaA_id = $_POST['personaA_id'];
        $personaB_id = $_POST['personaB_id'];
        $tipo_parentesco_id = $_POST['tipo_parentesco_id'];
        // echo "ingresa a storeParentezco " . $miembroa_id . ", " . $miembrob_id . ", " . $parentezco;
        $parentezco = Parentesco::create($tipo_parentesco_id, $personaA_id, $personaB_id);
        //    echo "pasa a storeParentezco " . $parentezco;
        if ($parentezco) {
          // Redirige a una página de éxito o muestra un mensaje de éxito
          header("Location: ?controller=parentescos&action=parentesco&id=" . $personaA_id);
          exit();
        } else {
          // Maneja el caso en el que la creación de la persona falla
          // Puedes redirigir a una página de error o mostrar un mensaje de error
          header("Location: ?controller=home&action=error");
          exit();
        }
      }
    }
    public function deleteParentesco()
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $personaA_id = $_POST['personaA_id'];
        $personaB_id = $_POST['personaB_id'];
  
        // echo "antes del delete";
  
        $parentezco = Parentesco::delete($personaA_id, $personaB_id);
        // echo "pasa a storeParentezco " . $parentezco;
        if ($parentezco) {
          echo "id: " . $personaA_id;
          echo "id: " . $personaB_id;
          // Redirige a una página de éxito o muestra un mensaje de éxito
          header("Location: ?controller=parentescos&action=parentesco&id=" . $personaA_id);
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