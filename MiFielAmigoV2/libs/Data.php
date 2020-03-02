<?php

	//echo "<pre>".print_r($_SERVER, true)."</pre>" ;
	$path = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ; 
	$data = 
	[
		"app_name" => "Mi Fiel Amigo v2",

		// Datos de conexión
		"host"     => "localhost",
		"user"     => "root",
		"pass"     => "",
    
		"dbno"     => "refugio"
	] ;