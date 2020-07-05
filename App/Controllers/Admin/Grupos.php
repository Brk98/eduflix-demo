<?php

namespace App\Controllers\Admin;

use \Core\View;
use App\Models\Admin\Grupo;

/**
 * Grupos controller
 *
 */
class Grupos extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $grupos = Grupo::getAll();

        View::renderTemplate('Admin/Grupos/index.html', [
            'grupos' => $grupos
        ]);
    }

    /**
     * Show the add new page
     *
     * @return void
     */
    public function addNewAction()
    {
        echo 'Hello from the addNew action in the Posts controller!';
    }
    
    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';

             echo $this->route_params['id'];
    }
}
