<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Curso;

require_once ('ImageResize.php');
use libs\ImageResize;
require_once ('ImageResizeException.php');
use libs\ImageResizeException;

class Cursos extends \Core\Controller
{
    public function tablaAction()
    {      
        try 
        {  
            $cursos = Curso::tabla();
            View::renderTemplate('Cursos/tabla.html', [
                'cursos' => $cursos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            $categorias = Curso::categorias();
            View::renderTemplate('Cursos/nuevo.html', [
                'categorias' => $categorias
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            $elementos = Curso::obtener($this->route_params['id']);
            $categorias = Curso::categorias();
            View::renderTemplate('Cursos/editar.html', [
                'elementos' => $elementos,
                'categorias' => $categorias
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Curso::$ip = $this->getIP();
            Curso::agregar($_POST['codigo'], $_POST['curso'], $_POST['descripcion'], $_POST['id_categoria'], isset($_POST['activo']));
            $id = Curso::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/cursos/";
            $fichero_subido = $dir_subida . basename($id . '.jpg');

            $sourcePath = $_FILES['imagen']['tmp_name'];

            if(move_uploaded_file($sourcePath,$fichero_subido)) {
                $image = new ImageResize($fichero_subido);
                $image->crop(108, 119, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }
            Curso::actualizar($id, $fichero_subido, $_POST['codigo'], $_POST['curso'], $_POST['descripcion'], $_POST['id_categoria'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Curso::$ip = $this->getIP();
            $dir_subida = "repositorio/cursos/";
            $fichero_subido = $dir_subida . basename($_POST['id'] . '.jpg');
            $sourcePath = $_FILES['imagen']['tmp_name'];
            if(move_uploaded_file($sourcePath,$fichero_subido)) {
                $image = new ImageResize($fichero_subido);
                $image->crop(108, 119, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }

            Curso::actualizar($_POST['id'], $fichero_subido, $_POST['codigo'], $_POST['curso'], $_POST['descripcion'], $_POST['id_categoria'], isset($_POST['activo']));
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Curso::$ip = $this->getIP();
            Curso::eliminar($this->route_params['id']);
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/tabla");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
