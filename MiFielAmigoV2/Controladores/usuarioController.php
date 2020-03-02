<?php

// Controlador Perro

require_once 'baseController.php';

require_once 'Modelos/Usuario.php';

require_once 'loginController.php';

require_once 'libs/Sesion.php';
require_once 'libs/Routing.php';

class usuarioController extends baseController
{
    private $sesion;

    /**
     * @return void
     */
    public function __construct()
    {
        // llama al constructor padre
        parent::__construct();

        
    }

    /**
     * info
     *
     * @return void
     */
    public function info()
    {

        $this->sesion = Sesion::getInstance();
        // comprobar si hay una sesión activa
        if(!$this->sesion->checkActiveSession()):
            loginController::login();
        endif;
        
        $idUsu = $_GET["idUsu"];
        
        $usuario = Usuario::find($idUsu);

            echo $this->twig->render('showInfo.php.twig', [
                'usuario' => $usuario
            ]);
    
    }

    /**
     * panel
     *
     * @return void
     */
    public function panel(){

        $this->sesion = Sesion::getInstance();
        // comprobar si hay una sesión activa
        if(!$this->sesion->checkActiveSession()):
            loginController::login();
        endif;

        $idUsu = $_GET["idUsu"];
        
        $usuario = Usuario::find($idUsu);

        $dat = Usuario::findUsers();

        echo $this->twig->render('showPanel.php.twig', [
            'usuario' => $usuario, 
            'dat' => $dat
        ]);

    }

    public function registrar(){

        $email = $_POST["email"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $pass = $_POST["pass"];
        $conf = $_POST["conf"];
        $api_key  =  md5($email . time());

        //comprobamos si  email ya existe
        $correoExiste = Usuario::emailExist($email);

        //echo "hola";

        //echo $this->twig->render('registro.php.twig',['correoExiste' => $correoExiste, 'contrasena' => $contrasena]);

        // comprobamos si las contraseñas son iguales
        if(($pass == $conf)):

            if(!$correoExiste):

                $usr = new Usuario();

                $usr->setEmail($email);
                $usr->setNombre($nombre);
                $usr->setApellidos($apellidos);
                $usr->setPass($pass);
                $usr->setApiKey($api_key);

                $usr->save();
            
            else:

                echo $this->twig->render('registro.php.twig',['correoExiste' => true]);
            endif;
            echo $this->twig->render("login.php.twig",["inicio" => 'true']);
        else:
            echo $this->twig->render('registro.php.twig',['contrasena' => true]);
        endif;
        //echo $email."<br>". $nombre."<br>".$apellidos ."<br>".$pass ."<br>".$conf;
    
    }

    public function borrar(){

        $this->sesion = Sesion::getInstance();
        // comprobar si hay una sesión activa
        if(!$this->sesion->checkActiveSession()):
            loginController::login();
        endif;

        $idBorrar = $_GET["id"];
        $idUsu = $_GET["idUsu"];

        //echo "idUsu" .$idUsu."<br>idBorrar".$idBorrar;

        $usr = Usuario::delete($idBorrar);

        $usuario = Usuario::find($idUsu);

        $dat = Usuario::findUsers();

        echo $this->twig->render('showPanel.php.twig', [
            'usuario' => $usuario, 
            'dat' => $dat
        ]);


    }

  
}
