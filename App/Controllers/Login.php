<?php

namespace App\Controllers;

use \Core\View;

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
        
        /*View::renderTemplate('Login/index.html', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);*/
        
    }
}
