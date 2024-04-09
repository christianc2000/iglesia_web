<?php
class Ingreso
{
    public $id;
    public $nombre;
    public $monto;
    public $fecha_registro;
    public $actividad_id;

    public function __construct($id, $nombre, $monto, $fecha_registro, $actividad_id)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->monto = $monto;
        $this->fecha_registro = $fecha_registro;
        $this->actividad_id = $actividad_id;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM ingresos ORDER;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $ingreso) {
            $list[] = new Ingreso($ingreso['id'], $ingreso['nombre'], $ingreso['monto'], $ingreso['fecha_registro'], $ingreso['actividad_id']);
        }
        return $list;
    }
    public static function allIngresoActividad($actividad_id)
    {
        $list = [];
        $db = Db::getInstance();

        $query = "SELECT ingresos.* FROM ingresos,actividads
        WHERE ingresos.actividad_id=:actividad_id AND actividads.id=:actividad_id;";

        $req = $db->prepare($query);
        $req->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
        $req->execute();

        // Recorremos los resultados de la consulta
        foreach ($req->fetchAll() as $ingreso) {
            $list[] = new Ingreso($ingreso['id'], $ingreso['nombre'], $ingreso['monto'], $ingreso['fecha_registro'], $ingreso['actividad_id']);
        }

        return $list;
    }

    public static function recaudacion($actividad_id,$ingreso, $monto)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // Obtener el valor actual de montototal
            $query = 'SELECT montototal FROM actividads WHERE id = :actividad_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $montoTotalActual = $row['montototal'];

            // Calcular el nuevo valor de montototal sumando el monto actual con el nuevo monto
            $nuevoMontoTotal = $montoTotalActual + $monto;

            $query = 'INSERT INTO ingresos (nombre, monto, actividad_id) VALUES (:ingreso, :monto, :actividad_id)';
            $req_ingreso = $db->prepare($query);
            $req_ingreso->bindParam(':ingreso', $ingreso);
            $req_ingreso->bindParam(':monto', $monto);
            $req_ingreso->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $req_ingreso->execute();
            
            $query = 'UPDATE actividads
SET montototal = :montototal
WHERE id=:actividad_id;';
            $req_actividad = $db->prepare($query);
            $req_actividad->bindParam(':montototal', $nuevoMontoTotal);
            $req_actividad->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $req_actividad->execute();
            // Confirmar la transacción
            //SUMAR LA CANTIDAD TOTAL DEL montototal de la actividad

            $db->commit();
            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
    public static function recaudacionDelete($actividad_id, $ingreso_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // Obtener el valor actual de montototal
            $query = 'SELECT montototal FROM actividads WHERE id = :actividad_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $montoTotalActual = $row['montototal'];

            // Obtener el monto que deseas eliminar
            $query = 'SELECT monto FROM ingresos WHERE id = :id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $ingreso_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $montoAEliminar = $row['monto'];

            // Calcular el nuevo valor de montototal restando el monto a eliminar
            $nuevoMontoTotal = $montoTotalActual - $montoAEliminar;

            // Actualizar montototal en la tabla actividads
            $query = 'UPDATE actividads SET montototal = :nuevoMontoTotal WHERE id = :actividad_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nuevoMontoTotal', $nuevoMontoTotal);
            $stmt->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar el registro de actividad_ingreso
            $query = 'DELETE FROM ingresos WHERE id = :id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $ingreso_id, PDO::PARAM_INT);
            $stmt->execute();

            $db->commit();
            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
