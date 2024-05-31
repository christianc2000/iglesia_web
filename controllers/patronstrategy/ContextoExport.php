<?php
require_once('controllers/patronstrategy/EstrategiaExport.php');
class ContextoExport{
    private $estrategia;

    public function setEstrategia(EstrategiaExport $estrategia){
        $this->estrategia=$estrategia;
    }

    public function exportarDatos($datos){
        $this->estrategia->exportar($datos);
    }

}