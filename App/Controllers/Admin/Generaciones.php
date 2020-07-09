<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Generacion;

class Generaciones extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $generaciones = Generacion::tabla();
            for ($i = 0; $i < count($generaciones); $i++)
                $generaciones[$i]['descripcion'] = strip_tags($generaciones[$i]['descripcion']);
            View::renderTemplate('Admin/Generaciones/tabla.html', [
                'generaciones' => $generaciones
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            View::renderTemplate('Admin/Generaciones/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            Generacion::$id = $this->route_params['id'];
            $elementos = Generacion::obtener();
            View::renderTemplate('Admin/Generaciones/editar.html', [
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
            Generacion::$ip = $this->getIP();
            Generacion::$generacion = $_POST['generacion'];
            Generacion::$descripcion = $_POST['descripcion'];
            Generacion::$activo = isset($_POST['activo']);
            Generacion::agregar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/generaciones/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Generacion::$ip = $this->getIP();
            Generacion::$id = $_POST['id'];
            Generacion::$generacion = $_POST['generacion'];
            Generacion::$descripcion = $_POST['descripcion'];
            Generacion::$activo = isset($_POST['activo']);
            Generacion::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/generaciones/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Generacion::$ip = $this->getIP();
            Generacion::$id = $this->route_params['id'];
            Generacion::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/generaciones/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
