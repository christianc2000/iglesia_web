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
    case 'parentescos':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new ParentescoController();
      break;
    case 'actividades':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new ActividadController();
      break;
    case 'participacions':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new ParticipacionController();
      break;
    case 'certificados':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new CertificadoController();
      break;
    case 'ministerios':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new MinisterioController();
      break;
    case 'cargos':
      // echo "ENTRAMOS A PERSONAS";
      $controller = new CargoController();
      break;
  }

  $controller->{$action}();
}

// Entradas para el controlador y sus actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personas' => ['index', 'create', 'store', 'update', 'edit', 'delete'],
  'parentescos' => ['parentesco', 'storeParentesco', 'deleteParentesco'],
  'actividades' => ['index', 'create', 'store', 'edit', 'update', 'delete','estado','storeEstado'], 
  'participacions' => ['participacion', 'storeParticipacion', 'deleteParticipacion'],
  'certificados'=>['generarCertificado','exportarCertificado'],
  'ministerios' => ['index', 'create', 'store', 'edit', 'update', 'delete', 'show'],
  'cargos' => ['cargos', 'storeEncargado', 'finalizarCargoMinisterio']
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
