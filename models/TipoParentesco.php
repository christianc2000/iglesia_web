<?php
class TipoParentesco
{
    public $id;
    public $nombre;

    public function __construct($id,$nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM tipo_parentescos');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $parentesco) {
            $list[] = new TipoParentesco($parentesco['id'], $parentesco['nombre']);
        }

        return $list;
    }

    // public static function create($tipo_parentesco_id, $personaA_id, $personaB_id)
    // {
    //     $db = Db::getInstance();
    //     $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

    //     $personaA_id = intval($personaA_id);
    //     $personaB_id = intval($personaB_id);

    //     try {
    //         // CREAR PARENTEZCO
    //         $query = 'INSERT INTO parentescos (parentesco, personaA_id, personaB_id) VALUES (:parentesco, :personaA_id, :personaB_id)';
    //         $req_persona = $db->prepare($query);

    //         $req_persona->bindParam(':parentesco', $tipo_parentesco_id);
    //         $req_persona->bindParam(':personaA_id', $personaA_id);
    //         $req_persona->bindParam(':personaB_id', $personaB_id);
    //         $req_persona->execute();

    //         // Obtener y retornar el ID del último registro insertado
    //         // $ultimoInsertId = $db->lastInsertId();

    //         // Confirmar la transacción
    //         $db->commit();

    //         return true;
    //     } catch (PDOException $e) {
    //         // En caso de error, revertir la transacción
    //         echo $e;
    //         $db->rollback();
    //         throw $e; // Puedes manejar el error de otra manera según tus necesidades
    //     }
    // }
    // public static function sinParentescos($id)
    // {
    //     $list = [];
    //     $db = Db::getInstance();

    //     // Asegurémonos de que $parentezco_id sea un entero
    //     $id = intval($id);
    //     $query = "SELECT personas.id, personas.ci, CONCAT(personas.nombre, ' ', personas.apellido) AS nombre
    //     FROM personas
    //     WHERE personas.id NOT IN (
    //         SELECT parentescos.personaB_id
    //         FROM parentescos
    //         WHERE parentescos.personaA_id = :id
    //     ) AND personas.id != :id;";
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     foreach ($stmt->fetchAll() as $persona) {
    //         $list[] =['persona_id'=>$persona['id'],'persona_ci'=>$persona['ci'],'persona_nombre'=>$persona['nombre']];
    //     }


    //     // Confirmar la transacción si todo fue exitoso
    //     // $db->commit();
    //     return $list;
    // }
    // public static function misParentescos($id)
    // {
    //     $list = [];
    //     $db = Db::getInstance();

    //     // Asegurémonos de que $parentezco_id sea un entero
    //     $id = intval($id);
    //     $query =  "SELECT personas.id,CONCAT(personas.nombre,' ',personas.apellido) AS pariente, tipo_parentescos.nombre AS parentesco
    //     FROM personas
    //     JOIN parentescos ON personas.id = parentescos.personaB_id
    //     JOIN tipo_parentescos ON parentescos.tipo_parentesco_id = tipo_parentescos.id
    //     WHERE parentescos.personaA_id = :id;";
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     foreach ($stmt->fetchAll() as $persona) {
    //         $list[] = ['pariente_id'=>$persona['id'],'pariente_nombre'=>$persona['pariente'],'parentesco'=>$persona['parentesco']];
    //     }


    //     // Confirmar la transacción si todo fue exitoso
    //     // $db->commit();
    //     return $list;
    // }

    // public static function delete($personaA_id, $personaB_id)
    // {
    //     $db = Db::getInstance();

    //     // Asegurémonos de que $parentezco_id sea un entero
    //     $personaA_id = intval($personaA_id);
    //     $personaB_id = intval($personaB_id);

    //     // Comenzar una transacción para asegurar la integridad de los datos
    //     $db->beginTransaction();

    //     try {
    //         // Primero, eliminamos el parentezco
    //         $query = 'DELETE FROM parentescos WHERE personaA_id = :personaA_id AND personaB_id=:personaB_id';
    //         $stmt = $db->prepare($query);
    //         $stmt->bindParam(':personaA_id', $personaA_id, PDO::PARAM_INT);
    //         $stmt->bindParam(':personaB_id', $personaB_id, PDO::PARAM_INT);
    //         $stmt->execute();

    //         // Confirmar la transacción si todo fue exitoso
    //         $db->commit();

    //         return true; // Éxito, el parentezco fue eliminado
    //     } catch (PDOException $e) {
    //         // En caso de error, revertir la transacción y manejar el error
    //         $db->rollback();
    //         throw $e; // Puedes manejar el error de otra manera según tus necesidades
    //     }
    // }

    public static function find($id)
    {
        $db = Db::getInstance();
        // Asegurémonos de que $id sea un entero
        $id = intval($id);
        
        $req = $db->prepare('SELECT * FROM tipo_parentescos WHERE tipo_parentescos.id = :id;');
        // La consulta ha sido preparada, ahora reemplazamos :id con el valor actual de $id
        $req->execute(array('id' => $id));

        // Comprobamos si se encontraron resultados
        $row = $req->fetch();

        if (!$row) {
            // No se encontraron resultados, puedes manejarlo de acuerdo a tus necesidades
            return null;
        }

        // Devolvemos los datos del parentezco que coincidió con el ID
        return new TipoParentesco($row['id'], $row['nombre']);
    }
}
