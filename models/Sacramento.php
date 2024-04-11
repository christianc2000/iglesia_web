<?php
class Sacramento
{
    public $id;
    public $nombre;

    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM sacramentos;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $sacramento) {
            $list[] = new Sacramento($sacramento['id'], $sacramento['nombre']);
        }

        return $list;
    }
    public static function find($id)
    {
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM sacramentos WHERE id = :id');

        $req->execute(array('id' => $id));
        $sacramento = $req->fetch();
        $sacramento =  new Sacramento($sacramento['id'], $sacramento['nombre']);

        return $sacramento;
        //return new Miembro($miembro['id'], $miembro['fecha_registro_miembro'], $miembro['created_at'], $miembro['updated_at']);
    }
}
