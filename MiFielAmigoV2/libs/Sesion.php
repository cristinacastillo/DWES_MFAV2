<?php

require_once "libs/Database.php";

class Sesion
{

	// segundos que se mantiene abierta la sesión
	private $time_expire = 300 ;				
	private static $instancia = null ;

	/**
	 */
	private function __construct() { }

	/**
	 */
	private function __clone() { }	

	/**
     * Cerramos la sesión si esta abierta
	 */
	public function close()
	{
		$_SESSION = [] ;
		session_destroy() ;
	}

	/**
	 */
	public static function getInstance()
	{
		session_start() ;

		// comprobamos si existe sesión
		if (isset($_SESSION["_sesion"])):
		// si existe deserializamos la sesión y guardamos en la instancia
			self::$instancia = unserialize($_SESSION["_sesion"] ) ;
		else:
			if (self::$instancia===null) 
		// si esta vacia, creamos una nueva sesión
				self::$instancia = new Sesion() ;
		endif ;

		// devolvemos la instancia
		return self::$instancia ;
	}

	/**
	 */
	public function login():bool
	{		
        // si el usuario es correcto, iniciamos la sesión
		// guardamos el momento (segs.) en que se inicia
		// la sesión
		$_SESSION["time"]    = time() ;
		$_SESSION["_sesion"] = serialize(self::$instancia) ;
        return true ;
	}

	/**
	 * @return bool
	 * Comprueba si ha expirado el tiempo de sesión
	 */
	public function isExpired():bool
	{
		return (time() - $_SESSION["time"] > $this->time_expire) ;
	}

	/**
	 * @return bool
	 * Comprueba si estas logueado 
	 */
	public function isLogged():bool
	{
		return !empty($_SESSION) ;
	}

	/**
	 * @return bool
	 * Comprueba si hay sesión activa
	 */
	public function checkActiveSession():bool
	{
		if ($this->isLogged())
			if (!$this->isExpired()) return true ;
		//
		return false ;
	}

}

