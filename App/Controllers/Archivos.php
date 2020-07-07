<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\Archivo;

class Archivos extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $archivos = Archivo::tabla();
            for ($i = 0; $i < count($archivos); $i++)
                $archivos[$i]['descripcion'] = strip_tags($archivos[$i]['descripcion']);
            View::renderTemplate('Archivos/tabla.html', [
                'archivos' => $archivos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            View::renderTemplate('Archivos/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $elementos = Archivo::obtener($this->route_params['id']);
            View::renderTemplate('Archivos/editar.html', [
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
            Archivo::$ip = $this->getIP();
            Archivo::agregar($_POST['nombre'], $_POST['descripcion'], $_FILES['archivo']['name'], isset($_POST['privado']));
            $id = Archivo::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/archivos/";
            mkdir($dir_subida.$id."/");
            $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            Archivo::actualizar($id, $_POST['nombre'], $_POST['descripcion'], $_FILES['archivo']['name'], isset($_POST['privado']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."archivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Archivo::$ip = $this->getIP();
            $dir_subida = "repositorio/archivos/";
            $fichero_subido = $dir_subida .$_POST['id']."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            Archivo::actualizar($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_FILES['archivo']['name'], isset($_POST['privado']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."archivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Archivo::$ip = $this->getIP();
            Archivo::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."archivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function descargarAction()
    {      
        try 
        {
            $archivo = Archivo::obtener($this->route_params['id']);
            $url = Config::HOST.Config::DIRECTORY.'repositorio/archivos/'.$archivo['0']['id'].'/'.rawurlencode($archivo['0']['archivo']);
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"".$archivo['0']['archivo']."\""); 
            readfile($url);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
