<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Conferencia;

class Conferencias extends \Core\Controller
{

    public function tablaAction()
    {      
        try 
        {  
            $conferencias = Conferencia::tabla();
            for ($i = 0; $i < count($conferencias); $i++)
                $conferencias[$i]['descripcion'] = strip_tags($conferencias[$i]['descripcion']);
            View::renderTemplate('Conferencias/tabla.html', [
                'conferencias' => $conferencias
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            View::renderTemplate('Conferencias/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $elementos = Conferencia::obtener($this->route_params['id']);
            View::renderTemplate('Conferencias/editar.html', [
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
            Conferencia::$ip = $this->getIP();
            Conferencia::agregar($_POST['conferencia'], $_POST['descripcion'], $_POST['fecha'], $_POST['horario'], $_POST['duracion']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Conferencia::$ip = $this->getIP();
            Conferencia::actualizar($_POST['id'], $_POST['conferencia'], $_POST['descripcion'], $_POST['fecha'], $_POST['horario'], $_POST['duracion']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Conferencia::$ip = $this->getIP();
            Conferencia::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
