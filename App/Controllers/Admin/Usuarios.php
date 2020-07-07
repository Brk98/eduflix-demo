<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Usuario;

require_once ('ImageResize.php');
use libs\ImageResize;
require_once ('ImageResizeException.php');
use libs\ImageResizeException;

class Usuarios extends \Core\Controller
{
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $usuarios = Usuario::tabla();
            View::renderTemplate('Admin/Usuarios/tabla.html', [
                'usuarios' => $usuarios
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            $roles = Usuario::roles();
            View::renderTemplate('Admin/Usuarios/nuevo.html', [
                'roles' => $roles
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $roles = Usuario::roles();
            $elementos = Usuario::obtener($this->route_params['id']);
            View::renderTemplate('Admin/Usuarios/editar.html', [
                'elementos' => $elementos,
                'roles' => $roles
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {
            Usuario::$ip = $this->getIP();
            Usuario::agregar('', $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['email'], $_POST['telefono'], $_POST['usuario'], $_POST['password'], $_POST['role'], isset($_POST['activo']));
            $id = Usuario::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/usuarios/";
            $fichero_subido = $dir_subida . basename($id . '.jpg');
            
            $sourcePath = $_FILES['imagen']['tmp_name'];

            if(move_uploaded_file($sourcePath,$fichero_subido)) {
                $image = new ImageResize($fichero_subido);
                $image->crop(108, 119, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }

            Usuario::actualizar($id, $fichero_subido, $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['email'], $_POST['telefono'], $_POST['usuario'], $_POST['password'], $_POST['role'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/usuarios/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Usuario::$ip = $this->getIP();
            $dir_subida = "repositorio/usuarios/";
            $fichero_subido = $dir_subida . basename($_POST['id'] . '.jpg');
            $sourcePath = $_FILES['imagen']['tmp_name'];
            if(move_uploaded_file($sourcePath,$fichero_subido)) {
                $image = new ImageResize($fichero_subido);
                $image->crop(108, 119, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }

            Usuario::actualizar($_POST['id'], $fichero_subido, $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['email'], $_POST['telefono'], $_POST['usuario'], $_POST['password'], $_POST['role'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/usuarios/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Usuario::$ip = $this->getIP();
            Usuario::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/usuarios/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
