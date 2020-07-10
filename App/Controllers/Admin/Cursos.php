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
    public function indexAction()
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $cursos = Curso::tabla();
            View::renderTemplate('Admin/Cursos/tabla.html', [
                'cursos' => $cursos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function inscribirGrupoAction()
    {     
        Curso::$id = $this->route_params['id'];
        $grupos = Curso::obtenerTodosGrupos();
        $cursos = Curso::obtener();
        for ($i = 0; $i < count($grupos); $i++){
            $grupos[$i]['descripcion'] = html_entity_decode(strip_tags($grupos[$i]['descripcion']));
            if (Curso::verificarInscrito($grupos[$i]['id']))
                $grupos[$i]['inscrito'] = 1;   
            else
                $grupos[$i]['inscrito'] = 0;   
        }
        View::renderTemplate('Admin/Cursos/inscribirGrupo.html', [
            'grupos' => $grupos,
            'cursos' => $cursos
        ]);
    }

    public function agregarGrupoAction()
    {     
        Curso::$ip = $this->getIP();
        Curso::$id = $this->route_params['id'];
        Curso::$id_grupo = $_GET['id'];
        Curso::agregarGrupo();
        header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/".Curso::$id."/grupos");
    }

    public function eliminarGrupoAction()
    {     
        Curso::$ip = $this->getIP();
        Curso::$id = $this->route_params['id'];
        Curso::$id_grupo = $_GET['id'];
        Curso::eliminarGrupo();
        header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/".Curso::$id."/grupos");
    }
    
    public function nuevoAction()
    {      
        try 
        {  
            $categorias = Curso::categorias();
            View::renderTemplate('Admin/Cursos/nuevo.html', [
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
            Curso::$ip = $this->getIP();
            Curso::$id = $this->route_params['id'];
            $elementos = Curso::obtener();
            $categorias = Curso::categorias();
            View::renderTemplate('Admin/Cursos/editar.html', [
                'elementos' => $elementos,
                'categorias' => $categorias
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function usuariosAction()
    {      
        try 
        {  
            Curso::$id = $this->route_params['id'];
            $elementos = Curso::obtener();
            $usuarios = Curso::obtenerUsuarios();
            for ($i = 0; $i < count($elementos); $i++)
                $elementos[$i]['descripcion'] = html_entity_decode(strip_tags($elementos[$i]['descripcion']));
            View::renderTemplate('Admin/Cursos/usuarios.html', [
                'elementos' => $elementos,
                'usuarios' => $usuarios
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function gruposAction()
    {      
        try 
        {  
            Curso::$id = $this->route_params['id'];
            $elementos = Curso::obtener();
            $grupos = Curso::obtenerGrupos();
            for ($i = 0; $i < count($elementos); $i++)
                $elementos[$i]['descripcion'] = html_entity_decode(strip_tags($elementos[$i]['descripcion']));
            for ($i = 0; $i < count($grupos); $i++)
                $grupos[$i]['descripcion'] = html_entity_decode(strip_tags($grupos[$i]['descripcion']));
            View::renderTemplate('Admin/Cursos/grupos.html', [
                'elementos' => $elementos,
                'grupos' => $grupos
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
            Curso::$codigo = $_POST['codigo'];
            Curso::$curso = $_POST['curso'];
            Curso::$descripcion = $_POST['descripcion'];
            Curso::$id_categoria = $_POST['id_categoria'];
            Curso::$activo = isset($_POST['activo']);
            Curso::agregar();
            $id = Curso::obtenerUltimoID();
            $id = $id[0]['id'];
            $dir_subida = "repositorio/cursos/";
            $fichero_subido = $dir_subida . basename($id . '.jpg');
            $sourcePath = $_FILES['imagen']['tmp_name'];
            if(move_uploaded_file($sourcePath,$fichero_subido)) {
                $image = new ImageResize($fichero_subido);
                $image->crop(480, 270, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }
            Curso::$ip = $this->getIP();
            Curso::$id = $id;
            Curso::$imagen = $fichero_subido;
            Curso::$codigo = $_POST['codigo'];
            Curso::$curso = $_POST['curso'];
            Curso::$descripcion = $_POST['descripcion'];
            Curso::$id_categoria = $_POST['id_categoria'];
            Curso::$activo = isset($_POST['activo']);
            Curso::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/");
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
                $image->crop(480, 270, true, ImageResize::CROPCENTER);
                $foto = $dir_subida.uniqid().'.jpg';
                unlink($fichero_subido);
                $image->save($fichero_subido);
            }

            Curso::$ip = $this->getIP();
            Curso::$id = $_POST['id'];
            Curso::$imagen = $fichero_subido;
            Curso::$codigo = $_POST['codigo'];
            Curso::$curso = $_POST['curso'];
            Curso::$descripcion = $_POST['descripcion'];
            Curso::$id_categoria = $_POST['id_categoria'];
            Curso::$activo = isset($_POST['activo']);
            
            Curso::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Curso::$ip = $this->getIP();
            Curso::$id = $this->route_params['id'];
            Curso::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/cursos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
