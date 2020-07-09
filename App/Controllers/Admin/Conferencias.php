<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Conferencia;

class Conferencias extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $conferencias = Conferencia::tabla();
            for ($i = 0; $i < count($conferencias); $i++)
                $conferencias[$i]['descripcion'] = strip_tags($conferencias[$i]['descripcion']);
            View::renderTemplate('Admin/Conferencias/tabla.html', [
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
            View::renderTemplate('Admin/Conferencias/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            Conferencia::$id = $this->route_params['id'];
            $elementos = Conferencia::obtener();
            View::renderTemplate('Admin/Conferencias/editar.html', [
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
            Conferencia::$conferencia = $_POST['conferencia'];
            Conferencia::$descripcion = $_POST['descripcion'];
            Conferencia::$fecha = $_POST['fecha'];
            Conferencia::$horario = $_POST['horario'];
            Conferencia::$duracion = $_POST['duracion'];
            Conferencia::agregar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Conferencia::$ip = $this->getIP();
            Conferencia::$id = $_POST['id'];
            Conferencia::$conferencia = $_POST['conferencia'];
            Conferencia::$descripcion = $_POST['descripcion'];
            Conferencia::$fecha = $_POST['fecha'];
            Conferencia::$horario = $_POST['horario'];
            Conferencia::$duracion = $_POST['duracion'];
            Conferencia::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Conferencia::$ip = $this->getIP();
            Conferencia::$id = $this->route_params['id'];
            Conferencia::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/conferencias/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
