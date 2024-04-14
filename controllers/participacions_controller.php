<?php
require_once('models/persona_model.php');
require_once('models/participacion_model.php');
require_once('models/sacramento_model.php');
require_once('models/tipo_participacion_model.php');
require_once('models/actividad_model.php');
class ParticipacionController
{
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
      require_once('views/actividades/actividad_participacion_view.php');
  }
  public function deleteParticipacion()
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $persona_id = $_POST['persona_id'];
          $actividad_id = $_POST['actividad_id'];
          $participacion = Participacion::deleteParticipacion($actividad_id, $persona_id);
          if ($participacion) {
              // Redirige a una página de éxito o muestra un mensaje de éxito
              header("Location: ?controller=participacions&action=participacion&id=" . $actividad_id);
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
              header("Location: ?controller=participacions&action=participacion&id=" . $actividad_id);
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