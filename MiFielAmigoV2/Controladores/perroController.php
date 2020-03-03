<?php

// Controlador Perro

require_once 'baseController.php';

require_once './Modelos/Perro.php';
require_once './Modelos/Adopcion.php';
require_once './Modelos/Usuario.php';

require_once 'loginController.php';

require_once './libs/Sesion.php';
require_once './libs/Routing.php';

class perroController extends baseController
{
    private $sesion;

    /**
     * __construct
     *
     * @return void
     */
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

    /**
     * listar
     *
     * @return void
     */
    public function listar()
    {
        
        if($_GET["idUsu"]):

            $dat = Perro::findAll();

            $idUsu = $_GET["idUsu"];
            
            $usuario = Usuario::find($idUsu);

            echo $this->twig->render('showDogs.php.twig', [
                'dat' => $dat,
                'usuario' => $usuario
            ]);

        else:

            echo $this->twig->render('login.php.twig', ['inicio' => 'false']);
            
        endif;
    }

    /**
     * listarPerro
     *
     * @return void
     */
    public function listarPerro()
    {
        $idPer = $_GET['id'];

        $idUsu = $_GET["idUsu"];
        
        $usuario = Usuario::find($idUsu);

        $dat = Perro::find($idPer);

        $adop = Adopcion::adopted($idPer);

        echo $this->twig->render('showDog.php.twig', ['dat' => $dat,
                                                      'a' => $adop, 'idUsu' => $idUsu, 
                                                      'usuario' => $usuario]);
    }

    /**
     * borrar
     *
     * @return void
     */
    public function borrar()
    {
        $idPer = $_GET['id'];
        $idUsu = $_GET['idUsu'];
        $usuario = Usuario::find($idUsu);     

        //$per->alert($msg);
        $per = Perro::find($idPer);
        $per->delete();
        $dat = Perro::findAll();

        echo $this->twig->render('showDogs.php.twig', [
            'dat' => $dat,
            'usuario' => $usuario
        ]);
        
    }

    /**
     * anadir
     *
     * @return void
     */
    public function anadir()
    {
        
        /* if (!isset($_GET['nombre'])):
            // si no tengo datos sobre el perro,
            // muestro el formulario vacío
            echo $this->twig->render('addDog.php.twig'); 

        else:*/

            $nombre = $_POST['nombre'];
            $raza = $_POST['raza'];
            $genero = $_POST['genero'];
            $descripcion = $_POST['descripcion'];
            $fec_nacimiento = $_POST['fec_nacimiento'];
            $foto = $_FILES['img'];

            $idUsu = $_POST["idUsu"];

            //echo $idUsu. "isudu";
            $usuario = Usuario::find($idUsu);

            $ruta_aleatoria = $_FILES["img"]["tmp_name"];

            //ruta + nombre de la foto
            $mi_ruta = "images/perros/" . $_FILES["img"]["name"];

        
            //print_r($foto,false);

            $per = new Perro();

            $per->setNombre($nombre);
            $per->setRaza($raza);
            $per->setGenero($genero);
            $per->setDescripcion($descripcion);
            $per->setFecNac($fec_nacimiento);
            $per->setFoto($mi_ruta);

            $per->save();

            $idPer = $per->getIdPer();

            //print_r($_FILES["img"]); //comprobar
            //echo "<br>";

            //movemos la imagen a nuestra ruta
            if (!move_uploaded_file($ruta_aleatoria, $mi_ruta)) :
                echo "Error: Foto no lo suficientmente adorable";

            endif;

            //print_r($mi_ruta,false);
            //echo "<br>";

            // redirigimos al nuevo registro

            $dat = Perro::find($idPer);

            echo $this->twig->render('showDog.php.twig', ['dat' => $dat,
                                                          'usuario' => $usuario]);

        //endif;
    }


    /**
     * editar
     *
     * @return void
     */
    public function editar(){

        $id = $_POST["id"];

        $idUsu = $_POST["idUsu"];

        $descripcionMod = $_POST["descripcionMod"];

        $per = Perro::find($id);

        $usuario = Usuario::find($idUsu);

       // print_r($descripcionMod,false);
        //print_r($id,false);

        $per->setDescripcion($descripcionMod);

        $per->save();

        echo $this->twig->render('showDog.php.twig', ['dat' => $per, 'usuario' => $usuario]);


    }
}
