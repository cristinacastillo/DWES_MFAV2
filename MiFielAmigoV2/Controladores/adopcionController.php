<?php

// Controlador Perro

require_once 'baseController.php';
require_once 'loginController.php';

require_once './Modelos/Adopcion.php';
require_once './Modelos/Perro.php';

require_once './libs/Sesion.php';
require_once './libs/Routing.php';

class adopcionController extends baseController
{
    private $sesion;
    
    public function __construct()
    {
        // llama al constructor padre
        parent::__construct();

        $this->sesion = Sesion::getInstance();
        // comprobar si hay una sesión activa
        if(!$this->sesion->checkActiveSession()):
            loginController::login();
            
        endif;
    }

    public function listar()
    {

        $idUsu = $_POST["idUsu"] ?? 0;
        if($idUsu != 0):
        $usuario = Usuario::find($idUsu);

        $dat = Adopcion::find($idUsu);

        echo $this->twig->render('showAdop.php.twig', [
            'dat' => $dat, 'usuario' => $usuario
        ]);
    else:
        echo $this->twig->render('login.php.twig', ['inicio' => 'false']);
    endif;
        
    }

    public function anadir(){

        $idUsu = $_POST["idUsu"] ?? 0;

        if ($idUsu!= 0):
            $usuario = Usuario::find($idUsu);

            $nombre = $_POST["nombre"];
            $idPer = $_POST["idPer"];
            $fecha = date("Y-m-d");

            $per = Perro::find($idPer);

            /*echo $nombre;
            echo $idPer;
            echo $idUsu;
            echo $idPer;
            */
            $adop = new Adopcion();


            $adop->setIdPer($idPer);
            $adop->setIdUsu($idUsu);
            $adop->setNombre($nombre);
            $adop->setFecha($fecha);


            $adop->save();

            $dat = Adopcion::find($idUsu);

            echo $this->twig->render('showAdop.php.twig', [
                'dat' => $dat,
                'usuario' => $usuario
            ]);
        else:
            echo $this->twig->render('login.php.twig', ['inicio' => 'false']);
        endif;
              


    }
}
