<?php
class Participacion
{
    public $actividad_id;
    public $persona_id;
    public $tipo_participacion_id;
    public $fecha_registro;
    public function __construct($actividad_id, $persona_id, $tipo_participacion_id, $fecha_registro)
    {
        $this->actividad_id = $actividad_id;
        $this->persona_id = $persona_id;
        $this->tipo_participacion_id = $tipo_participacion_id;
        $this->fecha_registro = $fecha_registro;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT participacions.*, tipo_participacions.nombre as tipo_participacion_nombre FROM participacions, tipo_participacions WHERE participacions.tipo_participacion_id=tipo_participacions.id;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $participacion) {
            $list[] = [$participacion['actividad_id'], $participacion['persona_id'], $participacion['tipo_participacion_id'], $participacion['fecha_registro'], $participacion['tipo_participacion_nombre']];
        }
        return $list;
    }
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM participacions WHERE id = :id');

        $req->execute(array('id' => $id));
        $asistencia = $req->fetch();
        return new Participacion($asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['tipo_participacion_id'], $asistencia['fecha_registro']);
    }
    public static function getAllParticipacion($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare("SELECT participacions.*, CONCAT(personas.nombre,' ',personas.apellido) as nombre_completo, tipo_participacions.nombre as tipo_participacion_nombre FROM participacions, personas, tipo_participacions 
        WHERE participacions.actividad_id = :id and personas.id = participacions.persona_id AND tipo_participacions.id=participacions.tipo_participacion_id;");
        $req->execute(array('id' => $id));

        while ($participacions = $req->fetch()) {

            $list[] = ['actividad_id' => $participacions['actividad_id'], 'persona_id' => $participacions['persona_id'], 'tipo_participacion_id' => $participacions['tipo_participacion_id'], 'fecha_registro' => $participacions['fecha_registro'], 'persona_nombrecompleto' => $participacions['nombre_completo'],'tipo_participacion_nombre'=>$participacions['tipo_participacion_nombre']];
        }
        return $list;
    }
    public static function getProtagonista($actividad_id){
        $list = [];
        $db = Db::getInstance();

        $id = intval($actividad_id);
        $req = $db->prepare("SELECT personas.id as persona_id,CONCAT(personas.nombre,' ',personas.apellido) as persona_nombre, sacramentos.nombre as sacramento_nombre FROM sacramentos,actividads, participacions,personas,tipo_participacions
        WHERE actividads.id=:id AND participacions.actividad_id=:id AND participacions.tipo_participacion_id=tipo_participacions.id AND tipo_participacions.nombre='Protagonista'
        AND participacions.persona_id=personas.id AND sacramentos.id=actividads.sacramento_id;");
        $req->execute(array('id' => $actividad_id));

        while ($participacions = $req->fetch()) {

            $list[] = ['persona_id' => $participacions['persona_id'], 'persona_nombre' => $participacions['persona_nombre'], 'sacramento_nombre' => $participacions['sacramento_nombre']];
        }
        return $list;
    }
    public static function deleteParticipacion($actividad_id, $persona_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // Eliminar el registro de actividad_ingreso
            $query = 'DELETE FROM participacions WHERE actividad_id = :actividad_id AND persona_id = :persona_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
            $stmt->bindParam(':persona_id', $persona_id, PDO::PARAM_INT);
            $stmt->execute();

            $db->commit();
            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
    public static function create($persona_id, $actividad_id, $tipo_participacion_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $persona_id = intval($persona_id);
        $actividad_id = intval($actividad_id);
        $tipo_participacion_id = intval($tipo_participacion_id);

        try {

            $query = 'INSERT INTO participacions (tipo_participacion_id, persona_id, actividad_id) VALUES (:tipo_participacion_id, :persona_id, :actividad_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':tipo_participacion_id', $tipo_participacion_id);
            $req_persona->bindParam(':persona_id', $persona_id);
            $req_persona->bindParam(':actividad_id', $actividad_id);
            $req_persona->execute();

            // Obtener y retornar el ID del último registro insertado
            // $ultimoInsertId = $db->lastInsertId();

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            echo $e;
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
}
