
<?php
// Cristina Castillo Obregón
// Desarrollo Web en Entorno Servidor
// curso 2019/20
// Proyecto Mi Fiel Amigo v2

require_once 'libs/Database.php';

class Adopcion
{
    private $idPer;
    private $idUsu;
    private $nombre;
    private $fecha;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdPer()
    {
        return $this->idPer;
    }

    /**
     * @param mixed idPer
     *
     * @return self
     */
    public function setIdPer($idPer)
    {
        $this->idPer = $idPer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUsu()
    {
        return $this->idUsu;
    }

    /**
     * @param mixed idUsu
     *
     * @return self
     */
    public function setIdUsu($idUsu)
    {
        $this->idUsu = $idUsu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * buscara en la base de datos todas las adopciones almacenadas y las devolverá
     * en un objeto Adopción
     *
     * @return void
     */
    public static function findAll()
    {
        $db = new Database();
        $sql = 'SELECT * FROM adopcion';

        $db->query($sql);

        //print_r($db,false);
        //die();

        $data = [];
        while ($obj = $db->getObject('Adopcion')) {
            array_push($data, $obj);
        }

        //
        return $data;
    }

    /**
     *  busca una adopcion en concreto en la base de datos mediante su id y lo devuelve en un objeto Adopcion
     *
     * @param integer $id
     * @return Adopcion
     */
    public static function find(int $id)
    {
        $db = new Database();

        $sql = "SELECT idPer, idUsu, nombre, DATE_FORMAT(fecha,'%d-%m-%Y') as fecha FROM adopcion WHERE idUsu = $id ;";

        //print_r($sql,false);
        //die();

        $db->query($sql);

        //
        $data = [];
        while ($obj = $db->getObject('Adopcion')) {
            array_push($data, $obj);
        }

        //
        return $data;
    }

    public function save()
    {
        $db = new Database();

        $sql = "INSERT INTO adopcion (idPer, idUSu, nombre, fecha) 
        VALUES ('{$this->idPer}', '{$this->idUsu}','{$this->nombre}',
                '{$this->fecha}'); ";

        //print_r($sql, false);
        //die();

        $db->query($sql);

    }

    public function adopted(int $id)
    {
        $db = new Database();

        $sql = "SELECT * FROM adopcion WHERE idPer = $id";

        $db->query($sql);

        return $db->getObject('Adopcion');
    }
}

