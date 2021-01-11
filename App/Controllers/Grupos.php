<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\Grupo;

class Grupos extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {       
        try 
        {  
            $grupos = Grupo::tabla();
            for ($i = 0; $i < count($grupos); $i++)
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            View::renderTemplate('Grupos/tabla.html', [
                'grupos' => $grupos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function grupoAction()
    {      
        try 
        {  
            $grupos = Grupo::obtener($this->route_params['id']);
            $usuarios = Grupo::usuarios($this->route_params['id']);
            for ($i = 0; $i < count($grupos); $i++)
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            View::renderTemplate('Grupos/grupo.html', [
                'grupos' => $grupos,
                'usuarios' => $usuarios
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
