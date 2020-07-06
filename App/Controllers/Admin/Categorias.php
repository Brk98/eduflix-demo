<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Categoria;

class Categorias extends \Core\Controller
{
    protected function before()
    {
    }

    public function indexAction()
    {      
        try 
        {  
            $categorias = Categoria::index();
            View::renderTemplate('Categorias/index.html', [
                'categorias' => $categorias
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            View::renderTemplate('Categorias/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $elementos = Categoria::elemento($this->route_params['id']);
            View::renderTemplate('Categorias/editar.html', [
                'elementos' => $elementos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Categoria::$ip = $this->getIP();
            Categoria::agregar($_POST['categoria'], $_POST['activo']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/categorias/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Categoria::$ip = $this->getIP();
            Categoria::actualizar($_POST['id'], $_POST['categoria']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/categorias/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Categoria::$ip = $this->getIP();
            Categoria::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/categorias/index");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
