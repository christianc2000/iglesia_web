<?php
class Cargo
{
    public $id;
    public $nombre;

    public $fecha_registro;
    public $fecha_finalizado;
    public $persona_id;

    public $ministerio_id;


    public function __construct($id, $nombre, $persona_id, $ministerio_id, $fecha_finalizado, $fecha_registro)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha_registro = $fecha_registro;
        $this->fecha_finalizado = $fecha_finalizado;
        $this->persona_id = $persona_id;
        $this->ministerio_id = $ministerio_id;
    }


    public static function getMiembrosVigentesMinisterio($id) //le paso el id del ministerio
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare("SELECT cargos.*, personas.ci as persona_ci, CONCAT(personas.nombre,' ',personas.apellido) as nombre_persona, ministerios.nombre as nombre_ministerio
FROM cargos
INNER JOIN personas ON personas.id = cargos.persona_id
INNER JOIN ministerios ON ministerios.id=cargos.ministerio_id
WHERE cargos.fecha_finalizacion IS NULL AND cargos.ministerio_id=:id;");
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        foreach ($req->fetchAll() as $row) {
            $list[] =['id'=>$row['id'], 'cargo'=>$row['nombre'], 'fecha_registro'=>$row['fecha_registro'], 'fecha_finalizacion'=>$row['fecha_finalizacion'],'ministerio_id'=>$row['ministerio_id'], 'ministerio_nombre'=>$row['nombre_ministerio'],'persona_id'=> $row['persona_id'],'persona_ci'=>$row['persona_ci'],'persona_nombrecompleto'=> $row['nombre_persona']];
        }

        return $list;
    }

    public static function getMiembrosCaducadosMinisterio($id) //le paso el id del ministerio
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare("SELECT cargos.*, personas.ci as persona_ci, CONCAT(personas.nombre,' ',personas.apellido) as nombre_persona, ministerios.nombre as nombre_ministerio
FROM cargos
INNER JOIN personas ON personas.id = cargos.persona_id
INNER JOIN ministerios ON ministerios.id=cargos.ministerio_id
WHERE cargos.fecha_finalizacion IS NOT NULL AND cargos.ministerio_id=:id;");
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        foreach ($req->fetchAll() as $row) {
            $list[] =['id'=>$row['id'], 'cargo'=>$row['nombre'], 'fecha_registro'=>$row['fecha_registro'], 'fecha_finalizacion'=>$row['fecha_finalizacion'],'ministerio_id'=>$row['ministerio_id'], 'ministerio_nombre'=>$row['nombre_ministerio'],'persona_id'=> $row['persona_id'],'persona_ci'=>$row['persona_ci'],'persona_nombrecompleto'=> $row['nombre_persona']];
        }

        return $list;
    }
    public static function create($cargo, $miembro_id, $ministerio_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $miembroa_id = intval($miembro_id);
        $miembrob_id = intval($ministerio_id);

        try {
            // CREAR HISTORIAL CARGOS
            $query = 'INSERT INTO cargos (nombre, persona_id, ministerio_id) VALUES (:nombre, :miembro_id, :ministerio_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':nombre', $cargo);
            $req_persona->bindParam(':miembro_id', $miembro_id);
            $req_persona->bindParam(':ministerio_id', $ministerio_id);
            $req_persona->execute();
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
    public static function finalizarCargoMinisterio($id)
    {
        $db = Db::getInstance();
        $id = intval($id);

        $db->beginTransaction();

        try {
            $query = 'UPDATE cargos SET fecha_finalizacion=NOW() WHERE id = :cargo_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':cargo_id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar la transacción si todo fue exitoso
            $db->commit();

            return true;
        } catch (PDOException $e) {
           
            $db->rollback();
            throw $e; 
        }
    }

}
