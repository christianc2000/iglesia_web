<?php
class Estado
{
    public $id;
    public $nombre;
    public function __construct($id,$nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }
    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM estados;');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $estado) {
            $list[] = new Estado($estado['id'],$estado['nombre']);
        }
        return $list;
    }
    public static function find($id){
        $list = [];
        $db = Db::getInstance();

        $id = intval($id);
        $req = $db->prepare('SELECT * FROM estados WHERE id = :id');
       
        $req->execute(array('id' => $id));
        $row = $req->fetch();
        $estado = new Estado($row['id'], $row['nombre']);

        return $estado;
    }
    public static function findByActividad($idActividad){
        $list = [];
        $db = Db::getInstance();

        $id = intval($idActividad);
        $req = $db->prepare('SELECT estados.* FROM actividads, estados WHERE actividads.id = :id and actividads.estado_id=estados.id');
       
        $req->execute(array('id' => $id));
        $row = $req->fetch();
        $estado = new Estado($row['id'], $row['nombre']);

        return $estado;
    }
}