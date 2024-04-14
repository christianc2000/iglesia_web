<?php
class Cargo
{
    public $id;

    public $fecha_registro;
    public $fecha_finalizado;
    public $persona_id;

    public $ministerio_id;
    public $tipo_cargo_id;


    public function __construct($id, $persona_id, $ministerio_id, $tipo_cargo_id, $fecha_finalizado, $fecha_registro)
    {
        $this->id = $id;
        $this->tipo_cargo_id = $tipo_cargo_id;
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
        $req = $db->prepare("SELECT cargos.*, personas.ci as persona_ci, CONCAT(personas.nombre,' ',personas.apellido) as persona_nombre, ministerios.nombre as ministerio_nombre, tipo_cargos.nombre as tipo_cargo_nombre
        FROM cargos
        INNER JOIN personas ON personas.id = cargos.persona_id
        INNER JOIN tipo_cargos ON tipo_cargos.id = cargos.tipo_cargo_id
        INNER JOIN ministerios ON ministerios.id=cargos.ministerio_id
        WHERE cargos.fecha_finalizacion IS NULL AND cargos.ministerio_id=:id;");
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        foreach ($req->fetchAll() as $row) {
            $list[] =['id'=>$row['id'], 'cargo'=>$row['nombre'], 'fecha_registro'=>$row['fecha_registro'], 'fecha_finalizacion'=>$row['fecha_finalizacion'],'ministerio_id'=>$row['ministerio_id'], 'ministerio_nombre'=>$row['ministerio_nombre'],'persona_id'=> $row['persona_id'],'persona_ci'=>$row['persona_ci'],'persona_nombrecompleto'=> $row['persona_nombre'],'tipo_cargo_nombre'=>$row['tipo_cargo_nombre']];
        }

        return $list;
    }

    public static function getMiembrosCaducadosMinisterio($id) //le paso el id del ministerio
    {
        $list = [];
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare("SELECT cargos.*, personas.ci as persona_ci, CONCAT(personas.nombre,' ',personas.apellido) as persona_nombre, ministerios.nombre as ministerio_nombre, tipo_cargos.nombre as tipo_cargo_nombre
        FROM cargos
        INNER JOIN personas ON personas.id = cargos.persona_id
        INNER JOIN tipo_cargos ON tipo_cargos.id = cargos.tipo_cargo_id
        INNER JOIN ministerios ON ministerios.id=cargos.ministerio_id
        WHERE cargos.fecha_finalizacion IS NOT NULL AND cargos.ministerio_id=:id;");
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        foreach ($req->fetchAll() as $row) {
            $list[] =['id'=>$row['id'], 'cargo'=>$row['nombre'], 'fecha_registro'=>$row['fecha_registro'], 'fecha_finalizacion'=>$row['fecha_finalizacion'],'ministerio_id'=>$row['ministerio_id'], 'ministerio_nombre'=>$row['ministerio_nombre'],'persona_id'=> $row['persona_id'],'persona_ci'=>$row['persona_ci'],'persona_nombrecompleto'=> $row['persona_nombre'],'tipo_cargo_nombre'=>$row['tipo_cargo_nombre']];
        }

        return $list;
    }
    public static function create($tipo_cargo_id, $miembro_id, $ministerio_id,$fecha_registro)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $miembro_id = intval($miembro_id);
        $ministerio_id = intval($ministerio_id);
        $tipo_cargo_id = intval($tipo_cargo_id);

        try {
            // CREAR HISTORIAL CARGOS
            $query = 'INSERT INTO cargos (fecha_registro,tipo_cargo_id, persona_id, ministerio_id) VALUES (:fecha_registro,:tipo_cargo_id, :miembro_id, :ministerio_id)';
            $req_persona = $db->prepare($query);
            $req_persona->bindParam(':fecha_registro', $fecha_registro);
            $req_persona->bindParam(':tipo_cargo_id', $tipo_cargo_id);
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
