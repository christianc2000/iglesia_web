<?php

class TipoParticipacion
{
    public $id;
    public $nombre;

    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }
    public static function all(){
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM tipo_participacions');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $parentesco) {
            $list[] = new TipoParticipacion($parentesco['id'], $parentesco['nombre']);
        }

        return $list;
    }
}
