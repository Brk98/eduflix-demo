<?php

namespace App\Controllers;

use \Core\View;
use App\Models\LoginModel;

use App\Config;

/**
 * Home controller
 *
 */
class Login extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        /*if(!isset($_SESSION['eduflix'])){
            header('Location: '.Config::HOST.Config::DIRECTORY);
            exit; 
           }*/
        //return true;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }
    

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
        
        View::renderTemplate('Login/index.html', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }


    public function forgotpasswordAction()
    {
        
        View::renderTemplate('Login/password.html', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }



    public function validateAction()
    {
        if (!empty($_POST)){
            
            LoginModel::$usuario = $_POST['usuario'];
            LoginModel::$password = $_POST['password'];
            
            $usuario = LoginModel::validarUsuario();

           if($usuario){

             $nombre = $usuario["nombre"]." ".$usuario["apaterno"]." ".$usuario["amaterno"];

             
             $_SESSION['eduflix'] = array("id"=>$usuario["id"],"usuario"=>$usuario["usuario"],"nombre"=>$nombre,"email"=>$usuario["email"],"telefono"=>$usuario["telefono"],"id_rol"=>$usuario["id_rol"],"foto"=>$usuario["foto"]);
                 
             $this->log("App\Controllers\Login","validateAction","ACCESS");

             header('Location: '.Config::HOST.Config::DIRECTORY.'Home/');
             exit;
                
           }else{
                $this->indexAction();
           }

        }else{

           $this->indexAction();

        }
        
    }


    public function cerrarSesionAction()
    {

        $this->log("App\Controllers\Login","cerrarSesionAction","CLOSE");

        session_destroy();
        session_unset();

        header('Location: '.Config::HOST.Config::DIRECTORY.'Login/');
        exit;


    }
}
