<?php


	require_once "Data.php" ;

	class Database 
	{
		private $pdo ;
		private $res ;

		/**
		 * establecer conexión con la base de datos
		 */
		public function __construct()
		{
			global $data ;
			$this->pdo = new PDO("mysql:host=".$data["host"].";dbname=".$data["dbno"].";charset=utf8",$data["user"],$data["pass"])
						 or die("Error de conexión con la base de datos.") ;
		}

		/**
		 * cerrar conexión con la base de datos
		 */
		public function __destruct()
		{
			$this->pdo = null ;
		}

		/**
		 *  realizar consulta a la base de datps
		 */
		public function query($sql)
		{
			$this->res = $this->pdo->query($sql) ;
		}

		/**
		 * devuelve un registro en formato de objeto
		 */
		public function getObject($cls = "StdClass")
		{
			return $this->res->fetchObject($cls) ;
		}

		/**
		 * devuelve el último ID
		 */
		public function lastId()
		{
			return $this->pdo->lastInsertId() ;
		}

	}