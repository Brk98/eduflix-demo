<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\DashboardModel;


class Dashboard extends \Core\Controller
{
    
    public function indexAction()
    {      
        try 
        {  
            View::renderTemplate('Admin/Dashboard/index.html', [
                'usuarios' => 'demo'
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
}
