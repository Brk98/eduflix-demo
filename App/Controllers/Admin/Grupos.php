<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Grupo;

class Grupos extends \Core\Controller
{

    

    protected function before()
    {
    }

    public function indexAction()

    {      
        try 
        {  
            $grupos = Grupo::index();
            for ($i = 0; $i < count($grupos); $i++)
            {
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            }
            View::renderTemplate('Grupos/index.html', [
                'grupos' => $grupos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            View::renderTemplate('Grupos/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $elementos = Grupo::obtener($this->route_params['id']);
            View::renderTemplate('Grupos/editar.html', [
                'obtenidos' => $obtenidos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::agregar($_POST['grupo'], $_POST['descripcion'], $_POST['activo']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::actualizar($_POST['id'], $_POST['grupo'], $_POST['descripcion']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
