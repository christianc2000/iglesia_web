<?php
require_once('controllers/patronstatus/ActividadContexto.php');
require_once('controllers/patronstatus/ActividadEstado.php');
class Cancelado implements ActividadEstado
{
    private $contexto;
    private $transicionValida;

    public function __construct()
    {
        // Por defecto, la transición se considera válida
        $this->transicionValida = true;
    }

    public function setContexto(ActividadContexto $contexto)
    {
        $this->contexto = $contexto;
    }

    public function transicionValida()
    {
        return $this->transicionValida;
    }

    public function pendiente(){
        $this->transicionValida=false;
    }
    public function iniciar()
    {
        // echo "No se puede iniciar una actividad cancelada\n";
        $this->transicionValida = false;
    }

    public function completar()
    {
        echo "No se puede completar una actividad cancelada\n";
        $this->transicionValida = false;
    }

    public function suspender()
    {
        echo "No se puede suspender una actividad cancelada\n";
        $this->transicionValida = false;
    }

    public function cancelar()
    {
        echo "La actividad ya está cancelada\n";
        $this->transicionValida = false;
    }
}
