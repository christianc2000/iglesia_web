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
