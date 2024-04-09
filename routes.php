<?php
function call($controller, $action)
{
  require_once('controllers/' . $controller . '_controller.php');

  switch ($controller) {
    case 'pages':
      $controller = new PagesController();
      break;
    case 'personas':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new PersonaController();
      break;
    case 'actividades':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new ActividadController();
      break;
      case 'ministerios':
        // echo "ENTRAMOS A PERSONAS";
        $controller = new MinisterioController();
        break;
  }

  $controller->{$action}();
}

// Entradas para el controlador y sus actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personas' => ['index', 'create', 'store', 'update', 'edit', 'delete', 'parentezco', 'storeParentezco', 'deleteParentezco'],
  'actividades' => ['index', 'create', 'store', 'edit', 'update', 'delete', 'recaudacion', 'storeRecaudacion', 'deleteRecaudacion', 'asistencia', 'storeAsistencia', 'deleteAsistencia'],
  'ministerios' => ['index', 'create', 'store', 'edit', 'update', 'delete','show','cargos','storeEncargado','finalizarCargoMinisterio']
);

if (array_key_exists($controller, $controllers)) {
  if (in_array($action, $controllers[$controller])) {
    call($controller, $action);
  } else {
    call('pages', 'error');
  }
} else {
  call('pages', 'error');
}
