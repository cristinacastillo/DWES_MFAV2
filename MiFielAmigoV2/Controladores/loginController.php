<?php

require_once 'baseController.php';

require_once './Modelos/Usuario.php';
require_once './Modelos/Perro.php';

require_once './libs/Sesion.php';
require_once './libs/Routing.php';

class loginController extends baseController
{
    private $sesion;

    public function __construct()
    {
        // llama al constructor padre
        parent::__construct();
        $this->sesion = Sesion::getInstance();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // $_GET["inicio"];
        if (!isset($_GET['inicio'])):
            echo $this->twig->render('login.php.twig', ['inicio' => 'true']);
        else:
            echo $this->twig->render('login.php.twig', ['inicio' => 'false']);
        endif;
    }

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        
        if(isset($_POST["email"])):

            $email = $_POST['email'];
            $pass = $_POST['pass'];

            $usuario = Usuario::exist($email, $pass);
            
            if ($usuario):


                $this->sesion->login();

                $dat = Perro::findAll();
                
                echo $this->twig->render('showDogs.php.twig', [
                'dat' => $dat,
                'usuario' => $usuario
            ]);

      
            else:

                echo $this->twig->render('login.php.twig', [
                    'inicio' => 'false',
                    'ok' => 'true'
                ]);
            endif;

        endif;

       /*else:
            header('location:index.php?con=login&ope=index&inicio=false');
            //route('index.php','login', 'login',['inicio'=>'false']);
           // echo $this->twig->render('login.php.twig', ['inicio' => 'false']);

        endif;*/
    }

    public function logout()
    {
        //print_r($_SESSION,FALSE);
        //$_SESSION = [] ;
		//session_destroy() ;
        $this->sesion->close();
        echo $this->twig->render('login.php.twig', ['inicio' => 'false']);

    }

    public function registrar(){

        echo $this->twig->render('registro.php.twig');

    }
}
