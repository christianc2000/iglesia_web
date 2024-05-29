<?php
require_once('patron/ActividadContexto.php');
require_once('patron/ActividadEstado.php');
class Completado implements ActividadEstado {
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
        echo "La actividad ya está completada\n";
        $this->transicionValida = false;
    }

    public function completar() {
        echo "La actividad ya está completada\n";
        $this->transicionValida = false;
    }

    public function suspender() {
        echo "No se puede suspender la actividad completada\n";
        $this->transicionValida = false;
    }

    public function cancelar() {
        echo "No se puede cancelar la actividad completada\n";
        $this->transicionValida = false;
    }
}