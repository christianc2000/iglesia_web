<?php
class Actividad
{
    public $id;
    public $fecha;
    public $horaInicio;
    public $horaFin;
    public $sacramento_id;
    public $estado_id; 
    public function __construct($id,$fecha,$horaInicio,$horaFin,$sacramento_id, $estado_id) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        $this->sacramento_id = $sacramento_id;
        $this->estado_id=$estado_id;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT actividads.*,sacramentos.nombre as sacramento_nombre, estados.nombre as estado_nombre FROM actividads,sacramentos,estados
        WHERE actividads.sacramento_id=sacramentos.id and actividads.estado_id=estados.id;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $actividad) {
            $list[] = ['id'=>$actividad['id'], 'fecha'=>$actividad['fecha'], 'horaInicio'=>$actividad['horainicio'], 'horaFin'=>$actividad['horafin'], 'sacramento_id'=>$actividad['sacramento_id'],'sacramento_nombre'=>$actividad['sacramento_nombre'],'estado'=>$actividad['estado_nombre']];
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
        $actividad =  new Actividad($actividad['id'], $actividad['fecha'], $actividad['horainicio'], $actividad['horafin'], $actividad['sacramento_id'], $actividad['estado_id']);

        return $actividad;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }

    public static function update($id, $nombre, $fecha, $horaInicio, $horaFin, $sacramento_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {

            // ACTUALIZAR LOS DATOS DE LA ACTIVIDAD
            $query = 'UPDATE actividads SET nombre=:nombre fecha = :fecha, horainicio = :horaInicio, horafin = :horaFin, sacramento_id=:sacramento_id WHERE id = :id';
            $req_actividad = $db->prepare($query);


            $req_actividad->bindParam(':sacramento_id', $sacramento_id);
            $req_actividad->bindParam(':nombre', $nombre);
            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
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
    public static function updateEstado($id, $estadoId)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $estadoId = intval($estadoId);
            $id = intval($id);
            // ACTUALIZAR LOS DATOS DE LA ACTIVIDAD
            $query = 'UPDATE actividads SET estado_id=:estadoId WHERE id = :id';
            $req_actividad = $db->prepare($query);


            $req_actividad->bindParam(':estadoId', $estadoId);
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
    public static function create($fecha, $horaInicio, $horaFin, $sacramento_id,$estado_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            $query = 'INSERT INTO actividads (fecha, horainicio, horafin, sacramento_id,estado_id) VALUES (:fecha, :horaInicio, :horaFin, :sacramento_id, :estado_id);';
            $req_actividad = $db->prepare($query);

            $req_actividad->bindParam(':fecha', $fecha);
            $req_actividad->bindParam(':horaInicio', $horaInicio);
            $req_actividad->bindParam(':horaFin', $horaFin);
            $req_actividad->bindParam(':sacramento_id', $sacramento_id);
            $req_actividad->bindParam(':estado_id', $estado_id);
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
