<?php

// Cristina Castillo Obregón
// Desarrollo Web en Entorno Servidor
// curso 2019/20
// Proyecto Mi Fiel Amigo v2

require_once './libs/Database.php';

class Perro
{
    private $idPer;
    private $nombre;
    private $raza;
    private $genero;
    private $descripcion;
    private $fec_nacimiento;
    private $foto;

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
    public function getRaza()
    {
        return $this->raza;
    }

    /**
     * @param mixed raza
     *
     * @return self
     */
    public function setRaza($raza)
    {
        $this->raza = $raza;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed genero
     *
     * @return self
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed descripcion
     *
     * @return self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecNac()
    {
        return $this->fec_nacimiento;
    }

    /**
     * @param mixed fec_nacimiento
     *
     * @return self
     */
    public function setFecNac($fec_nacimiento)
    {
        $this->fec_nacimiento = $fec_nacimiento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed foto
     *
     * @return self
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    
    /**
     * buscara en la base de datos todos los perros almacenados y los devolverá
     * en un objeto Perro
     *
     * @return void
     */
    public static function findAll()
    {
        $db = new Database();
        $sql = 'SELECT * FROM perro';

        $db->query($sql);

        //print_r($db,false);
        //die();

        $data = [];
        while ($obj = $db->getObject('Perro')) {
            array_push($data, $obj);
        }

        //
        return $data;
    }

     /**
      *  busca un perro en concreto en la base de datos mediante su id y lo devuelve en un objeto Perro
      *
      * @param integer $id
      * @return Perro
      */
    public static function find(int $id): Perro
    {
        $db = new Database();
        $db->query(
            "SELECT idPer,nombre, DATE_FORMAT(fec_nacimiento,'%d-%m-%Y') as fec_nacimiento, descripcion, foto, genero, raza FROM perro WHERE idPer = $id ;"
        );

        //
        return $db->getObject('Perro');
    }

    /**
     * borra un perro de la base de datos
     */
    public function delete()
    {
        $db = new Database();

        $sql = "DELETE FROM perro WHERE idPer={$this->idPer} ;";

        //echo $sql;
        //die();
        $db->query($sql);

        
    }

    /**
     * save
     *
     * @return void
     */
    public function save(){

        $db = new Database();

        if (is_null($this->idPer)) :

			// cogemos el último id para que aparezca de forma ordenada en la base de datos
			$this->idPer = $db->lastId();

			$db->query("ALTER TABLE perro AUTO_INCREMENT=$this->idPer");


			// preparamos la consulta para la insercción del nuevo perro

			$sql = "INSERT INTO perro (nombre, raza, genero, descripcion, fec_nacimiento, foto) 
						VALUES ('{$this->nombre}', '{$this->raza}','{$this->genero}',
								'{$this->descripcion}','{$this->fec_nacimiento}', '{$this->foto}') ;";


		    //print_r($sql,false);
			//die();

			// insertamos en la base de datos
			$db->query($sql);


			$this->idPer = $db->lastId();


		else :

            // actualizamos el perro
            
            $sql = "UPDATE perro SET descripcion='{$this->descripcion}' WHERE idPer={$this->idPer} ;";

            //print_r($sql);
            //die();
            
            $db->query($sql);


            
		endif;

		return $this;
    }

    public function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }


    public function anadirImg(){

        $db = new Database();

        $sql = "UPDATE foto SET foto='{$this->foto}' WHERE idPer={$this->idPer} ;";

        print_r($sql,false);
        die();

        $db->query($sql);
            

    }
}
