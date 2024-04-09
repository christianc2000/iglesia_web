<?php
require_once('persona.php'); // Reemplaza 'ruta_a_persona.php' con la ruta correcta al archivo de la clase Persona

class Asistencia
{
    public $actividad_id;
    public $persona_id;
    public $horallegada;
    public $fecha_registro;
    public function __construct($actividad_id, $persona_id, $horallegada, $fecha_registro)
    {
        $this->actividad_id = $actividad_id;
        $this->persona_id = $persona_id;
        $this->horallegada = $horallegada;
        $this->fecha_registro = $fecha_registro;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM asistencias ORDER BY updated_at DESC;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $asistencia) {
            $list[] = new Asistencia($asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['horallegada'], $asistencia['fecha_registro']);
        }
        return $list;
    }
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM asistencias WHERE id = :id');

        $req->execute(array('id' => $id));
        $asistencia = $req->fetch();
        new Asistencia($asistencia['actividad_id'], $asistencia['persona_id'], $asistencia['horallegada'], $asistencia['fecha_registro']);

        return $asistencia;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }
    public static function getAllAsistencia($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare("SELECT asistencias.*, CONCAT(personas.nombre,' ',personas.apellido) as nombre_completo FROM asistencias, personas 
WHERE asistencias.actividad_id = :id and personas.id = asistencias.persona_id ORDER BY asistencias.fecha_registro DESC;");
        $req->execute(array('id' => $id));

        while ($asistencia = $req->fetch()) {
           
            $list[] = ['actividad_id'=>$asistencia['actividad_id'], 'persona_id'=>$asistencia['persona_id'], 'horallegada'=>$asistencia['horallegada'], 'fecha_registro'=>$asistencia['fecha_registro'],'persona_nombrecompleto'=> $asistencia['nombre_completo']];
        }
        return $list;
    }
    public static function asistenciaDelete($actividad_id, $persona_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // Eliminar el registro de actividad_ingreso
            $query = 'DELETE FROM asistencias WHERE actividad_id = :actividad_id AND persona_id = :persona_id';
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
    public static function create($persona_id, $actividad_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $persona_id = intval($persona_id);
        $actividad_id = intval($actividad_id);

        try {
            date_default_timezone_set('America/La_Paz');
            $horallegada = date("H:i:s");
            $query = 'INSERT INTO asistencias (horallegada, persona_id, actividad_id) VALUES (:horallegada, :persona_id, :actividad_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':horallegada', $horallegada);
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
