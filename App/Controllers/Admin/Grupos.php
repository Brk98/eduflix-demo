<?php

namespace App\Controllers\Admin;
use App\Config;
use \Core\View;
use App\Models\Admin\Grupo;

class Grupos extends \Core\Controller
{
    public function indexAction() 
    {
        $this->tablaAction();
    }

    public function tablaAction()
    {      
        try 
        {  
            $grupos = Grupo::tabla();
            for ($i = 0; $i < count($grupos); $i++)
                $grupos[$i]['descripcion'] = strip_tags($grupos[$i]['descripcion']);
            View::renderTemplate('Admin/Grupos/tabla.html', [
                'grupos' => $grupos
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function inscribirUsuarioAction()
    {     
        Grupo::$id = $this->route_params['id'];
        $usuarios = Grupo::obtenerTodosUsuarios();
        $grupos = Grupo::obtener();
        for ($i = 0; $i < count($grupos); $i++)
        {
            $grupos[$i]['descripcion'] = html_entity_decode(strip_tags($grupos[$i]['descripcion']));
        }
        for ($i = 0; $i < count($usuarios); $i++)
        {
            if (Grupo::verificarInscrito($usuarios[$i]['id']))
                $usuarios[$i]['inscrito'] = 1;   
            else
                $usuarios[$i]['inscrito'] = 0;   
        }
        View::renderTemplate('Admin/Grupos/inscribirUsuario.html', [
            'usuarios' => $usuarios,
            'grupos' => $grupos
        ]);
    }

    public function agregarUsuarioAction()
    {     
        Grupo::$ip = $this->getIP();
        Grupo::$id = $this->route_params['id'];
        Grupo::$id_usuario = $_GET['id'];
        Grupo::agregarUsuario();
        header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/".Grupo::$id."/usuarios");
    }

    public function eliminarUsuarioAction()
    {     
        Grupo::$ip = $this->getIP();
        Grupo::$id = $this->route_params['id'];
        Grupo::$id_usuario = $_GET['id'];
        Grupo::eliminarUsuario();
        header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/".Grupo::$id."/usuarios");
    }
    

    
    public function nuevoAction()
    {      
        try 
        {  
            $generaciones = Grupo::generacionesObtener();
            View::renderTemplate('Admin/Grupos/nuevo.html', [
            'generaciones' => $generaciones
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
       
    public function editarAction()
    {      
        try 
        {  
            Grupo::$id = $this->route_params['id'];
            $obtenidos = Grupo::obtener();
            $generaciones = Grupo::generacionesObtener();
            View::renderTemplate('Admin/Grupos/editar.html', [
                'obtenidos' => $obtenidos,
                'generaciones' => $generaciones
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function agregarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::$grupo = $_POST['grupo'];
            Grupo::$descripcion = $_POST['descripcion'];
            Grupo::$activo = isset($_POST['activo']);
            Grupo::$id_generacion = $_POST['id_generacion'];
            echo Grupo::$id_generacion;
            Grupo::agregar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function actualizarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::$id = $_POST['id'];
            Grupo::$grupo = $_POST['grupo'];
            Grupo::$descripcion = $_POST['descripcion'];
            Grupo::$activo = isset($_POST['activo']);
            Grupo::$id_generacion = $_POST['id_generacion'];
            Grupo::actualizar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function usuariosAction()
    {      
        try 
        {  
            Grupo::$id = $this->route_params['id'];
            $elementos = Grupo::obtener();
            $usuarios = Grupo::obtenerUsuarios();
            for ($i = 0; $i < count($elementos); $i++)
                $elementos[$i]['descripcion'] = html_entity_decode(strip_tags($elementos[$i]['descripcion']));
            View::renderTemplate('Admin/Grupos/usuarios.html', [
                'elementos' => $elementos,
                'usuarios' => $usuarios
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function eliminarAction()
    {      
        try 
        {  
            Grupo::$ip = $this->getIP();
            Grupo::$id = $this->route_params['id'];
            Grupo::eliminar();
            header( "Location: ".Config::HOST.Config::DIRECTORY."admin/grupos/");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
