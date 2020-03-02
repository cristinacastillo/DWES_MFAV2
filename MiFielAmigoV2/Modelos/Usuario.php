<?php


// Cristina Castillo Obregón
// Desarrollo Web en Entorno Servidor
// curso 2019/20
// Proyecto Mi Fiel Amigo v2

class Usuario
{
    private $idUsu;
    private $nombre;
    private $apellidos;
    private $email;
    private $pass;
    private $api_key;


    public function __construct()
    { }


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
     * @param mixed nom
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
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed apellidos
     * 
     * @return self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed email
     * 
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed pass
     * 
     * @return self
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param mixed api_key
     * 
     * @return self
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

        /**
	 * buscara en la base de datos todos los usuarios almacenados y los devolverá
	 * en un objeto Usuario
	 */
	public static function findUsers()
	{
		$db = new Database();
		$sql = " SELECT * FROM usuario where admin not like 'admin';";

		$db->query($sql);

		//print_r($db,false);
		//die();

		$data = [];
		while ($obj = $db->getObject("Usuario"))
			array_push($data, $obj);

		//
		return $data;
    }
    
    /**
	 * busca un usuario en concreto en la base de datos mediante su id y lo devuelve en un objeto Usuario
	 */
	public static function find(int $id): Usuario
	{
		$db = new Database();
		$db->query("SELECT * FROM usuario WHERE idUsu = $id ;");

		//
		return $db->getObject("Usuario");
    }
    
    public static function admin(int $id)
	{
        $db = new Database();

        $sql = "SELECT admin FROM usuario WHERE idUsu = $id ;";
        
        
        //print_r($sql,false);
        //die();

        $db->query($sql);

		//
		return $db->getObject("Usuario");
    }   


    public function exist(string $ema, string $pas){

        $db = new Database();

        $sql = "SELECT * FROM usuario WHERE email='$ema' AND pass=MD5('$pas') ;";

       // print_r($sql,false);
        //die();
        
        $db->query($sql);

        return $db->getObject("Usuario");
    }

    public function emailExist(string $ema){

        $db = new Database();

        $sql = "SELECT * FROM usuario WHERE email='$ema';";

       // print_r($sql,false);
        //die();
        
        $db->query($sql);

        return $db->getObject("Usuario");

    }

    public function save(){

        $db = new Database();

        if (is_null($this->idUsu)) :

			// cogemos el último id para que aparezca de forma ordenada en la base de datos
			$this->idUsu = $db->lastId();

			$db->query("ALTER TABLE usuario AUTO_INCREMENT=$this->idUsu");


			// preparamos la consulta para la insercción del nuevo perro

			$sql = "INSERT INTO usuario (nombre, apellidos, email, pass, api_key) 
						VALUES ('{$this->nombre}', '{$this->apellidos}','{$this->email}',
                        MD5('{$this->pass}'),'{$this->api_key}') ;";


		    //print_r($sql,false);
			//die();

			// insertamos en la base de datos
			$db->query($sql);


            $this->idUsu = $db->lastId();
        endif;
    }

    public function delete (int $id){

        $db = new Database();

        $sql = "DELETE FROM usuario WHERE idUsu = $id";

        $db->query($sql);
    }
   
}
