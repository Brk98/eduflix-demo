<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

  

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        /*
        View::render('Home/index.php', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */
        View::renderTemplate('Home/index.html', [
            'nombre'    => $_SESSION['eduflix']['nombre'],
            'email' => $_SESSION['eduflix']['email']
        ]);
    }
}
