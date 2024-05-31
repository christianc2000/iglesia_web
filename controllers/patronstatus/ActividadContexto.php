<?php
require_once('controllers/patronstatus/ActividadEstado.php');
// Clase Contexto
class ActividadContexto {
    private $estado;
 
    public function __construct(ActividadEstado $estado) {
        $this->transicion($estado);
    }

    public function transicion(ActividadEstado $estado) {
        $this->estado = $estado;
        $this->estado->setContexto($this);
    }
    public function pendiente(){
        $this->estado->pendiente();
    }
    public function iniciar() {
        $this->estado->iniciar();
    }

    public function completar() {
        $this->estado->completar();
    }

    public function suspender() {
        $this->estado->suspender();
    }

    public function cancelar() {
        $this->estado->cancelar();
    }
    public function transicionValida(){
        return $this->estado->transicionValida();
    }
}