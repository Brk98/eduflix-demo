<?php

namespace App\Controllers;
use App\Config;
use \Core\View;
use App\Models\PerfilModel;

require_once ('Admin/ImageResize.php');
use libs\ImageResize;
require_once ('Admin/ImageResizeException.php');
use libs\ImageResizeException;

class Perfil extends \Core\Controller
{
    public function indexAction()
    {
        $this->editarAction();
    }

    
    public function editarAction()
    {      
        try 
        {  
            $perfil = PerfilModel::editar();
            $roles = PerfilModel::roles();
            View::renderTemplate('perfil.html', [
                'perfil' => $perfil,
                'roles' => $roles
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            PerfilModel::$ip = $this->getIP();
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

            PerfilModel::$id = $_POST['id'];
            PerfilModel::$foto = $fichero_subido;
            PerfilModel::$nombre = $_POST['nombre'];
            PerfilModel::$apaterno = $_POST['apaterno'];
            PerfilModel::$amaterno = $_POST['amaterno'];
            PerfilModel::$email = $_POST['email'];
            PerfilModel::$telefono = $_POST['telefono'];
            PerfilModel::$password = $_POST['password'];
            PerfilModel::$activo = isset($_POST['activo']);
            PerfilModel::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."perfil/editar");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
