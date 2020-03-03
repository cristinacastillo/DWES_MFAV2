<?php

	require_once "./libs/Data.php" ;

    // recogemos el controlador y la operación 
	$con = $_GET["con"]??"perro" ;
	$ope = $_GET["ope"]??"listar" ;

	//echo "$con, $ope<br/>" ;

	// creamos el nombre completo del controlador
	$nom = "{$con}Controller" ;

	// importar el controlador necesario
	require_once "Controladores/$nom.php" ;

	// instanciamos el controlador
	$controller = new $nom() ;

	// invocamos la operación a realizar
	$controller->$ope() ;
