<?php

class Persona
{
    public $id;
    public $ci;
    public $nombre;
    public $apellido;
    public $celular;
    public $direccion;
    public $correo;
    public $sexo;
    public $fecha_nacimiento;
    public $fecha_registro;
    public function __construct($id, $ci, $nombre, $apellido, $celular, $direccion, $correo, $sexo, $fecha_nacimiento, $fecha_registro)
    {
        $this->id = $id;
        $this->ci = $ci;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->celular = $celular;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->sexo = $sexo;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->fecha_registro = $fecha_registro;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM personas;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $persona) {
            $list[] = new Persona($persona['id'], $persona['ci'], $persona['nombre'], $persona['apellido'], $persona['celular'], $persona['direccion'], $persona['correo'], $persona['sexo'], $persona['fecha_nacimiento'], $persona['fecha_registro']);
        }

        return $list;
    }
    public static function find($id)
    {
        $db = Db::getInstance();
        // Asegúrate de que $id sea un entero
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM personas WHERE id = :id');
        // Reemplaza :id con el valor actual de $id
        $req->execute(array('id' => $id));

        // Verifica si la consulta tuvo éxito
        if ($persona = $req->fetch()) {
            // La consulta devolvió resultados, crea una instancia de Persona
            return new Persona(
                $persona['id'],
                $persona['ci'],
                $persona['nombre'],
                $persona['apellido'],
                $persona['celular'],
                $persona['direccion'],
                $persona['correo'],
                $persona['sexo'],
                $persona['fecha_nacimiento'],
                $persona['fecha_registro']
            );
        } else {
            // La consulta no devolvió resultados, maneja este caso
            // Puedes lanzar una excepción, mostrar un mensaje de error, etc.
            // Por ejemplo:
            throw new Exception("No se encontró ninguna persona con el ID $id");
        }
    }

    public static function create($ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // CREAR A LA PERSONA
            // $fecha_registro = 'NOW()';
            $query = 'INSERT INTO personas (ci, nombre, apellido, celular, direccion, correo, sexo, fecha_nacimiento) VALUES (:ci, :nombre, :apellido, :celular, :direccion, :correo, :sexo, :fecha_nacimiento)';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':ci', $ci);
            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':apellido', $apellido);
            $req_persona->bindParam(':celular', $celular);
            $req_persona->bindParam(':direccion', $direccion);
            $req_persona->bindParam(':correo', $correo);
            $req_persona->bindParam(':sexo', $sexo);
            $req_persona->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            // $req_persona->bindParam('fecha_registro',$fecha_registro);
            $req_persona->execute();
            // Confirmar la transacción
            $db->commit();

            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
    public static function update($id, $ci, $nombre, $apellido, $correo, $celular, $direccion, $sexo, $fecha_nacimiento)
    {
        $db = Db::getInstance();
        $db->beginTransaction(); // Iniciar una transacción para asegurar la integridad de los datos

        try {
            // ACTUALIZAR LOS DATOS DE LA PERSONA
            $query = 'UPDATE personas SET ci = :ci, nombre = :nombre, apellido = :apellido, celular = :celular, direccion = :direccion, correo = :correo, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento WHERE id = :id';
            $req_persona = $db->prepare($query);

            $req_persona->bindParam(':ci', $ci);
            $req_persona->bindParam(':nombre', $nombre);
            $req_persona->bindParam(':apellido', $apellido);
            $req_persona->bindParam(':celular', $celular);
            $req_persona->bindParam(':direccion', $direccion);
            $req_persona->bindParam(':correo', $correo);
            $req_persona->bindParam(':sexo', $sexo);
            $req_persona->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $req_persona->bindParam(':id', $id);
            $req_persona->execute();

            // Confirmar la transacción
            $db->commit();


            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $db->rollback();
            throw $e; // Puedes manejar el error de otra manera según tus necesidades
        }
    }
    public static function delete($id)
    {
        $db = Db::getInstance();

        // Asegurémonos de que $parentezco_id sea un entero
        $id = intval($id);

        // Comenzar una transacción para asegurar la integridad de los datos
        $db->beginTransaction();

        try {
            // Primero, eliminamos el parentezco
            $query = 'DELETE FROM personas WHERE id = :id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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

    public static function allPersonAsistencia($actividad_id)
    {
        $list = [];
        $db = Db::getInstance();

        $query = "SELECT personas.*
        FROM personas
        LEFT JOIN participacions ON personas.id = participacions.persona_id AND participacions.actividad_id = :actividad_id
        WHERE participacions.actividad_id IS NULL;";

        $req = $db->prepare($query);
        $req->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
        $req->execute();

        // Recorremos los resultados de la consulta
        foreach ($req->fetchAll() as $row) {
            $list[] = new Persona($row['id'], $row['ci'], $row['nombre'], $row['apellido'], $row['celular'], $row['direccion'], $row['correo'], $row['sexo'], $row['fecha_nacimiento'], $row['fecha_registro']);
        }

        return $list;
    }
}
