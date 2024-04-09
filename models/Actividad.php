<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

class Actividad
{
    public $id;
    public $nombre;
    public $fecha;
    public $horaInicio;
    public $horaFin;

    public $montoTotal;
    public function __construct($id,$nombre,$fecha,$horaInicio,$horaFin,$montoTotal) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        $this->montoTotal = $montoTotal;
        $this->nombre = $nombre;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM actividads;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $actividad) {
            $list[] = new Actividad($actividad['id'],$actividad['nombre'], $actividad['fecha'], $actividad['horainicio'], $actividad['horafin'], $actividad['montototal']);
        }
        return $list;
    }

    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM actividads WHERE id = :id');

        $req->execute(array('id' => $id));
        $actividad = $req->fetch();
        $actividad =  new Actividad($actividad['id'], $actividad['nombre'], $actividad['fecha'], $actividad['horainicio'], $actividad['horafin'], $actividad['montototal']);

        return $actividad;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }

    public static function update($id,$nombre, $fecha, $horaInicio, $horaFin)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {

            // ACTUALIZAR LOS DATOS DE LA ACTIVIDAD
            $query = 'UPDATE actividads SET  nombre = :nombre, fecha = :fecha, horainicio = :horaInicio, horafin = :horaFin WHERE id = :id';
            $req_actividad = $db->prepare($query);

            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
            $req_actividad->bindParam(':nombre', $nombre);
            $req_actividad->bindParam(':id', $id);
            $req_actividad->execute();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function create($nombre,$fecha, $horaInicio, $horaFin, $montoTotal)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $query = 'INSERT INTO actividads (nombre,fecha, horainicio, horafin, montototal) VALUES (:nombre, :fecha, :horaInicio, :horaFin, :montoTotal);';
            $req_actividad = $db->prepare($query);

            $req_actividad->bindParam(':nombre', $nombre);
            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
            $req_actividad->bindParam(':montoTotal', $montoTotal);
            $req_actividad->execute();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            echo "ERROR: $e";
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
