<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\MisArchivosModel;

class MisArchivos extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $archivos = MisArchivosModel::tabla();
            for ($i = 0; $i < count($archivos); $i++)
                $archivos[$i]['descripcion'] = strip_tags($archivos[$i]['descripcion']);
            View::renderTemplate('MisArchivos/tabla.html', [
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
            View::renderTemplate('MisArchivos/nuevo.html', []);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            MisArchivosModel::$id = $this->route_params['id'];
            $elementos = MisArchivosModel::obtener();
            View::renderTemplate('MisArchivos/editar.html', [
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
            MisArchivosModel::$ip = $this->getIP();
            MisArchivosModel::$nombre = $_POST['nombre'];
            MisArchivosModel::$descripcion = $_POST['descripcion'];
            MisArchivosModel::$archivo = $_FILES['archivo']['name'];
            MisArchivosModel::$privado = isset($_POST['privado']);
            MisArchivosModel::agregar();
            $id = MisArchivosModel::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/archivos/";
            mkdir($dir_subida.$id."/");
            $fichero_subido = $dir_subida .$id."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            MisArchivosModel::$id = $id;
            MisArchivosModel::$nombre = $_POST['nombre'];
            MisArchivosModel::$descripcion = $_POST['descripcion'];
            MisArchivosModel::$archivo = $_FILES['archivo']['name'];
            MisArchivosModel::$privado = isset($_POST['privado']);
            MisArchivosModel::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."MisArchivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            MisArchivosModel::$ip = $this->getIP();
            $dir_subida = "repositorio/archivos/";
            $fichero_subido = $dir_subida .$_POST['id']."/".basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
            MisArchivosModel::$id = $_POST['id'];
            MisArchivosModel::$nombre = $_POST['nombre'];
            MisArchivosModel::$descripcion = $_POST['descripcion'];
            MisArchivosModel::$archivo = $_FILES['archivo']['name'];
            MisArchivosModel::$privado = isset($_POST['privado']);
            MisArchivosModel::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."MisArchivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            MisArchivosModel::$ip = $this->getIP();
            MisArchivosModel::$id = $this->route_params['id'];
            MisArchivosModel::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."MisArchivos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function descargarAction()
    {      
        try 
        {
            MisArchivosModel::$id = $this->route_params['id'];
            $archivo = MisArchivosModel::obtener();
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
