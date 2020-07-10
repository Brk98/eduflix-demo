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
            Usuario::$id = $this->route_params['id'];
            $elementos = Usuario::obtener();
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
            Usuario::$nombre = $_POST['nombre'];
            Usuario::$apaterno = $_POST['apaterno'];
            Usuario::$amaterno = $_POST['amaterno'];
            Usuario::$email = $_POST['email'];
            Usuario::$telefono = $_POST['telefono'];
            Usuario::$usuario = $_POST['usuario'];
            Usuario::$password = $_POST['password'];
            Usuario::$role = $_POST['role'];
            Usuario::$activo = isset($_POST['activo']);
            Usuario::agregar();
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

            Usuario::$id = $id;
            Usuario::$foto = $fichero_subido;
            Usuario::$nombre = $_POST['nombre'];
            Usuario::$apaterno = $_POST['apaterno'];
            Usuario::$amaterno = $_POST['amaterno'];
            Usuario::$email = $_POST['email'];
            Usuario::$telefono = $_POST['telefono'];
            Usuario::$usuario = $_POST['usuario'];
            Usuario::$password = $_POST['password'];
            Usuario::$role = $_POST['role'];
            Usuario::$activo = isset($_POST['activo']);
            Usuario::actualizar();
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

            Usuario::$id = $_POST['id'];
            Usuario::$foto = $fichero_subido;
            Usuario::$nombre = $_POST['nombre'];
            Usuario::$apaterno = $_POST['apaterno'];
            Usuario::$amaterno = $_POST['amaterno'];
            Usuario::$email = $_POST['email'];
            Usuario::$telefono = $_POST['telefono'];
            Usuario::$usuario = $_POST['usuario'];
            Usuario::$password = $_POST['password'];
            Usuario::$role = $_POST['role'];
            Usuario::$activo = isset($_POST['activo']);
            Usuario::actualizar();
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
            Usuario::$id = $this->route_params['id'];
            Usuario::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/usuarios/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
