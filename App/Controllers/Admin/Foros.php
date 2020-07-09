<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Foro;

class Foros extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            for ($i = 0; $i < count($foros); $i++)
                $foros[$i]['descripcion'] = strip_tags($foros[$i]['descripcion']);
            View::renderTemplate('Admin/Foros/tabla.html', [
                'foros' => $foros
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            $tipos = Foro::tipo();
            View::renderTemplate('Admin/Foros/nuevo.html', [
                'tipos' => $tipos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $foros = Foro::tabla();
            $tipos = Foro::tipo();
            Foro::$id = $this->route_params['id'];
            $elementos = Foro::obtener();
            View::renderTemplate('Admin/Foros/editar.html', [
                'elementos' => $elementos,
                'foros' => $foros,
                'tipos' => $tipos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            Foro::$tema = $_POST['tema'];
            Foro::$descripcion = $_POST['descripcion'];
            Foro::$id_tipo_foro = $_POST['id_tipo_foro'];
            Foro::$activo = isset($_POST['activo']);
            Foro::agregar();
            $id = Foro::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/foros/";
            mkdir($dir_subida.$id."/");
            $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);

            Foro::$ip = $id;
            Foro::$archivo = $fichero_subido;
            Foro::$tema = $_POST['tema'];
            Foro::$descripcion = $_POST['descripcion'];
            Foro::$id_tipo_foro = $_POST['id_tipo_foro'];
            Foro::$activo = isset($_POST['activo']);

            Foro::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            $dir_subida = "repositorio/foros/";
            $fichero_subido = $dir_subida .$_POST['id']."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);


            Foro::$id = $_POST['id'];
            Foro::$archivo = $fichero_subido;
            Foro::$tema = $_POST['tema'];
            Foro::$descripcion = $_POST['descripcion'];
            Foro::$id_tipo_foro = $_POST['id_tipo_foro'];
            Foro::$activo = isset($_POST['activo']);

            Foro::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Foro::$ip = $this->getIP();
            Foro::$id = $this->route_params['id'];
            Foro::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/foros/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
