<?php
require_once('patron/ActividadContexto.php');
require_once('patron/ActividadEstado.php');
require_once('patron/Completado.php');
require_once('patron/Suspendido.php');
require_once('patron/Cancelado.php');
class EnProgreso implements ActividadEstado {
    private $contexto;
    private $transicionValida;

    public function __construct() {
        // Por defecto, la transición se considera válida
        $this->transicionValida = true;
    }

    public function setContexto(ActividadContexto $contexto) {
        $this->contexto = $contexto;
    }

    public function transicionValida() {
        echo "Estoy en progreso ".$this->transicionValida;
        return $this->transicionValida;
    }
    public function pendiente(){
        $this->transicionValida=false;
    }
    public function iniciar() {
        echo "La actividad ya está en progreso\n";
        $this->transicionValida = false;
    }

    public function completar() {
        echo "Completando la actividad desde el estado En Progreso\n";
        // Lógica para completar desde el estado En Progreso
        $this->contexto->transicion(new Completado());
    }

    public function suspender() {
        echo "Suspendiendo la actividad desde el estado En Progreso\n";
        // Lógica para suspender desde el estado En Progreso
        $this->contexto->transicion(new Suspendido());
    }

    public function cancelar() {
        echo "Cancelando la actividad desde el estado En Progreso\n";
        // Lógica para cancelar desde el estado En Progreso
        $this->contexto->transicion(new Cancelado());
    }
}