<?php
class Parentesco
{
    public $tipo_parentesco_id;
    public $personaA_id;
    public $personaB_id;

    public function __construct($tipo_parentesco_id, $personaA_id, $personaB_id)
    {
        $this->tipo_parentesco_id = $tipo_parentesco_id;
        $this->personaA_id = $personaA_id;
        $this->personaB_id = $personaB_id;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM parentescos');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $parentesco) {
            $list[] = new Parentesco($parentesco['tipo_parentesco_id'], $parentesco['personaA_id'], $parentesco['personaB_id']);
        }

        return $list;
    }

    public static function create($tipo_parentesco_id, $personaA_id, $personaB_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $personaA_id = intval($personaA_id);
        $personaB_id = intval($personaB_id);

        try {
            // CREAR PARENTEZCO
            $query = 'INSERT INTO parentescos (tipo_parentesco_id, personaA_id, personaB_id) VALUES (:tipo_parentesco_id, :personaA_id, :personaB_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':tipo_parentesco_id', $tipo_parentesco_id);
            $req_persona->bindParam(':personaA_id', $personaA_id);
            $req_persona->bindParam(':personaB_id', $personaB_id);
            $req_persona->execute();

        
            //VERIFICAMOS Tipo Parentesco
            // Verificar si el tipo de parentesco tiene parentesco_relacion_id no nulo
            $query_tipo_parentesco = 'SELECT parentesco_relacion_id FROM tipo_parentescos WHERE id = :tipo_parentesco_id';
            $req_tipo_parentesco = $db->prepare($query_tipo_parentesco);
            $req_tipo_parentesco->bindParam(':tipo_parentesco_id', $tipo_parentesco_id);
            $req_tipo_parentesco->execute();
            $parentesco_relacion_id = $req_tipo_parentesco->fetchColumn();

            if ($parentesco_relacion_id !== null) {
                // Insertar un registro en la tabla parentescos con los roles invertidos
                $query_invertida = 'INSERT INTO parentescos (tipo_parentesco_id, personaA_id, personaB_id) VALUES (:tipo_parentesco_id, :personaA_id, :personaB_id)';
                $req_invertida = $db->prepare($query_invertida);
                $req_invertida->bindParam(':tipo_parentesco_id', $parentesco_relacion_id);
                $req_invertida->bindParam(':personaA_id', $personaB_id);
                $req_invertida->bindParam(':personaB_id', $personaA_id);
                $req_invertida->execute();
            }else{
                $query_invertida = 'INSERT INTO parentescos (tipo_parentesco_id, personaA_id, personaB_id) VALUES (:tipo_parentesco_id, :personaA_id, :personaB_id)';
                $req_invertida = $db->prepare($query_invertida);
                $req_invertida->bindParam(':tipo_parentesco_id', $tipo_parentesco_id);
                $req_invertida->bindParam(':personaA_id', $personaB_id);
                $req_invertida->bindParam(':personaB_id', $personaA_id);
                $req_invertida->execute();
            }

            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            // echo $e;
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
    public static function sinParentescos($id)
    {
        $list = [];
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $id = intval($id);
        $query = "SELECT personas.id, personas.ci, CONCAT(personas.nombre, ' ', personas.apellido) AS nombre
        FROM personas
        WHERE personas.id NOT IN (
            SELECT parentescos.personaB_id
            FROM parentescos
            WHERE parentescos.personaA_id = :id
        ) AND personas.id != :id;";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $persona) {
            $list[] = ['persona_id' => $persona['id'], 'persona_ci' => $persona['ci'], 'persona_nombre' => $persona['nombre']];
        }


        // Confirmar la transacción si todo fue exitoso
        // $db->commit();
        return $list;
    }
    public static function misParentescos($id)
    {
        $list = [];
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $id = intval($id);
        $query =  "SELECT personas.id, personas.ci,CONCAT(personas.nombre,' ',personas.apellido) AS pariente, tipo_parentescos.nombre AS parentesco
        FROM personas
        JOIN parentescos ON personas.id = parentescos.personaB_id
        JOIN tipo_parentescos ON parentescos.tipo_parentesco_id = tipo_parentescos.id
        WHERE parentescos.personaA_id = :id;";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $persona) {
            $list[] = ['pariente_id' => $persona['id'], 'pariente_ci' => $persona['ci'], 'pariente_nombre' => $persona['pariente'], 'parentesco' => $persona['parentesco']];
        }


        // Confirmar la transacción si todo fue exitoso
        // $db->commit();
        return $list;
    }

    public static function delete($personaA_id, $personaB_id)
    {
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $personaA_id = intval($personaA_id);
        $personaB_id = intval($personaB_id);

        // Comenzar una transacción para asegurar la integridad de los datos
        $db->beginTransaction();

        try {
            // Primero, eliminamos el parentezco
            $query = 'DELETE FROM parentescos WHERE personaA_id = :personaA_id AND personaB_id=:personaB_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':personaA_id', $personaA_id, PDO::PARAM_INT);
            $stmt->bindParam(':personaB_id', $personaB_id, PDO::PARAM_INT);
            $stmt->execute();
            $query = 'DELETE FROM parentescos WHERE personaA_id = :personaA_id AND personaB_id=:personaB_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':personaA_id', $personaB_id, PDO::PARAM_INT);
            $stmt->bindParam(':personaB_id', $personaA_id, PDO::PARAM_INT);
            $stmt->execute();
            // Confirmar la transacción si todo fue exitoso
            $db->commit();

            return true; // Éxito, el parentezco fue eliminado
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción y manejar el error
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }

    public static function find($personaA_id, $personaB_id)
    {
        $db = Db::getInstance();
        // Asegurémonos de que $id sea un entero
        $personaA_id = intval($personaA_id);
        $personaB_id = intval($personaB_id);
        $req = $db->prepare('SELECT * FROM parentescos WHERE parentescos.personaA_id = :personaA_id AND parentescos.personaB_id=:personaB_id');
        // La consulta ha sido preparada, ahora reemplazamos :id con el valor actual de $id
        $req->execute(array('personaA_id' => $personaA_id, 'personaB_id' => $personaB_id));

        // Comprobamos si se encontraron resultados
        $row = $req->fetch();

        if (!$row) {
            // No se encontraron resultados, puedes manejarlo de acuerdo a tus necesidades
            return null;
        }

        // Devolvemos los datos del parentezco que coincidió con el ID
        return new Parentesco($row['parentezco'], $row['personaA_id'], $row['personaB_id']);
    }
}
