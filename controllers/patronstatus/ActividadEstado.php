<?php
require_once('controllers/patronstatus/ActividadContexto.php');
// Interfaz de Estado
interface ActividadEstado {
    public function setContexto(ActividadContexto $contexto);
    public function transicionValida();
    public function pendiente();
    public function iniciar();
    public function completar();
    public function suspender();
    public function cancelar();
}
