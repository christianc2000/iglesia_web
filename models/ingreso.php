<?php
class Ingreso
{
    public $id;
    public $nombre;
    public $created_at;
    public $updated_at;

    public function __construct($id, $nombre, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM ingresos ORDER BY updated_at DESC;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $ingreso) {
            $list[] = new Ingreso($ingreso['id'], $ingreso['nombre'], $ingreso['created_at'], $ingreso['updated_at']);
        }
        return $list;
    }
    public static function allIngresoActividad($actividad_id)
    {
        $list = [];
        $db = Db::getInstance();

        $query = "SELECT ingresos.*
        FROM ingresos
        LEFT JOIN actividad_ingreso ON ingresos.id = actividad_ingreso.ingreso_id AND actividad_ingreso.actividad_id = :actividad_id
        WHERE actividad_ingreso.actividad_id IS NULL;";

        $req = $db->prepare($query);
        $req->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
        $req->execute();

        // Recorremos los resultados de la consulta
        foreach ($req->fetchAll() as $ingreso) {
            $list[] = new Ingreso($ingreso['id'], $ingreso['nombre'], $ingreso['created_at'], $ingreso['updated_at']);
        }

        return $list;
    }
}
?>