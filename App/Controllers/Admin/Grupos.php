<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Grupo;

class Grupos extends \Core\Controller
{
    public function tablaAction()
    {      
        try 
        {  
            $grupos = Grupo::tabla();
            for ($i = 0; $i < count($grupos); $i++)
            {
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            }
            View::renderTemplate('Grupos/tabla.html', [
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
            $elementos = Grupo::elemento($this->route_params['id']);
            View::renderTemplate('Grupos/editar.html', [
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
            Grupo::agregar($_POST['grupo'], $_POST['descripcion'], $_POST['fecha'], $_POST['activo']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Grupo::actualizar($_POST['id'], $_POST['grupo'], $_POST['descripcion'], $_POST['fecha']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Grupo::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}