<?php


    //  importamos el archivo siguiente para que así se importen
    // las librerias necesarias y poder trabjar con twig.

	require_once "vendor/autoload.php" ;



	class baseController 
	{
		protected $twig ;

		public function __construct()
		{
			// para poder trabajar con twig:
			// instanciamos el cargador y le proporcionamos el directorio raíz
			// a partir del cual se encuentran las vistas.

			$loader = new \Twig\Loader\FilesystemLoader("./vistas") ;

			// creamos el objeto TWIG
			$this->twig   = new \Twig\Environment($loader) ;
		}
	}