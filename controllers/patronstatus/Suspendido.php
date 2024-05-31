<?php
require_once('controllers/patronstatus/ActividadContexto.php');
require_once('controllers/patronstatus/ActividadEstado.php');
require_once('controllers/patronstatus/EnProgreso.php');
require_once('controllers/patronstatus/Cancelado.php');
class Suspendido implements ActividadEstado {
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
        return $this->transicionValida;
    }
    public function pendiente(){
        $this->transicionValida=false;
    }
    public function iniciar() {
        echo "Reanudando la actividad suspendida\n";
        // Lógica para reanudar desde el estado Suspendido
        $this->contexto->transicion(new EnProgreso());
    }

    public function completar() {
        echo "No se puede completar la actividad suspendida\n";
        $this->transicionValida = false;
    }

    public function suspender() {
        echo "La actividad ya está suspendida\n";
        $this->transicionValida = false;
    }

    public function cancelar() {
        echo "Cancelando la actividad suspendida\n";
        // Lógica para cancelar desde el estado Suspendido
        $this->contexto->transicion(new Cancelado());
    }
}