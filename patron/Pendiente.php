<?php
require_once('patron/ActividadContexto.php');
require_once('patron/ActividadEstado.php');
require_once('patron/EnProgreso.php');
require_once('patron/Cancelado.php');
class Pendiente implements ActividadEstado
{
    private $contexto;
    private $transicionValida;

    public function __construct() {
        // Por defecto, la transición se considera válida
        $this->transicionValida = true;
    }

    public function setContexto(ActividadContexto $contexto)
    {
        $this->contexto = $contexto;
    }

    public function transicionValida() {
        return $this->transicionValida;
    }
    public function pendiente(){
        $this->transicionValida=false;
    }
    public function iniciar()
    {
        //echo "Iniciando la actividad desde el estado Pendiente\n";
        // Lógica para iniciar desde el estado Pendiente
        // Aquí se podría validar si la actividad puede pasar al estado EnProgreso
        // y luego transicionar al estado EnProgreso
        $this->contexto->transicion(new EnProgreso());
    }

    public function completar()
    {
        echo "No se puede completar la actividad desde el estado Pendiente\n";
        $this->transicionValida = false;
    }

    public function suspender()
    {
        echo "No se puede suspender la actividad desde el estado Pendiente\n";
        $this->transicionValida = false;
    }

    public function cancelar()
    {
        echo "Cancelando actividad pendiente\n";
        $this->contexto->transicion(new Cancelado());
    }
}
