<?php
class Parentezco
{
    public $parentezco;
    public $personaA_id;
    public $personaB_id;

    public function __construct($parentezco, $personaA_id, $personaB_id)
    {
        $this->parentezco = $parentezco;
        $this->personaA_id = $personaA_id;
        $this->personaB_id = $personaB_id;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM parentezcos');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $parentezco) {
            $list[] = new Parentezco($parentezco['parentezco'], $parentezco['personaA_id'], $parentezco['personaB_id']);
        }

        return $list;
    }

    public static function create($parentezco, $personaA_id, $personaB_id)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        $personaA_id = intval($personaA_id);
        $personaB_id = intval($personaB_id);

        try {
            // CREAR PARENTEZCO
            $query = 'INSERT INTO parentezcos (parentezco, personaA_id, personaB_id) VALUES (:parentezco, :personaA_id, :personaB_id)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':parentezco', $parentezco);
            $req_persona->bindParam(':personaA_id', $personaA_id);
            $req_persona->bindParam(':personaB_id', $personaB_id);
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
    public static function sinParentezcos($id)
    {
        $list = [];
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $id = intval($id);
        $query = "SELECT
    personas.*
FROM personas
WHERE personas.id != :id
AND personas.id NOT IN (
    SELECT parentezcos.personaA_id FROM parentezcos WHERE parentezcos.personaB_id = :id
    UNION
    SELECT parentezcos.personaB_id FROM parentezcos WHERE parentezcos.personaA_id = :id
);
";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $persona) {
            $list[] = new Persona($persona['id'],$persona['ci'],$persona['nombre'],$persona['apellido'],$persona['celular'],$persona['direccion'],$persona['correo'],$persona['tipo'],$persona['sexo'],$persona['fecha_nacimiento'],$persona['fecha_registro']);
        }


        // Confirmar la transacción si todo fue exitoso
        // $db->commit();
        return $list;
    }
    public static function misParentezcos($id)
    {
        $list = [];
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $id = intval($id);
        $query =  "SELECT
            CASE
                WHEN parentezcos.personaA_id = :id THEN personasB.id
                ELSE personasA.id
            END AS id,
            CASE
                WHEN parentezcos.personaA_id = :id THEN CONCAT(personasB.nombre, ' ', personasB.apellido)
                ELSE CONCAT(personasA.nombre, ' ', personasA.apellido)
            END AS nombre_completo,
            CASE
                WHEN parentezcos.personaA_id = :id THEN personasB.ci
                ELSE personasA.ci
            END AS ci,
            parentezcos.parentezco,
            parentezcos.personaA_id,
            parentezcos.personaB_id
        FROM parentezcos
        JOIN personas AS personasA ON parentezcos.personaA_id = personasA.id
        JOIN personas AS personasB ON parentezcos.personaB_id = personasB.id
        WHERE parentezcos.personaA_id = :id
        UNION
        SELECT
            CASE
                WHEN parentezcos.personaB_id = :id THEN personasA.id
                ELSE personasB.id
            END AS id,
            CASE
                WHEN parentezcos.personaB_id = :id THEN CONCAT(personasA.nombre, ' ', personasA.apellido)
                ELSE CONCAT(personasB.nombre, ' ', personasB.apellido)
            END AS nombre_completo,
            CASE
                WHEN parentezcos.personaB_id = :id THEN personasA.ci
                ELSE personasB.ci
            END AS ci,
            parentezcos.parentezco,
            parentezcos.personaA_id,
            parentezcos.personaB_id
        FROM parentezcos
        JOIN personas AS personasA ON parentezcos.personaA_id = personasA.id
        JOIN personas AS personasB ON parentezcos.personaB_id = personasB.id
        WHERE parentezcos.personaB_id = :id;    
            ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $persona) {
            $list[] = ['pariente_id' => $persona['id'], 'pariente_ci' => $persona['ci'], 'pariente_nombre' => $persona['nombre_completo'], 'parentezco' => $persona['parentezco'], 'personaA_id' => $persona['personaa_id'], 'personaB_id' => $persona['personab_id']];
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
            $query = 'DELETE FROM parentezcos WHERE personaA_id = :personaA_id AND personaB_id=:personaB_id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':personaA_id', $personaA_id, PDO::PARAM_INT);
            $stmt->bindParam(':personaB_id', $personaB_id, PDO::PARAM_INT);
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
        $req = $db->prepare('SELECT * FROM parentezcos WHERE parentezcos.personaA_id = :personaA_id AND parentezcos.personaB_id=:personaB_id');
        // La consulta ha sido preparada, ahora reemplazamos :id con el valor actual de $id
        $req->execute(array('personaA_id' => $personaA_id, 'personaB_id' => $personaB_id));

        // Comprobamos si se encontraron resultados
        $row = $req->fetch();

        if (!$row) {
            // No se encontraron resultados, puedes manejarlo de acuerdo a tus necesidades
            return null;
        }

        // Devolvemos los datos del parentezco que coincidió con el ID
        return new Parentezco($row['parentezco'], $row['personaA_id'], $row['personaB_id']);
    }
}
